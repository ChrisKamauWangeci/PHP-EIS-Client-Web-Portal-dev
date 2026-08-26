<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Exports\EhrorderssearchresultsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEhrorderRequest;
use App\Models\Ehrorderssearchresult;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class EhrorderssearchresultController extends Controller
{
    public function requestrecords($id)
    {
        $ehrorderssearchresult = Ehrorderssearchresult::findOrFail($id);
        $ehrorderssearchresult->status = 'requested';
        $ehrorderssearchresult->created_by = session('user.contractor.C_Name');
        $ehrorderssearchresult->requested_at = now();
        $ehrorderssearchresult->save();

        return view('user.ehrorderssearchresults._status_button', ['ehrorderssearchresult' => $ehrorderssearchresult]);
    }

    public function index(Request $request)
    {
        $filters = $request->query();

        // $query = Ehrorderssearchresult::query()
        //     ->select([
        //         'ehrorderssearchresults.*',
        //         'ehrorders.first_name',
        //         'ehrorders.last_name',
        //     ])
        //     ->join('ehrorders', 'ehrorderssearchresults.ehrorder_id', '=', 'ehrorders.id')
        //     ->when($filters['workorder_id'] ?? null, fn($q, $v) => $q->where('ehrorderssearchresults.workorder_id', $v))
        //     ->when($filters['ehrorder_id'] ?? null, fn($q, $v) => $q->where('ehrorderssearchresults.ehrorder_id', $v))
        //     ->when($filters['status'] ?? null, fn($q, $v) => $q->where('ehrorderssearchresults.status', $v))
        //     ->when(array_key_exists('consent_required', $filters), function ($q) use ($filters) {
        //         return match ($filters['consent_required']) {
        //             'null' => $q->whereNull('ehrorderssearchresults.consent_required'),
        //             'not_null' => $q->whereNotNull('ehrorderssearchresults.consent_required'),
        //             default => null,
        //         };
        //     })
        //     ->when($filters['managing_organization'] ?? null, fn($q, $v) => $q->where('ehrorderssearchresults.managing_organization', 'like', "%$v%"))
        //     ->when($filters['service_provider'] ?? null, fn($q, $v) => $q->where('ehrorders.service_provider', $v))
        //     ->when($filters['company_name'] ?? null, fn($q, $v) => $q->where('ehrorderssearchresults.company_name', 'like', "%$v%"))
        //     ->when($filters['first_name'] ?? null, fn($q, $v) => $q->where('ehrorders.first_name', 'like', "%$v%"))
        //     ->when($filters['last_name'] ?? null, fn($q, $v) => $q->where('ehrorders.last_name', 'like', "%$v%"))
        //     ->when($filters['received_at_from'] ?? null, fn($q, $v) => $q->whereDate('ehrorderssearchresults.received_at', '>=', $v))
        //     ->when($filters['received_at_to'] ?? null, fn($q, $v) => $q->whereDate('ehrorderssearchresults.received_at', '<=', $v))
        //     ->when($filters['created_at_from'] ?? null, fn($q, $v) => $q->whereDate('ehrorderssearchresults.created_at', '>=', $v))
        //     ->when($filters['created_at_to'] ?? null, fn($q, $v) => $q->whereDate('ehrorderssearchresults.created_at', '<=', $v))
        //     ->when(($filters['dbfield'] ?? null) && ($filters['dbconditions'] ?? null), function ($q) use ($filters) {
        //         $dbfield = $filters['dbfield'];
        //         $dbconditions = $filters['dbconditions'];
        //         $dbvalue = $filters['dbvalue'] ?? '';

        //         switch ($dbconditions) {
        //             case 'eq':
        //                 $q->where($dbfield, '=', $dbvalue);
        //                 break;
        //             case 'neq':
        //                 $q->where($dbfield, '!=', $dbvalue);
        //                 break;
        //             case 'contains':
        //                 $q->where($dbfield, 'LIKE', "%$dbvalue%");
        //                 break;
        //             case 'not_contains':
        //                 $q->where($dbfield, 'NOT LIKE', "%$dbvalue%");
        //                 break;
        //             case 'starts_with':
        //                 $q->where($dbfield, 'LIKE', "$dbvalue%");
        //                 break;
        //             case 'ends_with':
        //                 $q->where($dbfield, 'LIKE', "%$dbvalue");
        //                 break;
        //             case 'empty':
        //                 $q->where(function ($sub) use ($dbfield) {
        //                     $sub->whereNull($dbfield)
        //                         ->orWhere($dbfield, '');
        //                 });
        //                 break;
        //             case 'not_empty':
        //                 $q->where(function ($sub) use ($dbfield) {
        //                     $sub->whereNotNull($dbfield)
        //                         ->where($dbfield, '!=', '');
        //                 });
        //                 break;
        //         }
        //     });

        $query = $this->buildQuery($filters);

        $sort_field = $request->query('sort_field', 'ehrorderssearchresults.created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $ehrorderssearchresults = $query->with('ehrorder')->paginate(200);

        return view('user.ehrorderssearchresults.index', compact('ehrorderssearchresults', 'sort_direction'));
    }

    public function export(Request $request)
    {
        $filters = $request->query();

        $query = $this->buildQuery($filters);

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'asc');

        $query->orderBy($sort_field, $sort_direction);

        $hasDateRange =
            ! empty($filters['created_at_from']) ||
            ! empty($filters['created_at_to']) ||
            ! empty($filters['received_at_from']) ||
            ! empty($filters['received_at_to']);

        if (! $hasDateRange) {
            $query->limit(5000);
        }

        $rows = $query->get();

        $type = strtolower($request->query('type', 'xlsx'));

        $isCsv = $type === 'csv';

        return (new EhrorderssearchresultsExport($rows))
            ->download(
                'ehrorderssearchresults.' . ($isCsv ? 'csv' : 'xlsx'),
                $isCsv ? Excel::CSV : Excel::XLSX,
                $isCsv ? ['Content-Type' => 'text/csv'] : []
            );
    }

    private function buildQuery(array $filters)
    {
        return Ehrorderssearchresult::query()
            ->select([
                'ehrorderssearchresults.*',
                'ehrorders.first_name',
                'ehrorders.last_name',
            ])
            ->join('ehrorders', 'ehrorderssearchresults.ehrorder_id', '=', 'ehrorders.id')
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('ehrorderssearchresults.workorder_id', $v))
            ->when($filters['ehrorder_id'] ?? null, fn ($q, $v) => $q->where('ehrorderssearchresults.ehrorder_id', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('ehrorderssearchresults.status', $v))
            ->when(array_key_exists('consent_required', $filters), function ($q) use ($filters) {
                return match ($filters['consent_required']) {
                    'null' => $q->whereNull('ehrorderssearchresults.consent_required'),
                    'not_null' => $q->whereNotNull('ehrorderssearchresults.consent_required'),
                    default => null,
                };
            })
            ->when($filters['managing_organization'] ?? null, fn ($q, $v) => $q->where('ehrorderssearchresults.managing_organization', 'like', "%$v%"))
            ->when($filters['service_provider'] ?? null, fn ($q, $v) => $q->where('ehrorders.service_provider', $v))
            ->when($filters['company_name'] ?? null, fn ($q, $v) => $q->where('ehrorderssearchresults.company_name', 'like', "%$v%"))
            ->when($filters['first_name'] ?? null, fn ($q, $v) => $q->where('ehrorders.first_name', 'like', "%$v%"))
            ->when($filters['last_name'] ?? null, fn ($q, $v) => $q->where('ehrorders.last_name', 'like', "%$v%"))
            ->when($filters['received_at_from'] ?? null, fn ($q, $v) => $q->whereDate('ehrorderssearchresults.received_at', '>=', $v))
            ->when($filters['received_at_to'] ?? null, fn ($q, $v) => $q->whereDate('ehrorderssearchresults.received_at', '<=', $v))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->whereDate('ehrorderssearchresults.created_at', '>=', $v))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->whereDate('ehrorderssearchresults.created_at', '<=', $v))
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
            });
    }

    public function show(Ehrorderssearchresult $ehrorderssearchresult)
    {
        return view('user.ehrorderssearchresults.show', compact('ehrorderssearchresult'));
    }

    public function edit(Request $request, Ehrorderssearchresult $ehrorderssearchresult)
    {
        return view('user.ehrorderssearchresults.edit', compact('ehrorderssearchresult'));
    }

    public function update(UpdateEhrorderRequest $request, Ehrorderssearchresult $ehrorderssearchresult)
    {
        $ehrorderssearchresult->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.ehrorderssearchresults.show', $ehrorderssearchresult->id)
            ->with('success', 'Data has been saved');
    }

    // public function destroy(Ehrorderssearchresult $ehrorderssearchresult)
    // {
    //     $ehrorderssearchresult->delete();
    //     return redirect()
    //         ->route('user.ehrorderssearchresults.index')
    // }
}
