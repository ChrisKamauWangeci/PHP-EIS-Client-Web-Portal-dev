<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateExamrequestRequest;
use App\Models\Datachange;
use App\Models\Examrequest;
use App\Models\Workorder;
use Illuminate\Http\Request;

class ExamrequestController extends Controller
{
    public function index(Request $request)
    {
        $E_WorkOrder = trim($request->query('E_WorkOrder') ?? '') ?? null;

        $query = Examrequest::query();

        $examrequests = $query->paginate(100);

        return view('user.examrequests.index', compact('examrequests', 'E_WorkOrder'));
    }

    public function show(Examrequest $examrequest)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $examrequest->E_WorkOrder)
            ->first();

        return view('user.examrequests.show', compact('examrequest', 'workorder'));
    }

    public function edit(Examrequest $examrequest)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $examrequest->E_WorkOrder)
            ->first();

        return view('user.examrequests.edit', compact('examrequest', 'workorder'));
    }

    public function update(UpdateExamrequestRequest $request, Examrequest $examrequest)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $examrequest->E_WorkOrder)
            ->first();

        $examrequestold = clone $examrequest;

        $validated = $request->validated();

        $examrequest->update($validated + [
            // 'W_UpdUser' => session('user.contractor.C_Name'),
            // 'W_UpdDate' => date('Y-m-d H:i:s'),
        ]);

        $before = array_diff_assoc($examrequestold->toArray(), $examrequest->toArray());
        $after = array_diff_assoc($examrequest->toArray(), $examrequestold->toArray());

        // dump($examrequestold);
        // dump($examrequest);
        // die;

        if ($before) {
            ksort($before);
            ksort($after);
            $data = "Previous Data:\r\n";
            foreach ($before as $key => $value) {
                $data .= $key . ' = ' . $value . "\r\n";
            }
            $data .= "\r\n";
            $data .= "Subsequent Data:\r\n";
            foreach ($after as $key => $value) {
                $data .= $key . ' = ' . $value . "\r\n";
            }
            $data = rtrim($data);

            $datachange = new Datachange();
            $datachange->model = 'examrequests';
            $datachange->foreign_key = $examrequest->E_WorkOrder;
            $datachange->data = $data;
            $datachange->created_by = session('user.contractor.C_Name');
            $datachange->save();
        }

        return redirect()
            ->route('user.workorders.show', $workorder->W_WorkOrder)
            ->with('success', 'Data has been saved');
    }
}
