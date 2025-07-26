@extends('layouts.user.appUser')
@section('page', 'Riwayat Deposit')
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
                            @include('user.partial.riwayat-deposit')
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
            var link = '{{ url("dashboard/riwayat-deposit-ajax") }}';

            $('#spinner').show();
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: link,
                data: { page: page },
                success: function(data) {
                    console.log(data);
                    $('#spinner').hide();
                    if (data && data.partialView) {
                        $('#data-load').html(data.partialView);

                        $('.title-no').each(function(index) {
                            var itemId = 'number_' + index;
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

        $('#invoice').click(function() {
            // Mengambil teks dari elemen dengan id "invoice"
            var invoiceText = $(this).text();

            // Menyalin teks ke clipboard
            navigator.clipboard.writeText(invoiceText)
            .then(function() {
                // Menampilkan pesan SweetAlert berhasil
                Swal.fire({
                    icon: 'success',
                    text: 'Teks berhasil disalin ke clipboard!',
                    timer: 2000, // Durasi pesan pemberitahuan dalam milidetik
                    showConfirmButton: false // Menyembunyikan tombol OK
                });
            })
            .catch(function(error) {
                // Menampilkan pesan SweetAlert gagal
                Swal.fire({
                    icon: 'error',
                    text: 'Gagal menyalin teks ke clipboard.',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });

        $(document).on('click', '#invoice-oto', function() {
            var id = $(this).data('id');
            var amount = $(this).data('amount');

            checkout.process(id, {
                defaultLanguage: "id", 
                successEvent: function (result) {
                    var kode = result.merchantOrderId;
                    var reference = result.reference;

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
                }
            }); 
        });
        
    });
</script>


@endsection