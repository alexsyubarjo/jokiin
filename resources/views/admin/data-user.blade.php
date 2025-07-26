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
                    @include('admin.partial.data-pengguna')
                </div>
            </div>

        </div>


        <!-- Modal -->
        <div class="modal fade" id="dataModal" aria-labelledby="dataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="form-modal" action="{{ url('admin/data-pengguna/update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl">
                                    <input type="hidden" name="id" id="id_data" class="form-control" value="">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="name" id="name" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" id="username" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" id="email" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button id="btn-password" type="button"
                                            class="btn btn-outline-info btn-sm">Ganti
                                            Password</button>
                                    </div>
                                    <div id="d-password" class="mb-3">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="text" name="password" id="password" class="form-control"
                                                value="">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Nomor HP</label>
                                            <input type="text" name="nomor_hp" id="nomor_hp" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Saldo</label>
                                            <input type="text" name="saldo" id="saldo" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Saldo Employer</label>
                                            <input type="text" name="saldo_employer" id="saldo_employer"
                                                class="form-control" value="">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submit-modal" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!--/ Basic Bootstrap Table -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#d-password').hide();
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
                url: 'data-pengguna/ajax',
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

        $(document).on('click', '.dropdown-item#tombol-edit', function() {
            const id = $(this).data('id');
            var uRL = '{{ route('get_data_user') }}';

            $.ajax({
                url: uRL,
                data: { id: id, },
                success: function(data) {
                    $('#id_data').val(data.user.id);
                    $('#name').val(data.user.name);
                    $('#username').val(data.user.username);
                    $('#email').val(data.user.email);
                    $('#nomor_hp').val(data.user.nomor_hp);
                    $('#saldo').val(data.user.saldo);
                    $('#saldo_employer').val(data.user.saldo_employer);
                }
            });

        });

        $("#btn-password").click(function() {
            $("#d-password").toggle();
        });
        $('#submit-modal').on('click', function() {
            $('#form-modal').submit();
        });

        $(document).on('click', '#verif', function() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin mengverifikasi data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Verifikasi',
                cancelButtonText: 'Tutup'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var url = '{{ url("admin/data-pengguna/verif") }}';
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
                            text: 'Berhasil verifikasi data user.',
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
                    var url = '{{ url("admin/data-pengguna/destroy") }}';
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