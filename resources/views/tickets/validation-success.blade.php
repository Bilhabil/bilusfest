@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-success">
        <div class="card-body text-center">
            <h3 class="text-success">Tiket Valid</h3>
            <p><b>Nomor Tiket:</b> {{ $ticket->ticket_number }}</p>
            <p><b>Event:</b> {{ $ticket->orderDetail->ticketCategory->event->name }}</p>
            <p><b>Nama Pemesan:</b> {{ $ticket->orderDetail->order->user->name }}</p>
            <p><b>Kategori:</b> {{ $ticket->orderDetail->ticketCategory->name }}</p>
            <p><b>Tanggal:</b> {{ $ticket->orderDetail->ticketCategory->event->event_date->format('d M Y H:i') }}</p>
            <p><b>Lokasi:</b> {{ $ticket->orderDetail->ticketCategory->event->location }}</p>
        </div>
    </div>
</div>
@endsection
