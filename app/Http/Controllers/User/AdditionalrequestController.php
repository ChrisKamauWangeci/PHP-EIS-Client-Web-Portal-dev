<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contractor;
use App\Models\Hospital;
use App\Models\Insurancecompany;
use App\Models\Requestor;
use App\Models\Workorder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class AdditionalrequestController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $workorder_id = $request->query('workorder_id') ?? null;

        try {
            $workorder = Workorder::query()
                ->where('W_WorkOrder', $workorder_id)
                ->firstOrFail();
            $requestor = Requestor::query()
                ->where('R_Name', $workorder->W_Requestor)
                ->firstOrFail();
            $company = Company::query()
                ->where('C_Name', $requestor->R_Company)
                ->firstOrFail();
            $insurancecompany = Insurancecompany::query()
                ->where('I_Name', $workorder->W_InsCompany)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return back()->with('danger', $e->getMessage());
        }

        $companylor = '\\\\ftpserver\\ftpserver\\lor\\' . ($company->C_LOR ?? '');
        $insurancecompanylor = '\\\\ftpserver\\ftpserver\\lor\\' . ($insurancecompany->I_LOR ?? '');

        $loroptions = [];
        if (is_file($companylor ?? '')) {
            $loroptions[$company->C_LOR] = 'Company LOR - ' . $company->C_LOR;
        }
        if (is_file($insurancecompanylor ?? '')) {
            $loroptions[$insurancecompany->I_LOR] = 'Insurance LOR - ' . $insurancecompany->I_LOR;
        }

        return view('user.additionalrequests.create', compact('workorder', 'loroptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'workorder_id' => 'required|integer',
            'requesttype' => 'required|string|in:followup,cancel,missingrecord',
            'message' => 'nullable|string|max:1000',
            'lor' => 'nullable|string',
        ]);

        $workorder_id = $request->integer('workorder_id');
        $requestType = $request->input('requesttype');
        $message = $request->input('message');

        $subdomain = $this->subdomain();

        $datetime = now()->format('Ymd-Hi');

        try {
            $workorder = Workorder::query()
                ->where('W_WorkOrder', $workorder_id)
                ->firstOrFail();
            $hospital = Hospital::query()
                ->where('H_Hospital', $workorder->W_Hospital)
                ->firstOrFail();
            $contractor = Contractor::query()
                ->where('C_Name', $workorder->W_Contractor)
                ->firstOrFail();
            $requestor = Requestor::query()
                ->where('R_Name', $workorder->W_Requestor)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return back()->with('danger', $e->getMessage());
        }

        $additionalrequestsDirectory = '\\\\ftpserver\\ftpserver\\NoteFile\\additionalrequests\\' . $subdomain . '\\';

        $cover = $requestType != 'cancel' ? '_cover' : '';

        $coverPageFile = $additionalrequestsDirectory . "{$workorder->W_WorkOrder}-{$datetime}-request_{$requestType}{$cover}.pdf";

        $pdf = Pdf::loadView('user/additionalrequests/pdf/additionalrequest', [
            'workorder' => $workorder,
            'hospital' => $hospital,
            'requestor' => $requestor,
            'contractor' => $contractor,
            'requesttype' => $requestType,
            'message' => $message,
            'usersession' => session('user'),
        ]);
        $pdf->save($coverPageFile);

        $lor = $request->input('lor');
        $lorDirectory = '\\\\ftpserver\\ftpserver\\lor\\';
        $lorFile = is_file($lorDirectory . $lor) ? $lorDirectory . $lor : '';

        $authorizationDirectory = $subdomain === 'eis'
            ? '\\\\server2\\eisaccess\\AuthForms\\'
            : "\\\\server2\\eisaccess\\{$subdomain}\\AuthForms\\";

        $W_AuthorizedFile = '';
        if (! empty($workorder->W_AuthorizedFile)) {
            $info = pathinfo($workorder->W_AuthorizedFile);
            $W_AuthorizedFile = $info['filename'] ?? '';
        }

        $authorizationFile = '';

        if ($requestType == 'followup' || $requestType == 'missingrecord') {

            if (is_file($authorizationDirectory . $W_AuthorizedFile . '.pdf')) {
                $authorizationFile = $authorizationDirectory . $W_AuthorizedFile . '.pdf';
            } elseif (is_file($authorizationDirectory . $W_AuthorizedFile . '.tif')) {
                $authorizationFile = $authorizationDirectory . $W_AuthorizedFile . '.tif';

                $authorizationFileTemp = '\\\\ftpserver\\documents\\websitetemp\\' . $workorder->W_WorkOrder . '-auth-tif-additional.pdf';

                if (is_file($authorizationFileTemp)) {
                    unlink($authorizationFileTemp);
                }

                $command = [
                    'C:\xnview\nconvert.exe',
                    '-multi',
                    '-c',
                    '4',
                    '-out',
                    'pdf',
                    '-o',
                    $authorizationFileTemp,
                    $authorizationFile,
                ];
                Process::run($command);

                $authorizationFile = $authorizationFileTemp;
            }

            $outputFile = $additionalrequestsDirectory . $workorder->W_WorkOrder . '-' . $datetime . '-request_' . $requestType . '.pdf';

            $command = [
                'C:\gs\bin\gswin64c.exe',
                '-dQUIET',
                '-dBATCH',
                '-dNOPAUSE',
                '-q',
                '-sPAPERSIZE=letter',
                '-dFitPage',
                '-sDEVICE=pdfwrite',
                '-dPDFSETTINGS=/printer',
                '-sOutputFile=' . $outputFile,
            ];
            foreach ([$coverPageFile, $lorFile, $authorizationFile] as $inputFile) {
                if (is_file($inputFile)) {
                    $command[] = $inputFile;
                }
            }
            Process::run($command);

            if (is_file($coverPageFile)) {
                unlink($coverPageFile);
            }
            if (isset($authorizationFileTemp) && is_file($authorizationFileTemp)) {
                unlink($authorizationFileTemp);
            }
        }

        return redirect()
            ->route('user.workorderfiles.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
