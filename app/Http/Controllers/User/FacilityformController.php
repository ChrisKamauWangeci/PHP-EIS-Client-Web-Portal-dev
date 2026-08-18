<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacilityformRequest;
use App\Http\Requests\UpdateFacilityformRequest;
use App\Models\Facilityform;
use Illuminate\Http\Request;

class FacilityformController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Facilityform::query()
            ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', '%' . $v . '%'))
            ->when($filters['file_name'] ?? null, fn ($q, $v) => $q->where('file_name', 'LIKE', '%' . $v . '%'))
            ->when($filters['docusign_templateid_production'] ?? null, fn ($q, $v) => $q->where('docusign_templateid_production', $v))
            ->when($filters['created_by'] ?? null, fn ($q, $v) => $q->where('created_by', $v))
            ->when($filters['updated_by'] ?? null, fn ($q, $v) => $q->where('updated_by', $v));

        $sort_field = $request->query('sort_field', 'name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $facilityforms = $query->paginate(100);

        return view('user.facilityforms.index', compact('facilityforms', 'sort_direction'));
    }

    public function create()
    {
        return view('user.facilityforms.create');
    }

    public function store(StoreFacilityformRequest $request)
    {
        $facilityform = new Facilityform($request->validated());
        $facilityform->created_by = session('user.contractor.C_Name');
        $facilityform->updated_by = session('user.contractor.C_Name');
        $facilityform->save();

        return redirect()
            ->route('user.facilityforms.show', $facilityform->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Facilityform $facilityform)
    {
        return view('user.facilityforms.show', compact('facilityform'));
    }

    public function edit(Facilityform $facilityform)
    {
        return view('user.facilityforms.edit', compact('facilityform'));
    }

    public function update(UpdateFacilityformRequest $request, Facilityform $facilityform)
    {
        $facilityform->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.facilityforms.show', $facilityform->id)
            ->with('success', 'Data has been saved');
    }

    public function fileupload(Request $request, Facilityform $facilityform)
    {
        $file = $request->file('uploadfile');
        $filetype = $request->input('filetype');
        $filename = $request->input('filename');
        $clientfilename = $file->getClientOriginalName();

        if (! empty($clientfilename)) {

            $extension = $file->getClientOriginalExtension();

            if (! in_array($extension, ['pdf'])) {
                $request->session()->flash('danger', 'Uploaded file has an invalid file extension');

                return back();
            }

            $directory = '\\\\ftpserver\\ftpserver\\facilityforms\\';
            if ($filetype == 'facilityformsfillable') {
                $directory = '\\\\ftpserver\\ftpserver\\facilityformsfillable\\';
            }

            $filename = $directory . $filename;

            $file->move($directory, basename($filename));

            if (is_file($filename)) {
                $request->session()->flash('success', 'File is uploaded: ' . $filename);

                return back();
            }

            return back()->with('danger', 'File was not uploaded');
        }
    }

    public function destroy(Facilityform $facilityform)
    {
        $facilityform->delete();

        return redirect()
            ->route('user.facilityforms.index')
            ->with('success', 'Data has been saved');
    }
}
