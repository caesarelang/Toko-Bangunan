@extends('Admin.Layouts.app')

@section('content')
<h2 class="mb-4">Order #{{ $order->id }}</h2>

<p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
<p><strong>Status:</strong> {{ ucfirst(str_replace('_',' ',$order->status)) }}</p>
<p><strong>Total:</strong> Rp {{ number_format($order->total_price,0,',','.') }}</p>

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
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->price,0,',','.') }}</td>
            <td>Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($order->latitude && $order->longitude)
<h4>Delivery Location</h4>
<iframe 
    width="100%" 
    height="400" 
    frameborder="0" 
    style="border:0; margin-bottom:20px;"
    src="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&output=embed"
    allowfullscreen>
</iframe>

<p>
    <a target="_blank" href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}" class="btn btn-sm btn-primary">
        Open in Google Maps
    </a>
    <a target="_blank" href="https://wa.me/?text={{ urlencode('Hi, order #' . $order->id . ' delivery location: https://www.google.com/maps?q=' . $order->latitude . ',' . $order->longitude) }}" class="btn btn-sm btn-success">
        Share via WhatsApp
    </a>
</p>
@endif

<h5>Update Status</h5>
<form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
    @csrf
    @method('PUT')
    <select name="status" class="form-select w-auto d-inline">
        @if($order->status === 'cancellation_requested')
            <option value="cancelled">Approve</option>
            <option value="processing" selected>Decline</option>
        @elseif($order->status === 'processing')
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>Delivering</option>
        @elseif($order->status === 'delivering')
            <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>Delivering</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
        @endif
    </select>
    <button type="submit" class="btn btn-success btn-sm">Update</button>
</form>
@endsection

