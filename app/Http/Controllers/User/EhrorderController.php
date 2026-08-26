<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexEhrorderRequest;
use App\Http\Requests\StoreEhrorderRequest;
use App\Http\Requests\UpdateEhrorderRequest;
use App\Mail\SmartaccessEmail;
use App\Models\Ehrorder;
use App\Models\Ehrordersdocument;
use App\Models\Ehrorderssearchresult;
use App\Models\EpicOrganization;
use App\Models\Smartaccesstheme;
use App\Services\EhrorderCoverpageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EhrorderController extends Controller
{
    public function index(IndexEhrorderRequest $request)
    {
        $filters = $request->validated();

        $query = Ehrorder::query()
            ->when($filters['id'] ?? null, fn ($q, $v) => $q->where('id', $v))
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['service_provider'] ?? null, fn ($q, $v) => $q->where('service_provider', $v))
            ->when($filters['company_name'] ?? null, fn ($q, $v) => $q->where('company_name', $v))
            ->when($filters['last_name'] ?? null, fn ($q, $v) => $q->where('last_name', 'like', "%$v%"))
            ->when($filters['first_name'] ?? null, fn ($q, $v) => $q->where('first_name', 'like', "%$v%"))
            ->when($filters['gender'] ?? null, fn ($q, $v) => $q->where('gender', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['submitted_at_from'] ?? null, fn ($q, $v) => $q->whereDate('submitted_at', '>=', $v))
            ->when($filters['submitted_at_to'] ?? null, fn ($q, $v) => $q->whereDate('submitted_at', '<=', $v))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when(($filters['dbfield'] ?? null) && ($filters['dbconditions'] ?? null), function ($q) use ($filters) {
                $dbfield = $filters['dbfield'];
                $dbconditions = $filters['dbconditions'];
                $dbvalue = $filters['dbvalue'] ?? '';

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
            })
            ->with('ehrorderssearchresults');

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $ehrorders = $query->paginate(200);

        return view('user.ehrorders.index', compact('ehrorders', 'sort_direction'));
    }

    public function show(Ehrorder $ehrorder)
    {
        $ehrorderssearchresults = Ehrorderssearchresult::query()
            ->where('ehrorder_id', $ehrorder->id)
            ->get();

        $ehrordersdocuments = Ehrordersdocument::query()
            ->where('ehrorder_id', $ehrorder->id)
            ->get();

        $site_name = config('site_config.site_name');

        $epicOrganizations = null;

        try {
            $patientSearchFile = "{$site_name}\\epic\\processed_patientsearch\\{$ehrorder->id}-patientsearch.json";
            $patientsearch = Storage::disk('ftpserver2')->get($patientSearchFile);

            if (! empty($patientsearch) && is_string($patientsearch)) {
                $data = json_decode($patientsearch, true);
            } else {
                $data = null;
            }

            // dump($data);
            // $orgIds = [];

            if (isset($data['entry'])) {
                foreach ($data['entry'] as $entry) {
                    if (isset($entry['resource']['issue'])) {
                        foreach ($entry['resource']['issue'] as $issue) {
                            if (isset($issue['diagnostics']) && str_starts_with($issue['diagnostics'], 'Organization/')) {
                                $orgIds[] = str_replace('Organization/', '', $issue['diagnostics']);
                            }
                        }
                    }
                }
            }

            // // Output the IDs
            // dump($orgIds);

            // echo "<pre>";

            $epicOrganizations = EpicOrganization::query()
                ->whereIn('organization_id', $orgIds)
                ->limit(5000)
                ->get();

            // print_r($epicOrganizations);

        } catch (\Exception $e) {
            $patientsearch = null;
            $epicOrganizations = null;
        }

        return view('user.ehrorders.show', compact('ehrorder', 'ehrorderssearchresults', 'ehrordersdocuments', 'patientSearchFile', 'patientsearch', 'epicOrganizations'));
    }

    public function create()
    {
        return view('user.ehrorders.create');
    }

    public function store(StoreEhrorderRequest $request)
    {
        $ehrorder = new Ehrorder($request->validated());
        $ehrorder->uuid = Str::uuid();
        $ehrorder->created_by = session('user.contractor.C_Name');
        $ehrorder->updated_by = session('user.contractor.C_Name');
        $ehrorder->save();

        return redirect()
            ->route('user.ehrorders.show', $ehrorder->id)
            ->with('success', 'Data has been saved');
    }

    public function edit(Request $request, Ehrorder $ehrorder)
    {
        return view('user.ehrorders.edit', compact('ehrorder'));
    }

    public function update(UpdateEhrorderRequest $request, Ehrorder $ehrorder)
    {
        $ehrorder->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.ehrorders.show', $ehrorder->id)
            ->with('success', 'Data has been saved');
    }

    private function theme(Ehrorder $ehrorder): array
    {
        return Smartaccesstheme::query()
            ->where('company_name', $ehrorder->company_name)
            ->first()?->toArray()

            ?? Smartaccesstheme::query()
                ->where('company_name', 'EIS')
                ->firstOrFail()
                ->toArray();
    }

    public function invitationemailfasten(Request $request, int $id)
    {
        $ehrorder = Ehrorder::query()
            ->where('service_provider', 'fasten_health')
            ->where('id', $id)
            ->firstOrFail();

        $data['ehrorder'] = $ehrorder;
        $data['from'] = 'info@expressimagingservices.com';
        $data['subject'] = 'Connect to Your Health Records';
        $data['view'] = 'emails.smartaccess.smartaccess';

        if ($ehrorder->company_name == 'ABACUS' || $ehrorder->company_name == 'ABACUS CLIENT DIRECT' || $ehrorder->company_name == 'ABACUS AGENT') {
            $data['view'] = 'emails.smartaccess.smartaccess-abacus';
        }

        $data['theme'] = $this->theme($ehrorder);

        try {

            if ($request->isMethod('get')) {
                return (new SmartaccessEmail($data))->render();
            }

            Mail::mailer('smtprelaygmail')
                ->to($ehrorder->email_address)
                ->cc([
                    'anhle@expressimagingservices.com',
                    'andras@expressimagingservices.com',
                ])
                ->send(new SmartaccessEmail($data));
        } catch (\Throwable $e) {
            return redirect()
                ->route('user.ehrorders.show', $id)
                ->with('danger', 'Error sending email: ' . $e->getMessage());
        }

        return redirect()
            ->route('user.ehrorders.show', $id)
            ->with('success', 'Email sent to: ' . $ehrorder->email_address);
    }

    // public function destroy(Ehrorder $ehrorder)
    // {
    //     $ehrorder->delete();
    //     return redirect()
    //         ->route('user.ehrorders.index')
    //         ->with('success', 'Record has been deleted');
    // }

    public function coverpage(Request $request, Ehrorder $ehrorder, EhrorderCoverpageService $ehrorderCoverpageService)
    {
        $pdf = $ehrorderCoverpageService->generate($ehrorder);

        return $pdf->stream(
            $ehrorder->workorder_id . '-coverpage.pdf'
        );
    }
}
