<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Infaq Bulanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }

        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>LAPORAN KEUANGAN INFAQ BULANAN</h2>
<p style="text-align:center;">Tanggal Cetak: {{ date('d-m-Y') }}</p>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $trx)
        <tr>
            <td>{{ \Carbon\Carbon::parse($trx->date)->format('d-m-Y') }}</td>
            <td>{{ ucfirst($trx->type) }}</td>
            <td>{{ $trx->description }}</td>
            <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="summary">
    <p><strong>Total Pemasukan:</strong> Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    <p><strong>Saldo Akhir:</strong> Rp {{ number_format($saldo, 0, ',', '.') }}</p>
</div>

</body>
</html>