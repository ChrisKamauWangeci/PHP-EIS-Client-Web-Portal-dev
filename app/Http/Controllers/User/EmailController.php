<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\EmailEmail;
use App\Models\Email;
use App\Models\Hospital;
use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Email::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['type'] ?? null, fn ($q, $v) => $q->where('type', $v))
            ->when($filters['contractor'] ?? null, fn ($q, $v) => $q->where('contractor', 'LIKE', '%' . $v . '%'))
            ->when($filters['recipient'] ?? null, fn ($q, $v) => $q->where('recipient', 'LIKE', '%' . $v . '%'))
            ->when($filters['subject'] ?? null, fn ($q, $v) => $q->where('subject', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $emails = $query->paginate(100);

        return view('user.emails.index', compact('emails', 'sort_direction'));
    }

    public function create(Request $request)
    {
        $workorder_id = $request->input('workorder_id');

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->first();

        if (! $workorder) {
            return back()
                ->with('danger', 'Workorder not found for id ' . $workorder_id);
        }

        $hospital = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->first();

        if (! $hospital) {
            return back()
                ->with('danger', 'Hospital not found for workorder ' . $workorder->W_WorkOrder);
        }

        $file = $request->query('file') ?? '';
        $file = urldecode($file);

        $fileExist = true;
        if ($file && ! is_file($file)) {
            $fileExist = false;
        }

        $email_type = $request->query('email_type') ?? 'file';

        $sender = $request->query('sender') ?? 'eis_request@expressimagingservices.com';

        $recipient = $request->query('recipient');

        $subject = $request->query('subject') ?? 'EIS: Workorder: ' . $workorder->W_WorkOrder . ' - ' . $workorder->W_FirstName . ' ' . $workorder->W_LastName;

        $body = $request->query('body') ?? '';

        if ($email_type == 'fee_approval') {

            $subject = 'EIS: Fee Approval Required for ' . $workorder->W_WorkOrder . ' - ' . $workorder->W_FirstName . ' ' . $workorder->W_LastName;

            $body = 'Hello,';
            $body .= "\n";
            $body .= "\n";
            $body .= 'Fee Approval Required for the ' . \Helper::recordYear($workorder->W_YearsOfRecord) . " of records. The total cost is \${$workorder->W_DrFee} for {$workorder->W_ImagePages} pages.\n";
            $body .= "Please provide the fee approval along with name and phone number of the underwriter.\n";
            $body .= "\n";
            $body .= "Policy: {$workorder->W_InsPolicy}, Workorder: {$workorder->W_WorkOrder}, Applicant: {$workorder->W_FirstName} {$workorder->W_LastName}\n";
            $body .= "\n";
            $body .= "{$workorder->W_Hospital}\n";
            $body .= "{$hospital->H_Address}\n";
            $body .= "{$hospital->H_City}, {$hospital->H_State} {$hospital->H_Zip}\n";
        }

        $emails = Email::query()
            ->where('workorder_id', $workorder_id)
            ->get();

        return view('user.emails.create', compact('workorder', 'email_type', 'sender', 'recipient', 'subject', 'body', 'file', 'fileExist', 'emails'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender' => 'required|email:rfc,dns',
            'recipient' => 'required|email:rfc,dns',
            'subject' => 'required|min:5|max:80',
            'body' => 'required|min:5',
        ]);

        $email_type = $request->input('email_type');
        $sender = $request->input('sender');
        $recipient = $request->input('recipient');
        $subject = $request->input('subject');
        $body = $request->input('body');
        $file = $request->input('file');
        $attachment = $request->input('attachment') ?? false;

        $workorder_id = $request->input('workorder_id');

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        $data['from'] = $sender;
        $data['subject'] = $subject;
        $data['body'] = $body;

        if ($attachment) {

            $data['file'] = $file;

            if (! is_file($file)) {
                return back()
                    ->withInput()
                    ->with('danger', 'File not found ' . $file);
            }
        }

        Mail::mailer('smtprelaygmail')
            ->to($recipient)
            ->send(new EmailEmail($data));

        $email = new Email();
        $email->workorder_id = $workorder->W_WorkOrder;
        $email->type = $email_type;
        $email->contractor = session('user.contractor.C_Name');
        $email->sender = $sender;
        $email->recipient = $recipient;
        $email->subject = $data['subject'];
        $email->body = $data['body'];
        if ($attachment) {
            $email->attachment = $file;
        }
        $email->save();

        if ($email_type == 'fee_approval') {
            $workorder->W_FollowUpStatus = 'Fee Approval direct notification email sent to: ' . $recipient . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
            $workorder->save();
        }

        return back()
            ->with('success', 'Workorder ' . $workorder->W_WorkOrder . ', file: ' . $file . ' is emailed to: ' . $recipient);
    }

    public function show(Email $email)
    {
        return view('user.emails.show', compact('email'));
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
