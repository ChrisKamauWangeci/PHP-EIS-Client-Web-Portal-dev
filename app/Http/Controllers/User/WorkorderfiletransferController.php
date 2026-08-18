<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workorderfiletransfer;
use Illuminate\Http\Request;

class WorkorderfiletransferController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'order_type' => 'nullable|in:ehr,aps',
            'workorder_id' => 'nullable|integer',
            'filename' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:100',
            'requestor' => 'nullable|string|max:100',
            'ip_address' => 'nullable|string|max:20',
        ]);

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');

        $order_type = $filters['order_type'] ?? 'aps';
        if ($order_type == 'ehr') {
            config()->set('database.default', 'ehr');
        }

        $workorderfiletransfers = Workorderfiletransfer::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['filename'] ?? null, fn ($q, $v) => $q->where('filename', 'LIKE', "%$v%"))
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', 'LIKE', "%$v%"))
            ->when($filters['requestor'] ?? null, fn ($q, $v) => $q->where('requestor', 'LIKE', "%$v%"))
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%$v%"))
            ->orderBy($sort_field, $sort_direction)
            ->paginate(100)
            ->appends($filters);

        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $view = $request->header('HX-Request') ? 'user.workorderfiletransfers._table' : 'user.workorderfiletransfers.index';

        return view($view, compact('workorderfiletransfers', 'sort_direction', 'order_type'));
    }
}
