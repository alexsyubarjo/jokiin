@extends('layouts.user.appUser')
@section('page', 'Invoice Deposit')
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

                    <div class="inner-block">

                        <div class="col-lg-8 offset-lg-2">
                            <div class="card shadow mb-1">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <h2>
                                                <b class="h3 fw-bold">INVOICE</b><br>
                                                <span data-inv="{{ $depo->kode }}" class="btn btn-secondary btn-sm">
                                                    #{{ $depo->kode }}
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                    </div>
                                    <hr style="border-top: 1px solid white;">
                                    <div class="row text-white-100 small text-center">
                                        <div class="col-md-4 mb-2">
                                            TANGGAL &amp; WAKTU<br>
                                            <span class="text-gray-700">
                                                {{ date_format($depo->created_at, 'd M Y, H:i') }}
                                            </span>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            KODE INVOICE<br>
                                            <span class="text-gray-700"><b>#{{ $depo->kode }}</b></span>
                                        </div>
                                        <div class="col-md-4 mb-1">
                                            STATUS<br>
                                            <h6>
                                                @php
                                                if ($depo->status == "Pending") {
                                                $btn = "btn-warning";
                                                } elseif ($depo->status == "Sukses") {
                                                $btn = "btn-success";
                                                } elseif ($depo->status == "Cancel") {
                                                $btn = "btn-danger";
                                                } elseif ($depo->status == "Error") {
                                                $btn = "btn-danger";
                                                } else {
                                                $btn = "btn-primary";
                                                }
                                                @endphp

                                                <span class="btn {{ $btn }} btn-xs">
                                                    {{ $depo->status }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($depo->metode == "Manual")
                            <div class="card bg-gray-400 shadow">
                                <div class="card-body">
                                    @php
                                    $rep_no = "62" . substr($soc->whatsapp, 1);
                                    @endphp
                                    <div class="alert alert-info" role="alert">
                                        Untuk melakukan transfer manual, harap mengisi saldo Anda
                                        sesuai
                                        dengan nominal dan penerima yang tercantum di bawah ini.
                                        <br />
                                        Jika
                                        Anda membutuhkan bantuan atau konfirmasi pembayaran, jangan
                                        ragu
                                        untuk menghubungi admin melalui WhatsApp di nomor
                                        <a target="_blank" href="https://api.whatsapp.com/send?phone={{ $rep_no }}">
                                            <b>{{ $soc->whatsapp }}</b>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                @if ($depo->metode == "Manual")
                                                <tr>
                                                    <td>Tipe Transfer</td>
                                                    <td>{{ $depo->bank }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Penerima</td>
                                                    <td>{{ $bank->nama_rek }}</td>
                                                </tr>
                                                <tr>
                                                    <td>No. Penerima</td>
                                                    <td><b>{{ $bank->no_rek }}</b>
                                                        <button data-penerima="{{ $bank->no_rek }}"
                                                            class="btn btn-ungu btn-xs float-end">
                                                            <i class="lni lni-files"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif

                                                <tr>
                                                    <td>Metode</td>
                                                    <td>Deposit {{ $depo->metode }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nominal Transfer</td>
                                                    <td>
                                                        <span class="h5 text-danger bold mt-1">
                                                            <b>
                                                                Rp {{ $depo->nominal }},-
                                                            </b>
                                                        </span>
                                                        @php
                                                        $nominalCopy = str_replace(".", "" , $depo->nominal);
                                                        @endphp
                                                        <button data-nominal="{{ $nominalCopy }}"
                                                            class="btn btn-ungu btn-xs float-end mt-1">
                                                            <i class="lni lni-files"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row text-white-100 small">
                                        <div class="col-md-12">
                                            <div class="float-start mt-1">
                                                <a href="{{ url('dashboard/riwayat-deposit') }}"
                                                    class="btn btn-ungu btn-icon-split">
                                                    <span class="icon text-gray-600">
                                                        <i class="lni lni-chevron-left-circle"></i>
                                                    </span>
                                                    <span class="text">History</span>
                                                </a>
                                            </div>

                                            <div class="float-end mt-2">
                                                @if ($depo->status == "Pending")
                                                <button id="batalkan" class="btn btn-danger btn-bold"
                                                    data-inv="{{ $depo->kode }}">
                                                    <span class="icon text-gray-600">
                                                        <i class="lni lni-ban"></i>
                                                    </span>
                                                    <span class="text">Batalkan</span>
                                                </button>
                                                @endif
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
        $('[data-inv]').click(function() {
            var inv = $(this).data('inv');
            copyToClipboard(inv);
            showSuccessAlert();
        });

        $('[data-penerima]').click(function() {
            var penerima = $(this).data('penerima');
            copyToClipboard(penerima);
            showSuccessAlert();
        });

        $('[data-nominal]').click(function() {
            var nominal = $(this).data('nominal');
            copyToClipboard(nominal);
            showSuccessAlert();
        });

        function copyToClipboard(text) {
            var tempInput = $('<input>');
            $('body').append(tempInput);
            tempInput.val(text).select();
            document.execCommand('copy');
            tempInput.remove();
        }

        function showSuccessAlert() {
            Swal.fire({
            icon: 'success',
            title: 'Tercopy!',
            text: 'Data telah disalin ke clipboard.',
            showConfirmButton: false,
            timer: 1500
            });
        }

        $(document).on('click', '#batalkan', function() {
            // Menampilkan SweetAlert confirmation
            Swal.fire({
                title: 'Apakah Anda yakin ingin membatalkan invoice ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    var inv = $(this).data('inv');
                    var url = '{{ url("dashboard/batal-deposit") }}';
                    
                    // Mengirim permintaan AJAX
                    $.ajax({
                        url: url,
                        data: {
                            inv: inv
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Berhasil Membatalkan Deposit.',
                                icon: 'success',
                                timer: 500,
                                showConfirmButton: false
                            }).then(function() {
                                // Load halaman yang diinginkan setelah SweetAlert ditutup
                                window.location.href = "{{ url('dashboard/riwayat-deposit') }}";
                            });
                        },
                        error: function(xhr) {
                            // Tanggapan error, tampilkan pesan kesalahan
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan. Silakan coba lagi.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });

    });
</script>


<!-- End About Area -->
@endsection