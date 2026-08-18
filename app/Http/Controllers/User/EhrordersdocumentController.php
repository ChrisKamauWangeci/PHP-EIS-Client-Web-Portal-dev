<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEhrorderRequest;
use App\Models\Ehrordersdocument;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EhrordersdocumentController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Ehrordersdocument::query()
            ->select([
                'ehrordersdocuments.*',
                'ehrorders.service_provider',
                'ehrorders.first_name',
                'ehrorders.last_name',
            ])
            ->join('ehrorders', 'ehrordersdocuments.ehrorder_id', '=', 'ehrorders.id')
            ->when($filters['id'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.id', $v))
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.workorder_id', $v))
            ->when($filters['ehrorder_id'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.ehrorder_id', $v))
            ->when($filters['first_name'] ?? null, fn ($q, $v) => $q->where('ehrorders.first_name', 'like', "%$v%"))
            ->when($filters['last_name'] ?? null, fn ($q, $v) => $q->where('ehrorders.last_name', 'like', "%$v%"))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.status', 'like', "%$v%"))
            ->when($filters['received_at_from'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.received_at', '>=', Carbon::parse($v)->format('Y-m-d H:i:s')))
            ->when($filters['received_at_to'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.received_at', '<=', Carbon::parse($v)->format('Y-m-d H:i:s')))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.created_at', '>=', Carbon::parse($v)->format('Y-m-d H:i:s')))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->where('ehrordersdocuments.created_at', '<=', Carbon::parse($v)->format('Y-m-d H:i:s')));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $ehrordersdocuments = $query->paginate(200);

        return view('user.ehrordersdocuments.index', compact('ehrordersdocuments', 'sort_direction'));
    }

    public function show(Ehrordersdocument $ehrordersdocument)
    {
        return view('user.ehrordersdocuments.show', compact('ehrordersdocument'));
    }

    public function edit(Request $request, Ehrordersdocument $ehrordersdocument)
    {
        return view('user.ehrordersdocuments.edit', compact('ehrordersdocument'));
    }

    public function update(UpdateEhrorderRequest $request, Ehrordersdocument $ehrordersdocument)
    {
        $ehrordersdocument->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.ehrordersdocuments.show', $ehrordersdocument->id)
            ->with('success', 'Data has been saved');
    }
}
