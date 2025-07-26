@extends('layouts.user.appUser')
@section('page', 'Dashboard')
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

            @if ($user->role === "Worker")
            <div class="col-lg-9 col-md-8 col-12">
                <div class="main-content">

                    <div class="details-lists">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">

                                <div class="single-list two">
                                    <div class="list-icon">
                                        <i class="lni lni-wallet"></i>
                                    </div>
                                    <h3>
                                        {{ number_format($user->saldo, 0, ',', '.') }}
                                        <span>Total Saldo</span>
                                    </h3>
                                </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-12">

                                <div class="single-list">
                                    <div class="list-icon">
                                        <i class="lni lni-emoji-smile"></i>
                                    </div>
                                    <h3>
                                        {{ number_format($Count1->count(), 0, ',', '.') }}
                                        <span>Tugas Dibayar</span>
                                    </h3>
                                </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-12">

                                <div class="single-list three">
                                    <div class="list-icon">
                                        <i class="lni lni-emoji-sad"></i>
                                    </div>
                                    <h3>
                                        {{ number_format($Count3->count(), 0, ',', '.') }}
                                        <span>Tugas Ditolak</span>
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12">

                            <div class="activity-log dashboard-block">
                                <h3 class="block-title">Pemberitahuan</h3>

                                @if($Logs && $Logs->count() > 0)
                                <ul>

                                    @foreach($Logs as $log)
                                    @php
                                    if ($log->status == "Sukses") {
                                    $stat = 'text-success';
                                    }elseif ($log->status == "Error") {
                                    $stat = 'text-danger';
                                    }else{
                                    $stat = 'text-primary';
                                    }
                                    @endphp
                                    <li>
                                        <div class="log-icon">
                                            <i class="lni lni-alarm {{ $stat }}"></i>
                                        </div>
                                        <a href="{{ url('dashboard/logs') }}" class="title {{ $stat }}">
                                            {!! $log->log_info !!}
                                        </a>
                                        <span class="time">{{ $log->created_at->diffForHumans() }} </span>
                                    </li>
                                    @endforeach

                                </ul>
                                @else
                                <div class="mt-3 text-center">
                                    <ul>
                                        <li>
                                            <p style="color:#888">Data Kosong</p>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-12 col-12">

                            <div class="recent-items dashboard-block">
                                <h3 class="block-title">Informasi Tugas</h3>
                                <div class="container-fluid">
                                    <div class="card-body">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                <h2 class="">{{ number_format($jumlahTugas, 0, ',', '.') }}</h2>
                                                <span>Total Tugas</span>
                                            </div>
                                            <div id="orderStatisticsChart"></div>
                                        </div>
                                        <ul class="p-0 m-0">

                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-success">
                                                        <i class="lni lni-emoji-smile"></i>
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">
                                                            <a href="{{ url('dashboard/task?status=selesai') }}">Tugas
                                                                Selesai</a>
                                                        </h6>
                                                        <small class="text-muted">Total : {{
                                                            number_format($Count1->count(), 0, ',', '.') }}</small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small
                                                            class="fw-semibold">{{number_format($Count1->sum('post.komisi'),
                                                            0,',', '.') }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-warning"><i
                                                            class="lni lni-emoji-speechless"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">
                                                            <a href="{{ url('dashboard/task?status=pending') }}">Tugas
                                                                Pending</a>
                                                        </h6>
                                                        <small class="text-muted">Total : {{
                                                            number_format($Count2->count(), 0, ',', '.') }}</small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small
                                                            class="fw-semibold">{{number_format($Count2->sum('post.komisi'),
                                                            0,',', '.') }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-danger"><i
                                                            class="lni lni-emoji-sad"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">
                                                            <a href="{{ url('dashboard/task?status=ditolak') }}">Tugas
                                                                Ditolak</a>
                                                        </h6>
                                                        <small class="text-muted">Total : {{
                                                            number_format($Count3->count(), 0, ',', '.') }}</small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small
                                                            class="fw-semibold">{{number_format($Count3->sum('post.komisi'),
                                                            0,',', '.') }}</small>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            @elseif ($user->role === "Employer")
            @include('user.employer.dashboard')
            @endif


            </>
        </div>
</section>
<!-- End About Area -->

<!-- Vendors JS -->
<script src="{{ url('assets/admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<script type="text/javascript">
    'use strict';
    
(function () {
    let cardColor, headingColor, axisColor, shadeColor, borderColor;

    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;
    var suc = {{ $Count1->count() }};
    var pen = {{ $Count2->count() }};
    var err =  {{ $Count3->count() }};
    var total = suc + pen + err;

    // Order Statistics Chart
    // --------------------------------------------------------------------
    const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),
    orderChartConfig = {
    chart: {
    height: 165,
    width: 130,
    type: 'donut'
    },
    labels: ['Selesai', 'Pending', 'Ditolak'],
    series: [suc, pen, err],
    colors: [config.colors.success, config.colors.warning, config.colors.danger],
    stroke: {
    width: 5,
    colors: cardColor
    },
    dataLabels: {
    enabled: false,
    formatter: function (val, opt) {
        return parseInt(val);
    }
    },
    legend: {
    show: false
    },
    grid: {
    padding: {
        top: 0,
        bottom: 0,
        right: 15
    }
    },
    plotOptions: {
    pie: {
        donut: {
        size: '75%',
        labels: {
            show: true,
            value: {
            fontSize: '1.5rem',
            fontFamily: 'Public Sans',
            color: headingColor,
            offsetY: -15,
            formatter: function (val) {
                return parseInt(val);
            }
            },
            name: {
            offsetY: 20,
            fontFamily: 'Public Sans'
            },
            total: {
            show: true,
            fontSize: '0.8125rem',
            color: axisColor,
            formatter: function (w) {
                return total;
            }
            }
        }
        }
    }
    }
    };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
})();
</script>

@endsection