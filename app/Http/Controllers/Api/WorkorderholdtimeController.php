<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Requestor;
use App\Models\Statustrigger;
use App\Models\Workorder;
use App\Models\Workorderholdtime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkorderholdtimeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'workorder_id' => 'required|integer',
        ]);

        $workorderholdtimes = Workorderholdtime::query()
            ->where('workorder_id', $request->query('workorder_id'))
            ->get();

        foreach ($workorderholdtimes as $workorderholdtime) {

            if ($workorderholdtime->requirement) {
                $rrr = explode(',', $workorderholdtime->requirement);
                $rr = '';
                foreach ($rrr as $r) {
                    $rr .= Helper::requirementoption($r) . ', ';
                }
                $rr = rtrim($rr, ', ');
                $workorderholdtime->requirement = $rr;
            }
        }

        return $workorderholdtimes;
    }

    public function store(Request $request)
    {
        $request->validate([
            'workorder_id' => 'required|integer',
            'date_start' => 'required|date',
            'reason' => 'required|string|min:1|max:50',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
            'status_note' => 'nullable|string|min:1|max:500',
        ]);

        $statusNote = $request->input('status_note');
        $dateStart = Carbon::parse($request->input('date_start'));
        $reasontext = $request->input('reason');
        $noHold = $request->input('nohold') ?? 0;

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $request->input('workorder_id'))
            ->firstOrFail();
        $requestor = Requestor::query()
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();
        $company = Company::query()
            ->where('C_Name', $requestor->R_Company)
            ->firstOrFail();

        $statusCodes = [
            10 => '26', // NAILBA System
            69 => 'P03', // Nationwide System
            90 => '219', // NYL
            88 => '1003800773', // USAA
        ];

        $reasonCodes = [
            '605' => 'Additional Facility Information Needed',
            '606' => 'Additional Patient Information Needed',
            '607' => 'Cancellation Fee Notice',
            '608' => 'Cancellation Not Possible',
            '609' => 'Facility Unresponsive Uncooperative',
            '610' => 'Fee Approval',
            '611' => 'No Records',
            '612' => 'Order on Hold Per Requestor',
            '613' => 'Other',
            '614' => 'Patient Assistance Needed',
            '615' => 'Patient ID/Drivers License Required',
            '616' => 'Patient Refusal To Release Records',
            '617' => 'Power of Attorney Required/Rejected',
            '618' => 'Special Authorization Non Prefill',
            '619' => 'Special Authorization Prefill',
            '620' => 'Time Frame Verification Needed',
            '621' => 'HIPAA Not Received with Order',
        ];

        $holdId = 2;
        $isSpecialAuth = false;
        if (in_array($request->input('reason'), ['Special Authorization Prefill', 'Special Authorization Non Prefill'])) {
            $holdId = 1;
            $isSpecialAuth = true;
            $workorder->W_AuthSignature = 1;
        }

        if (in_array($this->subdomain(), ['eisdev', 'eisuat', 'eis'])) {
            $statuscode = array_search($request->input('reason'), $reasonCodes) ?? 605;
            if ($workorder->W_HospitalID && array_key_exists($workorder->W_HospitalID, $statusCodes)) {
                $statuscode = $statusCodes[$workorder->W_HospitalID];
            }
        } else {
            $statuscode = $statusCodes[$workorder->W_HospitalID ?? null] ?? 605;
        }

        if ($isSpecialAuth && $requestor->R_Company === 'PRUDENTIAL INSURANCE COMPANY OF AMERICA') {
            $statuscode = '022';
        }

        $requirement = implode(',', array_filter((array) $request->input('requirements')));

        $workorderholdtime = new Workorderholdtime();
        $workorderholdtime->workorder_id = $request->input('workorder_id');
        $workorderholdtime->date_start = $dateStart;
        $workorderholdtime->hold_id = $holdId;
        $workorderholdtime->status_code = $statuscode;
        $workorderholdtime->company_id = $company->id;
        $workorderholdtime->reason = $request->input('reason');
        $workorderholdtime->requirement = $requirement;
        $workorderholdtime->created_by = session('user.contractor.C_Name');
        $workorderholdtime->modified_by = session('user.contractor.C_Name');

        if (! $noHold) {
            $workorderholdtime->save();
        }

        if ($workorderholdtime->requirement) {

            $rr = collect(explode(',', $workorderholdtime->requirement))
                ->map(fn ($r) => Helper::requirementoption($r))
                ->implode(', ');
            $workorderholdtime->requirement = $rr;

            $reasontext .= " - {$workorderholdtime->requirement}";
        }

        $actionText = $noHold == 1 ? 'WITHOUT HOLD' : 'START';

        $workorder->W_FollowUpStatus = 'WORKORDER HOLD ' . $actionText . ' (' . $dateStart->format('m/d/Y') . ') - ' . $reasontext . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->save();

        $statustrigger = new Statustrigger();
        $statustrigger->WorkOrderNo = $workorder->W_WorkOrder;
        $statustrigger->statuscode = $statuscode;
        if ($requestor->R_Company == 'PLICO-WCL') {
            $statustrigger->laststatus = $statustrigger->statuscode . ': ACTION REQUIRED ' . $actionText . ': ' . $reasontext . ' - ' . $statusNote . ' (' . date('g:i:s A') . ')';
        } else {
            $statustrigger->laststatus = $statustrigger->statuscode . ': ACTION REQUIRED ' . $actionText . ': ' . $reasontext . ' - ' . $statusNote . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
        }

        if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
            if (in_array($requestor->R_Company, ['NATIONWIDE LIFE UNDERWRITING', 'BESTOW AGENCY LLC'])) {
                $statustrigger->laststatus = 'ACTION REQUIRED ' . $actionText . ': ' . $reasontext . ' - ' . $statusNote . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
            }
        }

        $statustrigger->CreatedBy = session('user.contractor.C_Name');
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        return $workorderholdtime;
    }

    public function update(Request $request, Workorderholdtime $workorderholdtime)
    {
        $request->validate([
            'id' => 'required|integer',
            'date_end' => 'required|date',
            'status_note_end' => 'nullable|string|min:1|max:500',
        ]);

        $dateEnd = Carbon::parse($request->input('date_end'));

        $workorderholdtime = Workorderholdtime::findOrFail($request->input('id'));
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorderholdtime->workorder_id)
            ->firstOrFail();
        $requestor = Requestor::query()
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        $workorderholdtime->date_end = $dateEnd;
        $workorderholdtime->modified_by = session('user.contractor.C_Name');
        $workorderholdtime->save();

        $reasontext = $workorderholdtime->reason;

        if ($workorderholdtime->requirement) {
            $reasontext .= ' - ' . Helper::requirementoption($workorderholdtime->requirement);
        }

        $workorder->W_FollowUpStatus = 'WORKORDER HOLD END (' . $dateEnd->format('m/d/Y') . ') - ' . $reasontext . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->save();

        $statusCodes = [
            '' => '607', // All other companies
            '10' => '28', // NAILBA System
            '69' => 'P01', // Nationwide System
            '90' => '201', // NYL
            '88' => '1003800773', // USAA
        ];

        $statustrigger = new Statustrigger();
        $statustrigger->WorkOrderNo = $workorder->W_WorkOrder;

        $hospitalId = $workorder->W_HospitalID ?? null;
        $statuscode = $statusCodes[$hospitalId] ?? 607;

        if ($requestor->R_Company === 'PRUDENTIAL INSURANCE COMPANY OF AMERICA') {
            $statuscode = '022';
        }

        $statustrigger->statuscode = $statuscode;

        if ($requestor->R_Company == 'PLICO-WCL') {
            $statustrigger->laststatus = $statustrigger->statuscode . ': ACTION REQUIRED END: ' . $reasontext . ' - ' . $request->input('status_note_end') . ' (' . date('g:i:s A') . ')';
        } else {
            $statustrigger->laststatus = $statustrigger->statuscode . ': ACTION REQUIRED END: ' . $reasontext . ' - ' . $request->input('status_note_end') . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
        }

        if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
            if (in_array($requestor->R_Company, ['NATIONWIDE LIFE UNDERWRITING', 'BESTOW AGENCY LLC'])) {
                $statustrigger->laststatus = 'ACTION REQUIRED END: ' . $reasontext . ' - ' . $request->input('status_note_end') . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
            }
        }

        $statustrigger->CreatedBy = session('user.contractor.C_Name');
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        return $workorderholdtime;
    }
}
