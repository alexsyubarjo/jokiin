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
                            <h5 class="mb-0">Setting Sosial Media</h5>
                            {{-- <small class="text-muted float-end">Default label</small> --}}
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/media-sosial/update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" placeholder="Facebook"
                                        value="{{ $soc->facebook }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" placeholder="Instagram"
                                        value="{{ $soc->instagram }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Whatsapp</label>
                                    <input type="text" class="form-control" id="wa-number" name="whatsapp"
                                        placeholder="Whatsapp" value="{{ $soc->whatsapp }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telegram</label>
                                    <input type="text" class="form-control" name="telegram" placeholder="Telegram"
                                        value="{{ $soc->telegram }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" name="twitter" placeholder="Twitter"
                                        value="{{ $soc->twitter }}">
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
        $('#wa-number').on('input', function() {
        var inputValue = $(this).val();

        // Mencegah input "62" di awal
        if (inputValue.startsWith("62")) {
          inputValue = inputValue.slice(2);
          $(this).val(inputValue);
        }
        if (inputValue.length > 0 && inputValue.charAt(0) !== "0") {
          $(this).val(inputValue.substr(1));
        }
      });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 450,
        menubar: false,
    });
</script>
@endsection