@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Laporan Transaksi</h3>
        <div>
            <a href="{{ route('admin.reports.export.pdf') }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('admin.reports.export.excel') }}" class="btn btn-success">Export Excel</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>Kode</th><th>User</th><th>Email</th><th>Total</th><th>Status</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                            <td>{{ strtoupper($order->status) }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada transaksi.</td></tr>
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
