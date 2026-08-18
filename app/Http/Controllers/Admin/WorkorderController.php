<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contractor;
use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WorkorderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workorder::query();

        $query->select([
            'Workorder.W_WorkOrder',
            'Workorder.W_Contractor',
            'Workorder.W_Owner',
            'Workorder.W_Status',
            'Workorder.W_Urgent',
            'Workorder.W_FirstName',
            'Workorder.W_MiddleInit',
            'Workorder.W_LastName',
            'Workorder.W_ImagePages',
            'Workorder.W_Hospital',
            'Workorder.W_FollowUpDt',
            'Workorder.W_FollowUpStatus',
            'Workorder.W_UpdDate',
            'Workorder.W_ReceiveDate',
            'Workorder.W_CompletedDate',
            'Requestor.R_Company as Requestor_R_Company',
            'Hospital.H_Hospital as Hospital_H_Hospital',
            'Hospital.H_Hospital2 as Hospital_H_Hospital2',
            'Hospital.H_Phone as Hospital_H_Phone',
            'Hospital.H_City as Hospital_H_City',
            'Hospital.H_State as Hospital_H_State',
            'Hospital.H_Zip as Hospital_H_Zip',
            'Hospital.H_CopyService as Hospital_H_CopyService',
        ]);

        $query->when($filters['W_Workorder'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Workorder', $v));
        $query->when($filters['W_Status'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Status', $v));
        $query->when($filters['W_FirstName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FirstName', 'LIKE', '%' . $v . '%'));
        $query->when($filters['W_LastName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_LastName', 'LIKE', '%' . $v . '%'));
        $query->when($filters['W_SS'] ?? null, fn ($q, $v) => $q->where('Workorder.W_SS', 'LIKE', '%' . $v . '%'));
        $query->when($filters['W_DOB'] ?? null, fn ($q, $v) => $q->where('Workorder.W_DOB', $v . ' 00:00:00.000'));
        $query->when($filters['W_Hospital'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Hospital', 'LIKE', '%' . $v . '%'));
        $query->when($filters['W_Urgent'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Urgent', $v));
        $query->when($filters['receivedfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '>=', $v));
        $query->when($filters['receivedto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '<=', $v));
        $query->when($filters['followupfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FollowUpDt', '>=', $v));
        $query->when($filters['followupto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FollowUpDt', '<=', $v));

        $query->when(($filters['dbfield'] ?? null) && ($filters['dbconditions'] ?? null), function ($q) use ($filters) {
            $dbfield = $filters['dbfield'];
            $dbconditions = $filters['dbconditions'];
            $dbvalue = $filters['dbvalue'] ?? '';

            switch ($dbconditions) {
                case 'contains':
                    $q->where($dbfield, 'LIKE', "%$dbvalue%");
                    break;

                case 'doesnotcontain':
                    $q->where($dbfield, 'NOT LIKE', "%$dbvalue%");
                    break;

                case 'beginswith':
                    $q->where($dbfield, 'LIKE', "$dbvalue%");
                    break;

                case 'endswith':
                    $q->where($dbfield, 'LIKE', "%$dbvalue");
                    break;

                case 'isequalto':
                    $q->where($dbfield, '=', $dbvalue);
                    break;

                case 'isnotequalto':
                    $q->where($dbfield, '!=', $dbvalue);
                    break;

                case 'isempty':
                    $q->where(function ($sub) use ($dbfield) {
                        $sub->whereNull($dbfield)
                            ->orWhere($dbfield, '');
                    });
                    break;

                case 'isnotempty':
                    $q->where(function ($sub) use ($dbfield) {
                        $sub->whereNotNull($dbfield)
                            ->where($dbfield, '!=', '');
                    });
                    break;
            }
        });

        $query->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name');
        $query->leftJoin('Hospital', 'Workorder.W_Hospital', '=', 'Hospital.H_Hospital');

        $sort_field = $request->query('sort_field', 'W_ReceiveDate');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workorders = $query->paginate(100);

        return view('admin.workorders.index', compact('workorders', 'sort_direction'));
    }

    public function stats(Request $request)
    {
        $display = $request->query('display') ?? 1;
        $years = $request->query('years') ?? 3;
        $statuses = $request->query('statuses');

        $filters = $request->query();

        $query = Workorder::query();

        $query->select(DB::raw('count(*) as counter'), DB::raw('DATEPART(year, W_ReceiveDate) as year'));

        $query->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name');
        $query->groupby(DB::raw('DATEPART(year, W_ReceiveDate)'));

        $query->orderBy('year');

        if ($filters['statuses'] ?? null) {
            $query->addSelect(DB::raw("SUM(case when W_Status = 'Incomplete' then 1 else 0 end) as count_incomplete"));
            $query->addSelect(DB::raw("SUM(case when W_Status = 'Complete' then 1 else 0 end) as count_complete"));
            $query->addSelect(DB::raw("SUM(case when W_Status = 'Cancel' then 1 else 0 end) as count_cancel"));
            $query->addSelect(DB::raw("SUM(case when W_Status = 'Duplicate' then 1 else 0 end) as count_duplicate"));
            $query->addSelect(DB::raw("SUM(case when W_Status = 'Delete' then 1 else 0 end) as count_delete"));
        }

        if ($display) {
            $query->addSelect(DB::raw('DATEPART(month, W_ReceiveDate) as month'));
            $query->groupby(DB::raw('DATEPART(month, W_ReceiveDate)'));
            $query->orderBy('month');
        }

        $query->when($filters['R_Company'] ?? null, fn ($q, $v) => $q->where('Requestor.R_Company', $v));
        $query->when($filters['W_Requestor'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Requestor', $v));
        $query->when($filters['W_Owner'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Owner', $v));
        $query->when($filters['W_Status'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Status', $v));
        $query->when($filters['W_Hospital'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Hospital', 'LIKE', '%' . $v . '%'));
        $query->when($filters['receivedfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '>=', $v));
        $query->when($filters['receivedto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '<=', $v));
        $query->when($filters['years'] ?? null, fn ($q, $v) => $q->whereDate('Workorder.W_ReceiveDate', '>', now()->subYear($v)));

        $query->when($filters['completedfrom'] ?? null, function ($q, $v) {
            $q->where('Workorder.W_Status', 'Complete');
            $q->where('Workorder.W_CompletedDate', '>=', $v);
        });
        $query->when($filters['completedto'] ?? null, function ($q, $v) {
            $q->where('Workorder.W_Status', 'Complete');
            $q->where('Workorder.W_CompletedDate', '<=', $v);
        });

        $query->when($filters['dbfield'] ?? null && $filters['dbconditions'] ?? null, function ($q) use ($filters) {
            $dbfield = $filters['dbfield'];
            $dbconditions = $filters['dbconditions'];
            $dbvalue = $filters['dbvalue'];

            if ($dbconditions == 'contains') {
                $q->where($dbfield, 'LIKE', '%' . $dbvalue . '%');
            } elseif ($dbconditions == 'doesnotcontain') {
                $q->where($dbfield, 'NOT LIKE', '%' . $dbvalue . '%');
            } elseif ($dbconditions == 'beginswith') {
                $q->where($dbfield, 'LIKE', $dbvalue . '%');
            } elseif ($dbconditions == 'endswith') {
                $q->where($dbfield, 'LIKE', '%' . $dbvalue);
            } elseif ($dbconditions == 'isequalto') {
                $q->where($dbfield, $dbvalue);
            } elseif ($dbconditions == 'isnotequalto') {
                $q->where($dbfield, '!=', $dbvalue);
            } elseif ($dbconditions == 'isempty') {
                $q->whereNull($dbfield)->orWhere($dbfield, '');
            } elseif ($dbconditions == 'isnotempty') {
                $q->whereNotNull($dbfield)->orWhere($dbfield, '>', '');
            }
        });

        $workorders = $query->get();

        $companies = Cache::remember('admin-workorders-index-companies-' . $this->subdomain(), 180, function () {
            return $companies = Company::select('C_Name')->orderBy('C_Name', 'ASC')->pluck('C_Name', 'C_Name')->toArray();
        });

        $contractors = Cache::remember('admin-workorders-index-contractors-' . $this->subdomain(), 180, function () {
            return $contractors = Contractor::select('C_Name')->where('C_Caller', 1)->orderBy('C_Name', 'ASC')->pluck('C_Name', 'C_Name')->toArray();
        });

        return view('admin.workorders.stats', compact('workorders', 'companies', 'contractors', 'display', 'years', 'statuses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Workorder $workorder)
    {
        return view('admin.workorders.show', compact('workorder'));
    }

    public function edit(Workorder $workorder)
    {
        //
    }

    public function update(Request $request, Workorder $workorder)
    {
        //
    }

    public function destroy(Workorder $workorder)
    {
        //
    }
}
