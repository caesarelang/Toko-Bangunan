@extends('Owner.Layouts.app')

@section('content')
<h2 class="mb-4">Revenue Dashboard</h2>

<!-- Filter -->
<form action="{{ route('owner.revenue') }}" method="GET" class="mb-3 d-flex gap-2 align-items-center">
    <select name="month" class="form-select w-auto">
        @for($m=1;$m<=12;$m++)
        <option value="{{ $m }}" {{ $month==$m ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
        @endfor
    </select>

    <select name="year" class="form-select w-auto">
        @for($y=date('Y');$y>=date('Y')-5;$y--)
        <option value="{{ $y }}" {{ $year==$y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
    </select>

    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
</form>

<div class="mb-4">
    <h4>Total Revenue: <span class="text-success">Rp {{ number_format($totalRevenue,0,',','.') }}</span></h4>
</div>

<!-- Chart -->
<canvas id="revenueChart" height="100"></canvas>

<!-- Table -->
<table class="table table-striped mt-4">
    <thead>
        <tr>
            <th>Date</th>
            <th>Revenue</th>
        </tr>
    </thead>
    <tbody>
        @foreach($revenuePerDay as $day => $amount)
        <tr>
            <td>{{ $day }} {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</td>
            <td>Rp {{ number_format($amount,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line', // bisa juga 'bar'
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($chartData) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endsection
