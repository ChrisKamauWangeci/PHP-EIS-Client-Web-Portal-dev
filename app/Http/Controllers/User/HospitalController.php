<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Models\Cioxsiteid;
use App\Models\Datachange;
use App\Models\Facilityform;
use App\Models\Hospital;
use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    public function prg(Request $request)
    {
        $params = array_filter($request->except('_token'));

        return redirect()
            ->route('user.hospitals.index', $params);
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'H_ID' => 'nullable|integer',
            'H_Hospital' => 'nullable|string|max:255',
            'H_Hospital2' => 'nullable|string|max:255',
            'H_Address' => 'nullable|string|max:255',
            'H_City' => 'nullable|string|max:255',
            'H_State' => 'nullable|string|max:255',
            'H_Zip' => 'nullable|string|max:10',
            'H_Phone' => 'nullable|string|max:25',
            'H_Fax' => 'nullable|string|max:25',
            'dbfield' => 'nullable|string|in:H_Hospital,H_Hospital2,H_Phone,H_Fax,H_Address,H_City,H_State,H_Zip,H_SpecialAuthFile,H_Docusign,H_Created,created_by,H_UpdDate,H_UpdUser',
            'dbconditions' => 'nullable|string|in:eq,neq,contains,not_contains,starts_with,ends_with,empty,not_empty',
            'dbvalue' => 'nullable|string|max:255',
            'sort_field' => 'nullable|string|in:H_ID,H_Hospital,H_Hospital2,H_Address,H_City,H_State,H_Zip,H_Phone,H_Fax',
            'sort_direction' => 'nullable|string|in:asc,desc',
        ]);

        $query = Hospital::query()
            ->when($validated['H_ID'] ?? null, fn ($q, $v) => $q->where('H_ID', $v))
            ->when($validated['H_Hospital'] ?? null, fn ($q, $v) => $q->where('H_Hospital', 'LIKE', '%' . $v . '%'))
            ->when($validated['H_Hospital2'] ?? null, fn ($q, $v) => $q->where('H_Hospital2', 'LIKE', '%' . $v . '%'))
            ->when($validated['H_Address'] ?? null, fn ($q, $v) => $q->where('H_Address', 'LIKE', '%' . $v . '%'))
            ->when($validated['H_City'] ?? null, fn ($q, $v) => $q->where('H_City', 'LIKE', '%' . $v . '%'))
            ->when($validated['H_State'] ?? null, fn ($q, $v) => $q->where('H_State', $v))
            ->when($validated['H_Zip'] ?? null, fn ($q, $v) => $q->where('H_Zip', $v))
            ->when($validated['H_Phone'] ?? null, fn ($q, $v) => $q->where('H_Phone', 'LIKE', '%' . $v . '%'))
            ->when($validated['H_Fax'] ?? null, fn ($q, $v) => $q->where('H_Fax', 'LIKE', '%' . $v . '%'));

        $query->when(($validated['dbfield'] ?? null) && ($validated['dbconditions'] ?? null), function ($q) use ($validated) {
            $dbfield = $validated['dbfield'];
            $dbconditions = $validated['dbconditions'];
            $dbvalue = $validated['dbvalue'] ?? '';

            switch ($dbconditions) {
                case 'eq':
                    $q->where($dbfield, '=', $dbvalue);
                    break;
                case 'neq':
                    $q->where($dbfield, '!=', $dbvalue);
                    break;
                case 'contains':
                    $q->where($dbfield, 'LIKE', "%$dbvalue%");
                    break;
                case 'not_contains':
                    $q->where($dbfield, 'NOT LIKE', "%$dbvalue%");
                    break;
                case 'starts_with':
                    $q->where($dbfield, 'LIKE', "$dbvalue%");
                    break;
                case 'ends_with':
                    $q->where($dbfield, 'LIKE', "%$dbvalue");
                    break;
                case 'empty':
                    $q->where(function ($sub) use ($dbfield) {
                        $sub->whereNull($dbfield)
                            ->orWhere($dbfield, '');
                    });
                    break;
                case 'not_empty':
                    $q->where(function ($sub) use ($dbfield) {
                        $sub->whereNotNull($dbfield)
                            ->where($dbfield, '!=', '');
                    });
                    break;
            }
        });

        $sort_field = $validated['sort_field'] ?? 'H_Hospital';
        $sort_direction = $validated['sort_direction'] ?? 'asc';
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $hospitals = $query->paginate(200);

        $facilityformsselects = Facilityform::query()
            ->select(['id', 'slug'])
            ->orderBy('name', 'asc')
            ->pluck('slug', 'id');

        return view('user.hospitals.index', compact('hospitals', 'sort_direction', 'facilityformsselects'));
    }

    public function create()
    {
        return view('user.hospitals.create');
    }

    public function store(StoreHospitalRequest $request)
    {
        $hospital = new Hospital($request->validated());
        $hospital->created_by = session('user.contractor.C_Name');
        $hospital->H_UpdUser = session('user.contractor.C_Name');
        $hospital->timezone_offset = Helper::timezones($request->H_State);
        $hospital->save();

        return redirect()
            ->route('user.hospitals.show', $hospital->H_ID)
            ->with('success', 'Data has been saved');
    }

    public function show(Hospital $hospital)
    {
        $workorders = Workorder::query()
            ->where('W_Hospital', $hospital->H_Hospital)
            ->orderBy('W_WorkOrder', 'DESC')
            ->get();

        $cioxsiteid = Cioxsiteid::query()
            ->where('C_Hospital', $hospital->H_Hospital)
            ->first();

        // dd($hospital);
        return view('user.hospitals.show', compact('hospital', 'cioxsiteid', 'workorders'));
    }

    public function edit(Hospital $hospital)
    {
        return view('user.hospitals.edit', compact('hospital'));
    }

    public function update(UpdateHospitalRequest $request, Hospital $hospital)
    {
        $hospitalold = $hospital;
        $hospitalold = $hospitalold->toArray();

        $hospital->update($request->validated() + [
            'timezone_offset' => Helper::timezones($request->H_State),
            'H_UpdUser' => session('user.contractor.C_Name'),
        ]);

        $before = array_diff_assoc($hospitalold, $hospital->toArray());
        $after = array_diff_assoc($hospital->toArray(), $hospitalold);

        if ($before) {
            ksort($before);
            ksort($after);
            $data = "Previous Data:\r\n";
            foreach ($before as $key => $value) {
                $data .= $key . ' = ' . $value . "\r\n";
            }
            $data .= "\r\n";
            $data .= "Subsequent Data:\r\n";
            foreach ($after as $key => $value) {
                $data .= $key . ' = ' . $value . "\r\n";
            }
            $data = rtrim($data);

            $datachange = new Datachange();
            $datachange->model = 'hospitals';
            $datachange->foreign_key = $hospital->H_ID;
            $datachange->data = $data;
            $datachange->created_by = session('user.contractor.C_Name');
            $datachange->save();
        }

        return redirect()
            ->route('user.hospitals.show', $hospital->H_ID)
            ->with('success', 'Data has been saved');
    }

    public function transfer(Request $request)
    {
        $specialauthfile = $request->input('specialauthfile');
        $docusign = $request->input('docusign');
        $facilityformid = $request->input('facilityformid');

        $selectedhospitalids = array_filter($request->input('Hospital.selected'));

        if (empty($selectedhospitalids)) {
            return back()->with('danger', 'Invalid request Hospitals not selected');
        }

        if (! $specialauthfile && ! $docusign) {
            return back()->with('danger', 'Invalid request specialauthfile or docusign not selected');
        }

        $facilityform = Facilityform::find($facilityformid);

        $fields = [
            'H_UpdUser' => session('user.contractor.C_Name'),
        ];

        if (! $facilityform) {
            if ($specialauthfile) {
                $fields += ['H_SpecialAuthFile' => DB::raw('NULL')];
            }
            if ($docusign) {
                $fields += [
                    'H_Docusign' => DB::raw('NULL'),
                    'auth_docusign_changed' => now(),
                ];
            }
        }

        if ($facilityform) {
            if ($specialauthfile) {
                $fields += ['H_SpecialAuthFile' => $facilityform->file_name];
            }
            if ($docusign) {

                // if(!$facilityform->docusign_templateid_production) {
                //     $request->session()->flash('danger', 'Facility form does not have a docusign template id');
                //     return back();
                // }

                $fields += [
                    'H_Docusign' => $facilityform->slug,
                    'auth_docusign_changed' => now(),
                ];
            }
        }

        Hospital::query()
            ->whereIn('H_ID', $selectedhospitalids)
            ->update($fields);

        return back()->with('success', 'Hospitals changed');
    }

    public function fileupload(Request $request, Hospital $hospital)
    {
        $request->validate([
            'uploadfile' => 'required|file|mimes:pdf,tif',
            'filename' => 'required|string|max:255|regex:/^[\w\-. ]+$/',
        ]);

        $file = $request->file('uploadfile');
        $originalInput = basename($request->input('filename'));
        $filenameOnly = pathinfo($originalInput, PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());

        $directory = '\\\\server2\\eisaccess\\FacilityForms';
        $destination = $directory . '\\' . $filenameOnly . '.' . $extension;

        if (! move_uploaded_file($file->getRealPath(), $destination)) {
            return back()->with('danger', 'Failed to move uploaded file.');
        }

        if (is_file($destination)) {
            $hospital->upload_by = session('user.contractor.C_Name');
            $hospital->upload_date = now();
            $hospital->save();

            return back()->with('success', 'File is uploaded: ' . $destination);
        }

        return back()->with('danger', 'File was not uploaded');
    }

    public function destroy(Hospital $hospital)
    {
        //
    }
}
