<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Webhook::query()
            ->when($filters['id'] ?? null, fn ($q, $v) => $q->where('id', $v))
            ->when($filters['payload'] ?? null, fn ($q, $v) => $q->where('payload', 'like', "%$v%"))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $webhooks = $query->paginate(200);

        return view('user.webhooks.index', compact('webhooks', 'sort_direction'));
    }

    public function show(Webhook $webhook)
    {
        return view('user.webhooks.show', compact('webhook'));
    }

}
