@extends('layouts.appHome')
@section('page', 'Top Worker')
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

<!-- Start About Area -->
<section class="about-us section">
    <div class="container">
        <div class="row align-items-center card shadow">
            <div class="col-md-12 col-12">
                <div class="card-body">
                    <h4 class="mb-5 header-title"><i class="lni lni-crown"></i> @yield('page')s</h4>
                    <!-- content-1 start -->
                    <div class="content-right wow fadeInRight" data-wow-delay=".5s">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Worker</th>
                                    <th scope="col">Task</th>
                                    <th scope="col">Earned</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="350">
                                        <div class="row g-0" style="max-width:200px;">
                                            <div class="col-md-4">
                                                <img src="{{ asset('storage/images/default.jpg') }}"
                                                    class="img-fluid rounded-circle" width="50" />
                                            </div>
                                            <div class="col-md-8">
                                                Mark Jason
                                                <div class="d-block">
                                                    <i class="lni lni-star-filled text-warning"></i>
                                                    <i class="lni lni-star-filled text-warning"></i>
                                                    <i class="lni lni-star-filled text-warning"></i>
                                                    <i class="lni lni-star-filled text-warning"></i>
                                                    <i class="lni lni-star-empty"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pt-3">
                                        <button class="btn btn-sm btn-outline-success" data-toggle="tooltip"
                                            data-placement="top" title="Sukses">100</button>
                                        <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                            data-placement="top" title="Gagal">0</button>
                                        <button class="btn btn-sm btn-outline-secondary" data-toggle="tooltip"
                                            data-placement="top" title="Total">100</button>
                                    </td>
                                    <td class="pt-3">Rp.123.000,-</td>
                                    <td class="pt-3"><button class="btn btn-sm btn-primary">Profile</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->
@endsection