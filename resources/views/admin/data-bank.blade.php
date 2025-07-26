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
                    @include('admin.partial.data-bank')
                </div>
            </div>

        </div>


        <!-- Modal -->
        <div class="modal fade" id="tambahdataModal" aria-labelledby="tambahdataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahdataModalLabel">Tambah Bank</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="tambah-form-modal" action="{{ url('admin/data-bank/store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl">

                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Bank</label>
                                            <input type="text" name="bank" class="form-control" placeholder="Bank">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Nama Bank</label>
                                            <input type="text" name="nama_bank" class="form-control"
                                                placeholder="Nama Bank">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Tipe</label>
                                            <select class="form-select" name="type">
                                                <option value="">- Pilih Tipe -</option>
                                                <option value="bank">Bank</option>
                                                <option value="emoney">Emoney</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="tambah-submit-modal" class="btn btn-primary">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="dataModal" aria-labelledby="dataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataModalLabel">Edit Bank</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form id="form-modal" action="{{ url('admin/data-bank/update') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl">
                                    <input type="hidden" name="id" id="id_data" class="form-control" value="">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Bank</label>
                                            <input type="text" name="bank" id="bank" class="form-control"
                                                placeholder="Bank">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Nama Bank</label>
                                            <input type="text" name="nama_bank" id="nama_bank" class="form-control"
                                                placeholder="Nama Bank">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Tipe</label>
                                            <select class="form-select" name="type" id="type">
                                                <option value="">- Pilih Tipe -</option>
                                                <option value="bank">Bank</option>
                                                <option value="emoney">Emoney</option>
                                            </select>
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
        $('#spinner .spinner-border').hide();
        $(document).off('click', '.pagination li a');
        $(document).on('click', '.pagination li a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data_pagination(page);
        });

        function fetch_data_pagination(page) { 
            $('#spinner .spinner-border').show();
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: 'data-bank/ajax',
                data: { page: page },
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
            var uRL = '{{ route('get_data_bank') }}';

            $.ajax({
                url: uRL,
                data: { id: id, },
                success: function(data) {
                    $('#id_data').val(data.bank.id);
                    $('#bank').val(data.bank.bank);
                    $('#nama_bank').val(data.bank.nama_bank);
                    $('#type').val(data.bank.type);
                }
            });
        });

        $('#tambah-submit-modal').on('click', function() {
            $('#tambah-form-modal').submit();
        });

        $('#submit-modal').on('click', function() {
            $('#form-modal').submit();
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
                    var url = '{{ url("admin/data-bank/destroy") }}';
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