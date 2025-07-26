<div class="my-items">

    <div class="item-list-title">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <p>Posts</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Kategori</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>Progres</p>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <p>Status | Aksi</p>
            </div>
        </div>
    </div>

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

    @foreach($postsItems as $post)
    @php
    $total = (float) $post->total; // Cast to float if needed
    $jumlah = (int) $post->jumlah; // Cast to integer
    $progress = ($jumlah != 0) ? ($total / $jumlah) * 100 : 0;
    @endphp
    <div class="single-item-list">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12">
                <div class="item-image">
                    @if($post->image && !filter_var($post->image, FILTER_VALIDATE_URL))
                    <img src="{{ asset('storage/posts/'.$post->image) }}" alt="{{ $post->title }}">
                    @else
                    <img src="{{ asset('storage/images/content.jpg') }}" alt="{{ $post->title }}">
                    @endif
                    <div class="content">
                        <h3 class="title">
                            <a target="_blank" href="{{ url('detail-jobs/'.$post->slug) }}">
                                <b>{{ $post->post_title }}</b>
                            </a>
                        </h3>
                        <span class="price">
                            @php
                            $content = $post->post_content;
                            $limitedContent = strlen($content) > 75 ? substr($content, 0, 75) . '...' : $content;
                            @endphp
                            {!! $limitedContent !!}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <p>{{ $post->category }}</p>
            </div>
            <div class="col-lg-2 col-md-2 col-12">

                <div class="progress">
                    <div class="progress-bar {{ $jumlah != 0 ? getProgressBarClass($progress) : '' }}"
                        role="progressbar"
                        style="width: {{ $jumlah != 0 ? $progress : 0 }}%"
                        aria-valuenow="{{ $jumlah != 0 ? round($progress) : 0 }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $jumlah != 0 ? round($progress) : 0 }}%
                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-md-3 col-12">
                @if($post->status == "Selesai")
                <span class="btn btn-xs btn-success">Selesai</span>
                @elseif($post->status == "Berjalan")
                <span class="btn btn-xs btn-warning">Berjalan</span>
                @else
                <span class="btn btn-xs btn-primary">{{ $post->status }}</span>
                @endif
                |
                <a href="{{ route('posts.edit', ['post' => Crypt::encrypt($post->id)]) }}"
                    class="btn btn-xs btn-primary">
                    <i class="lni lni-pencil-alt"></i> Edit
                </a>
                <span id="hapus" class="btn btn-xs btn-danger" data-id="{{ $post->id }}">
                    <i class="lni lni-trash"></i> Hapus
                </span>
            </div>

        </div>
    </div>
    @endforeach

    @if($postsItems && $postsItems->count() > 0)
    <div class="row">
        <div class="col-12">

            <div class="pagination left">
                <ul class="pagination-list">
                    @if ($postsItems->onFirstPage())
                    <li class="disabled"><a style="cursor: no-drop"><i class="lni lni-chevron-left"></i></a></li>
                    @else
                    <li><a href="{{ $postsItems->previousPageUrl() }}"><i class="lni lni-chevron-left"></i></a></li>
                    @endif

                    @foreach ($postsItems->getUrlRange(1, $postsItems->lastPage()) as $page => $url)
                    @if ($page == $postsItems->currentPage())
                    <li class="active"><a href="{{ $url }}">{{ $page }}</a></li>
                    @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    @if ($postsItems->hasMorePages())
                    <li><a href="{{ $postsItems->nextPageUrl() }}"><i class="lni lni-chevron-right"></i></a></li>
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
