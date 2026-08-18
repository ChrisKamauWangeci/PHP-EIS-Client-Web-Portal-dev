<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Filetransfer;
use App\Models\Hospital;
use App\Models\Insurancecompany;
use App\Models\Requestor;
use App\Models\Requestorfollowup;
use App\Models\Workorder;
use App\Models\Workorderholdtime;
use App\Models\Statustrigger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;

class WorkorderfileController extends Controller
{
    public function show(Request $request, $W_WorkOrder)
    {
        if (! ctype_digit($W_WorkOrder) || (int) $W_WorkOrder < 1 || (int) $W_WorkOrder > 99999999) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', 'Invalid work order number');
        }

        try {
            $workorder = Workorder::query()
                ->select([
                    'W_WorkOrder',
                    'W_FirstName',
                    'W_LastName',
                    'W_DOB',
                    'W_Hospital',
                    'W_AuthorizedFile',
                    'W_ImageFile',
                    'W_DrInvoiceNo',
                    'W_Requestor',
                    'W_InsCompany',
                    'W_Status',
                    'W_FollowUpStatus',
                    'W_ReceiveDate',
                ])
                ->where('W_WorkOrder', $W_WorkOrder)
                ->firstOrFail();

            $hospital = Hospital::query()
                ->select([
                    'H_Hospital',
                    'H_Address',
                    'H_City',
                    'H_State',
                    'H_Zip',
                    'H_Phone',
                    'H_PhoneExt',
                    'H_Fax',
                ])
                ->where('H_Hospital', $workorder->W_Hospital)
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
                ->first();
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', $e->getMessage());
        }

        $company->C_LORExpirationDateLabel = $this->_checkExpiration($company->C_LORExpirationDate);
        if ($insurancecompany) {
            $insurancecompany->I_LORExpirationDateLabel = $this->_checkExpiration($insurancecompany->I_LORExpirationDate);
        }

        return view('user.workorderfiles.show', compact('workorder', 'hospital', 'requestor', 'company', 'insurancecompany'));
    }

    public function authcheckembed(Request $request)
    {
        $workorder_id = $request->input('workorder_id');

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $workorder_id)
            ->whereNotNull('W_DOB')
            ->whereNotNull('W_AuthorizedFile')
            ->firstOrFail();

        $filePath = "//server2/eisaccess/eisdev/AuthForms/{$workorder->W_AuthorizedFile}";

        $response = Http::withToken('ae4a3878-ebdd-457c-9429-62efae2008a1')
            ->acceptJson()
            ->get("https://hermeshealth.ai/v0/auth-check/{$workorder_id}");

        if (! $response->successful()) {
            dd('Failed to get upload URL', $response->body());
        }

        $data = $response->json();

        $uploadUrl = $data['uploadUrl'];

        $upload = Http::withBody(file_get_contents($filePath), 'application/pdf')
            ->put($uploadUrl);

        if (! $upload->successful()) {
            dd('Upload failed', $upload->status(), $upload->body());
        }

        $embeddata = [
            'firstName' => $workorder->W_FirstName,
            'lastName' => $workorder->W_LastName,
            'dateOfBirth' => $workorder->W_DOB->format('Y-m-d'),
            'authorizationType' => 'Hipaa',
            'capacity' => 'SelfAuthorizing',
            'startDateOfService' => now()->subYears(5)->toDateString(),
            'endDateOfService' => now()->toDateString(),
            'authorizationExpirationDate' => now()->addDays(30)->toDateString(),
        ];

        $response = Http::withToken('ae4a3878-ebdd-457c-9429-62efae2008a1')
            ->acceptJson()
            ->post("https://hermeshealth.ai/v0/auth-check/{$workorder_id}/embed-token", $embeddata);

        if (! $response->successful()) {
            dd('embed failed', $response->status(), $response->body());
        }

        $token = $response->json('token');

        return view('user.workorderfiles.authcheckembed', compact('token'));
    }

    protected function _checkExpiration($date)
    {
        if (! $date) {
            return 'invalid';
        }

        try {
            $expirationdate = strtotime($date->toDateTimeString());
            $today = time();
            $todayplus30days = $today + 60 * 60 * 24 * 30;
            $value = 'valid';
            if ($expirationdate < $todayplus30days) {
                $value = 'expiring';
            }
            if ($expirationdate < $today) {
                $value = 'expired';
            }
        } catch (\Exception $e) {
            $value = 'invalid';
        }

        return $value;
    }

    public function qr(Request $request, $W_WorkOrder)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $W_WorkOrder)
            ->firstOrFail();

        $data = [
            'workorder' => $workorder,
        ];

        $pdf = Pdf::loadView('user/workorderfiles/pdf/qr', $data);
        $pdf->setPaper('letter', 'portrait');
        $canvas = $pdf->getCanvas();
        $canvas->page_script('$pdf->set_opacity(0.0, "Multiply");');

        return $pdf->stream($workorder->W_WorkOrder . '-qr.pdf');
    }

    public function coverpage(Request $request, $W_WorkOrder)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $W_WorkOrder)
            ->firstOrFail();

        $hospital = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->firstOrFail();

        $data = [
            'workorder' => $workorder,
            'hospital' => $hospital,
            'userinfo' => session('user'),
        ];

        $pdf = Pdf::loadView('user/workorderfiles/pdf/coverpage', $data);

        return $pdf->stream($workorder->W_WorkOrder . '-coverpage.pdf');
    }

    public function createrequestfile(Request $request)
    {
        $start = microtime(true);

        $W_WorkOrder = $request->query('W_WorkOrder') ?? 0;

        $lorfile = $request->query('lorfile') ?? '';
        $type = $request->query('type') ?? '';
        $requestnote = $request->query('requestnote') ?? '1st';

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $W_WorkOrder)
            ->firstOrFail();

        $hospital = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->firstOrFail();

        $data = [
            'workorder' => $workorder,
            'hospital' => $hospital,
            'requestnote' => $requestnote,
            'userinfo' => session('user'),
        ];

        $pdf = Pdf::loadView('user/workorderfiles/pdf/coverpage', $data);
        $pdf->save('\\\\ftpserver\\ftpserver\\notefile\\coverpages\\' . $this->subdomain() . '\\' . $W_WorkOrder . '-coverpage.pdf');

        // $pdf = Pdf::loadView('user/workorderfiles/pdf/qr', $data);
        // $pdf->setPaper('letter', 'portrait');
        // $canvas = $pdf->getCanvas();
        // $canvas->page_script('$pdf->set_opacity(0.0, "Multiply");');
        // $pdf->save('\\\\ftpserver\\ftpserver\\notefile\\coverpages\\' . $this->subdomain() . '\\' . $W_WorkOrder . '-qr.pdf');

        $folder_coverpage = '\\\\ftpserver\\ftpserver\\notefile\\coverpages\\' . $this->subdomain() . '\\';
        $folder_lor = '\\\\ftpserver\\ftpserver\\lor\\';

        $folder_auth = '\\\\server2\\eisaccess\\' . $this->subdomain() . '\\AuthForms\\';
        if ($this->subdomain() == 'eis') {
            $folder_auth = '\\\\server2\\eisaccess\\AuthForms\\';
        }

        $datefolder = date_format($workorder->W_ReceiveDate, 'Ym');
        $folder_output = '\\\\ftpserver\\ftpserver\\NoteFile\\FaxRequest1\\' . $this->subdomain() . '\\' . $datefolder . '\\';
        if (! is_dir($folder_output)) {
            mkdir($folder_output, 0777, true);
        }

        $file_coverpage = is_file($folder_coverpage . $W_WorkOrder . '-coverpage.pdf') ? $folder_coverpage . $W_WorkOrder . '-coverpage.pdf' : '';
        $file_lor = is_file($folder_lor . $lorfile) ? $folder_lor . $lorfile : '';
        // $file_qr = is_file($folder_coverpage . $W_WorkOrder . '-qr.pdf') ? $folder_coverpage . $W_WorkOrder . '-qr.pdf' : '';

        $W_AuthorizedFile_info = pathinfo($workorder->W_AuthorizedFile);
        $W_AuthorizedFile = $W_AuthorizedFile_info['filename'];

        $file_auth = '';

        if ($W_AuthorizedFile && is_file($folder_auth . $W_AuthorizedFile . '.tif')) {
            $file_auth = $folder_auth . $W_AuthorizedFile . '.tif';
        }

        if ($W_AuthorizedFile && is_file($folder_auth . $W_AuthorizedFile . '.pdf')) {
            $file_auth = $folder_auth . $W_AuthorizedFile . '.pdf';
        }

        $file_auth_info = pathinfo($file_auth);

        if (isset($file_auth_info['extension']) && $file_auth_info['extension'] == 'tif') {

            $newfilename = $file_auth_info['filename'] . '-temp.pdf';
            $fileauthpdftemp = '\\\\ftpserver\\documents\\websitetemp\\' . $newfilename;

            if (is_file($fileauthpdftemp)) {
                @chmod($fileauthpdftemp, 0777);
                $tempfiledeleted = unlink($fileauthpdftemp);
            }

            $command = [
                'C:\xnview\nconvert.exe',
                '-multi',
                '-c',
                '4',
                '-out',
                'pdf',
                '-o',
                $fileauthpdftemp,
                $file_auth,
            ];
            Process::run($command);

            $request->session()->flash('success', 'File Converted Successfully');
            @chmod($fileauthpdftemp, 0777);

            $file_auth = is_file($fileauthpdftemp) ? $fileauthpdftemp : '';
        }

        $filename_final = $W_WorkOrder . '-' . date('Ymd-Hi') . '-' . $type . '_' . $requestnote . '.pdf';
        $filename_final_qr = $W_WorkOrder . '-' . date('Ymd-Hi') . '-' . $type . '_' . $requestnote . '_qr.pdf';
        $output_file = $folder_output . $filename_final;

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
            '-sOutputFile=' . $output_file,
        ];

        if (! empty($file_coverpage)) {
            $command[] = $file_coverpage;
        }

        if (! empty($file_lor)) {
            $command[] = $file_lor;
        }

        if (! empty($file_auth)) {
            $command[] = $file_auth;
        }
        Process::run($command);

        if (isset($fileauthpdftemp) && is_file($fileauthpdftemp)) {
            @unlink($fileauthpdftemp);
        }

        $workorder->W_FollowUpStatus = 'Request File Created - ' . $filename_final_qr . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->save();

        $elapsedtime = (microtime(true) - $start);

        $request->session()->flash('success', 'file created<br />' . $folder_output . $filename_final_qr . '<br />' . number_format($elapsedtime, 2) . ' seconds');

        return back();
    }

    public function file(Request $request)
    {
        $file = urldecode($request->query('file'));

        $fileinfo = pathinfo($file);
        $dirname = $fileinfo['dirname'];
        $filename = $fileinfo['filename'];
        $extension = $fileinfo['extension'] ?? '';

        $workorder_id = $request->query('workorder_id') ?? null;
        $retry = $request->query('retry') ?? null;

        $downloadfile = (bool) $request->query('download');

        if ($retry && ! is_file($file)) {
            $extensionother = ($extension == 'tif') ? 'pdf' : 'tif';
            $file = $dirname . '\\' . $filename . '.' . $extensionother;
        }

        if (! is_file($file)) {
            return back()->with('danger', 'File not found: ' . $file);
        }

        $filetransfer = new Filetransfer();
        $filetransfer->direction = 'download';
        $filetransfer->file_type = 'file';
        $filetransfer->workorder_id = $workorder_id;
        $filetransfer->contractor_id = session('user.contractor.id');
        $filetransfer->contractor = session('user.contractor.C_Name');
        $filetransfer->filename = $file;
        $filetransfer->ip_address = $request->ip();
        $filetransfer->remote_host = gethostbyaddr($request->ip());
        $filetransfer->save();

        $disposition = 'inline';

        $contenttype = 'application/pdf';

        if ($downloadfile) {
            $disposition = 'attachment';
        }

        if ($extension == 'tif') {
            $contenttype = 'image/tiff';
            $disposition = 'attachment';
        }

        $headers = [
            'Content-Type' => $contenttype,
            'Content-Disposition' => '' . $disposition . '; filename="' . basename($file) . '"',
        ];

        return response()->file($file, $headers);
    }

    public function fileupload(Request $request, Workorder $workorder)
    {
        $file = $request->file('uploadfile');
        $type = $request->input('type');
        $clientfilename = $file->getClientOriginalName();

        if (! empty($clientfilename)) {

            $extension = strtolower($file->getClientOriginalExtension());

            // if (! in_array($extension, ['pdf', 'tif'])) {
            //     return back()->with('danger', 'Uploaded file has an invalid file extension');
            // }

            if ($type == 'auth') {

                $directory = '\\\\server2\\eisaccess\\' . $this->subdomain() . '\\AuthForms\\';

                if ($this->subdomain() == 'eis') {
                    $directory = '\\\\server2\\eisaccess\\AuthForms\\';
                }

                $directoryold = '\\\\ftpserver\\ftpserver\\NoteFile\\OldAutho\\' . $this->subdomain() . '\\';

                if ($workorder->W_AuthorizedFile) {
                    $authorizedfile_parts = pathinfo($workorder->W_AuthorizedFile);
                    $W_AuthorizedFileName = $authorizedfile_parts['filename'];
                } else {
                    $W_AuthorizedFileName = $workorder->W_WorkOrder;
                }

                $filename = $directory . $W_AuthorizedFileName . '.' . $extension;
                $filenamepdf = $directory . $W_AuthorizedFileName . '.pdf';
                $filenametif = $directory . $W_AuthorizedFileName . '.tif';

                if (is_file($filename)) {
                    rename($filename, $directoryold . $workorder->W_WorkOrder . '-' . date('Ymd-His') . '.pdf');
                }
                if (is_file($filenamepdf)) {
                    rename($filenamepdf, $directoryold . $workorder->W_WorkOrder . '-' . date('Ymd-His') . '.pdf');
                }
                if (is_file($filenametif)) {
                    rename($filenametif, $directoryold . $workorder->W_WorkOrder . '-' . date('Ymd-His') . '.tif');
                }

                if (! is_file($filename)) {

                    move_uploaded_file($file->getPathName(), $filename);

                    if (is_file($filename)) {

                        if ($extension == 'tif' || $extension == 'tiff') {
                            $filenamenew = $filenamepdf;

                            $command = [
                                'C:\xnview\nconvert.exe',
                                '-multi',
                                '-c',
                                '4',
                                '-out',
                                'pdf',
                                '-o',
                                $filenamenew,
                                $filename,
                            ];
                            Process::run($command);
                        }

                        $requestorfollowup = Requestorfollowup::query()
                            ->where('R_Workorder', $workorder->W_WorkOrder)
                            ->first();

                        if ($requestorfollowup) {
                            $requestorfollowup->R_Complete = 1;
                            $requestorfollowup->R_InquiryComplete = now()->toDateTimeString();
                            $requestorfollowup->save();
                        }


                        $filetype = $request->input('filetype');

                        $workorderholdtimeimagefile = null;

                        if ($filetype == 'Special Authorization Form' && is_file($filename)) {
                            copy($filename, '\\\\ftpserver2\\ftpserver\\special_authorization\\' . $workorder->W_WorkOrder . '.' . $extension);
                            $request->session()->flash('success', 'Special Authorization File is uploaded: special_authorization ' . $filename);

                            $statusCode = 659;
                            if($this->subdomain() == 'usaa') {
                                $statusCode = 1003800773;
                            }

                            Statustrigger::create([
                                'WorkOrderNo' => $workorder->W_WorkOrder,
                                'statuscode' => $statusCode,
                                'laststatus' => $statusCode . ': Special Authorization Received',
                                'Created' => now(),
                                'CreatedBy' => session('user.contractor.C_Name'),
                                'ChangeType' => 'S',
                            ]);

                            $workorderholdtimeimagefile = $workorder->W_WorkOrder . '.' . $extension;
                        }

                        $workorderholdtime = Workorderholdtime::query()
                            ->where('workorder_id', $workorder->W_WorkOrder)
                            ->where('hold_id', 1)
                            ->whereNull('date_end')
                            ->first();

                        if ($workorderholdtime) {
                            $workorderholdtimedata = [
                                'modified_by' => session('user.contractor.C_Name'),
                                'date_end' => now()->toDateString(),
                                'modified' => now(),
                            ];

                            if ($workorderholdtimeimagefile) {
                                $workorderholdtimedata['image_file'] = $workorderholdtimeimagefile;
                            }

                            $workorderholdtime->update($workorderholdtimedata);
                        }

                        $workorder->W_Owner = 'ROSA LINDA GUTIERREZ';
                        $workorder->W_FollowUpStatus = "New {$filetype} Uploaded (" . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
                        $workorder->W_FollowUpDt = now()->toDateTimeString();
                        $workorder->W_AuthorizedFile = $W_AuthorizedFileName . '.' . $extension;
                        $workorder->save();

                        $request->session()->flash('success', 'Authorization file is uploaded: ' . $filename);
                    }
                }
            }

            if ($type == 'invoice') {

                $directory = '\\\\server2\\eisaccess\\' . $this->subdomain() . '\\CHECKS\\';

                if ($this->subdomain() == 'eis') {
                    $directory = '\\\\server2\\eisaccess\\CHECKS\\';
                }

                $filename = $directory . $workorder->W_WorkOrder . '.' . $extension;
                $filenamepdf = $directory . $workorder->W_WorkOrder . '.pdf';
                $filenametif = $directory . $workorder->W_WorkOrder . '.tif';

                if (is_file($filenamepdf)) {
                    $increment = 1;
                    while (is_file($directory . $workorder->W_WorkOrder . '-' . $increment . '.pdf')) {
                        $increment++;
                    }
                    rename($filenamepdf, $directory . $workorder->W_WorkOrder . '-' . $increment . '.pdf');
                }
                if (is_file($filenametif)) {
                    $increment = 1;
                    while (is_file($directory . $workorder->W_WorkOrder . '-' . $increment . '.tif')) {
                        $increment++;
                    }
                    rename($filenametif, $directory . $workorder->W_WorkOrder . '-' . $increment . '.tif');
                }

                if (! is_file($filename)) {

                    // $a = $file->move($directory, basename($filename));
                    move_uploaded_file($file->getPathName(), $filename);

                    if (is_file($filename)) {

                        if ($extension == 'tif' || $extension == 'tiff') {
                            $filenamenew = $filenamepdf;

                            $command = [
                                'C:\xnview\nconvert.exe',
                                '-multi',
                                '-c',
                                '4',
                                '-out',
                                'pdf',
                                '-o',
                                $filenamenew,
                                $filename,
                            ];
                            Process::run($command);
                        }
                        $workorder->W_DrInvoiceNo = $request->input('W_DrInvoiceNo');
                        $workorder->save();

                        $request->session()->flash('success', 'Invoice file is uploaded: ' . $filename);
                    }
                }
            }

            if ($type == 'notes') {

                $directory = '\\\\ftpserver\\ftpserver\\notefile\\notes\\' . $this->subdomain() . '\\';
                $filename = $directory . $workorder->W_WorkOrder . '-' . date('Ymd-His') . '-notes.' . $extension;

                move_uploaded_file($file->getPathName(), $filename);

                if (is_file($filename)) {
                    $request->session()->flash('success', 'Note file is uploaded: ' . $filename);
                }
            }

            if ($type == 'reviewaps') {

                $directory = '\\\\ftpserver\\ftpserver\\notefile\\reviewaps\\' . $this->subdomain() . '\\';
                $filename = $directory . $workorder->W_WorkOrder . '-' . date('Ymd-His') . '-reviewaps.' . $extension;

                // $a = $file->move($directory, basename($filename));
                move_uploaded_file($file->getPathName(), $filename);

                if (is_file($filename)) {
                    $request->session()->flash('success', 'Review APS file is uploaded: ' . $filename);
                }
            }

            if ($type == 'authspecial') {
                $directory = '\\\\ftpserver\\ftpserver\\notefile\\specialauth\\';
                $filename = $directory . $workorder->W_WorkOrder . '.' . $extension;

                // $a = $file->move($directory, basename($filename));
                move_uploaded_file($file->getPathName(), $filename);

                if (is_file($filename)) {
                    if ($extension == 'tif' || $extension == 'tiff') {
                        $filenamenew = $directory . $workorder->W_WorkOrder . '.pdf';
                        @unlink($filenamenew);

                        $command = [
                            'C:\xnview\nconvert.exe',
                            '-multi',
                            '-c',
                            '4',
                            '-out',
                            'pdf',
                            '-o',
                            $filenamenew,
                            $filename,
                        ];
                        Process::run($command);
                    }

                    $request->session()->flash('success', 'Special Authorization File is uploaded: ' . $filename);
                }
            }

            $filetransfer = new Filetransfer();
            $filetransfer->direction = 'upload';
            $filetransfer->file_type = $type;
            $filetransfer->workorder_id = $workorder->W_WorkOrder;
            $filetransfer->contractor_id = session('user.contractor.id');
            $filetransfer->contractor = session('user.contractor.C_Name');
            $filetransfer->filename = $filename;
            $filetransfer->ip_address = $request->ip();
            $filetransfer->remote_host = gethostbyaddr($request->ip());
            $filetransfer->save();

            return redirect()
                ->route('user.workorderfiles.show', $workorder->W_WorkOrder);
        }
    }
}
