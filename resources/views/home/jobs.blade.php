@extends('layouts.appHome')
@section('page', 'Jobs')
@section('content')
<!-- Start Breadcrumbs -->
{{-- <div class="breadcrumbs">
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
</div> --}}
<!-- End Breadcrumbs -->

<!-- Start Hero Area -->

<section class="category-page section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="category-sidebar">

                    <div class="single-widget search">
                        <h3>Cari @yield('page')</h3>
                        <form>
                            <input id="search-input" type="text" placeholder="Ketik Jobs..">
                            <button type="button"><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>

                    <div class="single-widget range">
                        <h3>Rentang Harga</h3>
                        <input type="range" class="form-range" id="range-ajax" name="range" step="1" min="100"
                            max="15000" value="100" onchange="rangePrimary.value = formatCurrency(this.value)">
                        <div class="range-inner">
                            <label>Minimal :</label>
                            <input type="text" class="ps-5" id="rangePrimary" placeholder="Rp. 100" />
                        </div>
                    </div>


                    <div class="single-widget">
                        <h3>Categories</h3>
                        <ul class="list">

                            @foreach ($Categories as $kat)
                            <li>
                                <a href="javascript:void(0);" id="catte" data-slug="{{ $kat->slug }}">
                                    @if ($kat->icon)
                                    <i class="lni {{ $kat->icon }}"></i>
                                    @else
                                    <i class="lni lni-briefcase"></i>
                                    @endif
                                    {{ $kat->name }}<span>{{ $postCounts[$kat->id] }}</span>
                                </a>
                            </li>
                            @endforeach


                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
                <div class="category-grid-list">
                    <div class="row">
                        <div class="col-12">

                            <div class="tab-content mb-5" id="spinner">
                                <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                    aria-labelledby="nav-grid-tab">
                                    <div class="row">
                                        <div class="col-12 text-center pt-5">
                                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"
                                                role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="posts-list" data-url="{{ url('jobs/ajax') }}">
                                @include('home.partial.jobs-load')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>


<script type="text/javascript">
    $(document).ready(function() {
        $('#spinner').hide();
        $(document).off('click', '.pagination-list li a'); // Menghapus event listener sebelumnya
        $(document).on('click', '.pagination-list li a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_user_data_pagination(page);
        });

        // Inisialisasi event listener saat halaman pertama kali dimuat
        bindRangeAjaxChange();

        function bindRangeAjaxChange() {
            $(document).off('change', '#range-ajax'); // Menghapus event listener sebelumnya
            $(document).on('change', '#range-ajax', function() {
                var rangeValue = $(this).val();
                fetch_user_data_range(rangeValue);
            });
        }

        function fetch_user_data_range(rangeValue) {
            var searchParams = new URLSearchParams(window.location.search);
            var categoryValue = searchParams.get('category');

            var currentPath = window.location.pathname;
            var newPath = currentPath + (currentPath.endsWith('/') ? '' : '?') + (categoryValue ? 'category=' + categoryValue : '');

            var newURL = newPath + (rangeValue ? (newPath.includes('?') ? '&' : '?') + 'range=' + rangeValue : '');

            $('#spinner').show();

            $.ajax({
                url: $("#posts-list").data("url"),
                data: { range: rangeValue, category: categoryValue },
                success: function(response) {
                    $('#spinner').hide();
                    $('#posts-list').html(response.partialView);
                    window.history.pushState(null, null, newURL);
                    bindPaginationClick(); // Menambahkan event listener untuk pagination setelah memuat data baru
                }
            });
        }

        function fetch_user_data_pagination(page) {
            var link = document.createElement('a');
            link.href = window.location.href;
            var searchParams = new URLSearchParams(link.search);

            var rangeIsi = searchParams.get("range");
            var categoryValue = searchParams.get("category");

            var currentPath = window.location.pathname;
            var newPath = currentPath + (currentPath.endsWith('/') ? '' : '?') + (categoryValue ? 'category=' + categoryValue : '');

            var newURL = newPath + (rangeIsi ? (newPath.includes('?') ? '&' : '?') + 'range=' + rangeIsi : '');

            $('#spinner').show();
            
            $('html, body').animate({ scrollTop: 0 }, 'fast');

            $.ajax({
                url: $("#posts-list").data("url"),
                data: { range: rangeIsi, category: categoryValue, page: page },
                success: function(response) {
                    $('#spinner').hide();
                    $('#posts-list').html(response.partialView);
                    bindPaginationClick();
                }
            });
        }

        function bindPaginationClick() {
            $(document).off('click', '.pagination-list li a');
            $(document).on('click', '.pagination-list li a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_user_data_pagination(page);
            });
        }

        $('#search-input').on('input', function() {
            var searchQuery = $(this).val();
            fetch_user_data_search(searchQuery);
        });

        function fetch_user_data_search(searchQuery) {
            var searchParams = new URLSearchParams(window.location.search);
            var categoryValue = searchParams.get('category');
            var rangeValue = searchParams.get('range');
            var page = searchParams.get('page');

            var currentPath = window.location.pathname;
            var newPath = currentPath + (currentPath.endsWith('/') ? '' : '?') + (categoryValue ? 'category=' + categoryValue : '');

            var newURL = newPath + (rangeValue ? (newPath.includes('?') ? '&' : '?') + 'range=' + rangeValue : '');

            $('#spinner').show();

            $.ajax({
                url: $("#posts-list").data("url") + (page ? '?page=' + page : ''),
                data: { search: searchQuery, range: rangeValue, category: categoryValue },
                success: function(response) {
                    $('#spinner').hide();
                    $('#posts-list').html(response.partialView);
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    bindPaginationClick(); // Menambahkan event listener untuk pagination setelah memuat data baru
                }
            });
        }
    
        
        $(document).on('click', '#catte', function() {
            var categoryId = $(this).data("slug");
            
            var searchParams = new URLSearchParams(window.location.search);
            var rangeValue = searchParams.get('range');

            var currentPath = window.location.pathname;
            var newPath = currentPath + (currentPath.endsWith('/') ? '' : '?') + 'category=' + categoryId;

            var newURL = window.location.origin + newPath + (rangeValue ? '&range=' + rangeValue : '');

            window.history.pushState(null, '', newURL);

            $('a[id^="catte"]').removeClass('active-catte');
            $(this).addClass('active-catte');

            $('#spinner').show();

            $.ajax({
                url: $("#posts-list").data("url"),
                data: { range: rangeValue, category: categoryId},
                success: function(response) {
                    $('#spinner').hide();
                    $('#posts-list').html(response.partialView);
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    bindPaginationClick(); // Menambahkan event listener untuk pagination setelah memuat data baru
                }
            });

        });

    });

</script>


<script>
    function formatCurrency(value) {
        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
        const formattedAmount = formatter.format(value);
        const formattedAmountWithoutSymbol = formattedAmount.replace('Rp.', '').trim();
        return formattedAmountWithoutSymbol;
    }
</script>
<!-- End About Area -->
@endsection