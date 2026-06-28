@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3>Pembayaran Tiket</h3>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p><b>Kode Order:</b> {{ $order->order_code }}</p>
            <p><b>Total Bayar:</b> Rp {{ number_format($order->total_price,0,',','.') }}</p>
            <p class="text-muted mb-3">Kalau popup pembayaran ditutup, kamu bisa buka lagi dari detail pesanan.</p>

            <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
            <a href="{{ route('user.orders.show',$order) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            window.location.href = "{{ route('user.payment.success',$order) }}";
        },
        onPending: function(result) {
            window.location.href = "{{ route('user.orders.show',$order) }}";
        },
        onError: function(result) {
            window.location.href = "{{ route('user.payment.failed',$order) }}";
        },
        onClose: function() {
            window.location.href = "{{ route('user.orders.show',$order) }}";
        }
    });
};
</script>
@endsection
