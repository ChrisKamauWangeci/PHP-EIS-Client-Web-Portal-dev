<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Order::query()
            ->when($filters['id'] ?? null, fn ($q, $v) => $q->where('id', $v));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $orders = $query->paginate(100);

        return view('user.orders.index', compact('orders', 'sort_direction'));
    }

    public function show(Order $order)
    {
        return view('user.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
