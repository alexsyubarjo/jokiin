<div class="my-items">

    <div class="item-list-title">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <p>Tugas</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Worker</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Komisi</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>Aksi</p>
            </div>
        </div>
    </div>


    @foreach($tugasItems as $tugas)
    <div class="single-item-list">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <div class="item-image">
                @if($tugas->post && $tugas->post->image && !filter_var($tugas->post->image, FILTER_VALIDATE_URL))
    <img src="{{ asset('storage/posts/'.$tugas->post->image) }}" alt="{{ $tugas->post->title }}">
@elseif($tugas->post)
    <img src="{{ asset('storage/images/content.jpg') }}" alt="{{ $tugas->post->title }}">
@else
    <img src="{{ asset('storage/images/content.jpg') }}" alt="Post tidak tersedia">
@endif

                    <div class="content">
                        <h3 class="title">
                            <a target="_blank" href="{{ url('detail-jobs/'.$tugas->post->slug) }}">
                                <b>{{ $tugas->post->title }}</b>
                            </a>
                        </h3>
                        <span class="price">
                            @php
                            $content = $tugas->post->content;
                            $limitedContent = strlen($content) > 75 ? substr($content, 0, 75)
                            . '...' : $content;
                            @endphp

                            {!! $limitedContent !!}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>{{ $tugas->nama_user }}</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Rp. {{ number_format($tugas->post->komisi, 0, ',', '.') }}</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="row align-items-center">

                    <div class="col-auto">
                        <span class="btn btn-sm btn-primary" id="tombol-bukti" data-id="{{ $tugas->id }}"
                            data-bs-toggle="modal" data-bs-target="#buktiModal">Bukti</span>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-ungu dropdown-toggle btn-sm" type="button" id="dd-role" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dd-role">
                            <li>
                                <a id="terima" class="dropdown-item" href="javascript:void(0)"
                                    data-id="{{ $tugas->id }}">
                                    Terima
                                </a>
                            </li>
                            <li>
                                <a id="tolak" class="dropdown-item" href="javascript:void(0)"
                                    data-id="{{ $tugas->id }}">
                                    Tolak
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>

        </div>
    </div>
    @endforeach

    @if($tugasItems && $tugasItems->count() > 0)
    <div class="row">
        <div class="col-12">

            <div class="pagination left">
                <ul class="pagination-list">
                    @if ($tugasItems->onFirstPage())
                    <li class="disabled"><a style="cursor: no-drop"><i class="lni lni-chevron-left"></i></a></li>
                    @else
                    <li><a href="{{ $tugasItems->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
                    @endif

                    @foreach ($tugasItems->getUrlRange(1, $tugasItems->lastPage()) as $page => $url)
                    @if ($page == $tugasItems->currentPage())
                    <li class="active"><a href="{{ $url }}">{{ $page }}</a></li>
                    @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    @if ($tugasItems->hasMorePages())
                    <li><a href="{{ $tugasItems->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a></li>
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