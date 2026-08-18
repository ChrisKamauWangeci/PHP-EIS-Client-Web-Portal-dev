<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketmanagerAssignRequest;
use App\Http\Requests\StoreTicketmanagerRequest;
use App\Http\Requests\UpdateTicketmanagerRequest;
use App\Models\Contractor;
use App\Models\Ticket;
use App\Models\Ticketmanager;
use Illuminate\Http\Request;

class TicketmanagerController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Ticketmanager::query()
            ->when($filters['name'] ?? null, fn ($q, $v) => $q->where('name', 'LIKE', "%{$v}%"))
            ->when($filters['email'] ?? null, fn ($q, $v) => $q->where('email', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $ticketmanagers = $query->paginate(100);

        $contractors = Contractor::query()
            ->select('C_Name')
            ->whereNotNull('C_Email')
            ->orderBy('C_Name', 'ASC')
            ->pluck('C_Name', 'C_Name')
            ->toArray();

        return view('admin.ticketmanagers.index', compact('ticketmanagers', 'sort_direction', 'contractors'));
    }

    public function create()
    {
        return view('admin.ticketmanagers.create');
    }

    public function assign(StoreTicketmanagerAssignRequest $request)
    {
        $contractor = Contractor::query()
            ->where('C_Name', $request->input('C_Name'))
            ->firstOrFail();

        $ticketmanager = new Ticketmanager();
        $ticketmanager->name = $contractor->C_Name;
        $ticketmanager->email = $contractor->C_Email;
        $ticketmanager->save();

        return redirect()
            ->route('admin.ticketmanagers.index')
            ->with('success', 'Data has been saved');
    }

    public function store(StoreTicketmanagerRequest $request)
    {
        $ticketmanager = new Ticketmanager($request->validated());
        $ticketmanager->save();

        return redirect()
            ->route('admin.ticketmanagers.index')
            ->with('success', 'Data has been saved');
    }

    public function show(Ticketmanager $ticketmanager)
    {
        $ticketscount = Ticket::where('assigned_to', $ticketmanager->name)->count();

        return view('admin.ticketmanagers.show', compact('ticketmanager', 'ticketscount'));
    }

    public function edit(Ticketmanager $ticketmanager)
    {
        return view('admin.ticketmanagers.edit', compact('ticketmanager'));
    }

    public function update(UpdateTicketmanagerRequest $request, Ticketmanager $ticketmanager)
    {
        $ticketmanager->update($request->validated());

        return redirect()
            ->route('admin.ticketmanagers.show', $ticketmanager->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Ticketmanager $ticketmanager)
    {
        $ticketmanager->delete();

        return redirect()
            ->route('admin.ticketmanagers.index')
            ->with('success', 'Record has been deleted');
    }
}
