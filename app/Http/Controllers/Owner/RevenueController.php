<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Order;

class RevenueController extends Controller
{

public function index(Request $request)
{
    // Ambil bulan & tahun filter, default bulan ini
    $month = $request->input('month', Carbon::now()->month);
    $year  = $request->input('year', Carbon::now()->year);

    // Semua order completed di bulan tersebut
    $orders = Order::where('status','completed')
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->get();

    // Hitung total pemasukan
    $totalRevenue = $orders->sum('total_price');

    // Pemasukan per hari
    $revenuePerDay = $orders->groupBy(function($order){
        return $order->created_at->format('d'); // tanggal
    })->map(function($dayOrders){
        return $dayOrders->sum('total_price');
    });

    // Untuk grafik
    $daysInMonth = Carbon::create($year, $month)->daysInMonth;
    $chartLabels = [];
    $chartData = [];
for($d=1;$d<=$daysInMonth;$d++){
    $label = str_pad($d, 2, '0', STR_PAD_LEFT); // 1 → "01"
    $chartLabels[] = $d;
    $chartData[] = (float) ($revenuePerDay[$label] ?? 0); // cast ke float supaya Chart.js
}


    return view('Owner.Revenues.index', compact('month','year','totalRevenue','revenuePerDay','chartLabels','chartData'));
}
}
