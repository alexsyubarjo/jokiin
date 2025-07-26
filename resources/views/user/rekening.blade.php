@extends('layouts.user.appUser')
@section('page', 'Setting Rekening')
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

                            <form class="profile-setting-form" method="post"
                                action="{{ url('dashboard/edit_rekening') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="form-group">
                                            <label>Bank*</label>
                                            <select class="form-select ds-pw" aria-label="Bank" name="bank">
                                                <option value="">Pilih Bank</option>
                                                @foreach ($bank as $b)
                                                <option value="{{ $b->bank }}" {{ (isset($rek) && $rek->bank ==
                                                    $b->bank) ? "selected" : "" }}>
                                                    {{ $b->bank }}
                                                </option>
                                                @endforeach
                                                <optgroup label="E-money">
                                                    @foreach ($emoney as $b)
                                                    <option value="{{ $b->bank }}" {{ (isset($rek) && $rek->bank ==
                                                        $b->bank) ? "selected" : "" }}>
                                                        {{ $b->bank }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="form-group">
                                            <label>Nama Rekening*</label>
                                            <input class="form-control ds-pw" name="nama" type="text"
                                                value="{{ isset($rek->nama) ? $rek->nama : "" }}"
                                                placeholder="Nama Rekening">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="form-group">
                                            <label>Nomor Rekening*</label>
                                            <input class="form-control ds-pw" name="rek" type="number"
                                                value="{{ isset($rek->rek) ? $rek->rek : "" }}"
                                                placeholder="Nomor Rekening">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="form-group button mb-0">
                                            <button id="submit-button" type="submit" class="btn">
                                                Update Rekening
                                            </button>
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
</section>

<script>
    $(document).ready(function() {
        var submitButton = $('#submit-button');
        var inputs = $('.ds-pw');

        // Memeriksa apakah semua input kosong saat halaman dimuat
        var allFilled = true;

        inputs.each(function() {
            if ($(this).val() === '') {
                allFilled = false;
                return false; // Menghentikan loop jika ada input yang kosong
            }
        });

        submitButton.prop('disabled', !allFilled);

        // Memeriksa setiap perubahan pada input
        inputs.on('keyup', function() {
            var allFilled = true;

            inputs.each(function() {
                if ($(this).val() === '') {
                    allFilled = false;
                    return false; // Menghentikan loop jika ada input yang kosong
                }
            });

            submitButton.prop('disabled', !allFilled);
        });
    });
</script>
<!-- End About Area -->
@endsection