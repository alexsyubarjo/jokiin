<div class="my-items">

    <div class="activity-log dashboard-block">

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
                <span class="title {{ $stat }}">
                    {!! $log->log_info !!}
                </span>
                <span class="time">{{ $log->created_at->diffForHumans() }} </span>
            </li>
            @endforeach
        </ul>
    </div>

    @if($Logs && $Logs->count() > 0)
    <div class="pagination left">
        <ul class="pagination-list">
            @if ($Logs->onFirstPage())
            <li class="disabled"><a href="javascript:void(0)"><i class="lni lni-chevron-left"></i></a></li>
            @else
            <li><a href="{{ $Logs->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
            @endif

            @foreach ($Logs->getUrlRange(1, $Logs->lastPage()) as $page => $url)
            @if ($page == $Logs->currentPage())
            <li class="active"><a href="{{ $url }}">{{ $page }}</a></li>
            @else
            <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            @if ($Logs->hasMorePages())
            <li><a href="{{ $Logs->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a>
            </li>
            @else
            <li class="disabled"><a href="javascript:void(0)"><i class="lni lni-chevron-right"></i></a></li>
            @endif
        </ul>
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