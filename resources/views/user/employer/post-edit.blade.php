@extends('layouts.user.appUser')
@section('page', 'Edit Tugas')
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

            <div class="col-lg-9 col-md-8 col-12">
                <div class="main-content">

                    <div class="dashboard-block mt-0">
                        <div class="row card-body align-items-center mb-5 mt-2">
                            <div class="col-md-6">
                                <h5 class="card-title"><i class="lni lni-list"></i> @yield('page')</h5>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <a href="{{ route('posts.index') }}" class="btn btn-ungu btn-sm">
                                    <i class="lni lni-list"></i> Data Tugas
                                </a>
                            </div>
                        </div>
                        <div class="inner-block">

                            <div class="post-ad-tab">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-item-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-item-info" type="button" role="tab"
                                            aria-controls="nav-item-info" aria-selected="true">
                                            <span class="serial">01</span>
                                            Step
                                            <span class="sub-title">Tambah Informati</span>
                                        </button>
                                        <button class="nav-link" id="nav-item-details-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-item-details" type="button" role="tab"
                                            aria-controls="nav-item-details" aria-selected="false">
                                            <span class="serial">02</span>
                                            Step
                                            <span class="sub-title">Tambah Detail</span>
                                        </button>
                                        <button class="nav-link" id="nav-user-info-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-user-info" type="button" role="tab"
                                            aria-controls="nav-user-info" aria-selected="false">
                                            <span class="serial">03</span>
                                            Step
                                            <span class="sub-title">Tambah Bukti</span>
                                        </button>
                                    </div>
                                </nav>
                                <form class="default-form-style" method="post"
                                    action="{{ route('posts.update', ['post' => $post->id]) }}"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-item-info" role="tabpanel"
                                            aria-labelledby="nav-item-info-tab">

                                            <div class="step-one-content">
                                                <div class="default-form-style">
                                                    <div class="row">

                                                        <div class="col-lg-6 offset-lg-3 mb-3">
                                                            <div class="upload-input">
                                                                <input type="file" id="upload" name="image">
                                                                <label for="upload" class="text-center content">
                                                                    <div class="text upload-img">
                                                                        @if($post->image && !filter_var($post->image, FILTER_VALIDATE_URL))
                                                                        <img src="{{ asset('storage/posts/'.$post->image) }}"
                                                                            alt="{{ $post->title }}" height="235">
                                                                        @else
                                                                        <span class="d-block mb-15">Gambar Post
                                                                            Tugas</span>
                                                                        <span class=" mb-15 plus-icon"><i
                                                                                class="lni lni-plus"></i></span>
                                                                        <span class="main-btn d-block btn-hover">Pilih
                                                                            File</span>
                                                                        <span class="d-block">Maksimal Ukuran File
                                                                            5Mb</span>
                                                                        @endif
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Judul Tugas*</label>
                                                                <input name="title" type="text"
                                                                    placeholder="Ketik Judul"
                                                                    value="{{ $post->title }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Kategori*</label>
                                                                <div class="selector-head">
                                                                    <span class="arrow">
                                                                        <i class="lni lni-chevron-down"></i>
                                                                    </span>
                                                                    <select name="kategori" class="user-chosen-select">
                                                                        <option value="">- Pilh Kategori -</option>
                                                                        @foreach ($kategori as $k)
                                                                        <option value="{{ $k->id }}" @if($post->
                                                                            category_id==$k->id) selected
                                                                            @endif>{{ $k->name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group button mb-0">
                                                                <button id="lanjut1" type="button" class="btn">Lanjut
                                                                    Step</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="nav-item-details" role="tabpanel"
                                            aria-labelledby="nav-item-details-tab">

                                            <div class="step-two-content">
                                                <div class="default-form-style">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label>Jumlah Tugas*</label>
                                                                <input id="jumlah" name="jumlah" type="text"
                                                                    placeholder="Jumlah tugas"
                                                                    value="{{ $post->jumlah }}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="form-group">
                                                                <label>Komisi*</label>
                                                                <input id="komisi" name="komisi" type="text"
                                                                    placeholder="Komisi" value="{{ $post->komisi }}"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group mt-30">
                                                                <label>Tambah Deskripsi*</label>
                                                                <textarea class="tinymce-editor" name="content">
                                                                    {{ $post->content }}
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group button mb-0">
                                                                <button id="kembali1" type="button"
                                                                    class="btn alt-btn">Kembali</button>
                                                                <button id="lanjut2" type="button" class="btn ">Lanjut
                                                                    Step</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="nav-user-info" role="tabpanel"
                                            aria-labelledby="nav-user-info-tab">

                                            <div class="step-three-content">
                                                <div class="default-form-style">
                                                    <div class="row">

                                                        <div class="col-lg-8 offset-lg-2">
                                                            <div class="card">

                                                                <div
                                                                    class="card-header d-flex justify-content-between align-items-center">
                                                                    <h5 class="mb-0">Judul Form Bukti</h5>
                                                                    <button id="tambah-bukti"
                                                                        class="btn btn-outline btn-ungu" type="button">
                                                                        <i class="lni lni-circle-plus"></i> Tambah
                                                                    </button>
                                                                </div>


                                                                <div id="body-bukti" class="card-body">

                                                                    @foreach ($file_form as $key => $value)
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Ketik Judul Bukti"
                                                                            name="form_bukti[]" id="form-bukti-satu"
                                                                            value="{{ $value }}">
                                                                    </div>
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-5">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    Agree to our <a target="_blank"
                                                                        href="{{ url('terms_and_conditions') }}">Terms
                                                                        and
                                                                        Conditions</a>
                                                                </label>
                                                            </div>
                                                            <div class="form-group button mb-0">
                                                                <button id="kembali2" type="button"
                                                                    class="btn alt-btn">Kembali</button>
                                                                <button id="submit" type="submit" class="btn ">Submit
                                                                    Tugas</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->

<script>
    $(document).ready(function() {
        $("#lanjut1, #kembali2").click(function() {
            $("#nav-item-details-tab").trigger("click");
        });
        $("#kembali1").click(function() {
            $("#nav-item-info-tab").trigger("click");
        });
        $("#lanjut2").click(function() {
            $("#nav-user-info-tab").trigger("click");
        });

        $('#jumlah, #komisi').on('keyup', function() {
            // Mengambil nilai input
            var inputVal = $(this).val();

            // Menghapus semua karakter kecuali angka
            var numericVal = inputVal.replace(/\D/g, '');

            // Memformat nilai dengan titik sebagai pemisah ribuan
            var formattedVal = numericVal.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Memasukkan nilai yang diformat kembali ke input
            $(this).val(formattedVal);
        });

        $("#upload").change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
            var image = $('<img>').attr('src', e.target.result).attr('alt', 'Gambar').addClass('img-fluid').css('height', '235px');
            $(".text").empty().append(image);
            };
            reader.readAsDataURL(file);
        });
 
        var buktiCount = 1;
        $('#tambah-bukti').click(function() {
            if (buktiCount >= 5) {
                Swal.fire({
                        title: 'Max 5',
                        text: 'Maksimal 5 bukti telah dicapai.',
                        icon: 'warning',
                        button: "Oke",
                    });
                return;
            }
            $('#form-bukti-satu').attr('placeholder', 'Ketik Judul Bukti 1');
            var newBuktiHTML =
            '<div class="input-group mb-3">' +
            '<input type="text" class="form-control" name="form_bukti[]" id="form-bukti" placeholder="Ketik Judul Bukti ' + (buktiCount + 1) + '">' +
            '<button class="delete-bukti btn btn-outline btn-danger" type="button">' +
            '<i class="lni lni-circle-minus"></i>' +
            '</button>' +
            '</div>';

        $('#body-bukti').append(newBuktiHTML);
        buktiCount++;
        });

        $(document).on('click', '.delete-bukti', function() {
            $(this).closest('.input-group').remove();
            buktiCount--;
        });

        $('#flexCheckDefault').change(function() {
            $('#submit').prop('disabled', !$(this).is(':checked'));
        });

        $('#submit').prop('disabled', true);
    });
</script>

{{-- <script src="{{ url('vendor/tinymce.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea.tinymce-editor',
        height: 300,
        menubar: false,
    });
</script>
@endsection