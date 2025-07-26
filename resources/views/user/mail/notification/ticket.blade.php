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
                                        @if ($content['status'] == 'Waiting')
                                        <p class="p">
                                            Admin akan segera membalas tiket anda, berikut adalah informasi tiket anda.
                                        </p>
                                        @elseif ($content['status'] == 'Replied')
                                        <p class="p">
                                            Admin telah membalas tiket anda, berikut adalah informasi tiket anda.
                                        </p>
                                        @elseif ($content['status'] == 'Closed')
                                        <p class="p">
                                            Admin telah menutup tiket anda, berikut adalah informasi tiket anda.
                                        </p>
                                        @endif
                                        <table class="subcopy table-7" width="100%" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <td class="td-6">
                                                    <p class="p">
                                                        - <b>ID:</b> {{ $content['id'] }}<br />
                                                        - <b>Subject:</b> {{ $content['subject'] }}<br />
                                                        - <b>Status:</b> {{ $content['status'] }}<br />
                                                        - <b>Alamat IP:</b> {{ $content['ip_address'] }}<br />
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        @if ($content['status'] == 'Waiting')
                                        <table class="subcopy table-7" width="100%" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <td class="td-6">
                                                    <p class="p" style="font-size: 14px;">
                                                        Admin akan segera membalas tiket anda, silahkan untuk menunggu.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        @endif
                                        @else
                                        <p class="p">
                                            Admin telah mengirimkan anda tiket, berikut adalah informasi tiket anda.
                                        </p>
                                        <table class="subcopy table-7" width="100%" cellpadding="0" cellspacing="0"
                                            role="presentation">
                                            <tr>
                                                <td class="td-6">
                                                    <p class="p">
                                                        - <b>ID:</b> {{ $content['id'] }}<br />
                                                        - <b>Subject:</b> {{ $content['subject'] }}<br />
                                                        - <b>Status:</b> {{ $content['status'] }}<br />
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