@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3>Checkout Tiket</h3>

    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5>{{ $ticketCategory->event->name }}</h5>
            <p>{{ $ticketCategory->event->location }}</p>
            <p>{{ $ticketCategory->event->event_date->format('d M Y H:i') }}</p>
            <hr>
            <p><b>Kategori:</b> {{ $ticketCategory->name }}</p>
            <p><b>Harga:</b> Rp {{ number_format($ticketCategory->price,0,',','.') }}</p>
            <p><b>Sisa:</b> {{ $ticketCategory->quota - $ticketCategory->sold }}</p>

            <form action="{{ route('user.checkout.store',$ticketCategory) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Jumlah Tiket</label>
                    <input type="number" name="quantity" class="form-control" min="1" max="{{ $ticketCategory->quota - $ticketCategory->sold }}" value="1">
                </div>
                <button class="btn btn-primary">Buat Pesanan</button>
                <a href="{{ route('user.events.show',$ticketCategory->event) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
