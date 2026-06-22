@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        @if($event->banner)<img src="{{ asset('storage/'.$event->banner) }}" class="card-img-top" style="max-height:420px;object-fit:cover;">@endif
        <div class="card-body">
            <h3>{{ $event->name }}</h3>
            <p>{{ $event->description }}</p>
            <p><b>Tanggal:</b> {{ $event->event_date->format('d M Y H:i') }}</p>
            <p><b>Lokasi:</b> {{ $event->location }}</p>

            <hr>
            <h5>Pilih Kategori Tiket</h5>

            <div class="row">
                @foreach($event->ticketCategories as $ticket)
                    <div class="col-md-3 mb-3">
                        <div class="card border h-100">
                            <div class="card-body">
                                <h5>{{ $ticket->name }}</h5>
                                <p>Rp {{ number_format($ticket->price,0,',','.') }}</p>
                                <small>Sisa: {{ $ticket->quota - $ticket->sold }}</small>
                                <a href="{{ route('user.checkout.create',$ticket) }}" class="btn btn-primary w-100 mt-3">Beli Tiket</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('user.events.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
