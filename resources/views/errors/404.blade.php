@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Page Not Found'))

@section('image')
<div style="background-image: url({{ asset('assets/svg/404.svg') }});"
    class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Maaf, halaman yang Anda cari tidak dapat ditemukan.'))