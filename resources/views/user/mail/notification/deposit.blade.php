@extends('user.mail.app')
@section('content')
<table class="wrapper table" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center td">
            <table class="content table-2" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="header td-2">
                        <a href="{{ url('/') }}" class="href">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="body td-3" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body table-3" align="center" width="570" cellpadding="0" cellspacing="0"
                            role="presentation">
                            <tr>
                                <td class="content-cell td-4">
                                    <h1 class="h1">
                                        Halo {{ $receiver['name'] }} !
                                    </h1>
                                    @if ($content['status'] <> 'Direct')
                                        @if ($content['status'] == 'Pending')
                                        <p class="p">
                                            Terimakasih telah melakukan deposit, berikut adalah informasi deposit anda.
                                        </p>
                                        @elseif ($content['status'] == 'Success')
                                        <p class="p">
                                            Deposit anda diterima, berikut adalah informasi deposit anda.
                                        </p>
                                        @elseif ($content['status'] == 'Canceled')
                                        <p class="p">
                                            Deposit anda dibatalkan, berikut adalah informasi deposit anda.
                                        </p>
                                        @endif
                                        <table class="subcopy table-7" width="100%" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <td class="td-6">
                                                    <p class="p">
                                                        - <b>ID:</b> {{ $content['id'] }}<br />
                                                        - <b>Metode:</b> {{ $content['method'] }}<br />
                                                        - <b>Jumlah:</b> Rp {{
                                                        number_format($content['amount'],0,',','.') }}<br />
                                                        - <b>Status:</b> {{ $content['status'] }}<br />
                                                        - <b>Alamat IP:</b> {{ $content['ip_address'] }}<br />
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        @if ($content['status'] == 'Pending')
                                        <table class="subcopy table-7" width="100%" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <td class="td-6">
                                                    <p class="p" style="font-size: 14px;">
                                                        Kami akan segera memproses Deposit anda, silahkan untuk melunasi
                                                        pembayaran terlebih dahulu.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        @endif
                                        @else
                                        <p class="p">
                                            Admin telah menambahkan anda deposit secara langsung, berikut adalah
                                            informasi deposit anda.
                                        </p>
                                        <table class="subcopy table-7" width="100%" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <td class="td-6">
                                                    <p class="p">
                                                        - <b>ID:</b> {{ $content['id'] }}<br />
                                                        - <b>Metode:</b> {{ $content['method'] }}<br />
                                                        - <b>Jumlah:</b> Rp {{
                                                        number_format($content['amount'],0,',','.') }}<br />
                                                        - <b>Status:</b> Success<br />
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td
                        style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                            role="presentation">
                            <tr>
                                <td class="content-cell td-7" align="center">
                                    <p class="p-2">
                                        © {{ date('Y') }} {{ Helper::website_config('main')->website_name }}. All rights
                                        reserved.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection