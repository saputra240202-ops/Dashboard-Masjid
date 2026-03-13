@extends('layouts.public')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6">
        Laporan Keuangan Masjid
    </h1>

    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-green-100 p-4 rounded">
            <h2 class="font-semibold">Total Saldo</h2>
            <p>Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>

        <div class="bg-blue-100 p-4 rounded">
            <h2 class="font-semibold">Pemasukan Bulan Ini</h2>
            <p>Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
        </div>

        <div class="bg-red-100 p-4 rounded">
            <h2 class="font-semibold">Pengeluaran Bulan Ini</h2>
            <p>Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</p>
        </div>
    </div>

    <h2 class="text-xl font-semibold mb-4">
        5 Transaksi Terakhir
    </h2>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">Tanggal</th>
                <th class="p-2">Keterangan</th>
                <th class="p-2">Tipe</th>
                <th class="p-2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latestTransactions as $trx)
            <tr>
                <td class="p-2">{{ $trx->date }}</td>
                <td class="p-2">{{ $trx->description }}</td>
                <td class="p-2">{{ $trx->type }}</td>
                <td class="p-2">
                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection