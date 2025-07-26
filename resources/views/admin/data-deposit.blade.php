@extends('layouts.appAdmin')
@section('page', $page)
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-12 mb-4 order-0">

            <h4 class="fw-bold py-3 mb-4">@yield('page')</h4>


            <div class="card">
                <div id="spinner" class="spinner d-flex justify-content-center align-items-center">
                    <div class="col-12 text-center">
                        <div class="spinner-border text-primary mt-5" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div id="data-tabel">
                    @include('admin.partial.data-deposit')
                </div>
            </div>

        </div>
    </div>
</div>
<!--/ Basic Bootstrap Table -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#spinner .spinner-border').hide();
        $(document).off('click', '.pagination li a');
        $(document).on('click', '.pagination li a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data_pagination(page);
        });

        function fetch_data_pagination(page) {
            var currentUrl = window.location.href; // Get the current URL
            var urlParts = currentUrl.split('/'); // Split the URL by '/'
            var dataUrl = urlParts[urlParts.length - 1]; // Get the last part of the URL
            
            $('#spinner .spinner-border').show();
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: 'data-deposit-ajax',
                data: { url: dataUrl, page: page },
                success: function(data) {
                    $('#spinner .spinner-border').hide();
                    $('#data-tabel').html(data.partialView);
                    bindPaginationClick();
                }
            });
        }

        function bindPaginationClick() {
            $(document).off('click', '.pagination li a');
            $(document).on('click', '.pagination li a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data_pagination(page);
            });
        }

        
        $(document).on('click', '#data-konfirmasi', function() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin mengkonfirmasi data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Konfirmasi',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var tipe = "konfirmasi";
                    var url = '{{ url("admin/data-deposit/update-status") }}';
                    var token = "{{ csrf_token() }}";

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            "id": id,
                            "tipe": tipe,
                            "_token": token,
                        },
                        success: function(response) {
                            Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil mengkonfirmasi data.',
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
                            }).then(function() {
                            location.reload();
                            });
                        }
                    });

                }
            });
        });
        
        $(document).on('click', '#data-cancel', function() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin membatalkan data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var tipe = "cancel";
                    var url = '{{ url("admin/data-deposit/update-status") }}';
                    var token = "{{ csrf_token() }}";

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            "id": id,
                            "tipe": tipe,
                            "_token": token,
                        },
                        success: function(response) {
                            Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil membatalkan data.',
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
                            }).then(function() {
                            location.reload();
                            });
                        }
                    });

                }
            });
        });

        
        $(document).on('click', '#hapus', function() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var url = '{{ url("admin/data-deposit/destroy") }}';
                    var token = "{{ csrf_token() }}";

                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function(response) {
                            Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil menghapus data.',
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
                            }).then(function() {
                            location.reload();
                            });
                        }
                    });

                }
            });
        });
    });
</script>

@endsection