@extends('layouts.appAdmin')
@section('page', $page)
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-12 mb-4 order-0">

            <h4 class="fw-bold py-3 mb-4">@yield('page')</h4>


            <div class="row">

                <div class="col-lg-8 offset-lg-2">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Setting SMTP Email</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/smtp-email/update') }}">
                                @csrf

                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Host</label>
                                        <input type="text" name="host" class="form-control" value="{{ $smtp->host }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Email Dari</label>
                                        <input type="email" name="from" class="form-control" value="{{ $smtp->from }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Enkripsi</label>
                                                <select name="encryption" class="form-control">
                                                    <option value="0" @if ($smtp->encryption == null)
                                                        selected="selected" @endif>Tidak ada</option>
                                                    <option value="ssl" @if ($smtp->encryption == 'ssl')
                                                        selected="selected" @endif>SSL</option>
                                                    <option value="tls" @if ($smtp->encryption == 'tls')
                                                        selected="selected" @endif>TLS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Port</label>
                                                <input type="text" name="port" class="form-control"
                                                    value="{{ $smtp->port }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="custom-control custom-switch mb-3">
                                        <div class="form-check form-switch">
                                            <input id="auth" class="form-check-input" type="checkbox" name="auth"
                                                role="switch" @if ($smtp->auth == 'on') checked @endif>
                                            <label class="custom-control-label ms-2" for="auth">Autentikasi</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ $smtp->username }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control"
                                            value="{{ $smtp->password }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="custom-control custom-switch mb-3">
                                        <div class="form-check form-switch">
                                            <input id="email_aktivasi" class="form-check-input" type="checkbox"
                                                name="email_aktivasi" role="switch" @if ($smtp->email_aktivasi == 'on')
                                            checked @endif>
                                            <label class="custom-control-label ms-2" for="email_aktivasi">Mengirim email
                                                aktivasi
                                                akun untuk pengguna baru.</label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="mb-3">
                                    <div class="my-3">
                                        <a href="https://jetpedia.id/admin/settings/website_configs/test_email"
                                            class="btn btn-outline-info btn-sm">Kirim Email Percobaan</a>
                                        <small class="form-text text-muted d-block">Sistem akan mengirim email ke nilai
                                            dari
                                            bidang <strong> Email Dari </strong> yang Anda tetapkan di atas.
                                            Pastikan
                                            untuk menyimpan pengaturan terlebih dahulu!</small>
                                    </div>
                                </div> --}}

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</div>
<!--/ Basic Bootstrap Table -->
<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="auth"]').on('change', (event) => {
        if($(event.currentTarget).is(':checked')) {
            $('input[name="username"],input[name="password"]').removeAttr('disabled');
        } else {
            $('input[name="username"],input[name="password"]').attr('disabled', 'true');
        }
    });
    });
</script>
@endsection