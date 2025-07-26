@extends('layouts.appAdmin')
@section('page', $page)
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-12 mb-4 order-0">

            <h4 class="fw-bold py-3 mb-4">@yield('page')</h4>


            <div class="row">

                <div class="col-lg-8 offset-lg-2">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Setting Duitku</h5>
                            {{-- <small class="text-muted float-end">Default label</small> --}}
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/setting-payment/update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Url Callback</label>
                                    <div class="input-group">
                                        <input type="text" id="callback-value" class="form-control"
                                            value="{{ url('/callback/duitku') }}" readonly>
                                        <button class="btn btn-outline-primary" type="button" id="callback">
                                            <i class="bx bx-copy"></i> Copy
                                        </button>
                                    </div>
                                    
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Merchant Code</label>
                                    <input type="text" class="form-control" name="merchant_code"
                                        placeholder="Merchant Code" value="{{ $pay->merchant_code }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">API Key</label>
                                    <input type="text" class="form-control" name="api_key" placeholder="API Key"
                                        value="{{ $pay->api_key }}">
                                </div>
                                {{-- <div class="mb-3">
                                    <label class="form-label">Private Key</label>
                                    <input type="text" class="form-control" name="private_key" placeholder="Private Key"
                                        value="{{ $pay->private_key }}">
                                </div> --}}
                                <div class="mb-3">
                                    <label class="form-label">Mode Endpoint</label>
                                    <select class="form-select" aria-label="Select Option" name="mode">
                                        <option value="">- Pilih Mode -</option>
                                        <option value="Sanbox" {{ (isset($pay) && $pay->mode == "Sanbox") ? "selected" :
                                            "" }}>Sanbox</option>
                                        <option value="Production" {{ (isset($pay) && $pay->mode == "Production") ?
                                            "selected" : "" }}>Production</option>
                                    </select>

                                </div>
                                <div class="mb-4">
                                    <div class="custom-control custom-switch mb-3">
                                        <div class="form-check form-switch">
                                            <input id="status" class="form-check-input" type="checkbox" name="status"
                                                role="switch" @if ($pay->status == 'on') checked @endif>
                                            <label class="custom-control-label ms-2" for="status">Aktifkan
                                                Payment</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</div>
<!--/ Basic Bootstrap Table -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#callback').click(function() {
            var callback = $('#callback-value').val();
            copyToClipboard(callback);
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
    });
</script>
@endsection