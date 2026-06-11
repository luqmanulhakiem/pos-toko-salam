<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Produk</title>
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
    </style>
</head>
<body>

<div class="header">
    <h2>Laporan Stok Produk {{ Str::ucfirst($type) }}</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Transaksi</th>
            <th>Pengguna</th>
            <th>Nama Produk</th>
            <th>Harga Modal</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @if (count($data) > 0)
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->produk->name }}</td>
                    <td>Rp. {{ number_format($item->cogs, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->price_sell, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->description }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" style="text-align: center;">Belum ada data</td>
            </tr>
        @endif
    </tbody>
</table>

</body>
</html>
