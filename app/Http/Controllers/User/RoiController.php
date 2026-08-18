<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoiRequest;
use App\Http\Requests\UpdateRoiRequest;
use App\Models\Hospital;
use App\Models\Roi;
use Illuminate\Http\Request;

class RoiController extends Controller
{
    public function index(Request $request)
    {
        $postname = trim($request->query('postname') ?? '') ?? null;

        $filters = $request->query();

        $query = Roi::query()
            ->when($filters['R_ROIname'] ?? null, fn ($q, $v) => $q->where('R_ROIname', 'LIKE', '%' . $v . '%'))
            ->when($filters['R_City'] ?? null, fn ($q, $v) => $q->where('R_City', 'LIKE', '%' . $v . '%'))
            ->when($filters['R_State'] ?? null, fn ($q, $v) => $q->where('R_State', $v))
            ->when($filters['R_Zip'] ?? null, fn ($q, $v) => $q->where('R_Zip', $v))
            ->when($filters['R_Phone'] ?? null, fn ($q, $v) => $q->where('R_Phone', 'LIKE', '%' . $v . '%'))
            ->when($filters['R_Fax'] ?? null, fn ($q, $v) => $q->where('R_Fax', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'R_ROIname');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $rois = $query->paginate(100);

        return view('user.rois.index', compact('rois', 'sort_direction', 'postname'));
    }

    public function create()
    {
        return view('user.rois.create');
    }

    public function store(StoreRoiRequest $request)
    {
        $roi = new Roi($request->validated());
        $roi->R_UpdateBy = session('user.contractor.C_Name');
        $roi->save();

        return redirect()
            ->route('user.rois.show', $roi->R_ID)
            ->with('success', 'Data has been saved');
    }

    public function show(Roi $roi)
    {
        // $hospitals = Hospital::where('H_ROI', $roi->R_ROIname)->limit(100)->get();
        $hospitals = [];

        return view('user.rois.show', compact('roi', 'hospitals'));
    }

    public function edit(Roi $roi)
    {
        return view('user.rois.edit', compact('roi'));
    }

    public function update(UpdateRoiRequest $request, Roi $roi)
    {
        $roi->update($request->validated() + [
            'R_UpdateBy' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.rois.show', $roi->R_ID)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Roi $roi)
    {
        //
    }
}
