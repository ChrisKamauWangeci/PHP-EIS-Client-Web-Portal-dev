<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\Emailer;
use App\Models\Company;
use App\Models\Email;
use App\Models\Insurancecompany;
use App\Models\Requestor;
use App\Models\Workorder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkorderemailsendController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:confirmation,follow_up',
        ]);

        $type = $request->input('type');

        $workorder_id = $request->input('workorder_id');

        try {
            $workorder = Workorder::query()
                ->where('W_WorkOrder', $workorder_id)
                ->firstOrFail();

            $requestor = Requestor::query()
                ->select([
                    'R_Name',
                    'R_Email',
                    'R_Company',
                ])
                ->where('R_Name', $workorder->W_Requestor)
                ->firstOrFail();

            $company = Company::query()
                ->select([
                    'C_Name',
                    'C_WebID',
                    'C_LOR',
                    'C_LORExpirationDate',
                ])
                ->where('C_Name', $requestor->R_Company)
                ->firstOrFail();

            $insurancecompany = Insurancecompany::query()
                ->select([
                    'I_Name',
                    'I_LOR',
                    'I_LORExpirationDate',
                ])
                ->where('I_Name', $workorder->W_InsCompany)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
        }

        $sender = 'eis_request@expressimagingservices.com';

        $niceType = ucwords(str_replace('_', ' ', $type));

        $subject = 'Medical Records Request ' . $niceType . ' for ' . $workorder->W_FirstName . ' ' . $workorder->W_LastName . ' WO#' . $workorder->W_WorkOrder;

        $recipient = '';

        $confirmation = 'Hello ' . $workorder->W_Hospital . ' Medical Records Team,

I hope this message finds you well.
We are writing on behalf of our client to formally request copies of medical records for the patient listed below, in support of a Life Insurance / Disability Insurance review:

Patient Name: ' . $workorder->W_FirstName . ' ' . $workorder->W_LastName . '
Date of Birth: ' . $workorder->W_DOB->format('m/d/Y') . '

A HIPAA-compliant authorization is attached for your review. Kindly confirm receipt of the authorization and advise if it is acceptable on your end, or if any revisions or additional documentation are required.

Additionally, please let us know if there are any applicable fees, processing timelines, or other requirements needed to facilitate the release of records. We are happy to comply with your facility’s medical records request procedures.

Should you have any questions or require further clarification, please feel free to contact us using the information below:

Phone: 888-846-8804
Fax: 310-905-3256
Email: eis_request@expressimagingservices.com

Thank you for your time and assistance. We appreciate your support and look forward to working with your team.

Sincerely,

Express Imaging Services, Inc.
1805 W. 208th St., Suite 202
Torrance, CA 90501
Phone: 888-846-8804
Fax: 310-905-3256';

        $follow_up = '
Hello ' . $workorder->W_Hospital . ' Medical Records Team,

I hope this message finds you well.
We are writing on behalf of our client to follow up on the medical records request previously submitted for the patient listed below, in support of a Life Insurance / Disability Insurance review:

Patient Name: ' . $workorder->W_FirstName . ' ' . $workorder->W_LastName . '
Date of Birth: ' . $workorder->W_DOB->format('m/d/Y') . '
Date Request and HIPAA Authorization Sent:

We would like to kindly request an update on the status of this request.



Please let us know if any additional information, documentation, or actions are required on our end to facilitate the release of records. We are happy to comply with your facility’s medical records procedures.
Should you have any questions or require further clarification, please feel free to contact us using the information below:

Phone:  888-846-8804
Fax:  13109053256
Email: eis_request@expressimagingservices.com

Thank you for your time and assistance. We appreciate your support and look forward to your response.


Sincerely,

Express Imaging Services, Inc.
1805 W. 208th St., Suite 202
Torrance, CA 90501
Phone: 888-846-8804';

        $body = $$type;

        return view('user.workorderemailsend.create', compact('workorder', 'company', 'insurancecompany', 'type', 'niceType', 'sender', 'recipient', 'subject', 'body'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:confirmation,follow_up',
            'niceType' => 'required|string|in:Confirmation,Follow Up',
            'sender' => 'required|email',
            'recipient' => 'required|email',
            'subject' => 'required|min:5|max:100',
            'body' => 'required|min:5',
        ]);

        $sender = $request->input('sender');
        $recipient = $request->input('recipient');
        $subject = $request->input('subject');
        $body = $request->input('body');

        $workorder_id = $request->input('workorder_id');
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->firstOrFail();

        $data = [];
        $data['sender'] = $sender;
        $data['subject'] = $subject;
        $data['body'] = $body;

        // Collect attachments dynamically

        // dump($request->all());

        $attachments = [];

        foreach ($request->all() as $key => $value) {

            if (! preg_match('/^attachment_(\d+)$/', $key, $matches)) {
                continue;
            }

            $index = $matches[1];

            if (
                $request->input("attachment_{$index}_checkbox") === '1'
                && ! empty($value)
                && file_exists($value)
            ) {
                $attachments[] = $value;
            }
        }

        $totalSize = 0;

        foreach ($attachments as $path) {
            $totalSize += filesize($path);
        }

        if ($totalSize > 12 * 1024 * 1024) {
            return back()->withInput()->with('danger', 'Total attachment size exceeds 12MB limit. Please select smaller files or fewer attachments.');
        }

        $data['attachments'] = $attachments;

        $emailAttachment = ! empty($attachments)
            ? implode(', ', array_map('basename', $attachments))
            : null;

        Mail::mailer('smtprelaygmail')
            ->to($recipient)
            ->send(new Emailer($data));

        $email = new Email();
        $email->workorder_id = $workorder_id;
        $email->type = $validated['niceType'] . ' of Medical Records Request';
        $email->contractor = session('user.contractor.C_Name');
        $email->sender = $sender;
        $email->recipient = $recipient;
        $email->subject = $subject;
        $email->body = $body;
        $email->attachment = $emailAttachment;
        $email->save();

        $workorder->update([
            'W_FollowUpStatus' => $validated['niceType'] . ' of Medical Records Request email sent to: ' . $recipient . ' (' . now()->format('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus,
            'W_UpdUser' => session('user.contractor.C_Name'),
            'W_UpdDate' => now(),
        ]);

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Email Sent Successfully');
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
