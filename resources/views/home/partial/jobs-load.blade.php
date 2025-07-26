<div class="category-grid-topbar">
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-12">
            <h3 class="title">
                Menampilkan
                @if ($posts->total() > 0)
                {{ $posts->firstItem() }} - {{ $posts->lastItem() }}
                @else
                0
                @endif
                dari {{ $posts->total() }} data Jobs
            </h3>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">


                </div>
            </nav>
        </div>
    </div>
</div>

<div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
        <div class="row">

            @foreach($posts as $p)

            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="single-item-grid">
                    <div class="image">
                        <a href="{{ url('detail-jobs/'.$p->post_slug) }}">
                            @if($p->image && !filter_var($p->image, FILTER_VALIDATE_URL))
                            <img src="{{ asset('storage/posts/'.$p->image) }}" alt="{{ $p->title }}">
                            @else
                            <img src="{{ asset('storage/images/content.jpg') }}" alt="{{ $p->title }}">
                            @endif
                        </a>
                        @if ($p->average_rating > 3)
                        <i class="cross-badge lni lni-bolt"></i>
                        @endif
                        @php
                        $currentDate = strtotime(date('Y-m-d'));
                        $createdDate = strtotime($p->created_at);

                        if (floor(($currentDate - $createdDate) / (60 * 60 * 24 * 7)) <= 1) {
                            echo '<span class="flat-badge sale"><i class="lni lni-alarm"></i> New</span>' ; } @endphp
                            </div>
                            <div class="content">
                                <a href="{{ url('jobs/'.$p->category_slug) }}" class="tag">
                                    {{ $p->category_name }}
                                </a>
                                <p class="float-end" style="font-size:12px">{{ $p->created_at->diffForHumans() }}</p>
                                <h3 class="title">
                                    <a href="{{ url('detail-jobs/'.$p->post_slug) }}">
                                        {{ implode(' ', array_slice(explode(' ', $p->title), 0, 6)) }}
                                    </a>
                                </h3>
                                <div class="mt-2 d-flex align-items-center">
                                    <p class="location">
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-user"></i> {{ $p->user_name }}
                                        </a>
                                    </p>

                                    <div class="ms-auto mt-2">
                                        @if ($p->average_rating > 0)
                                        <i class="lni lni-star-filled text-warning"></i>
                                        @else
                                        <i class="lni lni-star"></i>
                                        @endif

                                        <span class="ms-1">({{ $p->total_ratings ?? 0 }})</span>
                                    </div>
                                </div>

                                </p>
                                <ul class="info">
                                    <li class="price">
                                        Rp. {{ number_format($p->komisi, 0, ',', '.') }}
                                    </li>
                                    <li class="bottom-content">

                                        @auth
                                        @php
                                        $tugas = DB::table('tugas')
                                        ->where('post_id', $p->id)
                                        ->where('user_id', Auth::id())
                                        ->first();
                                        @endphp
                                        @if ($tugas && $tugas->status == "1")
                                        <a href="javascript:void(0)" class="like bg-success"
                                            style="cursor:default">Selesai</a>
                                        @elseif ($tugas && $tugas->status == "2")
                                        <a href="javascript:void(0)" class="like bg-warning"
                                            style="cursor:default">Pending</a>
                                        @elseif ($tugas && $tugas->status == "3")
                                        <a href="javascript:void(0)" class="like bg-danger"
                                            style="cursor:default">Ditolak</a>
                                        @else
                                        <a href="{{ url('detail-jobs/'.$p->post_slug) }}" class="like">Ambil</a>
                                        @endif
                                        @else
                                        <a href="{{ url('detail-jobs/'.$p->post_slug) }}" class="like">Ambil</a>
                                        @endauth

                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>

    @if($posts && $posts->count() > 0)
    <div class="row">
        <div class="col-12">

            <div class="pagination left">
                <ul class="pagination-list">
                    @if ($posts->onFirstPage())
                    <li class="disabled"><a style="cursor: no-drop"><i class="lni lni-chevron-left"></i></a></li>
                    @else
                    <li><a href="{{ $posts->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
                    @endif

                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    @if ($page == $posts->currentPage())
                    <li class="active"><a href="{{ $url }}">{{ $page }}</a></li>
                    @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    @if ($posts->hasMorePages())
                    <li><a href="{{ $posts->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a></li>
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
                    <h5 style="color:#888">Maaf data kosong</h5>
                </div>
            </div>
        </div>
    </div>
    @endif