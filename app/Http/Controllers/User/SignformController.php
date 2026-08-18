<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Docusigndocument;
use App\Models\Hospital;
use App\Models\Prefill;
use App\Models\Workorder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class SignformController extends Controller
{
    public function index(Request $request)
    {
        $W_WorkOrder = $request->query('W_WorkOrder');

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
                    'Workorder.W_HospitalID',
                    'Workorder.W_AuthSignature',
                    'Workorder.W_DrFee',
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
                ])
                ->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name')
                ->leftJoin('Examrequest', 'Workorder.W_WorkOrder', '=', 'Examrequest.E_WorkOrder')
                ->leftJoin('Company', 'Requestor.R_Company', '=', 'Company.C_Name')
                ->where('W_WorkOrder', $W_WorkOrder)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
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

        $docusigndocuments = Docusigndocument::query()
            ->where('workorder_id', $workorder->W_WorkOrder)
            ->get();

        return view('user.signforms.index', compact('workorder', 'hospital', 'docusigndocuments'));
    }

    public function create(Request $request)
    {

        $data = [];
        foreach ($request->query() as $key => $value) {
            $data[$key] = addslashes(trim($request->query($key) ?? '')) ?? '';
        }

        return view('user.signforms.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'db' => 'required|string|max:255',
            'workorder_id' => 'required|integer',
            'slug' => 'required|string|max:255',
            'applicant' => 'required|string|max:255',
            'filename' => 'required|string|max:255|regex:/^[\w\-.]+$/',
        ]);

        $filename = basename($request->input('filename'));

        $prefill = new Prefill();
        $prefill->db = $request->input('db');
        $prefill->workorder_id = $request->input('workorder_id');
        $prefill->slug = $request->input('slug');
        $prefill->applicant = $request->input('applicant');
        $prefill->username = session('user.contractor.C_Name');
        $prefill->save();

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $request->input('workorder_id'))
            ->first();
        $workorder->W_FollowUpStatus = 'In House Prefill Created, ID: ' . $prefill->id . ' (' . session('user.contractor.C_Name') . ' ' . date('m/d/Y g:i:s A') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->save();

        if (! empty($_FILES)) {

            $safeBaseDir = '\\\\ftpserver\\documents\\sign\\';

            $prefillfile = $safeBaseDir . $filename;
            $prefillgsfile = $safeBaseDir . $request->input('workorder_id') . '-prefill-gs.pdf';

            move_uploaded_file($_FILES['data']['tmp_name'], $prefillfile);

            if (file_exists($prefillfile)) {
                $command = [
                    'C:\gs\bin\gswin64c.exe',
                    '-dQUIET',
                    '-q',
                    '-dBATCH',
                    '-dNOPAUSE',
                    '-sPAPERSIZE=letter',
                    '-dFitPage',
                    '-sDEVICE=pdfwrite',
                    '-dPDFSETTINGS=/printer',
                    '-dSAFER',
                    '-dFlattenAllForms=true',
                    '-dRemoveAllAnnotations=true',
                    '-sOutputFile=' . $prefillgsfile,
                    $prefillfile,
                ];
                $result = Process::run($command);

                if (! $result->successful()) {
                    logger()->error('signform store failed.', ['error' => $result->errorOutput()]);

                    return response()->json([
                        'success' => false,
                        'message' => 'PDF conversion failed',
                    ]);
                }
            }

            if (is_file($prefillgsfile)) {
                return response()->json([
                    'success' => true,
                    'message' => 'PDF filled and saved successfully.',
                    'prefillfile' => $prefillgsfile,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: PDF file not found.',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Data Sent',
            ]);
        }
    }

    public function show(Signform $signform)
    {
        return view('user.signforms.show', compact('signform'));
    }

    public function edit(Signform $signform)
    {
        //
    }

    public function update(UpdateDocusigndocumentRequest $request, Docusigndocument $docusigndocument)
    {
        //
    }

    public function destroy(Docusigndocument $docusigndocument)
    {
        //
    }
}
