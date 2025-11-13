@extends('Owner.Layouts.app')

@section('content')
<h2 class="mb-4">Dashboard - {{ \Carbon\Carbon::now()->format('F Y') }}</h2>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5>Total Revenue</h5>
                <h3>Rp {{ number_format($totalRevenue,0,',','.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5>Total Orders</h5>
                <h3>{{ $totalOrders }}</h3>
            </div>
        </div>
    </div>
</div>

<h4 class="mt-4">Top Products</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Total Sold</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topProducts as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->total_sold }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="mt-4">Top Customers by Orders</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Total Orders</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topCustomersOrders as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->total_orders }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="mt-4">Top Customers by Revenue</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Total Spent</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topCustomersRevenue as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>Rp {{ number_format($customer->total_spent,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
