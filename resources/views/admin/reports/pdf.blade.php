<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi BILUS FEST</title>
    <style>
        body{font-family:DejaVu Sans,sans-serif;font-size:12px;color:#111827}
        h2{text-align:center;color:#4F46E5;margin-bottom:4px}
        .subtitle{text-align:center;color:#EC4899;margin-bottom:20px}
        table{width:100%;border-collapse:collapse}
        th{background:#4F46E5;color:white;padding:8px;border:1px solid #ddd}
        td{padding:7px;border:1px solid #ddd}
    </style>
</head>
<body>
<h2>Laporan Transaksi BILUS FEST</h2>
<div class="subtitle">Data pemesanan tiket festival musik</div>

<table>
    <thead>
        <tr>
            <th>Kode Order</th>
            <th>User</th>
            <th>Email</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->email }}</td>
                <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
                <td>{{ strtoupper($order->status) }}</td>
                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
