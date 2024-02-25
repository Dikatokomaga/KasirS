@extends('layout.body.main')

@section('layout')
@include('sweetalert::alert')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <form id="printForm" action="{{ route('riwayat.print') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-inverse-info">
                    <i data-feather="printer"></i>
                </button>
            </form>
            
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card"> 
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Histori Transaksi</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>

                            <div class="row">
    <div class="col-md-6">
        <form action="{{ route('riwayat') }}" method="GET">
            <div class="input-group">
                <input type="date" class="form-control" name="start_date">
                <input type="date" class="form-control" name="end_date">
                <button type="submit" class="btn btn-outline-primary">Filter Tanggal</button>
            </div>
        </form>
    </div>
    <div class="col-md-6 text-end">
        <form id="printForm" action="{{ route('riwayat.print') }}" method="POST">
            @csrf
            <!-- <button type="submit" class="btn btn-inverse-info">
                <i data-feather="printer"></i>
            </button> -->
        </form>
    </div>
</div>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($riwayat as $ryt)
    @php
        $tanggalTransaksi = \Carbon\Carbon::parse($ryt->created_at)->format('Y-m-d');
        $startDate = \Carbon\Carbon::parse(request('start_date'))->format('Y-m-d');
        $endDate = \Carbon\Carbon::parse(request('end_date'))->format('Y-m-d');
    @endphp
    @if (!$startDate || ($tanggalTransaksi >= $startDate && $tanggalTransaksi <= $endDate))
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$ryt->created_at->format('d F Y')}}</td>
            <td>{{$ryt->kasir_nama}}</td>
            <td>{{format_rupiah($ryt->total)}}</td>
            <td>@if($ryt->status == 'selesai')
                    <span >Selesai</span>
                @else
                    <span>Pending</span>
                @endif
            </td>
            <td>
                @if(auth()->user()->role!="pengguna")
                    <form action="{{ route('riwayat.destroy', ['id' => $ryt->id]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-inverse-danger btn-icon" onclick="return confirm('Apakah Anda yakin ingin menghapus?');">
                            <i class="link-icon" data-feather="trash"></i>
                        </button>
                    </form>
                @endif
            </td>
        </tr>
    @endif
@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
