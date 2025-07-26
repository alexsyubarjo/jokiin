@extends('layouts.appHome')
@section('page', 'Reset Password')
@section('content')

<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
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
</div>
<!-- End Breadcrumbs -->

<section class="reset-password section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $target->email ?? old('email') }}" required autocomplete="email"
                                        readonly>

                                    @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                    }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control ds-pw @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">

                                    @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm
                                    Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control ds-pw"
                                        name="confirm_password" required autocomplete="new-password">
                                    <div class="invalid-feedback" role="alert" id="password-confirmation-error"></div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="submit-button" class="btn btn-ungu">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {
        var passwordInput = $('#password');
        var confirmPasswordInput = $('#password-confirm');
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

@endsection