<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestlogRequest;
use App\Http\Requests\UpdateRequestlogRequest;
use App\Models\Requestlog;
use Illuminate\Http\Request;

class RequestlogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Requestlog::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['request_type'] ?? null, fn ($q, $v) => $q->where('request_type', $v));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $requestlogs = $query->paginate(100);

        return view('user.requestlogs.index', compact('requestlogs', 'sort_direction'));
    }

    public function create()
    {
        return view('user.requestlogs.create');
    }

    public function store(StoreRequestlogRequest $request)
    {
        $requestlog = new Requestlog($request->validated());
        $requestlog->created_by = session('user.contractor.C_Name');
        $requestlog->updated_by = session('user.contractor.C_Name');
        $requestlog->save();

        return redirect()
            ->route('user.workorders.show', $requestlog->workorder_id)
            ->with('success', 'Data has been saved');
    }

    public function show(Requestlog $requestlog)
    {
        return view('user.requestlogs.show', compact('requestlog'));
    }

    public function edit(Requestlog $requestlog)
    {
        return view('user.requestlogs.edit', compact('requestlog'));
    }

    public function update(UpdateRequestlogRequest $request, Requestlog $requestlog)
    {
        $requestlog->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.requestlogs.show', $requestlog->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Requestlog $requestlog)
    {
        //
    }
}
