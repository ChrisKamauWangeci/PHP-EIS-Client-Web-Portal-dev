<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Mail\NoticeEmail;
use App\Models\Contractor;
use App\Models\Datachange;
use App\Models\Hospital;
use App\Models\Hospitalraw;
use App\Models\Requestor;
use App\Models\Statustrigger;
use App\Models\Workorder;
use App\Models\Workordernotice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkordernoticeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Workordernotice::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['type'] ?? null, fn ($q, $v) => $q->where('type', $v))
            ->when($filters['contractor'] ?? null, fn ($q, $v) => $q->where('contractor', 'LIKE', '%' . $v . '%'))
            ->when($filters['recipient'] ?? null, fn ($q, $v) => $q->where('recipient', 'LIKE', '%' . $v . '%'))
            ->when($filters['subject'] ?? null, fn ($q, $v) => $q->where('subject', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $workordernotices = $query->paginate(100);

        return view('user.workordernotices.index', compact('workordernotices', 'sort_direction'));
    }

    public function create(Request $request)
    {
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
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
        }

        $hospitalraw = Hospitalraw::query()
            ->where('R_WorkOrder', $workorder->W_WorkOrder)
            ->first();

        $sender = 'nmlc@expressimagingservices.com';

        if (! in_array($requestor->R_Company, ['NORTHWESTERN MUTUAL', 'NORTHWESTERN MUTUAL LTC'])) {
            $sender = 'actionrequired@expressimagingservices.com';
        }

        $workordernotices = Workordernotice::query()
            ->where('workorder_id', $workorder_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $workordernotice = Workordernotice::query()
            ->where('workorder_id', $workorder_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $workordernotice) {
            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder)
                ->with('danger', 'Workordernotices entry is missing record');
        }

        $recipient = $workordernotice->recipient ?? '';

        $subject = '';
        $body = '';

        $days = '25';

        if ($workorder->W_Owner == '45 DAYS NOTICE') {
            $days = '45';
        }

        if ($workorder->W_Owner != '25 DAYS NOTICE' && $workorder->W_Owner != '45 DAYS NOTICE') {
            return redirect()
                ->route('user.workorders.show', $workorder->W_WorkOrder)
                ->with('danger', 'Assigned must be: 25 DAYS NOTICE or 45 DAYS NOTICE');
        }

        $statustrigger = Statustrigger::query()
            ->where('WorkOrderNo', $workorder->W_WorkOrder)
            ->where('ChangeType', 'S')
            ->orderBy('Created', 'desc')
            ->first();
        // dump($statustrigger);
        if ($statustrigger) {
            $laststatus = strstr($statustrigger->laststatus, ':');
            $laststatus = strstr($laststatus, ' ');
        } else {
            $laststatus = '';
        }

        $originalprovider = $hospitalraw->R_Hospital ?? $hospital->H_Hospital2;

        $subject = $workorder->W_LastName . ', ' . $workorder->W_FirstName . ', ' . $workorder->W_MiddleInit . ' : APS Status Update';

        $bodyheader = '
Name: ' . $workorder->W_LastName . ', ' . $workorder->W_FirstName . ', ' . $workorder->W_MiddleInit . '
Policy/Cert: ' . $workorder->W_InsPolicy . '
Work Order: ' . $workorder->W_WorkOrder . '
Original Provider: ' . $originalprovider . '


We would like to take this opportunity to update you on the status of this pending request for medical records from ' . $originalprovider;

        $body = 'Please be advised that ' . $laststatus;

        $bodyfooter = 'For any additional status information, please contact us at ' . $sender;
        $bodyfooter .= "\r\n\r\nThank you,\r\nYour EIS Team";

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

        return view('user.workordernotices.create', compact('workorder', 'hospital', 'hospitalraw', 'days', 'workordernotices', 'workordernotice', 'statustriggers', 'sender', 'recipient', 'subject', 'body', 'bodyheader', 'bodyfooter', 'contractors'));
    }

    public function store(Request $request)
    {

        if ($request->input('sendemail') == 1) {

            $validated = $request->validate([
                'sender' => 'required|email:rfc',
                'recipient' => 'required|string',
                'subject' => 'required|min:5|max:80',
                'body' => 'required|min:5',
                'days' => 'required|in:25,45',
                'W_Owner' => 'required',
            ]);
        }

        $sender = $request->input('sender');
        $recipient = $request->input('recipient');
        $subject = $request->input('subject');
        $bodyheader = $request->input('bodyheader');
        $body = $request->input('body');
        $bodyfooter = $request->input('bodyfooter');
        $days = $request->input('days');

        $workorder_id = $request->input('workorder_id');
        $workordernotice_id = $request->input('workordernotice_id');

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        $workordernotice = Workordernotice::query()
            ->where('id', $workordernotice_id)
            ->firstOrFail();

        $requestor = Requestor::query()
            ->select(['R_Company'])
            ->where('R_Name', $workorder->W_Requestor)
            ->firstOrFail();

        $workorderold = $workorder;
        $workorderold = $workorderold->toArray();

        $status = $days . '-day ';

        if ($request->input('sendemail') == 1) {

            $message = $bodyheader . "\r\n\r\n" . $body . "\r\n\r\n" . $bodyfooter;

            $data['sender'] = $sender;
            $data['subject'] = $subject;
            $data['body'] = nl2br($message);

            $recipients = Helper::extractEmails($recipient);

            $file = $request->input('file') ?? '';
            $send_attachment = $request->input('send_attachment') ?? false;

            if ($send_attachment) {
                if (! is_file($file)) {
                    $request->session()->flash('danger', 'File not found ' . $file);

                    return back()->withInput();
                }
                $data['attachment'] = $file;
                $workordernotice->attachment = $file;
                // $message .= "\r\n\r\n" . 'Attachment: ' . basename($file);
            }

            if ($recipients) {
                Mail::mailer('smtprelaygmail')
                    ->to($recipients)
                    ->send(new NoticeEmail($data));
            }

            $workordernotice->sender = $sender;
            $workordernotice->recipient = $recipient;
            $workordernotice->subject = $subject;
            $workordernotice->body = $message;
            $workordernotice->emailed_at = now();

            $status .= ' - email sent to: ' . $recipient;
        }

        $workordernotice->user_after = $request->input('W_Owner');
        $workordernotice->updated_by = session('user.contractor.C_Name');
        $workordernotice->save();

        if ($workordernotice->user_after != $workordernotice->user_before) {
            $status .= ' - transfered back to ' . $request->input('W_Owner');
        }

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
            'W_FollowUpStatus' => $msg . " {$days} day notification email sent: " . $recipient . "\r\n(" . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus,
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => date('Y-m-d H:i:s'),
        ] + $W_FollowUpDt + $W_Owner);

        $statustrigger = new Statustrigger();
        $statustrigger->WorkOrderNo = $workorder_id;
        $statustrigger->statuscode = '022';
        if ($requestor->R_Company == 'PLICO-WCL') {
            $statustrigger->laststatus = $statustrigger->statuscode . ": {$days} day notification email sent to agent " . $recipient . "\r\n" . $body . "\r\n" . ' (' . date('g:i:s A') . ')';
        } else {
            $statustrigger->laststatus = $statustrigger->statuscode . ": {$days} day notification email sent to agent " . $recipient . "\r\n" . $body . "\r\n" . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
        }

        if ($this->subdomain() == 'eisdev' || $this->subdomain() == 'eisuat') {
            if (in_array($requestor->R_Company, ['NATIONWIDE LIFE UNDERWRITING', 'BESTOW AGENCY LLC'])) {
                $statustrigger->laststatus = "{$days} day notification email sent to agent " . $recipient . "\r\n" . $body . "\r\n" . ' (' . session('user.contractor.C_Name') . ' ' . date('g:i:s A') . ')';
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

        $request->session()->flash('success', 'Workorder Notice Completed');

        return back();
    }

    public function show(Workordernotice $workordernotice)
    {
        return view('user.workordernotices.show', compact('workordernotice'));
    }

    public function edit(Workordernotice $workordernotice)
    {
        // return view('user.workordernotices.edit', compact('workordernotice'));
    }

    public function update(Request $request, Workordernotice $workordernotice)
    {
        //
    }

    public function destroy(Workordernotice $workordernotice)
    {
        //
    }
}
