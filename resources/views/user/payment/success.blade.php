@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm border-0"><div class="card-body">
        <h3>Pembayaran Berhasil Diproses</h3>
        <p>Status final akan diperbarui oleh webhook Midtrans.</p>
        <a href="{{ route('user.orders.show',$order) }}" class="btn btn-primary">Lihat Pesanan</a>
    </div></div>
</div>
@endsection
