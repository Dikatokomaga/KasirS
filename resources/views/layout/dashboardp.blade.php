@extends('layout.body.main') @section('layout')
<div class="page-content">
  <div id="alertMessage" class="alert alert-info alert-dismissible fade show" role="alert">
    Selamat datang 
    {{ $pengguna }}
    di Kasir 
    !!!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
</div>

<script>
    // Menghilangkan alert setelah 5 detik
    setTimeout(function(){
        var alertMessage = document.getElementById('alertMessage');
        alertMessage.remove();
    }, 5000); // 5000 milidetik = 5 detik
</script>

    <div
        class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>

    </div>

    <div class="row">
    @if(auth()->user()->role != "karyawan")
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Users</h6>
                                <div class="dropdown mb-2">
                                    <a
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('index') }}">
                                            <i data-feather="eye" class="icon-sm me-2"></i>
                                            <span class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalUsers }}</h3>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Produk</h6>
                                <div class="dropdown mb-2">
                                    <a
                                        type="button"
                                        id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('produk') }}">
                                            <i data-feather="eye" class="icon-sm me-2"></i>
                                            <span class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalProduk }}</h3>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Sub Total</h6>
                                <div class="dropdown mb-2">
                                    <a
                                        type="button"
                                        id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                        <a
                                            class="dropdown-item d-flex align-items-center"
                                            href="{{ route('transaksi') }}">
                                            <i data-feather="eye" class="icon-sm me-2"></i>
                                            <span class="">View</span></a>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">Rp.
                                        {{ format_rupiah($totalPenjualan) }}</h3>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- row -->


    <style>
    .mb-12 {
        margin-bottom: 12px;
    }

    .product-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .product-image {
        width: 40%; /* Lebar gambar menjadi 50% dari lebar parent */
        height: auto; /* Agar gambar menyesuaikan tinggi */
        border-radius: 8px; /* Contoh: Tambahkan sudut yang melengkung pada gambar */
    }

    .product-details {
        margin-top: 8px; /* Jarak antara gambar dan detail produk */
    }

    .product-name {
        font-size: 18px; /* Ukuran font nama produk */
        margin-bottom: 4px; /* Jarak antara nama produk dan penyanyi */
    }

    .product-singer {
        font-size: 14px; /* Ukuran font penyanyi */
        margin-bottom: 4px; /* Jarak antara penyanyi dan harga */
    }

    .product-price {
        font-size: 16px; /* Ukuran font harga */
        color: #28a745; /* Warna teks harga (misalnya hijau) */
        font-weight: bold; /* Teks tebal pada harga */
    }
</style>

<div class="col-md-12 grid-margin stretch-card">
@if(auth()->user()->role != "admin")
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Produk Terbaru</h6>
                <!-- Dropdown menu untuk opsi lebih lanjut -->
            </div>

            <!-- Loop untuk menampilkan produk terbaru -->
            @foreach($produkTerbaru as $product)
            <div class="mb-12 product-container">
                <img src="{{ asset($product->gambar) }}" alt="{{ $product->gambar }}" class="img-fluid product-image">
                <div class="product-details">
                    <h6 class="mt-2 product-name">{{ $product->name }}</h6>
                    <p class="text-muted product-singer">{{ $product->penyanyi }}</p>
                    <span class="text-success product-price">Rp. {{ format_rupiah($product->harga) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

</div>
@endsection