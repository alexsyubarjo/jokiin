<div class="my-items">

    <div class="item-list-title">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12">
                <p>User</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>Komisi</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>Tanggal</p>
            </div>
            <div class="col-lg-1 col-md-1 col-12">
                <p>Status</p>
            </div>
        </div>
    </div>

    @foreach ($dataReff as $d)
    <div class="single-item-list">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12">
                <p>{{ $d->user->name }}</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>Rp. {{ number_format($d->komisi, 0, ',','.') }}</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>{{ $d->updated_at->format('d M Y, H:i') }}WIB</p>
            </div>
            <div class="col-lg-1 col-md-1 col-12 floa">
                @if ($d->komisi)
                <button class="btn btn-xs btn-success">Selesai</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @if($dataReff && $dataReff->count() > 0)
    <div class="row">
        <div class="col-12">

            <div class="pagination left">
                <ul class="pagination-list">
                    @if ($dataReff->onFirstPage())
                    <li class="disabled"><a style="cursor: no-drop"><i class="lni lni-chevron-left"></i></a></li>
                    @else
                    <li><a href="{{ $dataReff->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
                    @endif

                    @foreach ($dataReff->getUrlRange(1, $dataReff->lastPage()) as $page => $url)
                    @if ($page == $dataReff->currentPage())
                    <li class="active"><a href="{{ $url }}">{{ $page }}</a></li>
                    @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    @if ($dataReff->hasMorePages())
                    <li><a href="{{ $dataReff->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a></li>
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

<!-- Modal -->
<div class="modal fade" id="buktiModal" aria-labelledby="buktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buktiModalLabel">File Bukti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="data-bukti"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>