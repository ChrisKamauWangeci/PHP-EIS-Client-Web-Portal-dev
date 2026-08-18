<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportConfigNameRequest;
use App\Http\Requests\UpdateReportConfigNameRequest;
use App\Models\ReportConfigName;
use Illuminate\Http\Request;

class ReportConfigNameController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = ReportConfigName::query()
            ->when($filters['report_name'] ?? null, fn ($q, $v) => $q->where('report_name', $v));

        $query->orderBy('created_at', 'desc');

        $reportConfigNames = $query->paginate(200);

        return view('user.report_config_names.index', compact('reportConfigNames'));
    }

    public function show(ReportConfigName $reportConfigName)
    {
        return view('user.report_config_names.show', compact('reportConfigName'));
    }

    public function create()
    {
        return view('user.report_config_names.create');
    }

    public function store(StoreReportConfigNameRequest $request)
    {
        $reportConfigName = new ReportConfigName($request->validated());
        $reportConfigName->created_by = session('user.contractor.C_Name');
        $reportConfigName->updated_by = session('user.contractor.C_Name');
        $reportConfigName->save();

        return redirect()
            ->route('user.report_config_names.show', $reportConfigName->id)
            ->with('success', 'Data has been saved');
    }

    public function edit(Request $request, ReportConfigName $reportConfigName)
    {
        return view('user.report_config_names.edit', compact('reportConfigName'));
    }

    public function update(UpdateReportConfigNameRequest $request, ReportConfigName $reportConfigName)
    {
        $reportConfigName->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.report_config_names.show', $reportConfigName->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(ReportConfigName $reportConfigName)
    {
        $reportConfigName->delete();

        return redirect()
            ->route('user.report_config_names.index')
            ->with('success', 'Record has been deleted');
    }
}
