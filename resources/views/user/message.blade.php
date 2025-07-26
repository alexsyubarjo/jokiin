@extends('layouts.user.appUser')
@section('page', 'Pesan')
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
                    <div class="dashboard-block mt-0 pb-0">
                        <h3 class="block-title mb-0">@yield('page')</h3>

                        <div class="messages-body">
                            <div class="form-head">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-12">
                                        <div id="search-btn" class="chat-search-form">
                                            <input id="search" type="text" placeholder="Cari nama" name="search">
                                            <button value="search" type="submit">
                                                <i class="lni lni-search-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="label-chat"
                                        class="col-lg-7 col-12 align-left d-none d-sm-none d-lg-block d-md-block">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5 col-12">

                                    <div class="user-list">
                                        <ul>

                                            @foreach ($messages as $m)
                                            <li class=" d-flex align-items-center">
                                                <a id="user-sender" class="user-sender" href="javascript:void(0)"
                                                    onclick="openChat({{ $m->id }}, {{ auth()->id() }})">
                                                    <div
                                                        class="image {{ Cache::has('user-online' . $m->id) ? '' : 'busy' }}">
                                                        @if ($m->avatar)
                                                        <img src="{{ asset('storage/users-avatar/' . $m->avatar) }}"
                                                            alt="#">
                                                        @else
                                                        <img src="{{ asset('storage/images/default.jpg') }}" alt="#">
                                                        @endif
                                                    </div>
                                                    <span class="username fw-bold">{{ $m->name }}</span>
                                                    <span class="short-message">{{ implode(' ', array_slice(explode(' ',
                                                        $m->latestMessage->content), 0, 10)) }}...</span>

                                                    @if ($m->unseen_message_count)
                                                    <span class="unseen-message">{{ $m->unseen_message_count }}</span>
                                                    @endif
                                                </a>
                                                <button id="hapus-pesan" class="btn btn-xs me-2" type="button"
                                                    data-sen="{{ $m->id }}" data-rec="{{ auth()->id() }}">
                                                    <i class="lni lni-trash"></i>
                                                </button>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </div>

                                </div>
                                <div class="col-lg-7 col-12">

                                    <div id="spinner" class="col-12 text-center mt-5">
                                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"
                                            role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <div id="data-load"></div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
<!-- End About Area -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#data-load').hide();
        $('#spinner').hide();
    });
   
    $(document).on('click', '#user-sender', function() {
        $(".user-sender").css("background-color", "");
        $(this).css("background-color", "#c7c6c7");
        $.ajax({
            url: '{{ url("dashboard/chat_seen") }}',
            data: { id: page },
            success: function(data) {
            },
        });
    });

    $(document).on('click', '#hapus-pesan', function() {
        // Menampilkan SweetAlert confirmation
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus pesan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                
                var sen = $(this).data('sen');
                var rec = $(this).data('rec');
                var url = '{{ url("dashboard/hapus_chat") }}';
                
                // Mengirim permintaan AJAX
                $.ajax({
                    url: url,
                    data: {
                        sen: sen, rec: rec
                    },
                    success: function(response) {
                        // Tanggapan berhasil, lakukan tindakan yang sesuai
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil Menghapus Pesan.',
                            icon: 'success',
                            timer: 500,
                            showConfirmButton: false
                        }).then(function() {
                            // Load halaman yang diinginkan setelah SweetAlert ditutup
                            window.location.href = "{{ url('dashboard/pesan') }}";
                        });
                    },
                    error: function(xhr) {
                        // Tanggapan error, tampilkan pesan kesalahan
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan. Silakan coba lagi.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    function openChat(senderId, receiverId) {
        var uRL = '{{ url('dashboard/chat_ajax') }}';

        $('#spinner').show();
        
        $.ajax({
            url: uRL,
            data: { id_sen: senderId, id_rec: receiverId },
            success: function(data) {
                    $('#spinner').hide();
                    $('#data-load').show();
                    $('#label-chat').html(data.label);
                    $('#data-load').html(data.partialView);
                    $("#send-id").val(data.senId);
                }
        });
    }

    // Fungsi untuk melakukan pencarian pengguna
    function searchUsers(keyword) {
        $('.user-list ul li').each(function() {
            var username = $(this).find('.username').text();

            if (username.toLowerCase().includes(keyword.toLowerCase())) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Event delegation untuk pencarian pengguna
    $('.messages-body').on('click', '#search-btn button', function() {
        var keyword = $('#search').val();
        searchUsers(keyword);
    });

    $('.messages-body').on('keypress', '#search', function(event) {
        if (event.keyCode === 13) {
            var keyword = $(this).val();
            searchUsers(keyword);
            event.preventDefault();
        }
    });
    $('#search').keyup(function() {
        var keyword = $(this).val();
        searchUsers(keyword);
    });
</script>

@endsection