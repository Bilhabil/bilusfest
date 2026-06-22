@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3>Detail Event</h3>
    <div class="card shadow-sm border-0">
        @if($event->banner)<img src="{{ asset('storage/'.$event->banner) }}" class="card-img-top" style="max-height:420px;object-fit:cover;">@endif
        <div class="card-body">
            <h4>{{ $event->name }}</h4>
            <p>{{ $event->description }}</p>
            <p><b>Tanggal:</b> {{ $event->event_date->format('d M Y H:i') }}</p>
            <p><b>Lokasi:</b> {{ $event->location }}</p>
            <p><b>Status:</b> {{ $event->status }}</p>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
