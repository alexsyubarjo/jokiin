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
                            {{ number_format($user->saldo_employer, 0, ',', '.') }}
                            <span>Total Saldo</span>
                        </h3>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12">

                    <div class="single-list four">
                        <div class="list-icon">
                            <i class="lni lni-emoji-speechless"></i>
                        </div>
                        <h3>
                            {{ number_format($tugasJalan, 0, ',', '.') }}
                            <span>Tugas Berjalan</span>
                        </h3>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-12">

                    <div class="single-list">
                        <div class="list-icon">
                            <i class="lni lni-emoji-smile"></i>
                        </div>
                        <h3>
                            {{ number_format($tugasSelesai, 0, ',', '.') }}
                            <span>Tugas Selesai</span>
                        </h3>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-12">

                <div class="activity-log dashboard-block">
                    <h3 class="block-title">Progres Tugas</h3>

                    @if($posts && $posts->count() > 0)
                    <ul>

                        <div class="ms-3 me-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Tugas</th>
                                        <th class="fw-bold">Progres</th>
                                    </tr>
                                </thead>
                                @php
                                function getProgressBarClass($progress)
                                {
                                if ($progress >= 75) {
                                return 'bg-success';
                                } elseif ($progress >= 50) {
                                return 'bg-warning';
                                } else {
                                return 'bg-danger';
                                }
                                }
                                @endphp
                                @foreach ($posts as $log)
                                @php
                                $progress = ($log->jumlah != 0) ? (isset($log->total) / $log->jumlah) * 100 : 0;
                                @endphp
                                <tr>
                                    <td width="280px">{{ $log->post_title }}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar {{ isset($log) && $log->jumlah != 0 ? getProgressBarClass(($log->total / $log->jumlah) * 100) : '' }}"
                                                role="progressbar"
                                                style="width: {{ isset($log) && $log->jumlah != 0 ? ($log->total / $log->jumlah) * 100 : 0 }}%"
                                                aria-valuenow="{{ isset($log) && $log->jumlah != 0 ?
                                                 ($log->total / $log->jumlah) * 100 : 0 }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ isset($log) && $log->jumlah != 0 ? round(($log->total / $log->jumlah)
                                                * 100) : 0 }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                        </div>

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
                                            <small class="fw-semibold">{{number_format($Count1->sum('post.komisi'),
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
                                            <small class="fw-semibold">{{number_format($Count2->sum('post.komisi'),
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
                                            <small class="fw-semibold">{{number_format($Count3->sum('post.komisi'),
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