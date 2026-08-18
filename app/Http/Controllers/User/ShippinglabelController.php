<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShippinglabelRequest;
use App\Models\Workorder;
use Illuminate\Http\Request;

class ShippinglabelController extends Controller
{
    public function create(Request $request)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $request->W_WorkOrder)
            ->first();

        return view('user.shippinglabels.create', compact('workorder'));
    }

    public function store(StoreShippinglabelRequest $request)
    {
        $workorder = Workorder::query()
            ->where('W_WorkOrder', $request->W_WorkOrder)
            ->firstOrFail();

        $file = $request->file('shipping_label');

        $directory = '//server2/eisaccess/fedex/';

        $filename = $directory . $workorder->W_WorkOrder . '-' . $request->label . '.pdf';

        if (is_file($filename)) {
            rename($filename, $directory . $workorder->W_WorkOrder . '-' . $request->label . '-' . date('YmdHi') . '.pdf');
        }

        if (! move_uploaded_file($file->getRealPath(), $filename)) {
            return back()->with('danger', 'Failed to move uploaded file.');
        }

        if (is_file($filename)) {

            if ($request->label == 1) {
                $workorder->W_Tracking1 = $request->W_Tracking;
            }
            if ($request->label == 2) {
                $workorder->W_Tracking2 = $request->W_Tracking;
            }
            $workorder->save();

            return back()->with('success', 'Upload Successful');
        }

        return back()->withInput()->with('danger', 'The data could not be saved. Please, try again');
    }
}
