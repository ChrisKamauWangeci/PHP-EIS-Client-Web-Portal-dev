<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Filetransfer;
use App\Models\Workorder;
use Illuminate\Http\Request;

class WorkorderprefillController extends Controller
{
    public function index(Request $request)
    {
        $workorder = Workorder::find($request->query('workorder_id'));
        if (! $workorder) {
            return redirect()
                ->route('user.workorders.index')
                ->with('danger', 'Workorder not found.');
        }

        $directory = $request->query('directory') ?? '';
        $directory = preg_replace('/[^a-zA-Z0-9\/\\\_-]/', '', $directory);

        if (in_array($this->subdomain(), ['eis', 'eisdev', 'eisuat'])) {

            $prefillfolders = [
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\APPS-NATIONWIDE\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\COMPLETED-PREFILL\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\EQUITABLE\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\NATIONWIDE\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\NLTC\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\NMLC\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\PLICO-WCL\\',
            ];

            $mergefolders = [
                '\\\\ftpserver\\documents\\websiterecords\\',
                '\\\\ftpserver\\ftpserver\\NoteFile\\SpecialAuth\\',
                '\\\\ftpserver\\ftpserver\\NoteFile\\AmFam\\',
                '\\\\ftpserver\\ftpserver\\NoteFile\\Equitable\\',
                '\\\\ftpserver\\ftpserver\\NoteFile\\NLTC\\',
                '\\\\ftpserver\\ftpserver\\NoteFile\\NMLC\\',
                '\\\\ftpserver\\ftpserver\\PLIMerge\\specialauth\\',
            ];
        }

        if ($this->subdomain() == 'nyl') {

            $prefillfolders = [
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\COMPLETED-PREFILL\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\NYL\\',
            ];

            $mergefolders = [];
        }

        if ($this->subdomain() == 'usaa') {

            $prefillfolders = [
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\APPS-USAA\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\COMPLETED-PREFILL\\',
                '\\\\ftpserver2\\ftpserver\\fileTransfer\\prefill\\USAA\\',
            ];

            $mergefolders = [
                '\\\\ftpserver\\ftpserver\\NoteFile\\USAA\\',
            ];
        }

        if (! in_array($directory, $prefillfolders) && ! in_array($directory, $mergefolders)) {
            $directory = $prefillfolders[0];
        }

        $authorizedfile_parts = pathinfo($workorder->W_AuthorizedFile ?? '');
        $W_AuthorizedFileName = $authorizedfile_parts['filename'];

        $files = new \FilesystemIterator($directory, \FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::SKIP_DOTS);

        if ($W_AuthorizedFileName) {
            $files = new \RegexIterator($files, "/$workorder->W_WorkOrder|$W_AuthorizedFileName.*(\.pdf|\.tif)/i");
        } else {
            $files = new \RegexIterator($files, "/$workorder->W_WorkOrder.*(\.pdf|\.tif)/i");
        }

        return view('user.workorderprefills.index', compact('workorder', 'prefillfolders', 'mergefolders', 'directory', 'files'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'W_WorkOrder' => 'required|integer|exists:WorkOrder,W_WorkOrder',
            'uploadfile' => 'required|file|mimes:pdf,tif|min:1|max:100000',
            'directory' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9_\-\\\\\\/]+$/',
                function ($attribute, $value, $fail) {
                    if (str_contains($value, '..')) {
                        $fail('Invalid directory path.');
                    }
                    if (! is_dir($value)) {
                        $fail('Invalid directory: ' . $value);
                    }
                },
            ],
        ]);

        $workorder = Workorder::find($request->input('W_WorkOrder'));

        $file = $request->file('uploadfile');
        $directory = $request->input('directory');

        $extension = strtolower($file->getClientOriginalExtension());

        $filename = $directory . intval($workorder->W_WorkOrder) . '.' . $extension;

        if (is_file($filename)) {
            $timestamp = now()->format('YmdHis');
            $backupFile = $directory . pathinfo($filename, PATHINFO_FILENAME) . "_{$timestamp}." . $extension;
            rename($filename, $backupFile);
        }

        if (! move_uploaded_file($file->getPathName(), $filename)) {
            return back()->with('danger', 'File upload failed.');
        }

        if (is_file($filename)) {

            $timestamp = now()->format('m-d-Y g:i:s A');

            $contractor = session('user.contractor.C_Name');

            $workorder->update([
                'W_FollowUpStatus' => "Prefill Uploaded - $filename ({$timestamp} {$contractor})\r\n\r\n" . $workorder->W_FollowUpStatus,
            ]);

            Filetransfer::create([
                'direction' => 'upload',
                'file_type' => 'prefill',
                'workorder_id' => $workorder->W_WorkOrder,
                'contractor_id' => session('user.contractor.id'),
                'contractor' => session('user.contractor.C_Name'),
                'filename' => $filename,
                'ip_address' => $request->ip(),
                'remote_host' => gethostbyaddr($request->ip()),
            ]);

            $request->session()->flash('success', 'prefill file is uploaded: ' . $filename);
        }

        return redirect()
            ->back();
    }
}
