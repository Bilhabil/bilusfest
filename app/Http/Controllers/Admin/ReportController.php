<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.reports.index', compact('orders'));
    }

    public function exportPdf()
    {
        $orders = Order::with('user')->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-bilus-fest.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new OrdersExport, 'laporan-transaksi-bilus-fest.xlsx');
    }
}
