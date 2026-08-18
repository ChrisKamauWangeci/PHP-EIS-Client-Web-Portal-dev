<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NoticeEmail;
use App\Models\Contractor;
use App\Models\Datachange;
use App\Models\Email;
use App\Models\Hospital;
use App\Models\Hospitalraw;
use App\Models\Northwesternmutualagent;
use App\Models\Requestor;
use App\Models\Underwriter;
use App\Models\Woin;
use App\Models\Statustrigger;
use App\Models\Workorder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkorderemailController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function create(Request $request)
    {
        $type = $request->input('type');

        $workorder_id = $request->input('workorder_id');

        try {
            $workorder = Workorder::query()
                ->where('W_WorkOrder', $workorder_id)
                ->firstOrFail();

            $requestor = Requestor::query()
                ->where('R_Name', $workorder->W_Requestor)
                ->firstOrFail();

            $hospital = Hospital::query()
                ->where('H_Hospital', $workorder->W_Hospital)
                ->firstOrFail();

            $hospitalraw = Hospitalraw::query()
                ->where('R_WorkOrder', $workorder->W_WorkOrder)
                ->firstOrFail();

            $northwesternmutualagent = Northwesternmutualagent::query()
                ->where('WorkOrderNo', $workorder->W_WorkOrder)
                ->first();
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
        }

        // dump($hospitalraw);

        $sender = 'nmlc@expressimagingservices.com';

        $recipient = $northwesternmutualagent->AgentEmail ?? '';

        if ($requestor->R_Company == 'MASSMUTUAL') {
            $woin = Woin::query()
                ->where('WI_WorkOrder', $workorder->W_WorkOrder)
                ->first();

            $underwriter = Underwriter::query()
                ->where('U_Insurance', $woin->WI_InsName)
                ->where('U_Name', $woin->WI_Underwriter)
                ->first();

            $sender = 'info@expressimagingservices.com';
            $recipient = $underwriter->U_Email ?? '';
        }

        $subject = '';
        $body = '';

        if ($type == 'roadblock') {

            $subject = $workorder->W_LastName . ', ' . $workorder->W_FirstName . ', ' . $workorder->W_MiddleInit . ' : APS Status Update';

            $bodyheader = '
Name: ' . $workorder->W_LastName . ', ' . $workorder->W_FirstName . ', ' . $workorder->W_MiddleInit . '
Policy/Cert: ' . $workorder->W_InsPolicy . '
Work Order: ' . $workorder->W_WorkOrder . '
Original Provider: ' . $hospitalraw->R_Hospital . '


We would like to take this opportunity to update you on the status of this pending request for medical records from ' . $hospitalraw->R_Hospital;

            $body = '(INSERT ANY SPECIFIC DETAILS SHARED BY FACILITY)';

            $bodyfooter = 'This is an informational email only; no action is needed from ' . $workorder->W_InsCompany . ' at this time. Request will remain in process until records are received.

    For any additional status information, please contact us at 888-846-8804.

Thank you,
Your EIS Team';
        }

        $contractors = Contractor::query()
            ->select('C_Name')
            ->where('C_Caller', 1)
            ->orderBy('C_Name', 'ASC')
            ->pluck('C_Name', 'C_Name')
            ->toArray();

        $statustriggers = Statustrigger::query()
            ->where('WorkOrderNo', $workorder->W_WorkOrder)
            ->where('ChangeType', 'S')
            ->orderBy('Created', 'desc')
            ->get();

        return view('user.workorderemails.create', compact('workorder', 'statustriggers', 'type', 'sender', 'recipient', 'subject', 'body', 'bodyheader', 'bodyfooter', 'contractors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender' => 'required|email:rfc,dns',
            'recipient' => 'required',
            'subject' => 'required|min:5|max:100',
            'body' => 'required|min:5',
            'W_Owner' => 'required',
        ]);

        $sender = $request->input('sender');
        $recipient = $request->input('recipient');
        $subject = $request->input('subject');
        $bodyheader = $request->input('bodyheader');
        $body = $request->input('body');
        $bodyfooter = $request->input('bodyfooter');

        $type = $request->input('type');

        $workorder_id = $request->input('workorder_id');
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        $requestor = Requestor::query()
            ->select(['R_Company'])
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        $workorderold = $workorder;
        $workorderold = $workorderold->toArray();

        $message = $bodyheader . "\r\n\r\n" . $body . "\r\n\r\n" . $bodyfooter;

        $data['sender'] = $sender;
        $data['subject'] = $subject;
        $data['body'] = nl2br($message);

        $recipient = str_replace(' ', ',', $recipient);
        $recipient = str_replace(';', ',', $recipient);
        $recipients = explode(',', $recipient);
        $recipients = array_map('trim', $recipients);

        $recipients = array_filter($recipients, function ($s) {
            return filter_var($s, FILTER_VALIDATE_EMAIL);
        });

        if ($recipients) {
            Mail::mailer('smtprelaygmail')
                ->to($recipients)
                ->send(new NoticeEmail($data));
        }

        $email = new Email();
        $email->workorder_id = $workorder_id;
        $email->type = $type;
        $email->contractor = session('user.contractor.C_Name');
        $email->sender = $sender;
        $email->recipient = $recipient;
        $email->subject = $subject;
        $email->body = $body;
        $email->save();

        $msg = '';

        $W_FollowUpDt = [];
        $W_Owner = [];

        if ($request->input('W_FollowUpDt') != optional($workorder->W_FollowUpDt)->format('Y-m-d')) {
            $W_FollowUpDt = ['W_FollowUpDt' => $request->input('W_FollowUpDt')];
            $msg .= 'Followup date changed: ' . $request->input('W_FollowUpDt') . "\r\n";
        }

        if ($request->input('W_Owner') != $workorder->W_Owner) {
            $W_Owner = ['W_Owner' => $request->input('W_Owner')];
            $msg .= 'Assigned to changed: ' . $request->input('W_Owner') . "\r\n";
        }

        $workorder->update([
            'W_FollowUpStatus' => $msg . $type . ' notification email sent to: ' . $recipient . "\r\n(" . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus,
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => date('Y-m-d H:i:s'),
        ] + $W_FollowUpDt + $W_Owner);

        $statustrigger = new Statustrigger();
        $statustrigger->WorkOrderNo = $workorder_id;
        $statustrigger->statuscode = '022';
        if ($requestor->R_Company == 'PLICO-WCL') {
            $statustrigger->laststatus = $statustrigger->statuscode . ': Roadblock notification email sent to agent (' . date('g:i:s A') . ')';
        } else {
            $statustrigger->laststatus = $statustrigger->statuscode . ': Roadblock notification email sent to agent (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
        }

        if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
            if (in_array($requestor->R_Company, ['NATIONWIDE LIFE UNDERWRITING', 'BESTOW AGENCY LLC'])) {
                $statustrigger->laststatus = 'Roadblock notification email sent to agent (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
            }
        }

        $statustrigger->Created = now();
        $statustrigger->CreatedBy = session('user.contractor.C_Name');
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        $before = array_diff_assoc($workorderold, $workorder->toArray());
        $after = array_diff_assoc($workorder->toArray(), $workorderold);

        unset($before['W_FollowUpStatus']);
        unset($after['W_FollowUpStatus']);

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
            ->with('success', 'Workorder Notice Completed');
    }

    public function show(Email $email)
    {
        //
    }

    public function edit(Email $email)
    {
        //
    }

    public function update(Request $request, Email $email)
    {
        //
    }

    public function destroy(Email $email)
    {
        //
    }
}
