<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::with('user')
            ->latest()
            ->get()
            ->map(function ($order) {
                return [
                    'order_code' => $order->order_code,
                    'user' => $order->user->name,
                    'email' => $order->user->email,
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'date' => $order->created_at->format('d-m-Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Order',
            'Nama User',
            'Email',
            'Total Harga',
            'Status',
            'Tanggal',
        ];
    }
}
