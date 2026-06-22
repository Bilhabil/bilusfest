<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCategoryRequest;
use App\Models\Event;
use App\Models\TicketCategory;
use App\Repositories\TicketCategoryRepository;

class TicketCategoryController extends Controller
{
    protected TicketCategoryRepository $ticketRepository;

    public function __construct(TicketCategoryRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        $tickets = $this->ticketRepository->getAll();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $events = Event::where('status', 'active')->latest()->get();

        return view('admin.tickets.create', compact('events'));
    }

    public function store(TicketCategoryRequest $request)
    {
        $this->ticketRepository->store($request->validated());

        return redirect()->route('admin.tickets.index')->with('success', 'Kategori tiket berhasil ditambahkan.');
    }

    public function show(TicketCategory $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(TicketCategory $ticket)
    {
        $events = Event::latest()->get();

        return view('admin.tickets.edit', compact('ticket', 'events'));
    }

    public function update(TicketCategoryRequest $request, TicketCategory $ticket)
    {
        $this->ticketRepository->update($ticket, $request->validated());

        return redirect()->route('admin.tickets.index')->with('success', 'Kategori tiket berhasil diperbarui.');
    }

    public function destroy(TicketCategory $ticket)
    {
        $this->ticketRepository->delete($ticket);

        return redirect()->route('admin.tickets.index')->with('success', 'Kategori tiket berhasil dihapus.');
    }
}
