<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Synodextransmission;
use Illuminate\Http\Request;

class SynodextransmissionsController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'WorkOrderID' => 'nullable|integer',
        ]);

        $sort_field = $request->query('sort_field', 'ID');
        $sort_direction = $request->query('sort_direction', 'desc');

        $synodextransmissions = Synodextransmission::query()
            ->when($filters['WorkOrderID'] ?? null, fn ($q, $v) => $q->where('WorkOrderID', $v))
            ->orderBy($sort_field, $sort_direction)
            ->paginate(100)
            ->withQueryString();

        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $view = $request->header('HX-Request') ? 'user.synodextransmissions._table' : 'user.synodextransmissions.index';

        return view($view, compact('synodextransmissions', 'sort_direction'));
    }

    public function acordreferenceid(Request $request)
    {
        $filters = $request->validate([
            'WorkOrderID' => 'nullable|integer',
        ]);

        $synodextransmission = Synodextransmission::query()
            ->where('WorkOrderID', $filters['WorkOrderID'])
            ->first();

        return response(
            $synodextransmission?->AcordReferenceID ?? 'Not found'
        );
    }
}
