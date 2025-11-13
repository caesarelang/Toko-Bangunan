<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Laporan Penjualan</h3>
    @if($startDate || $endDate)
        <p>Periode: {{ $startDate ?? '-' }} s/d {{ $endDate ?? '-' }}</p>
    @endif

    <h4>Total Revenue: Rp {{ number_format($totalRevenue,0,',','.') }}</h4>

    <h5>Produk Terjual</h5>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
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

    <h5>Laporan Bulanan</h5>
    <table>
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
</body>
</html>
