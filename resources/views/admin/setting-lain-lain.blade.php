@extends('layouts.appAdmin')
@section('page', $page)
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-12 mb-4 order-0">

            <h4 class="fw-bold py-3 mb-4">@yield('page')</h4>


            <div class="row">

                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Setting Terms and Conditions</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/lain-lain/update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Terms and Conditions</label>
                                    <textarea type="text" class="form-control tinymce-editor" name="terms" rows="5"
                                        placeholder="Terms and Conditions">{{ $web->terms }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Setting Privacy Policy</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/lain-lain/update-privacy') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Privacy Policy</label>
                                    <textarea type="text" class="form-control tinymce-editor" name="privacy" rows="5"
                                        placeholder="Privacy Policy">{{ $web->privacy }}</textarea>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 450,
        menubar: false,
    });
</script>
@endsection