<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workorderfiledownload;
use Illuminate\Http\Request;

class WorkorderfiledownloadController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'order_type' => 'nullable|in:ehr,aps',
            'workorder_id' => 'nullable|integer',
            'company' => 'nullable|string|max:255',
        ]);

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');

        $order_type = $filters['order_type'] ?? 'aps';
        if ($order_type === 'ehr') {
            config()->set('database.default', 'ehr');
        }

        $workorderfiledownloads = Workorderfiledownload::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', 'LIKE', "%$v%"))
            ->orderBy($sort_field, $sort_direction)
            ->paginate(100)
            ->withQueryString();

        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $view = $request->header('HX-Request') ? 'user.workorderfiledownloads._table' : 'user.workorderfiledownloads.index';

        return view($view, compact('workorderfiledownloads', 'sort_direction', 'order_type'));
    }

    public function destroy(Request $request, $id)
    {
        $filters = $request->validate([
            'order_type' => 'nullable|in:ehr,aps',
        ]);

        $order_type = $filters['order_type'] ?? 'aps';

        if ($order_type === 'ehr') {
            config()->set('database.default', 'ehr');
        }

        $workorderfiledownload = Workorderfiledownload::query()
            ->findOrFail($id);

        $workorderfiledownload->delete();

        return response('');
    }
}
