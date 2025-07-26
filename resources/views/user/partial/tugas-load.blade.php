<div class="my-items">

    <div class="item-list-title">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <p>Tugas</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>komen</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Komisi</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Status</p>
            </div>
        </div>
    </div>


    @foreach($tugasItems as $tugas)
    <div class="single-item-list">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <div class="item-image">
                    @if($tugas->post->image && !filter_var($tugas->post->image, FILTER_VALIDATE_URL))
                    <img src="{{ asset('storage/posts/'.$tugas->post->image) }}" alt="{{ $tugas->post->title }}">
                    @else
                    <img src="{{ asset('storage/images/content.jpg') }}" alt="{{ $tugas->post->title }}">
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
            <div class="col-lg-3 col-md-3 col-12">
                <p>{{ $tugas->comments }}</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Rp. {{ number_format($tugas->post->komisi, 0, ',', '.') }}</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <span class="btn btn-xs btn-primary" id="tombol-bukti" data-id="{{ $tugas->id }}" data-bs-toggle="modal"
                    data-bs-target="#buktiModal">Bukti</span>
                @if($tugas->status == 1)
                <span class="btn btn-xs btn-success">Selesai</span>
                @elseif($tugas->status == 2)
                <span class="btn btn-xs btn-warning">Pending</span>
                @elseif($tugas->status == 3)
                <span class="btn btn-xs btn-danger">Ditolak</span>
                @endif
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