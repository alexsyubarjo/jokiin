@extends('layouts.user.appUser')
@section('page', 'Tarik Dana')
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

                            <div class="row justify-content-center">

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="alert alert-warning" role="alert">
                                        Saldo Anda : <strong>Rp {{ number_format($user->saldo, 0, ',', '.')
                                            }},-</strong>
                                    </div>
                                    <div class="alert alert-info" role="alert">
                                        Ketika Anda melakukan tarik dana, saldo di dompet Anda akan berkurang.
                                        Anda dapat melakukan permintaan tarik dana kapan saja. <br />
                                        Untuk melakukan tarik dana jumlah minimum yang dapat ditarik adalah
                                        <strong>Rp {{ number_format($web->min_wd, 0, ',', '.') }}</strong>
                                        dan dikenakan fee sebesar <strong>{{ $web->wd }}%</strong>
                                        <br /><br />
                                        <i class="text-danger">
                                            *Mohon pastikan data rekening Anda di bawah ini sudah sesuai dan benar.
                                        </i>
                                    </div>

                                    <div class="col-lg-8 offset-lg-2 mt-5">
                                        <strong>Data Rekening :</strong>
                                        <div class="float-end">
                                            <a href="{{ url('dashboard/rekening') }}" class="btn btn-ungu btn-xs">
                                                Edit rekening
                                            </a>
                                        </div>
                                        <table class="table table-bordered mt-2">
                                            <tr>
                                                <td>Bank</td>
                                                <td>{{ isset($rek->bank) ? $rek->bank : "" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Rekening</td>
                                                <td>{{ isset($rek->nama) ? $rek->nama : "" }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>{{ isset($rek->rek) ? $rek->rek : "" }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <form method="post" action="{{ url('dashboard/withdraw-dana') }}">
                                        @csrf

                                        <div class="col-lg-8 offset-lg-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Nominal Penarikan</h5>
                                                    <div class="form-group">
                                                        <input id="input-nominal" class="form-control" name="jumlah"
                                                            type="text" placeholder="Jumlah penarikan" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 offset-lg-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group button mb-0">
                                                        <button type="submit" class="btn">Withdraw</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

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
        $('#input-nominal').focus();
        $('#input-nominal').on('keyup', function() {
            // Mengambil nilai input
            var inputVal = $(this).val();

            // Menghapus semua karakter kecuali angka
            var numericVal = inputVal.replace(/\D/g, '');

            // Memformat nilai dengan titik sebagai pemisah ribuan
            var formattedVal = numericVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Memasukkan nilai yang diformat kembali ke input
            $(this).val(formattedVal);
        });
    });
</script>



<!-- End About Area -->
@endsection