<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Inquiry::query()
            ->when($filters['workorder'] ?? null, fn ($q, $v) => $q->where('workorder', $v))
            ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', '%' . $v . '%'))
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', $v))
            ->when($filters['requestor'] ?? null, fn ($q, $v) => $q->where('requestor', $v))
            ->when($filters['accountmanager'] ?? null, fn ($q, $v) => $q->where('accountmanager', $v))
            ->when($filters['accountmanageremail'] ?? null, fn ($q, $v) => $q->where('accountmanageremail', $v));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $inquiries = $query->paginate(100);
        // dd($inquiries);

        return view('user.inquiries.index', compact('inquiries', 'sort_direction'));
    }

    public function show(Inquiry $inquiry)
    {
        return view('user.inquiries.show', compact('inquiry'));
    }

    public function edit(Inquiry $inquiry)
    {
        return view('user.inquiries.edit', compact('inquiry'));
    }

    public function update(UpdateInquiryRequest $request, Inquiry $inquiry)
    {
        $inquiry->update($request->validated() + [
            // 'A_UpdateBy' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.inquiries.show', $inquiry->id)
            ->with('success', 'Data has been saved');
    }
}
