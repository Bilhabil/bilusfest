@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm border-0"><div class="card-body">
        <h3>Pembayaran Gagal</h3>
        <p>Silakan coba ulangi pembayaran.</p>
        <a href="{{ route('user.orders.show',$order) }}" class="btn btn-primary">Kembali</a>
    </div></div>
</div>
@endsection
