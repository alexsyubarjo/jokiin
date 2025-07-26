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
                    @include('admin.partial.data-tugas')
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="dataModal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">
                        Data Bukti
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody id="data-bukti-modal"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>\
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">
                        Edit Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">

                            <form id="form-modal" action="{{ url('admin/data-tugas/update-status') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" id="id_data" value="">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="">- Pilih Status -</option>
                                        <option value="1">Selesai</option>
                                        <option value="2">Pending</option>
                                        <option value="3">Ditolak</option>
                                    </select>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit-modal" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                url: 'data-tugas/ajax',
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

        $(document).on('click', '#data-bukti', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'data-tugas/modal-ajax',
                data: { id: id },
                success: function(data) {
                    $('#data-bukti-modal').html(data.partialView);
                }
            });
        });

        
        $('#submit-modal').on('click', function() {
            $('#form-modal').submit();
        });

        $(document).on('click', '.dropdown-item#data-edit', function() {
            const id = $(this).data('id');
            var uRL = '{{ route('get_data_tugas') }}';

            $.ajax({
                url: uRL,
                data: { id: id, },
                success: function(data) {
                    var statusValue = data.tugas.status;

                    $('#id_data').val(data.tugas.id);
                    $('#status').val(statusValue);
                    
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
                    var url = '{{ url("admin/data-tugas/destroy") }}';
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