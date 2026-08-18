<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filetransfer;
use Illuminate\Http\Request;

class FiletransferController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Filetransfer::query()
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', 'like', "%{$v}%"))
            ->when($filters['direction'] ?? null, fn ($q, $v) => $q->where('direction', $v))
            ->when($filters['file_type'] ?? null, fn ($q, $v) => $q->where('file_type', 'like', "%{$v}%"))
            ->when($filters['filename'] ?? null, fn ($q, $v) => $q->where('filename', 'like', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $filetransfers = $query->paginate(100);

        return view('admin.filetransfers.index', compact('filetransfers', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Filetransfer $filetransfer)
    {
        return view('admin.filetransfers.show', compact('filetransfer'));
    }

    public function edit(Filetransfer $filetransfer)
    {
        //
    }

    public function update(Request $request, Filetransfer $filetransfer)
    {
        //
    }

    public function destroy(Filetransfer $filetransfer)
    {
        //
    }
}
