@extends('layouts.appHome')
@section('page', 'Registration')
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
<section class="login registration section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                <div class="form-head">
                    <h4 class="title">@yield('page')</h4>


                    {{-- <div class="socila-login">
                        <ul>
                            <li><a href="{{ url('auth/facebook') }}" class="facebook"><i
                                        class="lni lni-facebook-original"></i>Import
                                    From Facebook</a></li>
                            <li><a href="{{ url('auth/google') }}" class="google"><i class="lni lni-google"></i>Import
                                    From Google
                                    Plus</a>
                            </li>
                        </ul>
                    </div>
                    <div class="alt-option">
                        <span>Or</span>
                    </div> --}}

                    <form action="{{ route('register') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') ?? '' }}"
                                class="@error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username') }}"
                                class="@error('username') is-invalid @enderror">
                            @error('username')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="@error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password"
                                class="@error('password') is-invalid @enderror">
                            @error('password')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="@error('password_confirmation') is-invalid @enderror">


                            <div class="invalid-feedback" role="alert" id="password-confirmation-error"></div>
                            @error('password_confirmation')
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="check-and-pass">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox"
                                            class="form-check-input width-auto @error('terms') is-invalid @enderror"
                                            id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="terms">
                                            Agree to our <a target="_blank"
                                                href="{{ url('terms_and_conditions') }}">Terms and
                                                Conditions</a>
                                        </label>
                                        @error('terms')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button">
                            <button type="submit" class="btn" id="btn-submit">Registration</button>
                        </div>
                        <p class="outer-link">Already have an account? <a href="{{ url('login') }}"> Login Now</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        var submitButton = $('#btn-submit');
        $('#password, #password_confirmation').on('keyup', function() {
            var allFilled = true;
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();

            if (password.length < 6) {
                $('#password').addClass('is-invalid');
                $('#password_confirmation').addClass('is-invalid');
                $('#password-confirmation-error').text('Password minimal 8 karakter.');
                allFilled = false;
            } else if (password === confirmPassword) {
                $('#password').removeClass('is-invalid');
                $('#password_confirmation').removeClass('is-invalid');
                $('#password-confirmation-error').text('');
            } else {
                $('#password').addClass('is-invalid');
                $('#password_confirmation').addClass('is-invalid');
                $('#password-confirmation-error').text('Konfirmasi password tidak sesuai.');
                allFilled = false;
            }
            submitButton.prop('disabled', !allFilled);
        });
    });

</script>



@endsection