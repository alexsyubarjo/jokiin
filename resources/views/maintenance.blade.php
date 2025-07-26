
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui" />
    <meta name="author" content="{{ website_config('main')->meta_author }}" />
    <meta name="keywords" content="{{ website_config('main')->meta_keywords }}" />
    <meta name="description" content="{{ website_config('main')->meta_description }}" />
    <title>{{ website_config('main')->website_name }} - @yield('code')</title>
	<link rel="shortcut icon" href="{{ url('file/images/'.website_config('main')->website_favicon.'') }}" />
    <link rel="stylesheet" href="{{ asset('assets/errors/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/errors/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/errors/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/errors/css/components.css') }}">
</head>
<body>
    <div id="app">
        <section class="section">
            <div class="container" style="margin-top: 100px;">
                @if (website_config('main')->website_logo_dark <> null)
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="text-center">
                            <div class="">
                                <img src="{{ url('file/images/'.website_config('main')->website_logo_dark.'') }}" height="40" alt="logo">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="page-error">
                    <div class="page-inner">
                        <div class="mb-3">
                            <img class="rounded" style="width: 300px;" src="{{ asset('assets/images/maintenance.png') }}" data-holder-rendered="true">
                        </div>
                        <div class="page-description">
                            Situs sedang dalam pengembangan.
                            <br> Jangan khawatir, kami akan segera kembali.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('assets/errors/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/errors/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/errors/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/errors/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/errors/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/errors/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/errors/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/errors/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/errors/js/custom.js') }}"></script>
</body>
</html>