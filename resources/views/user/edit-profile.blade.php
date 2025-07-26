@extends('layouts.user.appUser')
@section('page', 'Setting Profile')
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

                    <div class="dashboard-block mt-0 profile-settings-block">
                        <h3 class="block-title">@yield('page')</h3>

                        <div class="inner-block">
                            <div class="image">
                                @if ($user->avatar)
                                <img src="{{ asset('storage/users-avatar/' . $user->avatar) }}" alt="#"
                                    data-pagespeed-url-hash="2750445946">
                                @else
                                <img src="{{ asset('storage/images/default.jpg') }}" alt="#">
                                @endif
                            </div>
                            <form class="profile-setting-form" method="post"
                                action="{{ url('dashboard/edit-profile-post') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Lengkap*</label>
                                            <input class="form-control @error('name') is-invalid @enderror" name="name"
                                                type="text" placeholder="Steve" value="{{ $user->name }}">
                                            @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Username*</label>
                                            <input class="form-control @error('username') is-invalid @enderror"
                                                name="username" type="text" placeholder="@username"
                                                value="{{ $user->username }}">
                                            @error('username')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label>Email Address*</label>
                                            <input class="form-control @error('email') is-invalid @enderror"
                                                name="email" type="email" placeholder="username@gmail.com"
                                                value="{{ $user->email }}">
                                            @error('email')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group upload-image">
                                            <label>Profile Image</label>
                                            <input class="form-control" name="profile_image" type="file"
                                                placeholder="Upload Image">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group button mb-0">
                                            <button type="submit" class="btn">Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="dashboard-block password-change-block">
                        <h3 class="block-title">Ubah Password</h3>
                        <div class="inner-block">
                            <form id="form-password" class="default-form-style" method="post"
                                action="{{ url('dashboard/password-reset') }}">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Password Saat Ini*</label>
                                            <input name="current-password" type="password"
                                                placeholder="Enter old password"
                                                class="ds-pw form-control @error('current-password') is-invalid @enderror">
                                            @error('current-password')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Password Baru*</label>
                                            <input id="new-password" name="new-password" type="password"
                                                placeholder="Enter new password"
                                                class="ds-pw form-control @error('new-password') is-invalid @enderror">
                                            @error('new-password')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Ketik Ulang Password*</label>
                                            <input id="password-confirmation" name="password-confirmation"
                                                type="password" placeholder="Retype password"
                                                class="ds-pw form-control">

                                            <div class="invalid-feedback" role="alert" id="password-confirmation-error">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group button mb-0">
                                            <button id="submit-button" type="submit" class="btn">Update
                                                Password</button>
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
</section>

<script>
    $(document).ready(function() {
        var passwordInput = $('#new-password');
        var confirmPasswordInput = $('#password-confirmation');
        var submitButton = $('#submit-button');
        var inputs = $('.ds-pw');

        var allFilled = true;

        inputs.each(function() {
            if ($(this).val() === '') {
                allFilled = false;
                return false; // Menghentikan loop jika ada input yang kosong
            }
        });

        submitButton.prop('disabled', !allFilled);

        inputs.on('keyup', function() {
            var allFilled = true;

            inputs.each(function() {
                if ($(this).val() === '') {
                    allFilled = false;
                    return false; // Menghentikan loop jika ada input yang kosong
                }
            });

            var password = passwordInput.val();
            var confirmPassword = confirmPasswordInput.val();

            if (password === confirmPassword) {
                confirmPasswordInput.removeClass('is-invalid');
                $('#password-confirmation-error').text('');
            } else {
                confirmPasswordInput.addClass('is-invalid');
                $('#password-confirmation-error').text('Konfirmasi password tidak sesuai.');
                allFilled = false; // Set allFilled menjadi false jika konfirmasi password tidak sesuai
            }

            submitButton.prop('disabled', !allFilled);
        });
    });
</script>



<!-- End About Area -->
@endsection