@extends('Admin.Layouts.app')

@section('content')
<h2 class="mb-4">Orders</h2>

<form method="GET" action="{{ route('admin.orders') }}" class="mb-3 d-flex align-items-center gap-2">
    <select name="status" class="form-select w-auto">
        <option value="">All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="delivering" {{ request('status') == 'delivering' ? 'selected' : '' }}>Delivering</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="cancellation_requested" {{ request('status') == 'cancellation_requested' ? 'selected' : '' }}>Cancellation Requested</option>
    </select>

    <input type="date" name="start_date" class="form-control w-auto" value="{{ request('start_date') }}">
    <input type="date" name="end_date" class="form-control w-auto" value="{{ request('end_date') }}">

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm">Reset</a>
</form>

<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Delivery Location</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
            <td>
                <span class="badge bg-{{ match($order->status) {
                    'pending' => 'warning',
                    'processing' => 'info',
                    'delivering' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    'cancellation_requested' => 'danger',
                    default => 'secondary',
                } }}">
                    {{ ucfirst(str_replace('_',' ', $order->status)) }}
                </span>
            </td>
            <td>
                @if($order->latitude && $order->longitude)
                    {{-- Tombol modal map --}}
                    <button class="btn btn-sm btn-outline-primary mb-1" data-bs-toggle="modal" data-bs-target="#mapModal{{ $order->id }}">
                        View Map
                    </button>
                    {{-- Tombol share WA --}}
                    <a target="_blank" href="https://wa.me/?text={{ urlencode('Hi, order #' . $order->id . ' delivery location: https://www.google.com/maps?q=' . $order->latitude . ',' . $order->longitude) }}" class="btn btn-sm btn-success">
                        Share WA
                    </a>

                    <!-- Modal Map -->
                    <div class="modal fade" id="mapModal{{ $order->id }}" tabindex="-1" aria-labelledby="mapModalLabel{{ $order->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="mapModalLabel{{ $order->id }}">Order #{{ $order->id }} Location</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                            <div class="modal-body">
                                <iframe 
                                    width="100%" 
                                    height="400" 
                                    frameborder="0" 
                                    style="border:0"
                                    src="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&output=embed"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                      </div>
                    </div>
                @else
                    <span class="text-muted">No Location</span>
                @endif
            </td>
            <td>{{ $order->updated_at->format('d M Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}
@endsection
