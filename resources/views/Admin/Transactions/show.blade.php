@extends('Admin.Layouts.app')

@section('content')
<h2>Transaction #{{ $transaction->id }}</h2>
<p><strong>User:</strong> {{ $transaction->user->name }} ({{ $transaction->user->email }})</p>
<p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
<p><strong>Total:</strong> Rp {{ number_format($transaction->total_amount,0,',','.') }}</p>
<p><strong>Payment Method:</strong> {{ $transaction->payment_method }}</p>

<h4>Items</h4>
<table class="table table-sm">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaction->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->price,0,',','.') }}</td>
            <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
