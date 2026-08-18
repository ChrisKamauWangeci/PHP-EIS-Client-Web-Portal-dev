<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketcommentRequest;
use App\Http\Requests\StoreTicketfileRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Mail\TicketEmail;
use App\Models\Ticket;
use App\Models\Ticketcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Ticket::query()
            ->when($filters['id'] ?? null, fn($q, $v) => $q->where('id', $v))
            ->when($filters['workorder_id'] ?? null, fn($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['company'] ?? null, fn($q, $v) => $q->where('company', 'LIKE', '%' . $v . '%'))
            ->when($filters['requestor_name'] ?? null, fn($q, $v) => $q->where('requestor_name', 'LIKE', '%' . $v . '%'))
            ->when($filters['assigned_to'] ?? null, fn($q, $v) => $q->where('assigned_to', 'LIKE', '%' . $v . '%'))
            ->when($filters['subject'] ?? null, fn($q, $v) => $q->where('subject', 'LIKE', '%' . $v . '%'))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $tickets = $query->paginate(100)
            ->withQueryString();

        return view('user.tickets.index', compact('tickets', 'sort_direction'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load([
            'ticketcomments' => fn($q) => $q->orderBy('created_at')
        ]);

        return view('user.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('user.tickets.edit', compact('ticket'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return redirect()
            ->route('user.tickets.show', $ticket->id)
            ->with('success', 'Data has been saved');
    }

    public function create()
    {
        return view('user.tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = new Ticket($request->validated());
        $ticket->status = 'open';
        $ticket->save();

        $file = $request->file('uploadfile');
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $directory = $this->ticketDirectory($ticket);
            $file1 = now()->format('Ymd-His') . '-' . $ticket->id . '.' . $extension;
            $filename = $directory . $file1;
            $file->move($directory, basename($filename));
        }

        return redirect()
            ->route('user.tickets.show', $ticket->id)
            ->with('success', 'Data has been saved');
    }

    public function commentadd(StoreTicketcommentRequest $request, Ticket $ticket)
    {
        $ticket->touch();

        $ticketcomment = new Ticketcomment($request->validated());
        $ticketcomment->ticket_id = $ticket->id;
        $ticketcomment->created_by = session('user.contractor.C_Name');
        $ticketcomment->created_by_email = session('user.contractor.C_Email');
        $ticketcomment->save();

        $ticket->load([
            'ticketcomments' => fn($q) => $q->orderBy('created_at')
        ]);

        $data['from'] = 'info@expressimagingservices.com';
        $data['subject'] = 'Support Ticket #' . $ticket->id . ' - New Comment Added';
        $data['ticket'] = $ticket;
        $data['ticketcomments'] = $ticket->ticketcomments;

        Mail::to('andras@expressimagingservices.com')
            ->send(new TicketEmail($data));

        return redirect()
            ->route('user.tickets.show', $ticket->id)
            ->with('success', 'Data has been saved');
    }

    public function fileadd(StoreTicketfileRequest $request, Ticket $ticket)
    {
        $file = $request->file('uploadfile');
        $extension = $file->getClientOriginalExtension();
        $directory = $this->ticketDirectory($ticket);
        $file1 = now()->format('Ymd-His') . '-' . $ticket->id . '.' . $extension;
        $filename = $directory . $file1;
        // dd($filename);
        if (! $file->move($directory, $file1)) {
            return back()
                ->with('danger', 'Failed to move uploaded file.');
        }

        return redirect()
            ->route('user.tickets.show', $ticket->id)
            ->with('success', 'Data has been saved');
    }

    public function filedownload(Request $request, Ticket $ticket)
    {
        $directory = $this->ticketDirectory($ticket);

        $filename = $request->query('filename');
        $filename = preg_replace('/[^a-zA-Z0-9-_ .]/', '', $filename);

        $download = (bool) $request->query('download');

        $path = $directory . $filename;

        if (! is_file($path)) {
            return back()->with('danger', 'Invalid request');
        }

        if (ob_get_level()) {
            ob_end_clean();
        }

        if ($download) {
            return response()->download($path, $filename);
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    // public function close(Ticket $ticket)
    // {
    //     $ticket->update([
    //         'status' => 'closed',
    //         'closed_by' => session('user.contractor.C_Name'),
    //     ]);
    //     return redirect()
    //         ->route('user.tickets.index')
    //         ->with('success', 'Record has been closed');
    // }

    public function destroy(Ticket $ticket)
    {
        $ticket->ticketcomments()->delete();
        $ticket->delete();

        return redirect()
            ->route('user.tickets.index')
            ->with('success', 'Record has been deleted');
    }

    private function ticketDirectory(Ticket $ticket): string
    {
        return sprintf(
            '//ftpserver/documents/website/tickets/%s/%d/',
            $ticket->created_at->format('Ym'),
            $ticket->id
        );
    }
}
