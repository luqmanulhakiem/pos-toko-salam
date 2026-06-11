<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .summary-table {
            width: 50%;
            margin-bottom: 20px;
        }
        .summary-table th, .summary-table td {
            border: none;
            padding: 3px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Laporan Penjualan</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
</div>

<table class="summary-table">
    <tr>
        <th style="text-align: left; width: 150px;">Gross Revenue</th>
        <td>: Rp {{ number_format($grossRevenue, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">Net Profit</th>
        <td>: Rp {{ number_format($netProfit, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">Total Pesanan</th>
        <td>: {{ number_format($totalPesanan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="text-align: left;">Total Produk Terjual</th>
        <td>: {{ number_format($totalProdukTerjual, 0, ',', '.') }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Transaksi</th>
            <th>No Nota</th>
            <th>Kasir</th>
            <th>Harga Total</th>
        </tr>
    </thead>
    <tbody>
        @if (count($data) > 0)
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $item->nota_id }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>Rp. {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada data</td>
            </tr>
        @endif
    </tbody>
</table>

</body>
</html>
