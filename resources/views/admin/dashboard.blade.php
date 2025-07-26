@extends('layouts.appAdmin')
@section('page', 'Dashboard')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">



    <div class="row">

        <div class="col-lg-8 mb-4 order-0">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang {{ $user->name }}! 🎉</h5>
                                <p class="mb-4">
                                    {!! implode(' ', array_slice(explode(' ', $web->meta_description), 0, 15)) !!} ...
                                </p>

                                <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-primary">View
                                    Website</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('storage/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="{{ asset('storage/img/illustrations/man-with-laptop-dark.png') }}"
                                    data-app-light-img="{{ asset('storage/img/illustrations/man-with-laptop-light.png') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="row row-bordered g-0">

                        <div class="col-md-12">
                            <h5 class="card-header m-0 me-2 pb-3">Total Withdraw & Deposit</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 order-1 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Data Tugas</h5>
                    </div>
                </div>
                <div class="card-body mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">{{ number_format($jumlahTugas, 0, ',', '.') }}</h2>
                            <span>Total Tugas</span>
                        </div>
                        <div id="orderStatisticsChart"></div>
                    </div>
                    <ul class="p-0 m-0 mt-3">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-smile"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Tugas Selesai</h6>
                                    <small class="text-muted">Total : {{
                                        number_format($Count1->count(), 0, ',', '.') }}</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">{{number_format($Count1->sum('post.komisi'),
                                        0,',', '.') }}</small>
                                </div>
                            </div>
                        </li>

                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="bx bx-meh"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Tugas Pending</h6>
                                    <small class="text-muted">Total : {{
                                        number_format($Count2->count(), 0, ',', '.') }}</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">{{number_format($Count2->sum('post.komisi'),
                                        0,',', '.') }}</small>
                                </div>
                            </div>
                        </li>

                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="bx bx-sad"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Tugas Ditolak</h6>
                                    <small class="text-muted">Total : {{
                                        number_format($Count3->count(), 0, ',', '.') }}</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">{{number_format($Count3->sum('post.komisi'),
                                        0,',', '.') }}</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
    </div>

    <div class="row">
        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-8 order-1 mb-4">
            <div class="card h-100">
                <div class="card-body px-0">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            <div class="d-flex p-4 pt-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('storage/img/icons/unicons/wallet.png') }}" alt="User" />
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total Pendapatan</small>
                                    <div class="d-flex align-items-center">
                                        @php
                                        $jumWD = $jumlahWD * ($web->wd / 100);
                                        if ($percentageChange > 0){
                                        $per = "success";
                                        $cev = "up";
                                        }elseif ($percentageChange < 0) { $per="danger" ; $cev="down" ; }else {
                                            $per="primary" ; $cev="right" ; } @endphp <h6 class="mb-0 me-1">Rp {{
                                            number_format($jumWD, 0, ',', '.') }}</h6>
                                            <small class="text-{{ $per }} fw-semibold">
                                                <i class="bx bx-chevron-{{ $cev }}"></i>
                                                {{ number_format($percentageChange, 2) }}%
                                            </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="incomeChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->


        <!-- Transactions -->
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Top Worker</h5>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">

                        @foreach ($TopWork as $t)
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                @if ($t->avatar)
                                <img src="{{ asset('storage/users-avatar/' . $t->avatar) }}" alt="User"
                                    class="rounded" />
                                @else
                                <img src="{{ asset('storage/images/default.jpg') }}" alt="User" class="rounded" />
                                @endif
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">{{ $t->name }}</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <span class="text-muted">Rp</span>
                                    <h6 class="mb-0">{{ number_format($t->saldo, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
</div>
<!-- / Content -->
<script src="{{ url('assets/admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@include('admin.partial.dashboard-js')
@endsection