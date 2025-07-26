<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <title>{{ $web->website_name }} - @yield('page')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="author" content="{{ $web->meta_author }}" />
    <meta name="keywords" content="{{ $web->meta_keywords }}" />
    <meta name="description" content="{!! $web->meta_description !!}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/images/'.$web->website_favicon.'') }}" />
    <!-- Place favicon.ico in the root directory -->

    <!----------------------- Snipet Open graph Fcebook ---------------------->
    <meta property="og:title" content="{{ $web->website_name }}" />
    <meta property="og:description" content="{!! $web->meta_description !!}" />
    <meta property="og:image" content="{{ asset('storage/images/logo/'.$web->website_logo) }}" />

    <!-- Web Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ url('assets/home/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/home/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/home/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/home/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/home/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/home/css/main.css') }}" />


    <link rel="stylesheet" href="{{ url('assets/admin/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('assets/admin/js/config.js') }}"></script>

    <script src="{{ url('assets/home/js/jquery-3.7.0.min.js') }}"></script>

    {{-- Duitku JS --}}
    {{-- <script src="https://app-prod.duitku.com/lib/js/duitku.js"></script> --}}

    <script src="https://app-sandbox.duitku.com/lib/js/duitku.js"></script>

    <style type="text/css">
        .sliding-menu {
            max-width: 80%;
            /* Atur lebar maksimum sesuai kebutuhan */
            margin: 0 auto;
            /* Mengatur elemen menjadi rata tengah */
        }

        @media (min-width: 768px) {
            .dsmd {
                padding-top: 50px;
            }
        }

        @media (max-width: 768px) {
            .dashboard {
                padding-top: 180px;
            }
        }
    </style>

</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="nav-inner">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('storage/images/logo/'.$web->website_logo) }}" alt="Logo">
                            </a>
                            <div class="d-flex align-items-center">
                                <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                    <span class="toggler-icon"></span>
                                </button>
                                @auth
                                <button class="d-sm-block d-lg-none d-md-none btn btn-ungu ms-2" id="menuOpen">
                                    <i class="lni lni-dashboard"></i> Menu
                                </button>
                                @endauth

                            </div>

                            <div class="d-sm-block d-lg-none d-md-none menu-overlay"></div>
                            <div class="d-sm-block d-lg-none d-md-none sliding-menu">
                                <button class="menu-close" id="menuClose"><i class="lni lni-close"></i> </button>
                                <div class="col-lg-3 col-md-4 col-12 mt-5">
                                    @include('layouts.user.sidebar')
                                </div>
                            </div>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="{{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}"
                                            aria-label="Toggle navigation">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ Request::is('jobs') ? 'active' : '' }}" href="{{ url('jobs') }}"
                                            aria-label="Toggle navigation">Jobs</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="{{ Request::is('top_worker') ? 'active' : '' }}"
                                            href="{{ url('top_worker') }}" aria-label="Toggle navigation">Top Worker</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="{{ Request::is('about_us') ? 'active' : '' }}"
                                            href="{{ url('about_us') }}" aria-label="Toggle navigation">About Us</a>
                                    </li>

                                    @guest
                                    <hr class="d-sm-block d-lg-none d-md-none dropdown-divider">
                                    <li class="d-sm-block d-lg-none d-md-none nav-item">
                                        <a href="{{ url('login') }}" aria-label="Toggle navigation">Login</a>
                                    </li>
                                    <li class="d-sm-block d-lg-none d-md-none nav-item">
                                        <a href="{{ url('register') }}" aria-label="Toggle navigation">Register</a>
                                    </li>
                                    @endauth

                                </ul>
                            </div>
                            @guest
                            <div class="guest login-button">
                                <ul>
                                    <li>
                                        <a href="{{ url('login') }}"><i class="lni lni-enter"></i> Login</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('register') }}"><i class="lni lni-user"></i> Register</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="button header-button">
                                <a href="{{ url('auth/post') }}" class="btn">Post an Ad</a>
                            </div>
                            @else
                            <div class="login-button">
                                <ul>
                                    <li>
                                        @if ($user->role === "Worker")
                                        <a href="{{ url('dashboard/tarik-saldo') }}">
                                            <i class="lni lni-wallet"></i>
                                            {{ number_format($user->saldo, 0, ',', '.') }}
                                        </a>
                                        @elseif ($user->role === "Employer")
                                        <a href="{{ url('dashboard/deposit-saldo') }}">
                                            <i class="lni lni-wallet"></i>
                                            {{ number_format($user->saldo_employer, 0, ',', '.') }}
                                        </a>
                                        @endif
                                    </li>

                                    <li>
                                        <a href="{{ url('dashboard') }}"><i class="lni lni-dashboard"></i> Dashboard</a>
                                    </li>

                                    <li>
                                        <a href="#" id="logoutBtn">
                                            <i class="lni lni-exit"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endauth
                        </nav> <!-- navbar -->
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->

    </header>
    <!-- End Header Area -->


    <div class="dsmd">
        @yield('content')
    </div>


    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Start Footer Area -->
    <footer class="footer mb-0 pb-0">
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-12">
                            <div class="content">
                                <ul class="footer-bottom-links">
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('jobs') }}">Jobs</a></li>
                                    {{-- <li><a href="{{ url('top_worker') }}">Top Worker</a></li> --}}
                                    <li><a href="{{ url('about_us') }}">About Us</a></li>
                                    <li><a href="{{ url('terms_and_conditions') }}">Terms and Conditions</a></li>
                                    <li><a href="{{ url('privacy_policy') }}"> Privacy Policy</a></li>
                                </ul>
                                <p class="copyright-text">Copyright © {{ date("Y") }} <b>{{ $web->website_name }}</b>
                                    All
                                    Rights Reserved.</p>
                                <ul class="footer-social">
                                    @php
                                    $rep_no = "62" . substr($soc->whatsapp, 1);
                                    @endphp
                                    @if ($soc->facebook)
                                    <li><a target="_blank" href="{{ $soc->facebook }}"><i
                                                class="lni lni-facebook-filled"></i></a></li>
                                    @endif
                                    @if ($soc->twitter)
                                    <li><a target="_blank" href="{{ $soc->twitter }}"><i
                                                class="lni lni-twitter-original"></i></a></li>
                                    @endif
                                    @if ($soc->instagram)
                                    <li><a target="_blank" href="{{ $soc->instagram }}"><i
                                                class="lni lni-instagram"></i></a></li>
                                    @endif
                                    @if ($soc->youtube)
                                    <li><a target="_blank" href="{{ $soc->youtube }}"><i
                                                class="lni lni-youtube"></i></a></li>
                                    @endif
                                    @if ($soc->tiktok)
                                    <li><a target="_blank" href="{{ $soc->tiktok }}"><i class="lni lni-tumblr"></i></a>
                                    </li>
                                    @endif
                                    @if ($soc->whatsapp)
                                    <li><a target="_blank" href="https://api.whatsapp.com/send?phone={{ $rep_no }}"><i
                                                class="lni lni-whatsapp"></i></a></li>
                                    @endif
                                    @if ($soc->telegram)
                                    <li><a target="_blank" href="https://t.me/{{ $soc->telegram }}"><i
                                                class="lni lni-telegram"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{ url('assets/home/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/home/js/wow.min.js') }}"></script>
    <script src="{{ url('assets/home/js/tiny-slider.js') }}"></script>
    <script src="{{ url('assets/home/js/glightbox.min.js') }}"></script>
    <script src="{{ url('assets/home/js/main.js') }}"></script>
    <script src="{{ url('vendor/sweetalert/sweetalert.all.js') }}"></script>

    @include('sweetalert::alert')

    <script type="text/javascript">
        // Menggunakan SweetAlert untuk konfirmasi logout
        $('#logoutBtn, #logoutBtn2').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan logout
                    $('#logout-form').submit();
                }
            });
        });
    
        $(document).ready(function() {
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            $('#menuOpen').click(function() {
                $('.menu-overlay').fadeIn();
                $('.sliding-menu').animate({ left: 0 }, 300);
            });

            $('#menuClose, .menu-overlay').click(function() {
                $('.menu-overlay').fadeOut();
                $('.sliding-menu').animate({ left: '-380px' }, 300);
            });

        });
    </script>
</body>

</html>