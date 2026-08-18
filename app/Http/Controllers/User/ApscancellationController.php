<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateApscancellationRequest;
use App\Models\Apscancellation;
use App\Models\Workorder;
use Illuminate\Http\Request;

class ApscancellationController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Apscancellation::query()
            ->when($filters['EISWorkOrderID'] ?? null, fn ($q, $v) => $q->where('EISWorkOrderID', $v))
            ->when($filters['CompanyName'] ?? null, fn ($q, $v) => $q->where('CompanyName', 'LIKE', '%' . $v . '%'))
            ->when($filters['CancellationStatusID'] ?? null, fn ($q, $v) => $q->where('CancellationStatusID', $v))
            ->when($filters['IsNotified'] ?? null, fn ($q, $v) => $q->where('IsNotified', $v))
            ->when($filters['Username'] ?? null, fn ($q, $v) => $q->where('Username', $v));

        if (! isset($filters['IsNotified']) || $filters['IsNotified'] === '0') {
            $query->Where(function ($q) {
                $q->whereNull('IsNotified')
                    ->orWhere('IsNotified', 0);
            });
        }

        $sort_field = $request->query('sort_field', 'Inserted');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';
        $apscancellations = $query->paginate(100);
        // dd($apscancellations);

        $ids = $apscancellations->pluck('EISWorkOrderID')->filter()->unique();

        $workorders = Workorder::select(['W_WorkOrder', 'W_Status'])->whereIn('W_WorkOrder', $ids)->get();

        foreach ($apscancellations as $apscancellation) {
            $apscancellation->workorder = $workorders->firstWhere('W_WorkOrder', $apscancellation->EISWorkOrderID);
        }

        $cancellationStatusOptions = $this->getStatusOptions();

        $flash = false;

        return view('user.apscancellations.index', compact('apscancellations', 'sort_direction', 'cancellationStatusOptions', 'flash'));
    }

    public function show(Apscancellation $apscancellation)
    {
        $cancellationStatusOptions = $this->getStatusOptions();

        return view('user.apscancellations.show', compact('apscancellation', 'cancellationStatusOptions'));
    }

    public function edit(Apscancellation $apscancellation)
    {
        return view('user.apscancellations.edit', compact('apscancellation'));
    }

    public function update(UpdateApscancellationRequest $request, Apscancellation $apscancellation)
    {
        $apscancellation->update($request->validated() + [
            'Username' => session('user.contractor.C_Name'),
            'Updated' => now(),
        ]);

        if ($request->input('IsNotified') == '1') {

            $connections = ['eis', 'usaa', 'nyl', 'ehr'];

            foreach ($connections as $connection) {
                $workorder = Workorder::on($connection)
                    ->select(['W_WorkOrder', 'W_FollowUpStatus'])
                    ->where('W_WorkOrder', $apscancellation->EISWorkOrderID)
                    ->first();

                if ($workorder) {
                    $workorder->W_FollowUpStatus = 'CANCELLATION REQUEST COMPLETED (' . now()->format('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ')' . "\r\n\r\n" . $workorder->W_FollowUpStatus;
                    $workorder->save();
                    break;
                }
            }
        }

        if ($request->header('HX-Request')) {
            return view('user.apscancellations.partials.row', [
                'apscancellation' => $apscancellation,
                'cancellationStatusOptions' => $this->getStatusOptions(),
                'flash' => true,
            ]);
        }

        return redirect()
            ->route('user.apscancellations.index')
            ->with('success', 'Data has been saved');
    }

    protected function getStatusOptions()
    {
        return [
            1 => 'Requested',
            2 => 'Cancelled',
            3 => 'In Review',
            4 => 'Unable to Cancel',
        ];
    }
}
