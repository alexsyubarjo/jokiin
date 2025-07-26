@extends('layouts.user.appUser')
@section('page', 'Tugasku')
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
                        <nav id="nav-status" class="list-nav">
                            <ul>
                                <li class="">
                                    <a href="{{ url('dashboard/task') }}">Semua <span>{{ number_format($jumlahTugas, 0,
                                            ',', '.') }}</span></a>
                                </li>

                                <li class="">
                                    <a href="{{ url('dashboard/task?status=selesai') }}">
                                        Selesai <span>{{ number_format($Count1, 0, ',', '.') }}</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('dashboard/task?status=pending') }}">
                                        Pending <span>{{ number_format($Count2, 0, ',', '.') }}</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('dashboard/task?status=ditolak') }}">
                                        Ditolak <span>{{ number_format($Count3, 0, ',', '.') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

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

                        <div id="posts-task" data-url="{{ url('dashboard/task_ajax') }}">
                            @include('user.partial.tugas-load')
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="buktiModal" aria-labelledby="buktiModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buktiModalLabel">File Bukti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="data-bukti"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    console.log(data);
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
            var link = document.createElement('a');
            link.href = window.location.href;
            var searchParams = new URLSearchParams(link.search);

            var statusValue = searchParams.get("status");

            var currentPath = window.location.pathname;
            var newPath = currentPath + (currentPath.endsWith('/') ? '' : '?') + (statusValue ? 'status=' + statusValue : '');

            $('#spinner').show();
            
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: $("#posts-task").data("url"),
                data: { status: statusValue, page: page },
                success: function(data) {
                    $('#spinner').hide();
                    $('#posts-task').html(data.partialView);
                    window.history.pushState(null, null, newPath);
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
        // Mendapatkan URL saat ini
        var currentUrl = window.location.href;

        // Memeriksa apakah URL mengandung "/dashboard/task/selesai"
        if (currentUrl.indexOf("/dashboard/task?status=selesai") !== -1) {
            // Menambahkan kelas "active" pada elemen navigasi dengan href yang sesuai
            $("#nav-status ul li:nth-child(2)").addClass("active");
        } else if (currentUrl.indexOf("/dashboard/task?status=pending") !== -1) {
            // Menambahkan kelas "active" pada elemen navigasi dengan href yang sesuai
            $("#nav-status ul li:nth-child(3)").addClass("active");
        } else if (currentUrl.indexOf("/dashboard/task?status=ditolak") !== -1) {
            // Menambahkan kelas "active" pada elemen navigasi dengan href yang sesuai
            $("#nav-status ul li:nth-child(4)").addClass("active");
        } else {
            // Menambahkan kelas "active" pada elemen navigasi dengan href "/dashboard/task"
            $("#nav-status ul li:first-child").addClass("active");
        }
    });

</script>
@endsection