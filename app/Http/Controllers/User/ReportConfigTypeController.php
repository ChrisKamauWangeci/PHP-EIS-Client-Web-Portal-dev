<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportConfigTypeRequest;
use App\Http\Requests\UpdateReportConfigTypeRequest;
use App\Models\ReportConfigType;
use Illuminate\Http\Request;

class ReportConfigTypeController extends Controller
{
    public function index(Request $request)
    {

        $filters = $request->query();

        $query = ReportConfigType::query()
            ->when($filters['report_type'] ?? null, fn ($q, $v) => $q->where('report_type', $v));

        $query->orderBy('created_at', 'desc');

        $reportConfigTypes = $query->paginate(200);

        return view('user.report_config_types.index', compact('reportConfigTypes'));
    }

    public function show(ReportConfigType $reportConfigType)
    {
        return view('user.report_config_types.show', compact('reportConfigType'));
    }

    public function create()
    {
        return view('user.report_config_types.create');
    }

    public function store(StoreReportConfigTypeRequest $request)
    {
        $reportConfigType = new ReportConfigType($request->validated());
        $reportConfigType->created_by = session('user.contractor.C_Name');
        $reportConfigType->updated_by = session('user.contractor.C_Name');
        $reportConfigType->save();

        return redirect()
            ->route('user.report_config_types.show', $reportConfigType->id)
            ->with('success', 'Data has been saved');
    }

    public function edit(Request $request, ReportConfigType $reportConfigType)
    {
        return view('user.report_config_types.edit', compact('reportConfigType'));
    }

    public function update(UpdateReportConfigTypeRequest $request, ReportConfigType $reportConfigType)
    {
        $reportConfigType->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.report_config_types.show', $reportConfigType->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(ReportConfigType $reportConfigType)
    {
        $reportConfigType->delete();

        return redirect()
            ->route('user.report_config_types.index')
            ->with('success', 'Record has been deleted');
    }
}
