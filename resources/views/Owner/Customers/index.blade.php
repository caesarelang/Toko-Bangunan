@extends('Owner.Layouts.app')

@section('content')
<h2 class="mb-4">Customers</h2>

<ul class="nav nav-tabs mb-3" id="customerTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Customers</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="top-orders-tab" data-bs-toggle="tab" data-bs-target="#top-orders" type="button" role="tab">Top Orders</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="top-spent-tab" data-bs-toggle="tab" data-bs-target="#top-spent" type="button" role="tab">Top Spent</button>
  </li>
</ul>

<div class="tab-content" id="customerTabContent">
    {{-- All Customers --}}
    <div class="tab-pane fade show active" id="all" role="tabpanel">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Whatsapp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->whatsapp ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Top Orders --}}
    <div class="tab-pane fade" id="top-orders" role="tabpanel">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCustomers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->total_orders }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Top Spent --}}
    <div class="tab-pane fade" id="top-spent" role="tabpanel">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Total Spent</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCustomers->sortByDesc('total_spent') as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>Rp {{ number_format($customer->total_spent,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
