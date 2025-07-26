@extends('layouts.user.appUser')
@section('page', 'Data Jobs')
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

                        <div class="row card-body align-items-center mb-5 mt-3">
                            <div class="col-md-6">
                                <h5 class="card-title"><i class="lni lni-list"></i> @yield('page')</h5>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <a href="{{ route('posts.create') }}" class="btn btn-ungu btn-sm">
                                    <i class="lni lni-circle-plus"></i> Posting Tugas
                                </a>
                            </div>
                        </div>

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

                        <div id="posts-tugas" data-url="{{ url('dashboard/data-tugas-ajax') }}">
                            @include('user.partial.data-tugas-load')
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
                url: $("#posts-tugas").data("url"),
                data: { page: page },
                success: function(data) {
                    $('#spinner').hide();
                    $('#posts-tugas').html(data.partialView);
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

        $(document).on('click', '#hapus', function() {
            // Menampilkan SweetAlert confirmation
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data tugas ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var url = '{{ route("posts.destroy", [":post"]) }}';
                    url = url.replace(':post', id);
                    var token = $("meta[name='csrf-token']").attr("content");
                    
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function(response) {
                            // Tanggapan berhasil, lakukan tindakan yang sesuai
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Berhasil menghapus data tugas.',
                                icon: 'success',
                                timer: 500,
                                showConfirmButton: false
                            }).then(function() {
                                // Load halaman yang diinginkan setelah SweetAlert ditutup
                                window.location.href = "{{ url('dashboard/posts') }}";
                            });
                        }
                    });
                }
            });
        });

    });
</script>
@endsection