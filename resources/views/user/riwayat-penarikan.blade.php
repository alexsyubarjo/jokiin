@extends('layouts.user.appUser')
@section('page', 'Riwayat Penarikan')
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

            <div class="col-lg-9 col-md-12 col-12">
                <div class="main-content">
                    <div class="dashboard-block mt-0">
                        <h3 class="block-title">@yield('page')</h3>

                        <div id="spinner" class="col-12 text-center mt-5">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div id="data-load">
                            @include('user.partial.log-saldo')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->
<script>
    $(document).ready(function() {
        $('#spinner').hide();
        $(document).off('click', '.pagination-list li a');
        $(document).on('click', '.pagination-list li a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_user_data_pagination(page);
        });



        function fetch_user_data_pagination(page) {
            var link = '{{ url("dashboard/pagination/LogSaldo") }}';

            $('#spinner').show();
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: link,
                data: { page: page },
                success: function(data) {
                    $('#spinner').hide();
                    if (data && data.partialView) {
                        var startingNumber = data.startingNumber;
                        $('#data-load').html(data.partialView);

                        $('.title-no').each(function(index) {
                            var itemId = 'number_' + index;
                            $('#' + itemId).text(startingNumber + index);
                        });

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


@endsection