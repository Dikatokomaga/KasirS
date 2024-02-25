<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <style>
        /* Gaya CSS Anda di sini */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
@php

    $transaksiDetails = $transaksiDetails->sortBy('transaksi_id');
@endphp

<table border="1">
    <thead>
        <tr>
            <th>Transaksi ID</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($transaksiDetails->groupBy('transaksi_id') as $transaksi_id => $transaksi)
    @php
        $tanggalTransaksi = \Carbon\Carbon::parse($transaksi->first()->created_at)->format('Y-m-d');
        $startDate = \Carbon\Carbon::parse(request('start_date'))->format('Y-m-d');
        $endDate = \Carbon\Carbon::parse(request('end_date'))->format('Y-m-d');
    @endphp

    @if (!$startDate || ($tanggalTransaksi >= $startDate && $tanggalTransaksi <= $endDate))
        <tr>
            <td colspan="4">Transaksi ID: # INV-00230{{ $transaksi_id }}</td>
        </tr>
        @foreach ($transaksi as $key => $trx)
            <tr>
                <td>{{ $trx->transaksi_id }}</td>
                <td>{{ $trx->created_at->format('d F Y') }}</td>
                <td>{{ $trx->produk_name }}</td>
                <td>{{ $trx->qty }}</td>
            </tr>
        @endforeach
    @endif
@endforeach
    </tbody>
</table>
</html>
    
