@extends('layouts.user.appUser')
@section('page', 'Referral')
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
                                    <div class="alert alert-info" role="alert">
                                        Dapatkan penghasilan tambahan melalui program refferal/affiliate {{
                                        $web->website_name }}. Anda akan mendapatkan komisi <strong>5%</strong> dari
                                        setiap transaksi Withdraw yang bergabung melalui link referal Anda.
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Url Affiliate</label>
                                                <div class="input-group">
                                                    <input type="text" id="referral-value" class="form-control"
                                                        value="{{ url('/register/'.$user->kode_referral) }}" readonly>
                                                    <button class="btn btn-outline-primary" type="button" id="referral">
                                                        <i class="lni lni-clipboard"></i>Copy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <form method="POST" action="{{ route('update.referral') }}">
                                                    @csrf
                                                    <label class="form-label">Kode Referral</label>
                                                    <div class="input-group">
                                                        <input type="text" id="referral-value" name="referral"
                                                            class="form-control" value="{{ $user->kode_referral }}">
                                                        <button class="btn btn-outline-primary" type="submit"
                                                            id="referral">
                                                            <i class="lni lni-spinner-arrow"></i> Ubah Referral
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card">
                                        <div class="card-header">
                                            <h6 style="display: inline-block; margin: 0;">Referral : {{
                                                number_format($dataReff->count(), 0, ',','.') }} User</h6>
                                            <h6 class="float-end">Komisi: Rp. {{ number_format($dataReff->sum('komisi'),
                                                0, ',','.') }}</h6>
                                        </div>
                                        <div class="card-body">

                                            <div class="tab-content mb-5" id="spinner">
                                                <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                                    aria-labelledby="nav-grid-tab">
                                                    <div class="row">
                                                        <div class="col-12 text-center pt-5">
                                                            <div class="spinner-border text-primary"
                                                                style="width: 3rem; height: 3rem;" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="data-load">
                                                @include('user.partial.referral-load')
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
        $('#referral').click(function() {
            var referral = $('#referral-value').val();
            copyToClipboard(referral);
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

        $('#spinner').hide();
        $(document).off('click', '.pagination-list li a');
        $(document).on('click', '.pagination-list li a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_user_data_pagination(page);
        });



        function fetch_user_data_pagination(page) {
            var link = '{{ url("dashboard/referral/Ajax") }}';

            $('#spinner').show();
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: link,
                data: { page: page },
                success: function(data) {
                    console.log(data);
                    $('#spinner').hide();
                    if (data && data.partialView) {
                        var startingNumber = data.startingNumber;
                        $('#data-load').html(data.partialView);
                        bindPaginationClick();
                    } else {
                        console.error('Invalid AJAX response');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', error);
                    // Handle the error condition or display an error message
                }
            });
        }

        function bindPaginationClick() {
            $(document).off('click', '.pagination-list li a');
            $(document).on('click', '.pagination-list li a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_user_data_pagination(page);
            });
        }
    });
</script>



<!-- End About Area -->
@endsection