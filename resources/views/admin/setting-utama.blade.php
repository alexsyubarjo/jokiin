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
                            <h5 class="mb-0">Setting Website</h5>
                            {{-- <small class="text-muted float-end">Default label</small> --}}
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/setting-utama/update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nama Website</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Website"
                                        value="{{ $web->website_name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea type="text" class="form-control" name="keyword" rows="5"
                                        placeholder="Meta Keywords">{{ $web->meta_keywords }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Meta Deskripsi</label>
                                    <textarea type="text" class="form-control" name="deskripsi" rows="5"
                                        placeholder="Meta Deskripsi">{{ $web->meta_description }}</textarea>
                                </div>
                                <div class="row mb-3">
                                    <label class="form-label col-12">Minimal Withdraw</label>

                                    <div class="col-xl input-group input-group-merge">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="min_wd"
                                            placeholder="Minimal Withdraw" value="{{ $web->min_wd }}">
                                    </div>

                                    <div class="col-xl input-group input-group-merge">
                                        <input type="number" class="form-control" name="wd" placeholder="Persentase"
                                            value="{{ $web->wd }}">
                                        <span class="input-group-text" id="basic-addon33">%</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">About Us</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/setting-utama/update-about-us') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">About Us</label>
                                    <textarea type="text" class="form-control tinymce-editor" name="about_us"
                                        placeholder="About Us">{{ $web->about_us }}</textarea>
                                </div>

                                <button id="submit-button" type="submit" class="btn btn-primary">Update</button>
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