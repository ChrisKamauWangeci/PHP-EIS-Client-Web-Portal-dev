<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Copyservice;
use App\Models\Fax;
use App\Models\Hospital;
use App\Models\Roi;
use App\Models\Workorder;
use Illuminate\Http\Request;

class FaxController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Fax::query()
            ->where('product', '=', 'eis')
            ->when($filters['workorder'] ?? null, fn ($q, $v) => $q->where('workorder', $v))
            ->when($filters['fax_number'] ?? null, fn ($q, $v) => $q->where('fax_number', 'LIKE', '%' . $v . '%'))
            ->when($filters['file'] ?? null, fn ($q, $v) => $q->where('file', 'LIKE', '%' . $v . '%'))
            ->when($filters['email'] ?? null, fn ($q, $v) => $q->where('email', 'LIKE', '%' . $v . '%'))
            ->when($filters['api_status'] ?? null, fn ($q, $v) => $q->where('api_status', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $faxes = $query->paginate(100);

        return view('user.faxes.index', compact('faxes', 'sort_direction'));
    }

    public function create(Request $request)
    {
        $W_WorkOrder = $request->query('workorder_id') ?? null;

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $W_WorkOrder)
            ->firstOrFail();

        $hospital = Hospital::query()
            ->where('H_Hospital', $workorder->W_Hospital)
            ->first();

        $copyservice = Copyservice::query()
            ->where('C_CopyService', $hospital->H_CopyService)
            ->first();

        $roi = Roi::query()
            ->where('R_ROIname', $workorder->H_ROI)
            ->first();

        $file = $request->query('file');
        $file = urldecode($file);

        return view('user.faxes.create', compact('workorder', 'hospital', 'copyservice', 'roi', 'file'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'workorder_id' => 'required|integer',
            'fax_number' => 'required|integer|min:10000000000|max:99999999999',
            'file' => 'required|regex:/^[\w\-. \\\\]+$/',
        ]);

        $file = $request->input('file');
        $file = urldecode($file);

        $directory = dirname($file);

        if (str_contains($directory, '..')) {
            return back()->with('danger', 'Invalid directory path.');
        }

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $request->input('workorder_id'))
            ->firstOrFail();

        $fax_number = $request->input('fax_number');
        $fax_number = preg_replace('/[^0-9]/', '', $fax_number);

        if (strlen($fax_number) == 10 && is_numeric($fax_number)) {
            $fax_number = 1 . $fax_number;
        }

        if (strlen($fax_number) != 11 || ! is_numeric($fax_number)) {
            return back()->with('danger', 'Hospital Fax Number: ' . $fax_number . ' is invalid. Must be 10 or 11 digits only');
        }

        if (! is_file($file)) {
            return back()->with('danger', 'File not found ' . $file);
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        $contractoremail = session('user.contractor.C_Email');
        if (! filter_var($contractoremail, FILTER_VALIDATE_EMAIL)) {
            return back()->with('danger', 'Invalid Contractor Email');
        }

        $faxdir = '\\\\192.168.1.194\\data\\faxapp\\';
        $faxfilename = date('YmdHi') . '-eis-' . $this->subdomain() . '-' . intval($workorder->W_WorkOrder) . '-' . intval($fax_number) . '-' . $contractoremail . '.' . $extension;
        if (! @copy($file, $faxdir . $faxfilename)) {
            return back()->with('danger', 'Failed to copy file to fax directory.');
        }

        if (! is_file($faxdir . $faxfilename)) {
            return back()->with('danger', 'File not found ' . $faxdir . $faxfilename);
        }

        $workorder->W_FollowUpStatus = 'Fax submitted to: ' . $fax_number . ', File: ' . basename($file) . ' => ' . $faxfilename . ' (' . date('m-d-Y g:i:s A') . ' - ' . session('user.contractor.C_Name') . ')' . "\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->save();

        return back()->with('success', 'Workorder ' . $workorder->W_WorkOrder . ', file: ' . $file . ' => ' . $faxfilename . ', will be faxed to: ' . $fax_number);
    }

    public function show(Fax $fax)
    {
        return view('user.faxes.show', compact('fax'));
    }

    public function edit(Fax $fax)
    {
        //
    }

    public function update(Request $request, Fax $fax)
    {
        //
    }

    public function destroy(Fax $fax)
    {
        //
    }
}
