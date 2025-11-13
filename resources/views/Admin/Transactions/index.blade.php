@extends('Admin.Layouts.app')

@section('content')
<h2>Transactions</h2>
<form method="GET" action="{{ route('admin.transactions') }}" class="mb-3 d-flex align-items-center gap-2">
    <select name="status" class="form-select w-auto">
        <option value="">All Status</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>

    <input type="date" name="start_date" class="form-control w-auto" value="{{ request('start_date') }}">
    <input type="date" name="end_date" class="form-control w-auto" value="{{ request('end_date') }}">

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    <a href="{{ route('admin.transactions') }}" class="btn btn-secondary btn-sm">Reset</a>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>Rp {{ number_format($transaction->total_amount,0,',','.') }}</td>
            <td>{{ ucfirst($transaction->status) }}</td>
            <td>{{ $transaction->payment_method }}</td>
            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
            <td>{{ $transaction->updated_at->format('d M Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-sm btn-primary">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $transactions->links() }}
@endsection
