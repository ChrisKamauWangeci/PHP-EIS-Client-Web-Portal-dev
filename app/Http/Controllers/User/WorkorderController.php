<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Exports\WorkordersExport;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateWorkorderHospitalRequest;
use App\Http\Requests\UpdateWorkorderRequest;
use App\Mail\Emailer;
use App\Models\Apsorder;
use App\Models\Billtopicklist;
use App\Models\Contractor;
use App\Models\Creditcard;
use App\Models\Datachange;
use App\Models\Drfeeupdatehst;
use App\Models\Examrequest;
use App\Models\Facilityform;
use App\Models\Hospital;
use App\Models\Hospitalraw;
use App\Models\IncomingApsLog;
use App\Models\Insuranceagencyexception;
use App\Models\Insurancecompany;
use App\Models\Northwesternmutual;
use App\Models\Requestor;
use App\Models\Requestorrole;
use App\Models\Statuslist;
use App\Models\Statustrigger;
use App\Models\Ticket;
use App\Models\Underwriter;
use App\Models\Woin;
use App\Models\Workorder;
use App\Models\Workorderdetail;
use App\Models\Workorderduplicate;
use App\Models\Workorderfiledownload;
use App\Models\Workorderholdtime;
use App\Models\Workorderreopen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Excel;

class WorkorderController extends Controller
{
    public function prg(Request $request)
    {
        $params = array_filter($request->except('_token'));

        return redirect()
            ->route('user.workorders.index', $params);
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'database' => 'nullable|in:eis,usaa,nyl,ehr,eisuat',
            'search' => 'nullable|boolean',
            'type' => 'nullable|string|in:all,new,my',
            'W_Workorder' => 'nullable|integer|min:1|max:99999999',
            'W_Status' => 'nullable|string|in:Incomplete,Complete,Cancel,Duplicate,Delete',
            'W_FirstName' => 'nullable|string',
            'W_LastName' => 'nullable|string',
            'W_SS' => 'nullable|string',
            'W_DOB' => 'nullable|date',
            'W_Hospital' => 'nullable|string',
            'W_Urgent' => 'nullable|boolean',
            'W_Owner' => 'nullable|string',
            'dbfield' => 'nullable|string|in:W_InsPolicy,W_InsCompany,W_Contractor,W_Owner,W_PolicyNo,W_Requestor,W_Agent,Requestor.R_Company,W_BillCompany,W_LastName,W_FirstName,W_DOB,W_SS,W_YearsOfRecord,W_AuthorizedFile,W_Hospital,Hospital.H_City,Hospital.H_State,Hospital.H_Zip,Hospital.H_Phone,Hospital.H_CopyService',
            'dbconditions' => 'nullable|string|in:eq,neq,contains,not_contains,starts_with,ends_with,empty,not_empty',
            'dbvalue' => 'nullable|string',
            'is_hold' => 'nullable|boolean',
            'hold_reason' => 'nullable|string',
            'receivedfrom' => 'nullable|date',
            'receivedto' => 'nullable|date',
            'completedfrom' => 'nullable|date',
            'completedto' => 'nullable|date',
            'followupfrom' => 'nullable|date',
            'followupto' => 'nullable|date',
            'W_InsCompany' => 'nullable|string',
            'sort_field' => 'nullable|string|in:W_WorkOrder,W_ReceiveDate,W_FirstName,W_LastName,W_Hospital,Hospital_timezone_offset,W_Contractor,W_Owner,Requestor_R_Company,W_FollowUpStatus,W_FollowUpDt,W_UpdDate,W_Urgent,workorderholdtimes.reason,workorderholdtimes.date_start,age',
            'sort_direction' => 'nullable|in:asc,desc',
            'limit' => 'nullable|integer|in:200,500,1000',
        ]);

        $search = $validated['search'] ?? false;
        $type = $validated['type'] ?? 'all';

        $is_hold = $validated['is_hold'] ?? null;
        $hold_reason = $validated['hold_reason'] ?? null;

        $limit = $validated['limit'] ?? 200;

        $database = $validated['database'] ?? null;

        $db = $validated['database'] ?? config('database.default');

        $query = Workorder::on($db);

        $fields = [
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
        ];
        if ($db != 'ehr') {
            $fields = array_merge($fields, [
                'Hospital.H_Docusign as Hospital_H_Docusign',
                'Hospital.timezone_offset as Hospital_timezone_offset',
            ]);
        }

        $query->leftJoin('Requestor', 'Workorder.W_Requestor', 'Requestor.R_Name');
        $query->leftJoin('Hospital', 'Workorder.W_Hospital', 'Hospital.H_Hospital');

        if ($is_hold || $hold_reason) {
            $query->join('workorderholdtimes', 'workorderholdtimes.workorder_id', 'Workorder.W_WorkOrder')
                ->whereNull('workorderholdtimes.date_end');

            if ($hold_reason) {
                $query->where('workorderholdtimes.reason', $hold_reason);
            }

            $fields = array_merge($fields, [
                'workorderholdtimes.reason as hold_reason',
                'workorderholdtimes.date_start as hold_date_start',
                'workorderholdtimes.date_end as hold_date_end',
            ]);
        }

        $query->select($fields);

        $query->when($validated['W_Workorder'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Workorder', $v));
        $query->when($validated['W_Status'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Status', $v));
        $query->when($validated['W_Urgent'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Urgent', $v));
        $query->when($validated['W_InsCompany'] ?? null, fn ($q, $v) => $q->where('Workorder.W_InsCompany', $v));

        $query->when($validated['W_FirstName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FirstName', 'LIKE', '%' . $v . '%'));
        $query->when($validated['W_LastName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_LastName', 'LIKE', '%' . $v . '%'));
        $query->when($validated['W_SS'] ?? null, fn ($q, $v) => $q->where('Workorder.W_SS', 'LIKE', '%' . $v . '%'));
        $query->when($validated['W_Hospital'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Hospital', 'LIKE', '%' . $v . '%'));

        $query->when($validated['W_DOB'] ?? null, fn ($q, $v) => $q->where('Workorder.W_DOB', $v . ' 00:00:00.000'));

        $query->when($validated['receivedfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '>=', Carbon::parse($v)->startOfDay()));
        $query->when($validated['receivedto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($validated['completedfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_CompletedDate', '>=', Carbon::parse($v)->startOfDay()));
        $query->when($validated['completedto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_CompletedDate', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($validated['followupfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FollowUpDt', '>=', Carbon::parse($v)->startOfDay()));
        $query->when($validated['followupto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FollowUpDt', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($validated['W_Owner'] ?? null, function ($q, $v) {
            if ($v == 'empty') {
                $q->whereNull('Workorder.W_Owner');
            } else {
                $q->where('Workorder.W_Owner', $v);
            }
        });

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

        $sort_field = $validated['sort_field'] ?? 'W_ReceiveDate';
        $sort_direction = $validated['sort_direction'] ?? 'desc';

        if ($sort_field == 'age') {
            $query->orderByRaw(
                "DATEDIFF(DAY, Workorder.W_ReceiveDate, ISNULL(Workorder.W_CompletedDate, GETDATE())) {$sort_direction}"
            );
        } else {
            $query->orderBy($sort_field, $sort_direction);
        }

        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        if ($search) {
            $workorders = $query->paginate($limit);
        } else {
            $workorders = null;
        }

        $agencies = Cache::remember('workorders-index-agencies-' . $this->subdomain() . '-' . $db, 180, function () use ($db) {
            return Insuranceagencyexception::on($db)
                ->select('CarrierName')
                ->distinct()
                ->orderBy('CarrierName', 'asc')
                ->pluck('CarrierName', 'CarrierName')
                ->toArray();
        });

        $contractorsselects = Cache::remember('workorders-index-contractors-' . $this->subdomain() . '-' . $db, 180, function () use ($db) {
            return Contractor::on($db)
                ->select('C_Name')
                ->where('C_Location', '!=', 'inactive')
                ->orWhereNull('C_Location')
                ->orderBy('C_Name', 'asc')
                ->pluck('C_Name', 'C_Name')
                ->toArray();
        });
        $contractorsselectswithempty = ['empty' => 'Not Assigned'] + $contractorsselects;

        session(['user.workordersurl' => url()->full()]);

        return view('user.workorders.index', compact('workorders', 'sort_direction', 'agencies', 'contractorsselects', 'contractorsselectswithempty', 'database', 'type', 'limit', 'is_hold', 'hold_reason'));
    }

    private function buildQuery($validated)
    {
        $search = $validated['search'] ?? false;
        $type = $validated['type'] ?? 'all';

        $is_hold = $validated['is_hold'] ?? null;
        $hold_reason = $validated['hold_reason'] ?? null;

        $limit = $validated['limit'] ?? 200;

        $database = $validated['database'] ?? null;

        $db = $validated['database'] ?? config('database.default');

        $query = Workorder::on($db);

        $fields = [
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
        ];
        if ($db != 'ehr') {
            $fields = array_merge($fields, [
                'Hospital.H_Docusign as Hospital_H_Docusign',
                'Hospital.timezone_offset as Hospital_timezone_offset',
            ]);
        }

        $query->leftJoin('Requestor', 'Workorder.W_Requestor', 'Requestor.R_Name');
        $query->leftJoin('Hospital', 'Workorder.W_Hospital', 'Hospital.H_Hospital');

        if ($is_hold || $hold_reason) {
            $query->join('workorderholdtimes', 'workorderholdtimes.workorder_id', 'Workorder.W_WorkOrder')
                ->whereNull('workorderholdtimes.date_end');

            if ($hold_reason) {
                $query->where('workorderholdtimes.reason', $hold_reason);
            }

            $fields = array_merge($fields, [
                'workorderholdtimes.reason as hold_reason',
                'workorderholdtimes.date_start as hold_date_start',
                'workorderholdtimes.date_end as hold_date_end',
            ]);
        }

        $query->select($fields);

        $query->when($validated['W_Workorder'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Workorder', $v));
        $query->when($validated['W_Status'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Status', $v));
        $query->when($validated['W_Urgent'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Urgent', $v));
        $query->when($validated['W_InsCompany'] ?? null, fn ($q, $v) => $q->where('Workorder.W_InsCompany', $v));

        $query->when($validated['W_FirstName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FirstName', 'LIKE', '%' . $v . '%'));
        $query->when($validated['W_LastName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_LastName', 'LIKE', '%' . $v . '%'));
        $query->when($validated['W_SS'] ?? null, fn ($q, $v) => $q->where('Workorder.W_SS', 'LIKE', '%' . $v . '%'));
        $query->when($validated['W_Hospital'] ?? null, fn ($q, $v) => $q->where('Workorder.W_Hospital', 'LIKE', '%' . $v . '%'));

        $query->when($validated['W_DOB'] ?? null, fn ($q, $v) => $q->where('Workorder.W_DOB', $v . ' 00:00:00.000'));

        $query->when($validated['receivedfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '>=', Carbon::parse($v)->startOfDay()));
        $query->when($validated['receivedto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_ReceiveDate', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($validated['completedfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_CompletedDate', '>=', Carbon::parse($v)->startOfDay()));
        $query->when($validated['completedto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_CompletedDate', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($validated['followupfrom'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FollowUpDt', '>=', Carbon::parse($v)->startOfDay()));
        $query->when($validated['followupto'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FollowUpDt', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($validated['W_Owner'] ?? null, function ($q, $v) {
            if ($v == 'empty') {
                $q->whereNull('Workorder.W_Owner');
            } else {
                $q->where('Workorder.W_Owner', $v);
            }
        });

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

        return $query;
    }

    public function export(Request $request)
    {
        $filters = $request->query();

        $query = $this->buildQuery($filters);

        $sort_field = $request->query('sort_field', 'W_ReceiveDate');
        $sort_direction = $request->query('sort_direction', 'asc');

        $query->orderBy($sort_field, $sort_direction);

        $hasDateRange =
            ! empty($filters['receivedfrom']) ||
            ! empty($filters['receivedto']) ||
            ! empty($filters['completedfrom']) ||
            ! empty($filters['completedto']);

        if (! $hasDateRange) {
            $query->limit(5000);
        }

        $rows = $query->get();

        $exporttype = strtolower($request->query('exporttype', 'xlsx'));

        $isCsv = $exporttype === 'csv';

        return (new WorkordersExport($rows))
            ->download(
                'workorders.' . ($isCsv ? 'csv' : 'xlsx'),
                $isCsv ? Excel::CSV : Excel::XLSX,
                $isCsv ? ['Content-Type' => 'text/csv'] : []
            );
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'Workorder.selected' => 'required|array|min:1',
            'W_Owner' => 'required|string',
        ]);

        $selectedIds = array_filter($validated['Workorder']['selected']);

        $workorders = Workorder::query()
            ->whereIn('W_WorkOrder', $selectedIds)
            ->get();

        $transferredIds = [];
        $contractorName = session('user.contractor.C_Name');

        foreach ($workorders as $workorder) {

            $prevData = [
                'Assigned To' => $workorder->W_Owner,
                'Updated By' => $workorder->W_UpdUser,
                'Updated Date' => $workorder->W_UpdDate,
                'Follow Up Date' => $workorder->W_FollowUpDt,
            ];

            $workorder->W_Owner = $validated['W_Owner'];
            $workorder->W_UpdUser = $contractorName;
            $workorder->W_UpdDate = now();
            $workorder->save();

            $transferredIds[] = $workorder->W_WorkOrder;

            $newData = [
                'Assigned To' => $workorder->W_Owner,
                'Updated By' => $workorder->W_UpdUser,
                'Updated Date' => $workorder->W_UpdDate,
            ];

            $logData = "Previous Data:\r\n";
            foreach ($prevData as $key => $value) {
                $logData .= "$key = $value\r\n";
            }

            $logData .= "\r\nSubsequent Data:\r\n";
            foreach ($newData as $key => $value) {
                $logData .= "$key = $value\r\n";
            }

            Datachange::create([
                'model' => 'workorders',
                'foreign_key' => $workorder->W_WorkOrder,
                'data' => rtrim($logData),
                'created_by' => $contractorName,
            ]);
        }

        if (count($transferredIds)) {
            $request->session()->flash('success', 'Workorders: ' . implode(', ', $transferredIds) . ' transferred to Assigned To: ' . $validated['W_Owner']);
        } else {
            $request->session()->flash('danger', 'No workorders were transferred.');
        }

        $workordersurl = session('user.workordersurl') ?? route('user.workorders.index');

        return redirect($workordersurl);
    }

    public function show(Request $request, $W_WorkOrder)
    {
        $W_WorkOrder = (int) $W_WorkOrder;
        if ($W_WorkOrder > 99999999) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', 'Invalid Workorder');
        }

        try {

            $workorder = Workorder::query()
                ->select([
                    'Workorder.W_WorkOrder',
                    'Workorder.W_PolicyNo',
                    'Workorder.W_Requestor',
                    'Workorder.W_Agent',
                    'Workorder.W_BillCompany',
                    'Workorder.W_ReceiveDate',
                    'Workorder.W_CompletedDate',
                    'Workorder.W_Contractor',
                    'Workorder.W_ContractorFee',
                    'Workorder.W_Note',
                    'Workorder.W_Note2',
                    'Workorder.W_Note3',
                    'Workorder.W_SS',
                    'Workorder.W_LastName',
                    'Workorder.W_MiddleInit',
                    'Workorder.W_FirstName',
                    'Workorder.W_DOB',
                    'Workorder.W_YearsOfRecord',
                    'Workorder.W_RecordNo',
                    'Workorder.W_Hospital',
                    'Workorder.W_HospitalID',
                    'Workorder.W_InsPolicy',
                    'Workorder.W_InsCompany',
                    'Workorder.W_Status',
                    'Workorder.W_DrFee',
                    'Workorder.W_DrFee1',
                    'Workorder.W_DrFee2',
                    'Workorder.W_DrCheckNo',
                    'Workorder.W_DrCheckDate',
                    'Workorder.W_DrInvoiceNo',
                    'Workorder.W_ImageFile',
                    'Workorder.W_ImagePages',
                    'Workorder.W_NoFiles',
                    'Workorder.W_AuthorizedFile',
                    'Workorder.W_FollowUpDt',
                    'Workorder.W_FollowUpDone',
                    'Workorder.W_FollowUpStatus',
                    'Workorder.W_UpdUser',
                    'Workorder.W_UpdDate',
                    'Workorder.W_DrCheckNo2',
                    'Workorder.W_DrCheckDate2',
                    'Workorder.W_DrInvoiceNo2',
                    'Workorder.W_ShipFee',
                    'Workorder.W_ShipFee1',
                    'Workorder.W_ShipFee2',
                    'Workorder.W_Tracking1',
                    'Workorder.W_Tracking2',
                    'Workorder.W_ExamStatus',
                    'Workorder.W_Urgent',
                    'Workorder.W_Owner',
                    'Workorder.W_Gender',
                    'Workorder.W_RequestorNote',
                    'Workorder.W_WebUploadID',
                    'Workorder.W_DrFollowup',
                    'Workorder.post_issue_audit',
                    'Workorder.W_AuthSignature',
                    'Workorder.W_MultWO',
                    'Requestor.R_Name as Requestor_R_Name',
                    'Requestor.R_Email as Requestor_R_Email',
                    'Requestor.R_Company as Requestor_R_Company',
                    'Requestor.requestorrole_id as Requestor_requestorrole_id',
                    'workorderdetails.requestorrole as requestorrole_name',
                    'Examrequest.E_WorkOrder as Examrequest_E_WorkOrder',
                    'Examrequest.E_Address as Examrequest_E_Address',
                    'Examrequest.E_City as Examrequest_E_City',
                    'Examrequest.E_State as Examrequest_E_State',
                    'Examrequest.E_Zip as Examrequest_E_Zip',
                    'Examrequest.E_HomePhone as Examrequest_E_HomePhone',
                    'Examrequest.E_CellPhone as Examrequest_E_CellPhone',
                    'Examrequest.E_ApplicantEmail as Examrequest_E_ApplicantEmail',
                    'Company.C_Name as Company_C_Name',
                    'Company.C_Instruction as Company_C_Instruction',
                    'BillToPickList.BL_BillTo as BillToPickList_BL_BillTo',
                    'BillToPickList.BL_MaxAmt as BillToPickList_BL_MaxAmt',
                    'Billingfeeeis.B_Company as Billingfeeeis_B_Company',
                    'Billingfeeeis.B_Fee as Billingfeeeis_B_Fee',

                ])
                ->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name')
                ->leftJoin('workorderdetails', 'Workorder.W_WorkOrder', '=', 'workorderdetails.workorder_id')
                ->leftJoin('Examrequest', 'Workorder.W_WorkOrder', '=', 'Examrequest.E_WorkOrder')
                ->leftJoin('BillToPickList', 'Workorder.W_BillCompany', '=', 'BillToPickList.BL_BillTo')
                ->leftJoin('Billingfeeeis', 'Workorder.W_BillCompany', '=', 'Billingfeeeis.B_Company')
                ->leftJoin('Company', 'Requestor.R_Company', '=', 'Company.C_Name')
                ->where('W_WorkOrder', $W_WorkOrder)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
        }

        if ($workorder->requestorrole_name) {
            $requestorrole = Requestorrole::query()
                ->where('role', $workorder->requestorrole_name)
                ->first();
        } else {
            $requestorrole = false;
        }

        if ($workorder->W_Hospital) {
            $hospital = Hospital::query()
                ->select([
                    'H_Hospital',
                    'H_Affiliate',
                    'H_CopyService',
                    'H_Address',
                    'H_City',
                    'H_State',
                    'H_Zip',
                    'H_Phone',
                    'H_PhoneExt',
                    'H_Fax',
                    'H_TurnOverDays',
                    'H_PayAdvance',
                    'H_SendMethod',
                    'H_Note',
                    'H_SpecialAuth',
                    'H_SendMethodEmail',
                    'H_Hospital2',
                    'H_ResponseTime',
                    'H_ROI',
                    'H_ID',
                    'H_UpdUser',
                    'H_UpdDate',
                    'H_SpecialAuthFile',
                    'H_Docusign',
                ])
                ->where('H_Hospital', $workorder->W_Hospital)
                ->first();
        } else {
            $hospital = false;
        }

        $inhouseprefill = null;
        if ($hospital && $hospital->H_Docusign) {
            $facilitiesform = Facilityform::query()
                ->where('slug', $hospital->H_Docusign)
                ->first();
            if ($facilitiesform && $facilitiesform->internal_form) {
                $inhouseprefill = $facilitiesform->internal_form;
            }
        }

        $workorderholdtimescount = Workorderholdtime::query()
            ->where('workorder_id', $workorder->W_WorkOrder)
            ->where('date_end', null)
            ->count();

        $incomingapslog = IncomingApsLog::query()
            ->where('workorder', $workorder->W_WorkOrder)
            ->orderBy('created_at', 'desc')
            ->first();

        $statustriggers = Statustrigger::query()
            ->where('WorkOrderNo', $workorder->W_WorkOrder)
            ->where('ChangeType', 'S')
            ->orderBy('Created', 'desc')
            ->get();

        $type = 'S';
        if ($workorder->W_HospitalID == 10) {
            $type = 'G';
        }
        if ($workorder->W_HospitalID == 69) {
            $type = 'N';
        }

        $statuslists1 = Cache::remember('workorders-show-statuslists1-' . $type . '-' . $this->subdomain(), 180, function () use ($type) {
            return Statuslist::query()
                ->where('Type', $type)
                ->whereNotNull('statuscode')
                ->orderBy('statuscode', 'asc')
                ->get()
                ->toArray();
        });

        $statusnotes = [];
        foreach ($statuslists1 as $statuslist) {
            $statusnotes[$statuslist['id']] = $statuslist['statuscode'] . ': ' . $statuslist['Status'];
        }

        if ($workorder->Company_C_Name == 'PRUDENTIAL INSURANCE COMPANY OF AMERICA') {
            $prudentialnotes = [
                '037' => '037: Received a request from Prudential to cancel the order. The case has been closed and the facility has been notified.',
                '038' => "038: Opened the case for missing records per Prudential's request.",
                '102' => '102: Fee approval is required. Notification has been sent to the underwriter for approval.',
                '107' => '107: Received the authorization from Prudential by e-mail.',
                '129' => "129: Cancelled per Prudential's email, the facility has been informed and the case has been closed.",
                '224' => '224: Per Prudential, approved request for FedEx. Faxed a FedEx waybill today. Call back set for',
                '233' => "233: Per Prudential's e-mail, Patient provided verbal authorization to the facility.",
                '234' => "234: Per Prudential's email, Our records were received on the above mentioned client ( pages)",
                '235' => '235: Received a phone call from Prudential:',
            ];
            // dump($prudentialnotes);
            foreach ($statusnotes as $k => $v) {
                $parts = explode(':', $v, 2);
                $prefix = trim($parts[0]);
                if (isset($prudentialnotes[$prefix])) {
                    $statusnotes[$k] = $prudentialnotes[$prefix];
                }
            }
            // dump($statusnotes);
        }

        if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
            if ($workorder->Company_C_Name == 'NORTHWESTERN MUTUAL') {
                $statusnotes = [
                    '002' => '002: APS order confirmed. Verifying the information provided.',
                    '0111' => '0111: HIGH PRIORITY, Call back set for every 2 business days. ',
                    '003' => '003: Faxed request and authorization, the fax is completed. Facility takes days to log in faxed request. Call back',
                    '0003' => '0003: Per , the request is still in progress. Advised to follow-up tomorrow. Call back .',
                    '004' => '004: The facility does not accept faxed requests. The request and authorization have been (mailed / sent via FedEx), call back set for .',
                    '005' => '005: The facility requires the request to be mailed with prepayment. (Mailed / Fedexed) the request, authorization, and prepayment. Call back set for .',
                    '006' => "006: Unable to obtain the facility's fax number. The request has been mailed. Call back set for .",
                    '007' => '007: Faxed the EIS request and the electronically signed authorization to the dr / facility. Call back set for .',
                    '008' => '008: Faxed the EIS request and the voice signed authorization to the dr / facility. Call back set for .',
                    '009' => '009: The request has been hand delivered along with prepayment, must allow 2 weeks before the next follow up. Call back set for .',
                    '010' => '010: The request and authorization has been e-mailed along with copy of the check and mailed to APS Express. Call back set for',
                    '011' => '011: Per medical records representative, the request and authorization have been received. The patient has been verified. The average turnaround time is days. Call back set for .',
                    '0011' => '0011: The medical records representative has been reminded to provide all records available for the specific time frame / record set requested. Call back set for .',
                    '013' => "013: Per medical records representative, the request is in process pending the doctor's approval. Call back set for .",
                    '014' => '014: Per medical records representative, the records are in storage. The request is in process. The average turnaround time is days. Call back set for .',
                    '015' => '015: Per from the copy service, the request is in process. The average turnaround time is days. Call back set for .',
                    '016' => '016: Per medical records representative, the records will be (faxed / mailed / fedexed) once the payment has been received. (Mail / Credit card / FedEx) payment was made today. Call back set for .',
                    '018' => '018: Per medical records representative, the records were mailed out on . The address has been verified. If the records are not received, will call back on',
                    '019' => '019: The invoice was received via (fax / mail). (A mail / An overnight FedEx / A credit card) payment was made today. Call back set for .',
                    '020' => '020: The facility rejected the voice signed authorization. We have sent the special facility authorization to the client and we will follow up with the client directly.',
                    '021' => '021: The facility rejected the electronically signed authorization. We have sent the special facility authorization to the client and we will follow up with the client directly.',
                    '022' => '022: Free Text Here',
                    '023' => '023: Made a credit card payment to . The records will be . Call back set for , between the hours of .',
                    '024' => '024: Fedexed the request, tracking#',
                    '025' => '025: Payment sent via FedEx, tracking#',
                    '027' => '027: The payment has been received, the records will be (mailed/ faxed/ electronically sent) per medical records representative. If the records are not received, will call back on',
                    '028' => '028: Received an invoice via fax.  Fee approval is required. Notification has been sent to the underwriter for  review. ',
                    '029' => "029: The fee has been approved per requestor's email. The request is in process. Call back set for .",
                    '031' => '031: The request is on hold until the facility authorization is returned.',
                    '032' => '032: The signed facility authorization has been received. The request is in process. Call back set for .',
                    '033' => '033: facility has received the signed facility authorization per medical records representative. The average turnaround time is days. Call back set for .',
                    '034' => '034: Per medical records representative, a signed facility authorization is required. EIS will mail the authorization to the applicant ',
                    '035' => '035: signed facility authorization has not been received from the applicant. Will continue to follow up weekly until the applicant responds. The request is on hold pending the signed facility authorization.',
                    '037' => '037: Received a request  from Prudential to cancel the order. The case has been closed and the facility has been notified.',
                    '038' => "038: Opened the case for missing records per Prudential's request.",
                    '039' => "039: Faxed the request for (cut and paste requestors instructions) to the facility. Call back set for later today to verify if the missing information is in the patient's file.",
                    '040' => "040: Per medical records representative, the requested missing information is not in the patient's file. Please be advised that the request may be closed unless further instruction is provided.",
                    '042' => '042: Unable to locate the missing information. The request has been closed.',
                    '043' => '043: Per medical records representative, the missing information will be faxed today. Call back set for tomorrow if the missing records are not received.',
                    '044' => '044: Per medical records representative, the request for missing information has been received and is now in process. The average turnaround time is days. Call back set for .',
                    '045' => '045: The facility takes days to log in faxed request. Faxed the EIS request and authorization to the dr / facility, call back set for .',
                    '048' => '048: Made an online credit card payment today. The records will be available for download within 48 hours. Call back set for .',
                    '049' => '049: Made an online credit card payment to the copy service. Call back set for .',
                    '050' => '050: The invoice has been received via e-mail. E-mailed the credit card information to the copy service today. Call back set for .',
                    '051' => '051: Per , the faxed credit card information has not been received. Made a credit card payment today. The records will be . Call back set for , between the hours of .',
                    '052' => '052: Per office manager, the in-house copy service will copy the records tomorrow. Call back set for .',
                    '053' => '053: Per copy service representative, the records are now available for download. The records will be downloaded today.',
                    '054' => '054: Per medical records representative, the invoice will be faxed tomorrow. Call back set for .',
                    '055' => '055: Called the facility. The lines were always routed to voicemail. Left an urgent message. Call back set for .',
                    '056' => '056: Per status online from the copy service, the payment has been posted. The records will be sent electronically within 24-48 hours. Call back set for .',
                    '057' => '057: Per medical records representative, advised that all records have been destroyed. A certificate of no records will be sent from the facility. This case will be transferred to the account manager. Call back set for .',
                    '058' => '058: Per medical records representative, advised that the records were copied on (insert date). Call back set for .',
                    '059' => '059: Per medical records representative, the request is pending to be processed. Advised to call back in (insert amount of time). Call back set for .',
                    '060' => '060: Per medical records representative, the records will be faxed to us today. Call back set for',
                    '061' => '061: Per medical records representative, the request is in process. Call back set for .',
                    '062' => '062: Per from the copy service, unable to provide status for the request. Advised to call back on (insert date). Call back set for .',
                    '063' => '063: Per receptionist, (insert name) custodian will be in the office at (insert time). Call back set for .',
                    '064' => '064: Per receptionist, the custodian is on vacation until (insert date). Call back set for .',
                    '065' => '065: Per custodian, the request and authorization have been received. The patient has been verified. They require a prepayment and accept checks only. A faxed copy of the check is unacceptable. A check will be mailed today. Call back set for .',
                    '066' => '066: The medical records line is on voice mail. Call back set for today before (insert time).',
                    '067' => '067: Per custodian, the payment has been received. The records will be mailed out early next week. Call back set for .',
                    '068' => '068: Per custodian, the request is in process. The records will be mailed out today. Call back set for .',
                    '069' => '069: Per custodian, the request will be processed this week. Call back set for .',
                    '070' => '070: The line to the facility keeps on ringing. This case will be transferred to the account manager for further assistance.',
                    '071' => '071: Per custodian, the request and authorization have been received. The patient has been verified. They require a prepayment by check only. Check will be mailed today. The records will be mailed once they receive the payment. Call back set for .',
                    '072' => '072: Per e-mail from the copy service, the request has not been logged into their system yet. Call back set for .',
                    '073' => '073: The line to the facility is always busy. This case will be transferred to the account manager for further assistance.',
                    '074' => '074: Per custodian, the facility does not provide status checks over the phone. A status check will be faxed to the facility today. Call back set for .',
                    '075' => '075: Per custodian, unable to provide the status of the request today. Call back set for .',
                    '076' => '076: Per custodian, the request and authorization with letter of representation have been received. The patient has been verified. The custodian will provide us with the prepayment amount later today.',
                    '077' => '077: Per receptionist, the custodian is unavailable. Call back set for .',
                    '078' => '078: Per custodian, the records will be faxed today. Call back set for .',
                    '079' => '079: Per custodian, the request was forwarded to their copy service yesterday. Call back set for .',
                    '080' => '080: Per e-mail from the copy service, the request is in process. The average turnaround time is (insert time). Call back set for .',
                    '081' => '081: Per custodian, the records were mailed out on (insert date). The address has been verified. Call back set for .',
                    '082' => '082: Per status online, the request, authorization, and payment have been received. The request has been routed to records retrieval to be copied. Call back set for .',
                    '083' => '083: Per custodian, the faxed credit card information has been received. The request is in process. Advised that we send a FedEx waybill since the custodian cannot fax the records. A FedEx waybill will be sent today. Call back set for .',
                    '084' => '084: Per FedEx tracking online, the records are in transit and are scheduled to be delivered today. Call back set for .',
                    '085' => '085: E-mailed the copy service for the status of the request. Call back set for .',
                    '086' => '086: Per custodian, the facility does not confirm faxed requests or provide statuses unless (insert time) has passed. Advised that can refax the request to the verified fax number. Call back set for .',
                    '087' => '087: E-mailed the in-house copy service for the status of the request. Call back set for .',
                    '088' => '088: Per custodian, the request and authorization have been received. All the information regarding the patient has been verified; however the patient is not showing up on their system. This case will be transferred to the account manager.',
                    '089' => '089: Per custodian, the mailed payment has not been received. Call back set for .',
                    '090' => '090: Per custodian, they require a letter of representation. This case will be transferred to my account manager for further assistance.',
                    '091' => '091: Per custodian, the records will be e-mailed out today. The e-mail address has been verified. Call back set for .',
                    '092' => '092: Per copy service representative, they require a prepayment by credit card. An online credit card payment will be made today.',
                    '093' => '093: Per custodian, the faxed request has been lost. The request will be re-faxed. Call back set for .',
                    '094' => '094: Per custodian, the request has not been logged into their system. Additional time is needed for the request to be logged in. Call back set for .',
                    '095' => '095: Per custodian, the FedEx waybill has been received. The records will be picked up by FedEx tomorrow.',
                    '096' => '096: Per custodian, they do not confirm statuses of requests until after (insert time) have passed. Status checks will be faxed once a week. Call back set for .',
                    '097' => '097: Per custodian, the request and authorization have been received. The custodian was unable to verify the patient. The average turnaround time is (insert time). Call back set for .',
                    '098' => '098: This facility is a psychiatric office, unable to speak to a live custodian. The request will be mailed today. Call back set for .',
                    '099' => '099: Per custodian, the request and authorization have been received. The patient has been verified. Their copy service copies records every (insert day). Call back set for .',
                    '100' => '100: The office is closed for the day. Mailed the request and authorization to the dr / facility, call back set for to obtain a fax number.',
                    '101' => '101: Per medical records representative, the authorization form is not HIPAA compliant and the client must sign the attached special facility authorization. We will follow up with the client directly. ',
                    '102' => '102: Fee approval is required. Notification has been sent to the underwriter for approval. ',
                    '103' => '103: The fee has been approved by the underwriter.',
                    '104' => '104: Calling the custodian for the fee negotiation.',
                    '105' => '105: Per medical records representative, the fee is non-negotiable.',
                    '107' => '107: Received the authorization from Prudential by e-mail.',
                    '108' => '108: The patient is required to sign the facility special authorization, we will send the authorization and follow up directly with the client.',
                    '112' => '112: The facility does not accept credit card payment, the payment will be sent overnight via FedEx. Call back set for .',
                    '113' => '113: The facility does not accept faxed requests, the request will be sent overnight via FedEx. Call back set for .',
                    '115' => '115: Duplicate.',
                    '115' => '115: Cancelled duplicate request. ',
                    '116' => '116: Time expired.',
                    '119' => '119: Call back set for .',
                    '120' => '120: Per medical records representative, the faxed request has not been received. Will refax the request. Call back set for later today.',
                    '121' => '121: The invoice has been received. Faxed the credit card information.',
                    '122' => '122: Faxed a status request to the facility / copy service.',
                    '123' => '123: Received a faxed response from the facility / copy service.',
                    '124' => '124: The patient prefers the facility authorization to be emailed/faxed/mailed. Emailed/faxed/mailed the facility authorization today.',
                    '125' => '125: The fax was successfully completed.',
                    '126' => '126: Please be advised that the authorization may be rejected due to some missing information. information. To expedite processing, we will try to submit the authorization form as it is, and will inform you if the facility does not accept it.',
                    '129' => "129: Cancelled per Prudential's email, the facility has been informed and the case has been closed.",
                    '131' => '131: Submit APS copy request to CIOX',
                    '201' => '201: Per voice recording, the office will be closed on (insert date) until (insert date) for vacation. Call back set for .',
                    '202' => '202: Per copy service representative, advised to allow a few more days for status. Call back set for .',
                    '203' => '203: Per custodian, the payment has not been received. This case will be transferred to the account manager for further assistance.',
                    '204' => '204: Per custodian, the facility requires the date of birth of the patient written on the signed authorization. This case will be transferred to the account manager for further assistance.',
                    '205' => '205: Faxed the request, authorization, and credit card information to the . Call back set for .',
                    '206' => '206: Per custodian, the facility requires a letter of representation. The request and authorization with the letter of representation will be re-faxed. Call back set for .',
                    '207' => '207: Per custodian, the request was forwarded to the copy service on (insert date). The status of the request will be checked with the copy service today.',
                    '208' => '208: The invoice has been received via fax. Fee approval is needed. Notification has been sent to the underwriter for reveiw. ',
                    '209' => '209: The facility takes days to log in mailed request. Mailed request Letter Of Representation and authorization. Call back',
                    '210' => '210: The facility might require their own authorization to be signed by the patient. Please have the facility form signed in case the request is rejected. We will try and process the provided authorization to expedite the process.',
                    '212' => '212: Called and left message for independent copy service, waiting on response. Follow up set for',
                    '213' => '213: Records received from independent copy service, will complete today.',
                    '214' => '214: Per Medical records rep at , advised that the request was forwarded to their copy service on . Their copy service takes business days to copy the records and send us an invoice. If no invoice received, call back set for .',
                    '216' => '216: Per Patient advised to email the release form. Call back set for',
                    '217' => '217: Unable to speak to patient. Left message. Call back set for',
                    '219' => '219: The HIPAA authorization was rejected due to e-signature.',
                    '220' => "220: Per RELEASE OF INFORMATION PHONE#: , the EIS request has been received and authorization with letter of representation have been received. The patient has been verified. Turn around time is business days from today's date (). Call back set",
                    '221' => '221: Received correspondence via fax stating: . Call back for tomorrow to verify.',
                    '222' => '222: Received correspondence via mail stating: Call back for tomorrow to verify.',
                    '223' => '223: Facility requires payment via mail. Notification has been sent to the underwriter for reveiw.',
                    '224' => '224: Per Prudential, approved request for FedEx. Faxed a FedEx waybill today. Call back set for',
                    '225' => '225: Per FedEx Pickup Confirmation #',
                    '226' => '226: Received a phone call for request for fee approval from facility, Per',
                    '227' => '227: Faxed a cancellation notice to facility / copy service. Call back for today',
                    '228' => '228: The provided form is illegible; however, in the meantime will process the current release form provided.',
                    '229' => '229: Records are not available for download. Will follow up with the copy service. Call back set for',
                    '230' => "230: Received the request to cancel per requestor's email. Faxed cancellation note to facility/copy service. Call back set for",
                    '231' => '231: Received correspondence via fax regarding no records. Call back for tomorrow to verify.',
                    '232' => '232: Per RELEASE OF INFORMATION Note, the request and authorization have been received. Records available. Call back set for',
                    '233' => "233: Per Prudential's e-mail, Patient provided verbal authorization to the facility.",
                    '234' => "234: Per Prudential's email, Our records were received on the above mentioned client ( pages)",
                    '235' => '235: Received a phone call from Prudential:',
                    '236' => '236: UTAH: Must be notarized or signed off by a UHC Staff member.',
                    '237' => '237: Per Release of information phone#: , the records are ready to be copied/picked up.',
                    '238' => '238: Received records from the facility and they are cut off. Call back set for tomorrow for them to refax the records.',
                    '239' => '239: Called and left message for independent copy service, waiting on response. Follow up set for',
                    '240' => '240: Records received from independent copy service, will complete today.',
                    '241' => '241: Per independent copy service, records will be copied today, follow up set for',
                    '300' => '300: Per COPY SERVICE REPRESENTATIVE AT THE FACILITY, the request been received. The patient has been verified. The request will be forward to the copy service corporate office. Will follow up with the corporate office on',
                    '301' => '301: Per RELEASE OF INFORMATION, the request has been received. The patient has been verified. The request will be forward to the on site copy service representative today. It takes 3 business days to forward to corporate office. Call back',
                    '302' => '302: Per COPY SERVICE REPRESENTATIVE AT THE CORPORATE OFFICE, the request has not been logged in to their system. Call back set for',
                    '304' => '304: Facility only releases up to date of signature. Please provide an updated current signature and date.',
                    '307' => '307: Per patient phone number# ,Unable to speak to the patient left a detailed message. Call back set for',
                    '308' => '308: Per patient phone number# ,Unable to speak to the patient left a detailed message. Will mail special authorization form today. Emailed the special authorization to the requestor. Call back set for',
                    '309' => '309: Per patient phone number# ,Unable to speak to the patient. Unable to leave a message because call did not route to voicemail. Call back set for',
                    '310' => '310: Per patient phone number# ,Unable to speak to the patient. Unable to leave a message because voicemail box was full. Call back set for',
                    '314' => "314: Mailed the special authorization to the patient's provided mailing address today.",
                    '499' => '499: The facility is contracting DATAFILE TECHNOLOGIES, LLC as their copy service. They do not accept cancellations once they receive a request and ALL FEES MUST BE PAID IN FULL. Please let us know if you would like to proceed with this request.',
                    '599' => '599: APS Summary received',
                    '600' => '600: The fee approval request has been received by fax from facility / copy service. Faxed back to confirm fee approved. Call back set for',
                    '601' => '601: Received the authorization from the patient by fax.',
                    '502' => '502: Per Voice Prompt Phone Number: The office is closed due to COVID-19 until',
                    '503' => '503: Ready for Copy By',
                ];
            }
        }

        $followupstatuslists1 = Cache::remember('workorders-show-followupstatuslists1-' . $this->subdomain(), 180, function () {
            return Statuslist::query()
                ->where('Type', 'F')
                ->whereNotNull('statuscode')
                ->orderBy('statuscode', 'asc')
                ->get()
                ->toArray();
        });

        $followupstatuslists = [];
        foreach ($followupstatuslists1 as $followupstatuslist) {
            $followupstatuslists[$followupstatuslist['statuscode']] = $followupstatuslist['statuscode'] . ': ' . $followupstatuslist['Status'];
        }

        $workordercurrent = [
            'W_WorkOrder' => $workorder->W_WorkOrder,
            'W_FirstName' => $workorder->W_FirstName,
            'W_LastName' => $workorder->W_LastName,
        ];
        session(['user.workordercurrent' => $workordercurrent]);

        $workordersessions = session('user.workordersessions', []);
        $workordersessions['w' . $workorder->W_WorkOrder] = [
            'W_WorkOrder' => $workorder->W_WorkOrder,
            'W_LastName' => $workorder->W_LastName,
            'W_MiddleInit' => $workorder->W_MiddleInit,
            'W_FirstName' => $workorder->W_FirstName,
            'viewed_at' => now()->toDateTimeString(),
        ];
        if (count($workordersessions) > 10) {
            $workordersessions = array_slice($workordersessions, 1);
        }
        session(['user.workordersessions' => $workordersessions]);

        $contractorsselects = Cache::remember('workorders-show-contractors-' . $this->subdomain(), 180, function () {
            return Contractor::query()
                ->select('C_Name')
                ->where('C_Caller', 1)
                ->orderBy('C_Name', 'ASC')
                ->pluck('C_Name', 'C_Name')
                ->toArray();
        });

        $apsorder = null;
        if ($workorder->Company_C_Name == 'FFR') {
            $apsorder = Apsorder::query()
                ->where('EISWorkOrderID', $workorder->W_WorkOrder)
                ->first();
        }

        $tickets = collect();
        if ($this->subdomain() == 'eisdev') {
            $tickets = Ticket::query()
                ->where('workorder_id', $workorder->W_WorkOrder)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('user.workorders.show', compact('workorder', 'hospital', 'inhouseprefill', 'workorderholdtimescount', 'statustriggers', 'statusnotes', 'followupstatuslists', 'contractorsselects', 'incomingapslog', 'requestorrole', 'apsorder', 'tickets'));
    }

    public function history(Request $request)
    {
        $workordersessions = session('user.workordersessions', []);
        usort($workordersessions, function ($a, $b) {
            return ($b['viewed_at'] ?? 0) <=> ($a['viewed_at'] ?? 0);
        });

        if ($request->headers->get('HX-Request')) {
            return view('user.workorders.history', compact('workordersessions'))->fragment('workorderhistory');
        }

        return view('user.workorders.history', compact('workordersessions'));
    }

    public function edit(Workorder $workorder)
    {
        $contractors = Contractor::query()
            ->select('C_Name')
            ->where(function ($query) use ($workorder) {
                $query->where('C_Caller', 1)
                    ->orWhere('C_Name', $workorder->W_Contractor ?? '');
            })
            ->where(function ($query) use ($workorder) {
                $query->where('C_Location', '!=', 'inactive')
                    ->orWhereNull('C_Location')
                    ->orWhere('C_Name', $workorder->W_Contractor ?? '');
            })
            ->orderBy('C_Name', 'asc')
            ->pluck('C_Name', 'C_Name');

        $insurancecompanies = Insurancecompany::query()
            ->select('I_Name')
            ->where('I_ActiveWebsite', 1)
            ->orderBy('I_Name', 'asc')
            ->pluck('I_Name', 'I_Name');

        if ($workorder->W_InsCompany) {
            $insurancecompanies[$workorder->W_InsCompany] = $workorder->W_InsCompany;
        }

        $requestor = Requestor::query()
            ->select([
                'Requestor.R_Name as Requestor_R_Name',
                'Requestor.R_Company as Requestor_R_Company',
                'Company.C_Name as Company_C_Name',
                'Company.C_WebID as Company_C_WebID',
            ])
            ->join('Company', 'Requestor.R_Company', '=', 'Company.C_Name')
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        return view('user.workorders.edit', compact('workorder', 'requestor', 'contractors', 'insurancecompanies'));
    }

    public function update(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $workorderold = clone $workorder;

        $validated = $request->validated();

        $workorder->update($validated + [
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => now(),
        ]);

        if ($workorderold->W_ImageFile !== $workorder->W_ImageFile) {

            $workorderfiledownload = Workorderfiledownload::query()
                ->where('workorder_id', $workorder->W_WorkOrder)
                ->first();

            $is_deleted = 0;
            if ($workorderfiledownload) {
                $workorderfiledownload->delete();
                $is_deleted = 1;
            }
            $log_message = now()->format('Y-m-d H:i:s') . ',' . $is_deleted . ',' . $workorder->W_WorkOrder . ',' . $workorder->W_ImageFile . ',' . $workorderold->W_ImageFile . "\n";
            @file_put_contents(storage_path('persistent_logs/workorderfiledownloadresets.log'), $log_message, FILE_APPEND);
        }

        $woinUpdate = [];

        if ($workorderold->W_InsCompany != $workorder->W_InsCompany && $request->filled('W_InsCompany')) {

            if ($workorder->W_InsCompany == 'INFORMAL CARRIER') {
                $requestor = Requestor::query()
                    ->select('R_Company')
                    ->where('R_Name', $workorder->W_Requestor)
                    ->firstOrFail();

                $billtopicklist = Billtopicklist::query()
                    ->where('BL_BillTo', $requestor->R_Company)
                    ->first();
            } else {
                $billtopicklist = Billtopicklist::query()
                    ->where('BL_InsCompany', $workorder->W_InsCompany)
                    ->first();
            }

            $workorder->W_BillCompany = $billtopicklist->BL_BillTo ?? '';

            $woinUpdate['WI_InsName'] = $workorder->W_InsCompany;
        }

        if ($workorderold->W_InsPolicy != $workorder->W_InsPolicy) {
            $woinUpdate['WI_InsPolicy'] = $workorder->W_InsPolicy;
        }

        if (! empty($woinUpdate)) {
            Woin::query()
                ->where('WI_WorkOrder', $workorder->W_WorkOrder)
                ->where('WI_InsName', $workorderold->W_InsCompany)
                ->update($woinUpdate);
        }

        $workorder->W_ShipFee = $workorder->W_ShipFee1 + $workorder->W_ShipFee2;

        $workorder->save();

        // if($workorderold->W_ImageFile) {

        //     if ($workorder->W_FirstName . '-' . $workorder->W_LastName != $workorderold->W_FirstName . '-' . $workorderold->W_LastName) {

        //         $Company_C_WebID = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('Company_C_WebID'));
        //         $companydirectory = '//ftpserver/ftpserver/' . $Company_C_WebID;

        //         $W_FirstName = str_replace(' ', '-', $workorder->W_FirstName);
        //         $W_LastName = str_replace(' ', '-', $workorder->W_LastName);

        //         $W_FirstName = preg_replace('/[^a-zA-Z0-9\-]/', '', $W_FirstName);
        //         $W_LastName = preg_replace('/[^a-zA-Z0-9\-]/', '', $W_LastName);

        //         $W_ImageFileNew = $W_FirstName . '-' . $W_LastName . '-' . $workorder->W_WorkOrder;

        //         $W_ImageFileNew = str_replace(' ', '-', $W_ImageFileNew);

        //         $file = $companydirectory . '/' . $workorderold->W_ImageFile;

        //         $updatefield = false;

        //         if (is_file($file . '.pdf')) {
        //             rename($file . '.pdf', $companydirectory . '/' . $W_ImageFileNew . '.pdf');
        //             $updatefield = true;
        //         }

        //         if (is_file($file . '.tif')) {
        //             rename($file . '.tif', $companydirectory . '/' . $W_ImageFileNew . '.tif');
        //             $updatefield = true;
        //         }

        //         if (is_file($file . '-1.pdf')) {
        //             rename($file . '-1.pdf', $companydirectory . '/' . $W_ImageFileNew . '-1.pdf');
        //             $updatefield = true;
        //         }

        //         if (is_file($file . '-1.tif')) {
        //             rename($file . '-1.tif', $companydirectory . '/' . $W_ImageFileNew . '-1.tif');
        //             $updatefield = true;
        //         }

        //         if(preg_match('/[0-9]-([0-9]{1})$/', $workorderold->W_ImageFile, $matches)) {
        //             $W_ImageFileNew = $W_ImageFileNew . '-' . $matches[1];
        //         }

        //         if($updatefield) {
        //             $workorder->W_ImageFile = $W_ImageFileNew;
        //             $workorder->save();
        //         }

        //     }

        // }

        $before = array_diff_assoc($workorderold->toArray(), $workorder->toArray());
        $after = array_diff_assoc($workorder->toArray(), $workorderold->toArray());

        // dump($workorderold);
        // dump($workorder);
        // die;

        if ($before) {
            ksort($before);
            ksort($after);
            $data = "Previous Data:\r\n";
            $data .= 'Follow-up Date = ' . $workorder->W_FollowUpDt . "\r\n";
            foreach ($before as $key => $value) {
                $data .= $this->workorderMap($key) . ' = ' . $value . "\r\n";
            }
            $data .= "\r\n";
            $data .= "Subsequent Data:\r\n";
            foreach ($after as $key => $value) {
                $data .= $this->workorderMap($key) . ' = ' . $value . "\r\n";
            }
            $data = rtrim($data);

            $datachange = new Datachange();
            $datachange->model = 'workorders';
            $datachange->foreign_key = $workorder->W_WorkOrder;
            $datachange->data = $data;
            $datachange->created_by = session('user.contractor.C_Name');
            $datachange->save();
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function changerequestor(Request $request, $workorderid)
    {
        $workorder = Workorder::query()
            ->select('Workorder.*', 'Requestor.R_Name as requestor_name', 'Requestor.R_Company as requestor_company', 'Requestor.R_Email as requestor_email')
            ->where('W_WorkOrder', $workorderid)
            ->join('Requestor', 'Requestor.R_Name', '=', 'Workorder.W_Requestor')
            ->firstOrFail();

        return view('user.workorders.changerequestor', compact('workorder'));
    }

    public function changerequestorupdate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $workorderold = clone $workorder;

        $validated = $request->validated();

        $workorder->update($validated + [
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => now(),
        ]);

        $workorder->save();

        $before = array_diff_assoc($workorderold->toArray(), $workorder->toArray());
        $after = array_diff_assoc($workorder->toArray(), $workorderold->toArray());

        if ($before) {
            ksort($before);
            ksort($after);
            $data = "Previous Data:\r\n";
            $data .= 'Follow-up Date = ' . $workorder->W_FollowUpDt . "\r\n";
            foreach ($before as $key => $value) {
                $data .= $this->workorderMap($key) . ' = ' . $value . "\r\n";
            }
            $data .= "\r\n";
            $data .= "Subsequent Data:\r\n";
            foreach ($after as $key => $value) {
                $data .= $this->workorderMap($key) . ' = ' . $value . "\r\n";
            }
            $data = rtrim($data);

            $datachange = new Datachange();
            $datachange->model = 'workorders';
            $datachange->foreign_key = $workorder->W_WorkOrder;
            $datachange->data = $data;
            $datachange->created_by = session('user.contractor.C_Name');
            $datachange->save();
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function payment(Request $request, Workorder $workorder)
    {
        $dr = $request->query('dr') ?? 1;

        $creditcardinfos = Creditcard::all();

        $creditcardinfoslists = [];
        foreach ($creditcardinfos as $creditcardinfo) {
            $creditcardinfoslists[$creditcardinfo->CC_No] = $creditcardinfo->CC_No . ' - ' . $creditcardinfo->CC_Name;
        }

        return view('user.workorders.payment', compact('workorder', 'dr', 'creditcardinfos', 'creditcardinfoslists'));
    }

    public function paymentupdate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $dr = $request->input('dr');

        $oldFee = 0;

        if ($dr == 1) {
            $oldFee = $workorder->W_DrFee1;
            $newFee = $request->input('W_DrFee1');
            $W_DrCheckNo = $request->input('W_DrCheckNo');
            $W_DrInvoiceNo = $request->input('W_DrInvoiceNo');
            $W_DrFee = $workorder->W_DrFee2 + $newFee;
        }

        if ($dr == 2) {
            $oldFee = $workorder->W_DrFee2;
            $newFee = $request->input('W_DrFee2');
            $W_DrCheckNo = $request->input('W_DrCheckNo2');
            $W_DrInvoiceNo = $request->input('W_DrInvoiceNo2');
            $W_DrFee = $workorder->W_DrFee1 + $newFee;
        }

        $paymentnote = null;

        if ($request->input('payment_type') == 'unpaid') {

            $paymentnote .= 'UNPAID AMOUNT: $' . $newFee . "\r\n";
            $paymentnote .= 'INVOICE: ' . $W_DrInvoiceNo . "\r\n";
            $paymentnote .= '(' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ')';
        }

        if ($request->input('payment_type') == 'cc') {

            $creditcardinfo = Creditcard::query()
                ->where('CC_No', $request->input('CC_No'))
                ->first();

            $paymentnote .= 'PROCESSED BY: ' . session('user.contractor.C_Name') . "\r\n";
            $paymentnote .= $creditcardinfo->CC_Name . "\r\n";
            $paymentnote .= $creditcardinfo->CC_No . "\r\n";
            $paymentnote .= $creditcardinfo->CVC_No . ' ' . $creditcardinfo->ExpDate . "\r\n";
            $paymentnote .= 'CUSTODIAN NAME: ' . $request->input('custodian') . "\r\n";
            $paymentnote .= 'CUSTODIAN PHONE: ' . $request->input('custodian_phone') . "\r\n";
            $paymentnote .= 'AMOUNT: $' . $newFee . "\r\n";
            $paymentnote .= 'APPROVAL: ' . $W_DrCheckNo . "\r\n";
            $paymentnote .= 'INVOICE: ' . $W_DrInvoiceNo . "\r\n";
            $paymentnote .= '(' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ')';
        }

        if ($request->input('payment_type') == 'check') {

            $paymentnote .= 'PROCESSED BY: ' . session('user.contractor.C_Name') . "\r\n";
            $paymentnote .= "PAYMENT BY CHECK SUBMITTED\r\n";
            $paymentnote .= 'PAYABLE TO: ' . $request->input('payable') . "\r\n";
            $paymentnote .= 'CHECK SEND METHOD: ' . $request->input('sendmethod') . "\r\n";
            $paymentnote .= 'CHECK MAILING ADDRESS: ' . $request->input('mailing_address') . "\r\n";
            $paymentnote .= 'AMOUNT: $' . $newFee . "\r\n";
            $paymentnote .= 'CHECK NUMBER: ' . $W_DrCheckNo . "\r\n";
            $paymentnote .= 'INVOICE: ' . $W_DrInvoiceNo . "\r\n";
            $paymentnote .= '(' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ')';
        }

        if ($workorder->update($request->validated() + [
            'W_FollowUpStatus' => $paymentnote . "\r\n\r\n" . $workorder->W_FollowUpStatus,
            'W_DrFee' => $W_DrFee,
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => now(),
        ])) {

            $drfeeupdatehst = new Drfeeupdatehst();
            $drfeeupdatehst->D_WorkOrder = $workorder->W_WorkOrder;
            $drfeeupdatehst->D_UpdateTime = now()->toDateTimeString();
            $drfeeupdatehst->D_UserName = session('user.contractor.C_Name');
            $drfeeupdatehst->D_FieldName = 'Dr Fee ' . $dr;
            $drfeeupdatehst->D_OldFee = $oldFee;
            $drfeeupdatehst->D_NewFee = $newFee;
            $drfeeupdatehst->save();

            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder)
                ->with('success', 'Data has been saved');
        }

        return back()->withInput()->with('danger', 'The data could not be saved. Please, try again');
    }

    public function paymentnote(Request $request, Workorder $workorder)
    {
        $dr = $request->query('dr');
        if ($dr != 1 && $dr != 2) {
            exit('invalid request');
        }

        if ($workorder->W_Status == 'Incomplete' || ! $workorder->W_Hospital) {
            return back()->withInput()->with('danger', 'Invalid WorkOrder or Status is Incomplete');
        }

        return view('user.workorders.paymentnote', compact('workorder', 'dr'));
    }

    public function paymentnoteupdate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $dr = $request->input('dr');

        if ($workorder->W_Status == 'Incomplete' || ! $workorder->W_Hospital) {
            return back()
                ->withInput()
                ->with('danger', 'Invalid WorkOrder or Status is Incomplete');
        }

        $workorderold = $workorder;
        $workorderold = $workorderold->toArray();

        $W_DrFee = $dr == 1 ? $workorder->W_DrFee2 + $request->input('W_DrFee1') : $workorder->W_DrFee1 + $request->input('W_DrFee2');

        $workorder->update($request->validated() + [
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => now(),
            'W_DrFee' => $W_DrFee,
        ]);

        $before = array_diff_assoc($workorderold, $workorder->toArray());
        $after = array_diff_assoc($workorder->toArray(), $workorderold);

        if ($before) {
            ksort($before);
            ksort($after);
            $data = "Previous Data:\r\n";
            $data .= 'Follow-up Date = ' . $workorder->W_FollowUpDt . "\r\n";
            foreach ($before as $key => $value) {
                $data .= $this->workorderMap($key) . ' = ' . $value . "\r\n";
            }
            $data .= "\r\n";
            $data .= "Subsequent Data:\r\n";
            foreach ($after as $key => $value) {
                $data .= $this->workorderMap($key) . ' = ' . $value . "\r\n";
            }
            $data = rtrim($data);

            $datachange = new Datachange();
            $datachange->model = 'workorders';
            $datachange->foreign_key = $workorder->W_WorkOrder;
            $datachange->data = $data;
            $datachange->created_by = session('user.contractor.C_Name');
            $datachange->save();
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function updatestatusnote(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $validated = $request->validated();

        $requestor = Requestor::query()
            ->select(['R_Company'])
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        $note = $request->input('note');
        $statusnoteid = $request->input('statusnoteid');

        if ($request->input('w_note_date')) {
            $workorder->W_FollowUpDt = $request->input('w_note_date');
            $workorder->W_UpdUser = session('user.contractor.C_Name');
            $workorder->W_UpdDate = now();
            $workorder->save();
        }

        $statuslist = Statuslist::query()
            ->where('id', $statusnoteid)
            ->firstOrFail();

        $statustrigger = new Statustrigger();
        $statustrigger->WorkOrderNo = $workorder->W_WorkOrder;
        $statustrigger->statuscode = $statuslist->statuscode;

        $contractorName = $requestor->R_Company == 'PLICO-WCL' ? '' : session('user.contractor.C_Name') . ' ';
        $time = now()->format('g:i:s A');

        $statustrigger->laststatus = "{$statuslist->statuscode}: {$note} ({$contractorName}{$time})";

        if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
            if (in_array($requestor->R_Company, ['NATIONWIDE LIFE UNDERWRITING', 'BESTOW AGENCY LLC'])) {
                $statustrigger->laststatus = "{$note} ({$contractorName}{$time})";
            }
        }

        $statustrigger->Created = now();
        $statustrigger->CreatedBy = session('user.contractor.C_Name');
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function updatefollowupstatus(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $W_FollowUpStatus = $request->input('W_FollowUpStatus');
        $followupstatuslists = $request->input('followupstatuslists');
        $workorder->W_FollowUpStatus = $followupstatuslists . ': ' . $W_FollowUpStatus . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->W_FollowUpDt = $request->input('w_follow_up_status_date');
        $workorder->W_UpdUser = session('user.contractor.C_Name');
        $workorder->W_UpdDate = now();
        $workorder->save();

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function updatefollowupnote(Request $request, Workorder $workorder)
    {
        $rules = ['W_Note3' => 'required|string|min:5|max:500'];

        $messages = [
            'W_Note3.required' => 'Follow-Up Note is required.',
            'W_Note3.string' => 'Follow-Up Note must be a valid string.',
            'W_Note3.min' => 'Follow-Up Note must be at least 5 characters long.',
            'W_Note3.max' => 'Follow-Up Note must not exceed 500 characters.',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            if ($request->header('HX-Request')) {
                return response()
                    ->view('user.workorders.partials._followupnote', [
                        'workorder' => $workorder,
                        'errors' => $validator->errors(),
                        'old' => $request->all(),
                    ])
                    ->setStatusCode(200);
            }

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $timestamp = now()->format('m-d-Y g:i:s A');
        $userName = session('user.contractor.C_Name');

        $workorder->W_Note3 = "{$validated['W_Note3']} ({$timestamp} {$userName})\r\n\r\n" . $workorder->W_Note3;
        $workorder->W_UpdUser = $userName;
        $workorder->W_UpdDate = now();
        $workorder->save();

        if ($request->header('HX-Request')) {
            return response()
                ->view('user.workorders.partials._followupnote', [
                    'workorder' => $workorder,
                    'old' => [],
                    'errors' => new MessageBag(),
                ]);
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function related(Request $request, Workorder $workorder)
    {
        $hospital = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->firstOrFail();

        return view('user.workorders.related', compact('workorder', 'hospital'));
    }

    public function hospitalchange(Request $request, Workorder $workorder)
    {
        $hospitalcurrent = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->first();

        $hospitalraw = Hospitalraw::query()
            ->where('R_WorkOrder', $workorder->W_WorkOrder)
            ->first();

        $contractors = Contractor::query()
            ->select('C_Name')
            ->where('C_Caller', 1)
            ->orderBy('C_Name', 'ASC')
            ->get();

        $contractorsselects = $contractors->pluck('C_Name', 'C_Name');

        return view('user.workorders.hospitalchange', compact('workorder', 'hospitalcurrent', 'hospitalraw', 'contractorsselects'));
    }

    public function workorderhospitalupdate(UpdateWorkorderHospitalRequest $request, Workorder $workorder)
    {
        $W_WorkOrder = $request->input('W_WorkOrder');
        $H_ID = $request->input('H_ID');

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $W_WorkOrder)
            ->firstOrFail();

        $hospital = Hospital::query()
            ->where('H_ID', $H_ID)
            ->firstOrFail();

        $workorder->W_Hospital = $hospital->H_Hospital;

        // if ($hospital->H_Hospital != $request->input('hospital_name')) {
        if (strcasecmp($hospital->H_Hospital, $request->input('hospital_name')) !== 0) {
            $hospitalnew = $hospital->replicate();
            $hospitalnew->H_Hospital = $request->input('hospital_name');
            $hospitalnew->created_by = session('user.contractor.C_Name');
            $hospitalnew->H_UpdUser = session('user.contractor.C_Name');
            if ($hospitalnew->save()) {
                $request->session()->flash('success', 'A new hospital has been saved.');
            }
            $workorder->W_Hospital = $hospitalnew->H_Hospital;
        }

        if (! $workorder->W_Owner) {
            $workorder->W_Owner = $request->input('W_Owner');
        }

        $datachange = new Datachange();
        $datachange->model = 'workorders';
        $datachange->foreign_key = $workorder->W_WorkOrder;
        $datachange->data = 'Facility Upload: ' . $workorder->W_Hospital;
        $datachange->created_by = session('user.contractor.C_Name');
        $datachange->save();

        $workorder->W_WebUploadID = 0;
        $workorder->save();
        // dd($workorder);

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function workorderhospitalstore(StoreHospitalRequest $request, Workorder $workorder)
    {
        $W_WorkOrder = $request->input('W_WorkOrder');
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $W_WorkOrder)
            ->firstOrFail();

        $hospital = new Hospital($request->validated());
        $hospital->timezone_offset = Helper::timezones($request->H_State);
        $hospital->created_by = session('user.contractor.C_Name');
        $hospital->H_UpdUser = session('user.contractor.C_Name');
        $hospital->H_Created = now();
        $hospital->H_UpdDate = now();
        if ($hospital->save()) {
            $workorder->W_WebUploadID = 0;
            $workorder->W_Hospital = $hospital->H_Hospital;
            $workorder->save();
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function duplicate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $workorderduplicates = Workorderduplicate::query()
            ->where('oldworkorder', $workorder->W_WorkOrder)
            ->orderBy('created', 'asc')
            ->get();

        return view('user.workorders.duplicate', compact('workorder', 'workorderduplicates'));
    }

    public function duplicateupdate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $new = new Workorder();
        $new->W_PolicyNo = $workorder->W_PolicyNo;
        $new->W_Requestor = $workorder->W_Requestor;
        $new->W_InsCompany = $workorder->W_InsCompany;
        $new->W_InsPolicy = $workorder->W_InsPolicy;
        $new->W_Agent = $workorder->W_Agent;
        $new->W_BillCompany = $workorder->W_BillCompany;
        $new->W_Contractor = $workorder->W_Contractor;
        $new->W_FirstName = $workorder->W_FirstName;
        $new->W_MiddleInit = $workorder->W_MiddleInit;
        $new->W_LastName = $workorder->W_LastName;
        $new->W_DOB = $workorder->W_DOB;
        $new->W_SS = $workorder->W_SS;
        $new->W_YearsOfRecord = $workorder->W_YearsOfRecord;
        $new->W_RecordNo = $workorder->W_RecordNo;
        $new->W_WebUploadID = $workorder->W_WebUploadID;
        $new->W_OrderType = $workorder->W_OrderType;
        $new->W_ExamStatus = $workorder->W_ExamStatus;
        $new->W_Urgent = $workorder->W_Urgent;
        $new->W_MultWO = $workorder->W_MultWO;
        $new->W_HospitalID = $workorder->W_HospitalID;
        $new->W_Note2 = "HI CUSTODIAN,\r\nPLEASE SEND ANY AND ALL RECORDS INCLUDING OFFICE VISIT NOTES, SPECIALIST REPORTS AND ALL SPECIAL TEST RESULTS INCLUDING LABS, CARDIAC STUDIES, EKG TRACINGS, X-RAYS, PATHOLOGY REPORTS & COLONOSCOPY RESULTS. PLEASE DO NOT SEND PARTIAL RECORDS AS WE WILL HAVE TO RE-ORDER INFORMATION.";
        $new->W_Status = 'Incomplete';
        $new->W_CompletedDate = null;
        $new->W_DrFee = 0;
        $new->W_DrFee1 = 0;
        $new->W_DrFee2 = 0;
        $new->W_WebUploadID = 0;
        $new->W_FollowUpDone = 0;
        $new->W_CompleteDays = 0;
        $new->W_CompletionType = 0;
        $new->W_UpdUser = session('user.contractor.C_Name');
        $new->W_Owner = session('user.contractor.C_Name');
        $new->W_ReceiveDate = now()->format('Y-m-d 00:00:00');
        $new->W_UpdDate = now();
        $new->W_FollowUpDt = now();

        if ($request->input('duplicatehospital')) {
            $new->W_Hospital = $workorder->W_Hospital;
        }

        $save = $new->save();

        if ($save) {

            $W_FirstName = preg_replace('/[^A-Za-z0-9]/', '', $new->W_FirstName);
            $W_LastName = preg_replace('/[^A-Za-z0-9]/', '', $new->W_LastName);

            $new->W_ImageFile = $W_FirstName . '-' . $W_LastName . '-' . $new->W_WorkOrder;

            $extension = strtolower(pathinfo($workorder->W_AuthorizedFile ?? '', PATHINFO_EXTENSION));

            if ($extension == 'pdf' || $extension == 'tif') {

                $new->W_AuthorizedFile = $new->W_WorkOrder . '.' . $extension;

                $folder_auth = '\\\\server2\\eisaccess\\' . $this->subdomain() . '\\AuthForms\\';
                if ($this->subdomain() == 'eis') {
                    $folder_auth = '\\\\server2\\eisaccess\\AuthForms\\';
                }

                if (is_file($folder_auth . $workorder->W_AuthorizedFile) && ! is_file($folder_auth . $new->W_AuthorizedFile)) {
                    $copied = copy($folder_auth . $workorder->W_AuthorizedFile, $folder_auth . $new->W_AuthorizedFile);
                } else {
                    $copied = false;
                    $request->session()->flash('danger', 'existing workorder auth file does not exists');
                }

                if ($copied) {
                    $request->session()->flash('success', 'workorder auth file copied successfully');
                } else {
                    $request->session()->flash('danger', 'workorder auth file is not copied');
                }
            }

            $new->save();

            $examrequest = Examrequest::query()
                ->where('E_WorkOrder', $workorder->W_WorkOrder)
                ->first();

            if ($examrequest) {
                $examrequestnew = new Examrequest();
                $examrequestnew = $examrequest->replicate();
                $examrequestnew->E_WorkOrder = $new->W_WorkOrder;
                $examrequestnew->save();
            }

            $woin = new Woin();
            $woin->WI_WorkOrder = $new->W_WorkOrder;
            $woin->WI_InsName = $new->W_InsCompany;
            $woin->WI_InsPolicy = $new->W_InsPolicy;
            $woin->save();

            $requestor = Requestor::query()
                ->select(['R_Company'])
                ->where('R_Name', $workorder->W_Requestor)
                ->firstOrFail();

            $statustrigger = new Statustrigger();
            $statustrigger->WorkOrderNo = $new->W_WorkOrder;

            $statustrigger->statuscode = '022';

            $statustrigger->laststatus = '022: COPY FROM WORKORDER NUMBER: ' . $workorder->W_WorkOrder . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';

            if ($requestor->R_Company == 'PLICO-WCL') {
                $statustrigger->laststatus = '022: COPY FROM WORKORDER NUMBER: ' . $workorder->W_WorkOrder . ' (' . date('g:i:s A') . ')';
            }

            if ($this->subdomain() == 'usaa') {
                $statustrigger->statuscode = '1003800773';
                $statustrigger->laststatus = '1003800773: COPY FROM WORKORDER NUMBER: ' . $workorder->W_WorkOrder . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
            }

            if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
                if (in_array($requestor->R_Company, ['NATIONWIDE LIFE UNDERWRITING', 'BESTOW AGENCY LLC'])) {
                    $statustrigger->laststatus = 'COPY FROM WORKORDER NUMBER: ' . $workorder->W_WorkOrder . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
                }
            }

            $statustrigger->Created = now();
            $statustrigger->CreatedBy = session('user.contractor.C_Name');
            $statustrigger->ChangeType = 'S';
            $statustrigger->save();

            $workorder->W_FollowUpStatus = 'Request to create duplicate WO completed, new WO# ' . $new->W_WorkOrder . ' (' . session('user.contractor.C_Name') . ' ' . date('m-d-Y g:i:s A') . ')' . "\r\n\r\n" . $workorder->W_FollowUpStatus;
            $workorder->save();

            $workorderduplicate = new Workorderduplicate();
            $workorderduplicate->oldworkorder = $workorder->W_WorkOrder;
            $workorderduplicate->newworkorder = $new->W_WorkOrder;
            $workorderduplicate->username = session('user.contractor.C_Name');
            $workorderduplicate->hospitalid = $workorder->W_HospitalID;
            $workorderduplicate->created = now()->toDateTimeString();
            $workorderduplicate->save();

            $workorderdetail = Workorderdetail::query()
                ->where('workorder_id', $workorder->W_WorkOrder)
                ->first();

            if ($workorderdetail) {
                $workorderdetailnew = new Workorderdetail();
                $workorderdetailnew->workorder_id = $new->W_WorkOrder;
                $workorderdetailnew->requestorrole = $workorderdetail->requestorrole;
                $workorderdetailnew->save();
            }

            $request->session()->flash('success', 'The workorder ' . $workorder->W_WorkOrder . ' has been duplicated to: ' . $new->W_WorkOrder);
        } else {
            $request->session()->flash('danger', 'The workorder could not be saved. Please, try again.');
        }

        return back();
    }

    public function cancel(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $requestor = Requestor::query()
            ->select(['R_Company'])
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        if ($workorder->W_Status != 'Incomplete') {
            $request->session()->flash('danger', 'Unable to cancel. Workorder status is not: Incomplete');

            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder);
        }

        if ($workorder->W_DrFee > 0) {
            $request->session()->flash('danger', 'Unable to cancel. Please transfer workorder to: "CANCEL WITH FEE"');

            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder);
        }

        $cancelreasons = [
            '717' => '717: APS CANCELLED PER REQUESTOR',
            '718' => '718: APS CLOSED AS TIME EXPIRED',
            '719' => '719: APS CLOSED AS DUPLICATE',
        ];

        if (in_array($requestor->R_Company, [
            'PRUDENTIAL INSURANCE COMPANY OF AMERICA',
            'BESTOW AGENCY LLC',
            'FFR',
            'MASSMUTUAL',
        ])) {
            $cancelreasons = [
                '717' => 'APS CANCELLED PER REQUESTOR',
                '718' => 'APS CLOSED AS TIME EXPIRED',
                '719' => 'APS CLOSED AS DUPLICATE',
            ];
        }

        if ($this->subdomain() == 'usaa') {
            $cancelreasons = [
                '1003800735' => '1003800735: Duplicate.',
                '1003800747' => '1003800747: Time expired.',
                '1003800713' => '1003800713: Cancelled per requestors email, the facility has been informed and the case has been closed.',
            ];
        }

        if ($workorder->W_HospitalID == 69) {
            $cancelreasons = [
                'E33' => 'E33: REQUESTOR CREATED DUPLICATE. NO PHONE CALL',
                'P20' => 'P20: TIME EXPIRED.',
                'E31' => 'E31: REQUESTOR CANCELLED. NO PHONE CALL.',
            ];
        }

        return view('user.workorders.cancel', compact('workorder', 'cancelreasons'));
    }

    public function cancelupdate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $reason = $request->input('reason');

        $requestor = Requestor::query()
            ->select(['R_Company'])
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        $cancelreasons = [
            '717' => '717: APS CANCELLED PER REQUESTOR',
            '718' => '718: APS CLOSED AS TIME EXPIRED',
            '719' => '719: APS CLOSED AS DUPLICATE',
        ];

        if (in_array($requestor->R_Company, [
            'PRUDENTIAL INSURANCE COMPANY OF AMERICA',
            'BESTOW AGENCY LLC',
            'FFR',
            'MASSMUTUAL',
        ])) {
            $cancelreasons = [
                '717' => 'APS CANCELLED PER REQUESTOR',
                '718' => 'APS CLOSED AS TIME EXPIRED',
                '719' => 'APS CLOSED AS DUPLICATE',
            ];
        }

        if ($this->subdomain() == 'usaa') {
            $cancelreasons = [
                '1003800735' => '1003800735: Duplicate.',
                '1003800747' => '1003800747: Time expired.',
                '1003800713' => '1003800713: Cancelled per requestors email, the facility has been informed and the case has been closed.',
            ];
        }

        if ($workorder->W_HospitalID == 69) {
            $cancelreasons = [
                'E33' => 'E33: REQUESTOR CREATED DUPLICATE. NO PHONE CALL',
                'P20' => 'P20: TIME EXPIRED.',
                'E31' => 'E31: REQUESTOR CANCELLED. NO PHONE CALL.',
            ];
        }

        $cancelreasontext = $cancelreasons[$reason];

        $W_Status = 'Cancel';

        if ($reason == '719') {
            $W_Status = 'Duplicate';
        }
        if ($reason == '1003800735') {
            $W_Status = 'Duplicate';
        }
        if ($reason == 'E33') {
            $W_Status = 'Duplicate';
        }

        if (in_array($requestor->R_Company, [
            'MASSMUTUAL',
        ])) {
            if ($reason == '718') {
                $W_Status = 'Complete';
            }
            if ($reason == '719') {
                $W_Status = 'Complete';
            }
        }

        $workorder->W_FollowUpDone = 1;
        $workorder->W_Owner = null;
        $workorder->W_Status = $W_Status;
        $workorder->W_CompletedDate = now()->format('Y-m-d 00:00:00');
        $workorder->W_UpdDate = now();
        $workorder->W_UpdUser = session('user.contractor.C_Name');

        $billingcompanies = [
            'PROTECTIVE LIFE',
            'PROTECTIVE LIFE & ANNUITY',
            'PROTECTIVE LIFE CHASE',
            'PROTECTIVE LIFE/BGA',
            'WEST COAST LIFE',
            'STANDARD INSURANCE COMPANY',
            'TRANSAMERICA',
        ];

        if (! in_array($workorder->W_BillCompany, $billingcompanies)) {
            $workorder->W_BillCompany = $requestor->R_Company;
        }

        if ($workorder->save()) {
            $request->session()->flash('success', 'Workorder is cancelled');

            $statustrigger = new Statustrigger();
            $statustrigger->WorkOrderNo = $workorder->W_WorkOrder;
            $statustrigger->statuscode = $request->input('reason');

            $statustrigger->laststatus = "{$cancelreasontext}";

            $statustrigger->ChangeType = 'S';
            $statustrigger->Created = now();
            $statustrigger->CreatedBy = session('user.contractor.C_Name');
            if ($statustrigger->save()) {
                $request->session()->flash('success', 'Statustrigger is created');
            }

            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder);
        }
    }

    public function reopen(UpdateWorkorderRequest $request, Workorder $workorder)
    {

        $statuses = [
            'Complete',
            'Cancel',
            'Duplicate',
        ];

        if (! in_array($workorder->W_Status, $statuses)) {
            $request->session()->flash('danger', 'Workorder Status is invalid for reopen');

            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder);
        }

        $reasons = [
            'Reopened the case for missing records' => 'Missing Records - Reopened the case for missing records',
            'Reopened the case for legible records' => 'Legible Records - Reopened the case for legible records',
            'Reopened the case per the requestor' => 'EIS Error - Reopened the case per the requestor',
            'Reopened the case because the facility made an error' => 'Facility Made an Error - Reopened the case because the facility made an error',
            'Reopened with updated patient information' => 'Requestor provided updated patient information - Reopened with updated patient information',
        ];

        $underwriteremail = null;

        $requestor = Requestor::query()
            ->select(['R_Company'])
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        $woin = Woin::query()
            ->where('WI_WorkOrder', $workorder->W_WorkOrder)
            ->first();

        $underwriter = Underwriter::query()
            ->where('U_Insurance', $woin->WI_InsName)
            ->where('U_Name', $woin->WI_Underwriter)
            ->first();

        if ($underwriter) {
            $underwriteremail = $underwriter->U_Email;
        }

        // dump($woin);
        // dump($underwriter);

        return view('user.workorders.reopen', compact('workorder', 'reasons', 'requestor', 'underwriteremail'));
    }

    public function reopenupdate(UpdateWorkorderRequest $request, Workorder $workorder)
    {
        $oldworkorder = clone $workorder;

        $workorder->W_FollowUpDone = 0;
        $workorder->W_CompletionType = 0;
        $workorder->W_CompletedDate = null;
        $workorder->W_Status = 'Incomplete';
        $workorder->W_UpdUser = session('user.contractor.C_Name');
        $workorder->W_UpdDate = now();
        $workorder->W_FollowUpStatus = 'Reopened Workorder: ' . $request->input('reason') . ' (' . session('user.contractor.C_Name') . ' ' . now()->format('m/d/Y g:i:s A') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;

        if ($workorder->save()) {
            $datachange = new Datachange();
            $datachange->model = 'workorders';
            $datachange->foreign_key = $workorder->W_WorkOrder;
            $datachange->data = 'Reopened Workorder: ' . $request->input('reason');
            $datachange->created_by = session('user.contractor.C_Name');
            $datachange->save();
            $request->session()->flash('success', 'Success');

            $underwriteremail = $request->input('underwriteremail') ?? null;

            if ($underwriteremail && filter_var($underwriteremail, FILTER_VALIDATE_EMAIL)) {
                $data = [];
                $data['sender'] = 'info@expressimagingservices.com';
                $data['subject'] = 'EIS Workorder Reopened ' . $workorder->W_WorkOrder;
                $data['body'] = 'Workorder ' . $workorder->W_WorkOrder . ' for ' . $workorder->W_FirstName . ' ' . $workorder->W_LastName . " has been reopened.\r\n\r\nReason: " . $request->input('reason') . "\r\n";

                Mail::mailer('smtprelaygmail')
                    ->to($underwriteremail)
                    ->send(new Emailer($data));
            }

            if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {

                $workorderreopen = new Workorderreopen();
                $workorderreopen->Mi_WorkOrder = $workorder->W_WorkOrder;
                $workorderreopen->Mi_CompletedDate = $oldworkorder->W_CompletedDate;
                $workorderreopen->Mi_ReopenDate = now()->toDateTimeString();
                $workorderreopen->Mi_PageCount = $oldworkorder->W_ImagePages;
                $workorderreopen->Mi_CompletionType = $oldworkorder->W_CompletionType;
                $workorderreopen->Mi_UpdatedBy = session('user.contractor.C_Name');
                $workorderreopen->save();
            }
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder);
    }

    public function docusign(Request $request, $W_WorkOrder)
    {
        try {
            $workorder = Workorder::query()
                ->select([
                    'Workorder.W_WorkOrder',
                    'Workorder.W_Requestor',
                    'Workorder.W_Agent',
                    'Workorder.W_FirstName',
                    'Workorder.W_MiddleInit',
                    'Workorder.W_LastName',
                    'Workorder.W_DOB',
                    'Workorder.W_SS',
                    'Workorder.W_Gender',
                    'Workorder.W_YearsOfRecord',
                    'Workorder.W_RecordNo',
                    'Workorder.W_Hospital',
                    'Workorder.W_InsCompany',
                    'Workorder.W_ReceiveDate',
                    'Workorder.W_TransNo',
                    'Requestor.R_Name as Requestor_R_Name',
                    'Requestor.R_Email as Requestor_R_Email',
                    'Requestor.R_Company as Requestor_R_Company',
                    'Examrequest.E_WorkOrder as Examrequest_E_WorkOrder',
                    'Examrequest.E_Address as Examrequest_E_Address',
                    'Examrequest.E_City as Examrequest_E_City',
                    'Examrequest.E_State as Examrequest_E_State',
                    'Examrequest.E_Zip as Examrequest_E_Zip',
                    'Examrequest.E_HomePhone as Examrequest_E_HomePhone',
                    'Examrequest.E_CellPhone as Examrequest_E_CellPhone',
                    'Examrequest.E_ApplicantEmail as Examrequest_E_ApplicantEmail',
                    'Company.C_Name as Company_C_Name',
                ])
                ->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name')
                ->leftJoin('Examrequest', 'Workorder.W_WorkOrder', '=', 'Examrequest.E_WorkOrder')
                ->leftJoin('Company', 'Requestor.R_Company', '=', 'Company.C_Name')
                ->where('W_WorkOrder', $W_WorkOrder)
                ->firstOrFail();

            $hospital = Hospital::query()
                ->select([
                    'H_ID',
                    'H_Hospital',
                    'H_Hospital2',
                    'H_Address',
                    'H_City',
                    'H_State',
                    'H_Zip',
                    'H_Phone',
                    'H_Docusign',
                ])
                ->where('H_Hospital', $workorder->W_Hospital)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
        }

        $agent = '';
        $agent_email = '';

        if ($workorder->Company_C_Name == 'NORTHWESTERN MUTUAL') {
            $apsorder = Apsorder::query()
                ->where('EISWorkOrderID', $workorder->W_WorkOrder)
                ->first();

            if ($apsorder) {
                $agent = $apsorder->WritingAgentFirstName . ' ' . $apsorder->WritingAgentLastName;
                $agent_email = Helper::extractEmails($apsorder->WritingAgentEmail);
                $agent_email = is_array($agent_email) ? implode(', ', $agent_email) : $agent_email;
            }
        }

        if ($workorder->Company_C_Name == 'NORTHWESTERN MUTUAL LTC') {

            $northwesternmutual = Northwesternmutual::query()
                ->where('EISWorkOrderID', $workorder->W_WorkOrder)
                ->first();

            if ($northwesternmutual) {
                $agent = $northwesternmutual->RequestorFirstName . ' ' . $northwesternmutual->RequestorLastName;
                $agent_email = Helper::extractEmails($northwesternmutual->RequestorEmail1);
                $agent_email = is_array($agent_email) ? implode(', ', $agent_email) : $agent_email;
            }
        }

        return view('user.workorders.docusign', compact('workorder', 'hospital', 'agent', 'agent_email'));
    }
}
