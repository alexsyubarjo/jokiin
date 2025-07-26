<div class="my-items">

    <div class="item-list-title">
        <div class="row align-items-center">
            <div class="col-lg-1 col-md-1 col-12 align-left">
                <p>No</p>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <p>Informasi</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12 align-left">
                <p>Nominal</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Status</p>
            </div>
        </div>
    </div>

    {{-- @php $no = 1 @endphp --}}
    @foreach ($riwayatSaldo as $key => $log)
    @php
    if($log->status === 'Sukses'){
    $stat = "success";
    }elseif ($log->status === 'Pending') {
    $stat = "warning";
    }elseif ($log->status === 'Cancel') {
    $stat = "danger";
    }elseif ($log->status === 'Error') {
    $stat = "danger";
    }else{
    $stat = "primary";
    }

    $inal = $log->nominal * ($web->wd / 100);
    $nominal = $log->nominal - $inal;

    @endphp
    <div class="single-item-list">
        <div class="row align-items-center">
            <div class="col-lg-1 col-md-1 col-12 align-left">
                <div class="content mt-2">
                    <p class="title-no title" id="number_{{ $key }}">
                        {{ $key + 1 }}
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="content mt-2">
                    <p class="title">
                        Penarikan Dana {{ $log->created_at->format('d M Y, H:i') }}WIB
                    </p>
                    <span class="fw-light" style="font-size: 12px">
                        {{ $log->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="content mt-2">
                    <p class="fw-bold title text-{{ $stat }}">
                        Rp {{ number_format($nominal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <div class="content mt-2">
                    @if (isset($log->status))
                    <p class="title">
                        <button class="btn btn-xs btn-{{ $stat }}">
                            {{ $log->status }}
                        </button>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach


    @if($riwayatSaldo && $riwayatSaldo->count() > 0)
    <div class="row">
        <div class="col-12">

            <div class="pagination left">
                <ul class="pagination-list">
                    @if ($riwayatSaldo->onFirstPage())
                    <li class="disabled"><a style="cursor: no-drop"><i class="lni lni-chevron-left"></i></a></li>
                    @else
                    <li><a href="{{ $riwayatSaldo->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
                    @endif

                    @foreach ($riwayatSaldo->getUrlRange(1, $riwayatSaldo->lastPage()) as $page
                    =>
                    $url)
                    @if ($page == $riwayatSaldo->currentPage())
                    <li class="active"><a href="{{ $url }}">{{ $page }}</a></li>
                    @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    @if ($riwayatSaldo->hasMorePages())
                    <li><a href="{{ $riwayatSaldo->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a></li>
                    @else
                    <li class="disabled"><a style="cursor: no-drop"><i class="lni lni-chevron-right"></i></a></li>
                    @endif
                </ul>
            </div>

        </div>
    </div>
    @else
    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
            <div class="row">
                <div class="col-12 text-center pt-5">
                    <h6 style="color:#888">Maaf data kosong</h6>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>