@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row g-3">
        <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><small>Total Event</small><h3>{{ $totalEvents }}</h3></div></div></div>
        <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><small>Total User</small><h3>{{ $totalUsers }}</h3></div></div></div>
        <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><small>Tiket Terjual</small><h3>{{ $totalTicketsSold }}</h3></div></div></div>
        <div class="col-md-3"><div class="card shadow-sm border-0"><div class="card-body"><small>Pendapatan</small><h3>Rp {{ number_format($totalRevenue,0,',','.') }}</h3></div></div></div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">
            <h5>Grafik Penjualan</h5>
            <canvas id="salesChart" height="90"></canvas>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body table-responsive">
            <h5>Transaksi Terbaru</h5>
            <table class="table table-bordered mt-3">
                <thead><tr><th>Kode</th><th>User</th><th>Total</th><th>Status</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @foreach($latestOrders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($salesChart->pluck('date')),
        datasets: [{
            label: 'Pendapatan',
            data: @json($salesChart->pluck('total')),
            borderWidth: 2,
            tension: .4
        }]
    }
});
</script>
@endsection
