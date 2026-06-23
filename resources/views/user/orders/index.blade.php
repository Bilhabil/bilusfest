@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3>Riwayat Pemesanan</h3>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>Kode</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td><a href="{{ route('user.orders.show',$order) }}" class="btn btn-info btn-sm">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-shell">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
