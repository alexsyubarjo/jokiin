@extends('layouts.appHome')
@section('page', 'Home')
@section('content')

<!-- Start Hero Area -->
<section class="hero-area overlay">
    <div class="container">
        <div class="row">
            <div class="breadcrumbs-home col-lg-10 offset-lg-1 col-md-12 col-12">
                <div class="hero-text text-center">
                    <!-- Start Hero Text -->
                    <div class="section-heading">
                        <h2 class="wow fadeInUp" data-wow-delay=".3s">Selamat datang di {{ $web->website_name }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".5s">{!! $web->meta_description !!}</p>
                    </div>
                    <!-- End Search Form -->
                    <!-- Start Search Form -->
                    <div class="search-form wow fadeInUp" data-wow-delay=".7s">
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-12 p-0">
                                <div class="search-input">
                                    <label for="search"><i class="lni lni-search-alt theme-color"></i></label>
                                    <input type="text" name="search" id="search-input" placeholder="Cari Pekerjaan">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12 p-0">
                                <div class="search-input">
                                    <label for="category"><i class="lni lni-grid-alt theme-color"></i></label>
                                    <select name="category" id="category">
                                        <option value="none" selected disabled>Kategori</option>
                                        @foreach ($Categories as $kat)
                                        <option value="{{ $kat->slug }}">{{ $kat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-12 p-0">
                                <div class="search-btn button">
                                    <button id="search-btn" class="btn"><i class="lni lni-search-alt"></i>
                                        Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Search Form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- Start Categories Area -->
<section class="categories">
    <div class="container">
        <div class="cat-inner">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="category-slider">
                        <!-- Start Single Category -->
                        @foreach ($Categories as $kat)
                        <a href="{{ url('jobs?category='.$kat->slug) }}" class="single-cat">
                            <div class="icon-ungu">
                                @if ($kat->icon)
                                <i class="lni {{ $kat->icon }}"></i>
                                @else
                                <i class="lni lni-briefcase"></i>
                                @endif
                            </div>
                            <h3>{{ $kat->name }}</h3>
                            <h5 class="total">{{ $postCounts[$kat->id] }}</h5>
                        </a>
                        @endforeach
                        <!-- End Single Category -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Categories Area -->

<!-- Start How Works Area -->
<section class="items-grid how-works section custom-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Cara Kerja Worker</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Hasilkan saat melakukan tugas online dari rumah dan
                        dapatkan uang dengan menyelesaikan tugas-tugas sederhana.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <!-- Start Single Work -->
                <div class="single-work wow fadeInUp" data-wow-delay=".2s">
                    <span class="serial">01</span>
                    <h3>Buat Akun</h3>
                    <p>Buat akun baru di {{ $web->website_name }} dan lengkapi data diri serta verifikasi akun.</p>
                </div>
                <!-- End Single Work -->
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <!-- Start Single Work -->
                <div class="single-work wow fadeInUp" data-wow-delay=".4s">
                    <span class="serial">02</span>
                    <h3>Selesaikan Tugas</h3>
                    <p>Kerjakan tugas dari proyek yang telah Anda buka kuncinya.</p>
                </div>
                <!-- End Single Work -->
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <!-- Start Single Work -->
                <div class="single-work wow fadeInUp" data-wow-delay=".6s">
                    <span class="serial">03</span>
                    <h3>Dapatkan Komisi</h3>
                    <p>Dapatkan komisi berdasarkan kualitas & jumlah tugas yang Anda selesaikan</p>
                </div>
                <!-- End Single Work -->
            </div>
        </div>

        <div class="d-none d-sm-block">
            <div class="row pt-5 mt-5">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Cara Kerja Employer</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Temukan influencer di ceruk produk yang ditargetkan
                            dan
                            buat mereka mempromosikan bisnis Anda. Pekerjakan freelancer untuk menarik perhatian audiens
                            target Anda.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <!-- Start Single Work -->
                    <div class="single-work wow fadeInUp" data-wow-delay=".2s">
                        <span class="serial">01</span>
                        <h3>Buat Akun</h3>
                        <p>Buat akun baru di {{ $web->website_name }} dan lengkapi data diri serta verifikasi akun.</p>
                    </div>
                    <!-- End Single Work -->
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <!-- Start Single Work -->
                    <div class="single-work wow fadeInUp" data-wow-delay=".4s">
                        <span class="serial">02</span>
                        <h3>Posting Pekerjaan</h3>
                        <p>Dengan bekerjasama dengan influencer di ceruk produk yang ditargetkan, Anda mendapatkan cara
                            yang
                            terjangkau untuk mempromosikan produk & layanan Anda.</p>
                    </div>
                    <!-- End Single Work -->
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <!-- Start Single Work -->
                    <div class="single-work wow fadeInUp" data-wow-delay=".6s">
                        <span class="serial">03</span>
                        <h3>Hasil Yang Luar Biasa</h3>
                        <p>Dapatkan hasil yang luar biasa dari postingan pekerjaan anda.</p>
                    </div>
                    <!-- End Single Work -->
                </div>
            </div>
        </div>


    </div>
</section>
<!-- End How Works Area -->

<!-- Start Items Grid Area -->
<section class="items-grid section" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Jobs Terpopuler & Terbaru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">There are many variations of passages of Lorem
                        Ipsum available, but the majority have suffered alteration in some form.</p>
                </div>
            </div>
        </div>
        <div class="single-head">
            <div class="row">

                @foreach($posts as $p)
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Grid -->
                    <div class="single-grid wow fadeInUp" data-wow-delay=".6s">
                        <div class="image">
                            <a href="{{ url('detail-jobs/'.$p->post_slug) }}" class="thumbnail">
                                @if($p->image && !filter_var($p->image, FILTER_VALIDATE_URL)) 
                                <img src="{{ asset('storage/posts/'.$p->image) }}" alt="{{ $p->title }}">
                                @else
                                <img src="{{ asset('storage/images/content.jpg') }}" alt="{{ $p->title }}">
                                @endif
                            </a>
                            <div class="author">
                                <div class="author-image">
                                    <a href="{{ url('detail-jobs/'.$p->post_slug) }}">
                                        @if ($p->avatar)
                                        <img src="{{ asset('storage/users-avatar/' . $p->avatar) }}" alt="#">
                                        @else
                                        <img src="{{ asset('storage/images/default.jpg') }}" alt="#">
                                        @endif
                                        <span>{{ $p->user_name }}</span></a>
                                </div>
                                @php
                                $currentDate = strtotime(date('Y-m-d'));
                                $createdDate = strtotime($p->created_at);

                                if (floor(($currentDate - $createdDate) / (60 * 60 * 24 * 7)) <= 1) {
                                    echo '<p class="sale"><i class="lni lni-alarm"></i> New</p>' ; } @endphp </div>
                                    @if ($p->average_rating > 3)
                                    <p class="item-position"><i class="lni lni-bolt"></i> Populer</p>
                                    @endif
                            </div>
                            <div class="content">
                                <div class="top-content">
                                    <a href="{{ url('jobs?category='.$p->category_slug) }}" class="tag">{{
                                        $p->category_name
                                        }}</a>
                                    <h3 class="title">
                                        <a href="{{ url('detail-jobs/'.$p->post_slug) }}">
                                            {{ implode(' ', array_slice(explode(' ', $p->title), 0, 10)) }}
                                        </a>
                                    </h3>
                                    <p class="updated-time">{{ $p->created_at->diffForHumans() }}</p>
                                    <div class="row">
                                        <div class="col">
                                            <ul class="rating d-flex align-items-center">
                                                @php
                                                $rating = $p->average_rating; // Nilai rata-rata rating dari setiap post
                                                $starCount = 5; // Jumlah bintang maksimal
                                                @endphp

                                                @for ($i = 1; $i <= $starCount; $i++) @if ($i <=$rating) <li><i
                                                        class="lni lni-star-filled"></i></li>
                                                    @else
                                                    <li><i class="lni lni-star"></i></li>
                                                    @endif
                                                    @endfor

                                                    <li><a class="ms-1"
                                                            href="{{ url('detail-jobs/'.$p->post_slug) }}">({{
                                                            $p->total_ratings ?? 0 }})</a></li>
                                            </ul>
                                        </div>
                                        <div class="col">
                                            <ul class="info-list">
                                                <li><a href="{{ url('detail-jobs/'.$p->post_slug) }}"><i
                                                            class="lni lni-timer"></i>{{ date('d M,
                                                        Y', strtotime($p->updated_at)) }} </a></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="bottom-content">
                                    <p class="price"><span>Rp. {{ number_format($p->komisi, 0, ',', '.')
                                            }}</span></p>


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

                                </div>
                            </div>
                        </div>
                        <!-- End Single Grid -->
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
</section>
<!-- /End Items Grid Area -->

<!-- Start Why Choose Area -->
<section class="items-grid why-choose section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Mengapa Memilih Kami</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Jadwal fleksibel, bekerja dengan tugas sederhana nyaman
                        dan akrab. Dari mana saja, kapan saja, kami siap untuk berkolaborasi dengan Anda.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="choose-content">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single List -->
                            <div class="single-list wow fadeInUp" data-wow-delay=".2s">
                                <i class="lni lni-briefcase"></i>
                                <h4>Tugas Sederhana, Uang Tambahan</h4>
                                <p>Kami menawarkan tugas-tugas online sederhana yang dapat Anda selesaikan dari rumah
                                    dan di mana saja.
                                    Dengan menyelesaikan tugas-tugas kecil ini, Anda dapat menghasilkan uang
                                    tambahan.</p>
                            </div>
                            <!-- Start Single List -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single List -->
                            <div class="single-list wow fadeInUp" data-wow-delay=".4s">
                                <i class="lni lni-timer"></i>
                                <h4>Fleksibilitas Waktu dan Lokasi</h4>
                                <p>Anda dapat bekerja kapan
                                    saja sesuai kenyamanan Anda, tanpa harus terikat dengan jam kerja yang kaku. Anda
                                    juga dapat melakukan tugas-tugas ini dari rumah atau di mana saja selama Anda
                                    memiliki akses internet.</p>
                            </div>
                            <!-- Start Single List -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single List -->
                            <div class="single-list wow fadeInUp" data-wow-delay=".6s">
                                <i class="lni lni-handshake"></i>
                                <h4>Penghasilan Adil dan Transparan</h4>
                                <p>Kami memiliki sistem penghasilan yang adil dan transparan. Setiap tugas memiliki
                                    penilaian yang jelas, Anda akan dibayar secara adil berdasarkan tingkat keberhasilan
                                    dan
                                    kualitas kerja Anda.</p>
                            </div>
                            <!-- Start Single List -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /End Why Choose Area -->

<!-- Start Call Action Area -->
<section class="call-action overlay section">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8 offset-lg-2 col-12">
                <div class="inner">
                    <div class="content">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            CARA GANDA UNTUK MENYELESAIKAN PEKERJAAN</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Saatnya memposting pekerjaan dengan banyak tugas.
                            Ini adalah cara yang bagus untuk mempekerjakan pekerja lepas yang memiliki keahlian yang
                            tepat sesuai kebutuhan pekerjaan Anda..</p>
                        <div class="button wow fadeInUp" data-wow-delay=".8s">
                            <a href="{{ url('/register') }}" class="btn">Daftar Employer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Call Action Area -->

<!-- Start Newsletter Area -->
<div class="newsletter section">
    <div class="container">
        <div class="inner-content">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="title">
                        <i class="lni lni-alarm"></i>
                        <h2>Newsletter</h2>
                        <p>We don't send spam so don't worry.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="form">
                        <form action="#" method="get" target="_blank" class="newsletter-form">
                            <input name="EMAIL" placeholder="Your email address" type="email">
                            <div class="button">
                                <button class="btn">Subscribe<span class="dir-part"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Newsletter Area -->
<script type="text/javascript">
    $(document).ready(function() {
    $('#search-btn').on('click', function() {
        var category = $('#category option:selected').val();
        var searchQuery = $('#search-input').val();
        var url = 'jobs';

        if (category && category !== 'none') {
            url += '?category=' + category;
        }

        if (searchQuery) {
            url += (category && category !== 'none' ? '&' : '?') + 'search=' + searchQuery;
        }

        window.location.href = url;
    });
});


</script>

@endsection