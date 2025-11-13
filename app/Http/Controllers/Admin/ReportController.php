<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use DB;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;

        // Orders yang completed saja
        $ordersQuery = Order::query()->with('items.product')
            ->where('status', 'completed');

        if ($startDate) $ordersQuery->where('created_at', '>=', $startDate . ' 00:00:00');
        if ($endDate) $ordersQuery->where('created_at', '<=', $endDate . ' 23:59:59');

        $orders = $ordersQuery->get();

        // Total revenue dari orders completed
        $totalRevenue = $orders->sum('total_price');

        // Produk terjual dari orders completed
        $productsReport = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(quantity * price) as total_amount')
            )
            ->whereHas('order', fn($q) => $q->where('status', 'completed'))
            ->when($startDate, fn($q) => $q->whereHas('order', fn($q2) => $q2->where('created_at', '>=', $startDate . ' 00:00:00')))
            ->when($endDate, fn($q) => $q->whereHas('order', fn($q2) => $q2->where('created_at', '<=', $endDate . ' 23:59:59')))
            ->with('product')
            ->groupBy('product_id')
            ->get();

        // Laporan bulanan, hanya orders completed
        $monthlyReport = Order::select(
                DB::raw('DATE_FORMAT(created_at,"%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->where('status', 'completed')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate . ' 00:00:00'))
            ->when($endDate, fn($q) => $q->where('created_at', '<=', $endDate . ' 23:59:59'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('Admin.Reports.index', compact('totalRevenue','productsReport','monthlyReport','startDate','endDate'));
    }

    public function print(Request $request)
    {
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;

        // Orders completed
        $ordersQuery = Order::query()->with('items.product')
            ->where('status', 'completed');

        if ($startDate) $ordersQuery->where('created_at', '>=', $startDate . ' 00:00:00');
        if ($endDate) $ordersQuery->where('created_at', '<=', $endDate . ' 23:59:59');

        $orders = $ordersQuery->get();

        $totalRevenue = $orders->sum('total_price');

        $productsReport = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(quantity * price) as total_amount')
            )
            ->whereHas('order', fn($q) => $q->where('status', 'completed'))
            ->when($startDate, fn($q) => $q->whereHas('order', fn($q2) => $q2->where('created_at', '>=', $startDate . ' 00:00:00')))
            ->when($endDate, fn($q) => $q->whereHas('order', fn($q2) => $q2->where('created_at', '<=', $endDate . ' 23:59:59')))
            ->with('product')
            ->groupBy('product_id')
            ->get();

        $monthlyReport = Order::select(
                DB::raw('DATE_FORMAT(created_at,"%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->where('status', 'completed')
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate . ' 00:00:00'))
            ->when($endDate, fn($q) => $q->where('created_at', '<=', $endDate . ' 23:59:59'))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        $pdf = PDF::loadView('Admin.Reports.print', compact('totalRevenue','productsReport','monthlyReport','startDate','endDate'));
        return $pdf->download('report_'.date('Ymd_His').'.pdf');
    }
}
