@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Detail Tiket</h3>
    <div class="card shadow-sm border-0"><div class="card-body">
        <p><b>Event:</b> {{ $ticket->event->name }}</p>
        <p><b>Kategori:</b> {{ $ticket->name }}</p>
        <p><b>Harga:</b> Rp {{ number_format($ticket->price,0,',','.') }}</p>
        <p><b>Kuota:</b> {{ $ticket->quota }}</p>
        <p><b>Terjual:</b> {{ $ticket->sold }}</p>
        <p><b>Status:</b> {{ $ticket->status }}</p>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Kembali</a>
    </div></div>
</div>
@endsection
