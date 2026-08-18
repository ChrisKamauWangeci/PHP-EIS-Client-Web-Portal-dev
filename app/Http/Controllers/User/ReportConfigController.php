<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportConfigRequest;
use App\Http\Requests\UpdateReportConfigRequest;
use App\Models\ReportConfig;
use Illuminate\Http\Request;

class ReportConfigController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = ReportConfig::query()
            ->when($filters['report_name'] ?? null, fn ($q, $v) => $q->where('report_name', $v));

        $query->orderBy('created_at', 'desc');

        $reportConfigs = $query->paginate(100);

        return view('user.report_configs.index', compact('reportConfigs'));
    }

    public function show(ReportConfig $reportConfig)
    {
        return view('user.report_configs.show', compact('reportConfig'));
    }

    public function create()
    {
        return view('user.report_configs.create');
    }

    public function store(StoreReportConfigRequest $request)
    {
        $reportConfig = new ReportConfig($request->validated());
        $reportConfig->created_by = session('user.contractor.C_Name');
        $reportConfig->updated_by = session('user.contractor.C_Name');
        $reportConfig->save();

        return redirect()
            ->route('user.report_configs.show', $reportConfig->id)
            ->with('success', 'Data has been saved');
    }

    public function edit(Request $request, ReportConfig $reportConfig)
    {
        return view('user.report_configs.edit', compact('reportConfig'));
    }

    public function update(UpdateReportConfigRequest $request, ReportConfig $reportConfig)
    {
        $reportConfig->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.report_configs.show', $reportConfig->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(ReportConfig $reportConfig)
    {
        $reportConfig->delete();

        return redirect()
            ->route('user.report_configs.index')
            ->with('success', 'Record has been deleted');
    }
}
