@extends('layouts.appHome')
@section('page', 'Login')
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

<section class="login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                <div class="form-head">
                    <h4 class="title">@yield('page')</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>Email or Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" required autocomplete="username" autofocus />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control" name="password" required
                                autocomplete="current-password">
                        </div>
                        <div class="check-and-pass">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input width-auto" name="remember"
                                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label">Remember me</label>
                                    </div>
                                </div>

                                @if (Route::has('password.request'))
                                <div class="col-lg-6 col-md-6 col-12">
                                    <a href="{{ route('password.request') }}" class="lost-pass">Forgot your
                                        password?</a>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="button">
                            <button type="submit" class="btn">Login Now</button>
                        </div>
                        {{-- <div class="alt-option">
                            <span>Or</span>
                        </div>
                        <div class="socila-login">
                            <ul>
                                <li><a href="{{ url('auth/facebook') }}" class="facebook"><i
                                            class="lni lni-facebook-original"></i>Login With
                                        Facebook</a></li>
                                <li><a href="{{ url('auth/google') }}" class="google"><i
                                            class="lni lni-google"></i>Login With
                                        Google
                                        Plus</a>
                                </li>
                            </ul>
                        </div> --}}
                        <p class="outer-link">Don't have an account? <a href="{{ url('register') }}">Register here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection