@extends('layouts.user.appUser')
@section('page', 'Tugas Pending')
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

                        <div class="tab-content mb-5" id="spinner">
                            <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row">
                                    <div class="col-12 text-center pt-5">
                                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"
                                            role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="posts-task" data-url="{{ url('dashboard/task_ajax_employer') }}">
                            @include('user.partial.tugas-pending-load')
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#tombol-bukti').on('click', function() {
        const id = $(this).data('id');
        var uRL = '{{ route('get_data_bukti') }}'

            $.ajax({
                url: uRL,
                data: { id: id, },
                success: function(data) {
                    $('#data-bukti').html(data.partialView);
                }
            });

        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#spinner').hide();
        $(document).off('click', '.pagination-list li a');
        $(document).on('click', '.pagination-list li a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_user_data_pagination(page);
        });

        function fetch_user_data_pagination(page) {
            $('#spinner').show();
            
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: $("#posts-task").data("url"),
                data: { page: page },
                success: function(data) {
                    $('#spinner').hide();
                    $('#posts-task').html(data.partialView);
                    bindPaginationClick();
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

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '#terima', function() {
            // Menampilkan SweetAlert confirmation
            Swal.fire({
                title: 'Apakah Anda yakin ingin menerima?<br/>Tindakan ini akan mengurangi saldo employer anda.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    var id = $(this).data('id');
                    var url = '{{ url("dashboard/tugas_aksi") }}';
                    
                    // Mengirim permintaan AJAX
                    $.ajax({
                        url: url,
                        data: {
                            id: id, aksi: "terima"
                        },
                        success: function(response) {
                            if (response.success === false) {
                                Swal.fire({
                                    title: 'Opss!',
                                    text: response.message,
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: true
                                });
                            } else if (response.success === true) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 500,
                                    showConfirmButton: false
                                }).then(function() {
                                    // Load halaman yang diinginkan setelah SweetAlert ditutup
                                    window.location.href = "{{ url('dashboard/tugas-pending') }}";
                                });
                            }
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

        // Mendengarkan klik pada elemen dengan id "tolak"
        $(document).on('click', '#tolak', function() {
            // Menampilkan SweetAlert confirmation
            Swal.fire({
                title: 'Apakah Anda yakin ingin menolak?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    var id = $(this).data('id');
                    var url = '{{ url("dashboard/tugas_aksi") }}';
                    
                    // Mengirim permintaan AJAX
                    $.ajax({
                        url: url,
                        data: {
                            id: id, aksi: "tolak"
                        },
                        success: function(response) {
                            // Tanggapan berhasil, lakukan tindakan yang sesuai
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Tindakan berhasil dilakukan.',
                                icon: 'success',
                                timer: 500,
                                showConfirmButton: false
                            }).then(function() {
                                // Load halaman yang diinginkan setelah SweetAlert ditutup
                                window.location.href = "{{ url('dashboard/tugas-pending') }}";
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
@endsection