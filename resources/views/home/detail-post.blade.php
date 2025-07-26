@extends('layouts.appHome')
@section('page', 'About Us')
@section('content')

<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
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
</div>
<!-- End Breadcrumbs -->

<!-- Start About Area -->
<section class="item-details section">
    <div class="container">
        <div class="top-area">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-images">
                        <main id="gallery">

                        <div class="main-img">
                            @if($post->image && !filter_var($post->image, FILTER_VALIDATE_URL)) 
                                <img src="{{ asset('storage/posts/'.$post->image) }}" id="current" alt="{{ $post->title }}" height="440">
                            @else
                                <img src="{{ asset('storage/images/content.jpg') }}" id="current" alt="{{ $post->title }}" height="440">
                            @endif
                        </div>

                        </main>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-info">
                        <h2 class="title">{{ $post->title }}</h2>
                        <p class="location">
                        <ul class="rating d-flex mb-2">
                            @php
                            $rating = $post->average_rating; // Nilai rata-rata rating dari setiap post
                            $starCount = 5; // Jumlah bintang maksimal
                            @endphp

                            @for ($i = 1; $i <= $starCount; $i++) @if ($i <=$rating) <li><i
                                    class="lni lni-star-filled text-warning"></i></li>
                                @else
                                <li><i class="lni lni-star"></i></li>
                                @endif
                                @endfor

                                <li><a class="ms-1" href="{{ url('rating-jobs/'.$post->slug) }}">({{
                                        $post->total_ratings ?? 0 }})</a></li>
                        </ul>
                        </p>
                        <div class="list-info pt-3">
                            <h4>Informasi</h4>
                            <ul>
                                <li><span>Tanggal Post </span>: {{ date('d M, Y', strtotime($post->created_at)) }}</li>
                                <li><span>Jumlah Tugas </span>:
                                    {{ $post->jumlah }}
                                </li>
                                <li><span>Tugas Selesai </span>:
                                    {{ isset($tugasCounts[1]) ? $tugasCounts[1]->total : 0 }}
                                </li>
                                <li><span></span>
                                    @php
                                    $progress = (isset($tugasCounts[1]->total) / $post->jumlah) * 100;
                                    function getProgressBarClass($progress) {
                                    if ($progress < 50) { return 'bg-success' ; } elseif ($progress>= 50 && $progress <
                                            85) { return 'bg-primary' ; } else { return 'bg-danger' ; } } @endphp <div
                                            class="col-lg-3 col-md-3 col-12">
                                            <div class="progress">
                                                <div class="progress-bar {{ isset($tugasCounts[1]) ? getProgressBarClass(($tugasCounts[1]->total / $post->jumlah) * 100) : '' }}"
                                                    role="progressbar"
                                                    style="width: {{ isset($tugasCounts[1]) ? ($tugasCounts[1]->total / $post->jumlah) * 100 : 0 }}%"
                                                    aria-valuenow="{{ isset($tugasCounts[1]) ? ($tugasCounts[1]->total / $post->jumlah) * 100 : 0 }}"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                    {{ isset($tugasCounts[1]) ? round(($tugasCounts[1]->total /
                                                    $post->jumlah) *
                                                    100) : 0 }}%
                                                </div>
                                            </div>
                        </div>

                        </li>
                        </ul>
                    </div>
                    <div class="contact-info">
                        <ul>
                            <li>
                                <div class="call">
                                    Rp {{ number_format($post->komisi, 0, ',', '.') }}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="social-share">
                        <h4>Share Job</h4>
                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('detail-jobs/'.$post->slug)) }}"
                                    target="_blank" class="facebook"><i class="lni lni-facebook-filled"></i></a>
                            </li>
                            <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(url('detail-jobs/'.$post->slug)) }}"
                                    target="_blank" class="twitter"><i class="lni lni-twitter-original"></i></a>
                            </li>
                            <li><a href="https://plus.google.com/share?url={{ urlencode(url('detail-jobs/'.$post->slug)) }}"
                                    target="_blank" class="google"><i class="lni lni-google"></i></a></li>
                            <li><a href="https://www.linkedin.com/shareArticle?url={{ urlencode(url('detail-jobs/'.$post->slug)) }}"
                                    target="_blank" class="linkedin"><i class="lni lni-linkedin-original"></i></a>
                            </li>
                        </ul>

                        @auth
                        @php
                        $cek_repot = DB::table('data_repot')->where("user_id", $user->id)->where("post_id",
                        $post->id)->first();
                        @endphp
                        <ul class="float-end mt-2">
                            <li>
                                <button type="button" class="btn btn-danger btn-xs" data-bs-toggle="modal"
                                    data-bs-target="#repotModal" {{ $cek_repot ? 'disabled' : '' }}>
                                    <i class="lni lni-ban"></i> Repot Job
                                </button>
                            </li>
                        </ul>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item-details-blocks">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-12">

                <div class="single-block description">
                    <h3>Persyaratan dan kebutuhan Tugas</h3>
                    <p>{!! $post->content !!}</p>

                    <div class="tags pt-5">
                        <span class="fw-bold">Kategori :</span>
                        <ul class="list-unstyled d-inline ms-3">
                            <li class="d-inline">
                                <a href="{{ url('jobs?category='.$post->category_slug) }}" class="text-decoration-none">
                                    {{ $post->category_name }}
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>

                @auth

                @if ($post->status == "Berjalan")
                @if ($user->role !== "Employer")
                @if ($post->user_id !== $user->id)

                @if (!$TugasRate)
                <div class="single-block comment-form">
                    <h3 class="mb-4">Kirim bukti tugas jika selesai</h3>

                    <form action="{{ url('bukti_tugas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="form-box form-group">
                                <textarea name="comment" class="form-control form-control-custom"
                                    placeholder="Ketik sesuatu disini"></textarea>
                            </div>
                        </div>

                        <div class="mt-3 mb-4">

                            @if ($fileForm)
                            @foreach ($fileForm as $key => $value)
                            @if (!empty($value))
                            <div class="col-12 card-header mb-2">
                                <div class="form-group upload-image">
                                    <label class="mb-2 h6"><b>{{ $value }}</b></label>
                                    <input class="form-control" name="{{ $key }}" type="file"
                                        placeholder="Upload Bukti">
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif

                        </div>

                        <div class="col-12">
                            <div class="button">
                                <button type="submit" class="btn">Kirim Bukti</button>
                            </div>
                        </div>

                    </form>
                </div>
                @endif
                @endif
                @endif
                @endif

                @endauth



                <div class="single-block comments">
                    <div class="d-flex align-items-center mb-4">
                        <h3 class="me-3 mb-0">Ulasan</h3>
                        <ul class="rating d-flex list-inline mb-0">
                            @php
                            $rating = $post->average_rating; // Nilai rata-rata rating dari setiap post
                            $starCount = 5; // Jumlah bintang maksimal
                            @endphp

                            @for ($i = 1; $i <= $starCount; $i++) @if ($i <=$rating) <li><i
                                    class="lni lni-star-filled text-warning"></i></li>
                                @else
                                <li><i class="lni lni-star"></i></li>
                                @endif
                                @endfor

                                <li><a class="ms-1" href="{{ url('rating-jobs/'.$post->slug) }}">({{
                                        $post->total_ratings ?? 0 }})</a></li>
                        </ul>
                    </div>

                    @foreach ($UserRating as $rat)
                    <div class="single-comment">

                        @if ($rat->photo_user)
                        <img src="{{ asset('storage/images/' . $rat->photo_user) }}" alt="#">
                        @else
                        <img src="{{ asset('storage/images/default.jpg') }}" alt="#">
                        @endif

                        <div class="content">
                            <h4>{{ $rat->nama_user }}</h4>

                            <ul class="rating d-flex list-inline mb-0">
                                @php
                                $rating = $rat->star_rating; // Nilai rata-rata rating dari setiap post
                                $starCount = 5; // Jumlah bintang maksimal
                                @endphp

                                @for ($i = 1; $i <= $starCount; $i++) @if ($i <=$rating) <li>
                                    <i class="lni lni-star-filled text-warning"></i>
                                    </li>
                                    @else
                                    <li><i class="lni lni-star"></i></li>
                                    @endif
                                    @endfor

                            </ul>

                            @auth
                            @if ($rat->user_id == Auth::user()->id)
                            <div class="float-end">
                                <a href="javascript:void(0);" id="edit-rate" style="color:#5830e0">
                                    <i class="lni lni-pencil-alt"></i>
                                </a>
                            </div>
                            @endif
                            @endauth

                            <span style="font-size:smaller">{{ date('d M, Y', strtotime($rat->created_at)) }}</span>
                            <p>
                                {!! $rat->comments !!}
                            </p>

                        </div>
                    </div>
                    @endforeach

                </div>

                @auth
                @if ($post->status == "Berjalan")
                @if ($user->role !== "Employer")
                @if ($post->user_id !== $user->id)

                @if (!$userRat)
                @if ($TugasRate && $TugasRate->status !== "2")

                <div class="single-block comment-form">
                    <h3 class="mb-2">Beri Ulasan</h3>

                    <form action="{{ url('review_rating/'.$post->slug) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="rate">
                                    <input type="radio" id="star5" class="rate" name="rating" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" checked id="star4" class="rate" name="rating" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" class="rate" name="rating" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" class="rate" name="rating" value="2">
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" class="rate" name="rating" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="form-box form-group">
                                <textarea name="comment" class="form-control form-control-custom"
                                    placeholder="Ketik komentar kamu"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button">
                                <button type="submit" class="btn">Post Rating</button>
                            </div>
                        </div>

                    </form>
                </div>

                @endif
                @else

                <div id="edit-comment-form" class="single-block comment-form d-none">
                    <h3 class="mb-2">Edit Ulasan</h3>

                    <form action="{{ url('review_rating/'.$post->slug) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="rate">
                                    <input type="radio" {{ ($userRat->star_rating == 5) ? 'checked' : '' }}
                                    id="star5" class="rate" name="rating" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" {{ ($userRat->star_rating == 4) ? 'checked' : '' }}
                                    id="star4" class="rate" name="rating" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" {{ ($userRat->star_rating == 3) ? 'checked' : '' }}
                                    id="star3" class="rate" name="rating" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" {{ ($userRat->star_rating == 2) ? 'checked' : '' }}
                                    id="star2" class="rate" name="rating" value="2">
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" {{ ($userRat->star_rating == 1) ? 'checked' : '' }}
                                    id="star1" class="rate" name="rating" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="post_id" value="{{ $userRat->post_id }}">
                            <div class="form-box form-group">
                                <textarea name="comment" class="form-control form-control-custom"
                                    placeholder="Ketik komentar kamu">{{ $userRat->comments }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button">
                                <button type="submit" class="btn">Post Rating</button>
                            </div>
                        </div>

                    </form>
                </div>
                @endif
                @endif
                @endif
                @endif
                @endauth

            </div>


            <div class="col-lg-4 col-md-5 col-12">
                <div class="item-details-sidebar">

                    <div class="single-block author">

                        <h3 class="block-title">Informasi Tugas</h3>
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="mb-2">{{ number_format($post->jumlah , 0, ',', '.') }}</h2>
                                    <span>Jumlah Tugas</span>
                                </div>
                                <div id="orderStatisticsChart"></div>
                            </div>

                        </div>

                    </div>

                    <div class="single-block author">
                        <h3>Employer</h3>
                        <div class="content">
                            @if ($post->avatar)
                            <img src="{{ asset('storage/users-avatar/' . $post->avatar) }}" alt="#">
                            @else
                            <img src="{{ asset('storage/images/default.jpg') }}" alt="#">
                            @endif
                            <h4>{{ $post->user_name }}</h4>
                            <span class="fw-light" style="font-size:0.7rem;">
                                Bergabung Sejak {{ date('d M, Y', strtotime($post->user_created_at)) }}
                            </span>
                        </div>
                    </div>

                    @auth
                    @if ($post->user_id !== $user->id)
                    <div class="single-block contant-seller comment-form ">
                        <h3>Contact Employer</h3>
                        <form id="tambah-form" action="{{ route('pesan.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-box form-group">
                                        <input type="hidden" name="sender_id" value="{{ $post->user_id }}">
                                        <input type="hidden" name="slug" value="{{ $post->slug }}">
                                        <textarea name="reply" class="form-control form-control-custom"
                                            placeholder="Ketik pesan untuk employer."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="button">
                                        <button type="submit" class="btn">Kirim Pesan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endauth

                </div>
            </div>

        </div>
    </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="repotModal" tabindex="-1" aria-labelledby="repotModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="repotModalLabel">Repot Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="hidden" id="post-id" name="post_id" value="{{ $post->id }}">
                        <label for="alasan" class="form-label">Alasan</label>
                        <textarea class="form-control" id="alasan" rows="3" name="alasan"
                            placeholder="Ketik alasan"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button id="repot-job" type="button" class="btn btn-danger">
                        <i class="lni lni-ban"></i> Repot
                    </button>
                </div>
            </div>
        </div>
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
    var suc = {{ isset($tugasCounts[1]) ? $tugasCounts[1]->total : 0 }};
    var pen = {{ isset($tugasCounts[2]) ? $tugasCounts[2]->total : 0 }};
    var err = {{ isset($tugasCounts[3]) ? $tugasCounts[3]->total : 0 }};
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

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#edit-rate', function(e) {
            e.preventDefault();
            $('#edit-comment-form').toggleClass('d-none');
        });

        $("#repot-job").click(function() {
            var post_id = $("#post-id").val();
            var alasan = $("#alasan").val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ url('repot-job') }}", 
                method: "POST",
                data: {
                    _token: csrfToken,
                    post_id: post_id,
                    alasan: alasan 
                },
                success: function(response) {
                    if(response.success == true){
                        $('#repotModal').modal('hide');
                        Swal.fire({
                        title: 'Berhasil!',
                        text: 'Laporan job berhasil dikirim.',
                        icon: 'success'
                    }).then(function() {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                        title: 'Gagal!',
                        text: 'Maaf ada kesalahan sistem.',
                        icon: 'error'
                    });
                    }
                  
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengirim laporan job: ' + error,
                        icon: 'error'
                    });
                }
            });
        });

    });

</script>
@endsection