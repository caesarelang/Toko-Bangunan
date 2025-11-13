@extends('Admin.Layouts.app')

@section('content')
<h2 class="mb-4">Reports</h2>

{{-- Filter tanggal --}}
<form method="GET" class="mb-4 d-flex gap-2 align-items-end">
    <div>
        <label>Start Date</label>
        <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
    </div>
    <div>
        <label>End Date</label>
        <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="{{ route('admin.reports') }}" class="btn btn-secondary">Reset</a>
</form>

{{-- Total Penghasilan --}}
<div class="mb-4">
    <h4>Total Revenue: <span class="text-success">Rp {{ number_format($totalRevenue,0,',','.') }}</span></h4>
</div>

{{-- Produk terjual --}}
<h5>Produk Terjual</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty Terjual</th>
            <th>Total Uang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productsReport as $item)
        <tr>
            <td>{{ $item->product->name ?? '-' }}</td>
            <td>{{ $item->total_qty }}</td>
            <td>Rp {{ number_format($item->total_amount,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Laporan bulanan --}}
<h5 class="mt-4">Monthly Report</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Total Orders</th>
            <th>Total Revenue</th>
        </tr>
    </thead>
    <tbody>
        @foreach($monthlyReport as $month)
        <tr>
            <td>{{ \Carbon\Carbon::parse($month->month.'-01')->format('F Y') }}</td>
            <td>{{ $month->total_orders }}</td>
            <td>Rp {{ number_format($month->total_revenue,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('admin.reports.print', ['start_date'=>$startDate,'end_date'=>$endDate]) }}" class="btn btn-secondary mb-3" target="_blank">
    Cetak PDF
</a>
@endsection
