@extends('layouts.user.appUser')
@section('page', 'Deposit')
@section('content')
<!-- Start Breadcrumbs -->
{{-- <div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">@yield('page')</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>@yield('page')</li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
<!-- End Breadcrumbs -->

<!-- Start About Area -->

<section class="dashboard section">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-md-4 col-12">
                <div class="d-none d-sm-none d-lg-block d-md-block">
                    @include('layouts.user.sidebar')
                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-12">
                <div class="main-content">

                    <div class="dashboard-block mt-0 profile-settings-block">
                        <h3 class="block-title">@yield('page')</h3>

                        <div class="inner-block">

                            <div class="nav-align-top mb-4">
                                @if (Helper::website_config("duitku_payment")->status == "on")
                                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-kesatu"
                                            aria-controls="navs-pills-justified-kesatu" aria-selected="true">
                                            Deposit Manual
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-kedua"
                                            aria-controls="navs-pills-justified-kedua" aria-selected="false">
                                            Deposit Otomatis
                                        </button>
                                    </li>
                                </ul>
                                @endif
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="navs-pills-justified-kesatu"
                                        role="tabpanel">

                                        <div class="row mt-5">

                                            <form method="post" action="{{ url('dashboard/deposit-manual') }}">
                                                @csrf
                                                <div class="col-lg-8 offset-lg-2">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Pilih Tujuan Deposit</h5>
                                                            <div class="form-group">
                                                                <select class="form-select" name="bank" id="bank">
                                                                    <option value="">Pilih Tujuan</option>
                                                                    @foreach ($bank as $b)
                                                                    <option value="{{ $b->key }}" @if(old('bank')==$b->
                                                                        key)
                                                                        selected @endif>{{ $b->key }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Nominal Deposit</h5>
                                                            <div class="form-group">
                                                                <input id="input-manual" class="form-control"
                                                                    name="jumlah" type="text"
                                                                    placeholder="Jumlah Deposit"
                                                                    value="{{ old('jumlah') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 offset-lg-2">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group button mb-0">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Deposit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-justified-kedua" role="tabpanel">

                                        <div class="row mt-5">

                                            <div class="col-lg-8 offset-lg-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Nominal Deposit</h5>
                                                        <div class="form-group">
                                                            <input id="input-nominal" class="form-control" name="jumlah"
                                                                type="text" placeholder="Jumlah Deposit" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 offset-lg-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group button mb-0">
                                                            <button type="button" id="pay-duitku"
                                                                class="btn btn-primary">Deposit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#input-nominal, #input-manual').on('keyup', function() {
            // Mengambil nilai input
            var inputVal = $(this).val();

            // Menghapus semua karakter kecuali angka
            var numericVal = inputVal.replace(/\D/g, '');

            // Memformat nilai dengan titik sebagai pemisah ribuan
            var formattedVal = numericVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Memasukkan nilai yang diformat kembali ke input
            $(this).val(formattedVal);
        });

        var inputVal = $('#input-nominal').val();
        if (inputVal.trim() === '') {
        $('#pay-duitku').prop('disabled', true);
        }

        // Event handler saat input berubah
        $('#input-nominal').on('input', function() {
        var inputVal = $(this).val();
        if (inputVal.trim() === '') {
            $('#pay-duitku').prop('disabled', true);
        } else {
            $('#pay-duitku').prop('disabled', false);
        }
        });


        $('#pay-duitku').on('click', function() {
            var buttonPay = $("#pay-duitku");
            buttonPay.prop("disabled", true);
            buttonPay.html('<i class="spinner-border spinner-border-sm"></i> Loading');

            var amount = $("#input-nominal").val();
            var link = '{{ url("pay-duitku") }}';

            $.ajax({
                url: link,
                data: {
                    paymentAmount: amount,
                },
                success: function (result) {
                    if(result === "masih_pending"){
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Masih terdapat deposit yang berstatus pending.',
                            icon: 'warning',
                            timer: 2000,
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = "{{ url('dashboard/riwayat-deposit') }}";
                        });
                    }
                    checkout.process(result.reference, {
                        defaultLanguage: "id",
                        successEvent: function (result) {
                            var kode = result.merchantOrderId;
                            var reference = result.reference;

                            buttonPay.prop("disabled", false);
                            buttonPay.html("Deposit");

                            $.ajax({
                                url: '{{ url("respon-duitku") }}',
                                data: {
                                    kode: kode, reference:reference, amount: amount, status: "Sukses"
                                },
                                success: function(response) {
                                    
                                    if(response.status === "Success"){
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Berhasil Melakukan Deposit.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: true
                                        }).then(function() {
                                            window.location.href = "{{ url('dashboard/riwayat-deposit') }}";
                                        });
                                    }else if(response.status === "Error"){
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Deposit Gagal.',
                                            icon: 'error',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    }
                                },
                            });
                        },
                        pendingEvent: function (result) {
                            var kode = result.merchantOrderId;
                            var reference = result.reference;

                            buttonPay.prop("disabled", false);
                            buttonPay.html("Deposit");

                            $.ajax({
                                url: '{{ url("respon-duitku") }}',
                                data: {
                                    kode: kode, reference:reference, amount: amount, status: "Pending"
                                },
                                success: function(response) {
                                  
                                    if(response.status === "Success"){
                                        Swal.fire({
                                            title: 'Pending!',
                                            text: 'Deposit Sedang Pending.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: true
                                        }).then(function() {
                                            window.location.href = "{{ url('dashboard/riwayat-deposit') }}";
                                        });
                                    }else if(response.status === "Error"){
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Deposit Gagal.',
                                            icon: 'error',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    }
                                },
                            });
                        
                        },
                        errorEvent: function (result) {
                           var kode = result.merchantOrderId;
                            var reference = result.reference;
                            
                            buttonPay.prop("disabled", false);
                            buttonPay.html("Deposit");

                            $.ajax({
                                url: '{{ url("respon-duitku") }}',
                                data: {
                                    kode: kode, reference:reference, amount: amount, status: "Error"
                                },
                                success: function(response) {
                                    
                                    if(response.status === "Success"){
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Pembayaran Gagal.',
                                            icon: 'error',
                                            timer: 2000,
                                            showConfirmButton: true
                                        }).then(function() {
                                            window.location.href = "{{ url('dashboard/riwayat-deposit') }}";
                                        });
                                    }else if(response.status === "Error"){
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Deposit Gagal.',
                                            icon: 'error',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    }
                                },
                            });
                        },
                        closeEvent: function (result) {
                            // tambahkan fungsi sesuai kebutuhan anda
                            Swal.fire({
                                    title: 'Oops!',
                                    text: 'Pelanggan menutup popup tanpa menyelesaikan deposit.',
                                    icon: 'info',
                                    button: "Oke",
                                });
                            buttonPay.prop("disabled", false);
                            buttonPay.html("Deposit");
                        }
                    });
                },
            });
        });

    });
</script>


<!-- End About Area -->
@endsection