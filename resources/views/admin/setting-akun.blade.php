@extends('layouts.appAdmin')
@section('page', $page)
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-12 mb-4 order-0">

            <h4 class="fw-bold py-3 mb-4">@yield('page')</h4>


            <div class="row">
                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Setting Profile</h5>
                            {{-- <small class="text-muted float-end">Default label</small> --}}
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/setting-akun/update') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama Lengkap"
                                        value="{{ $user->name }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Alamat Email"
                                        value="{{ $user->email }}">
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Ganti Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('admin/setting-akun/update-password') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Password Lama</label>
                                    <input type="password" class="form-control ds-pw" name="password"
                                        placeholder="Password Lama">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control ds-pw" name="password-baru"
                                        id="password-baru" placeholder="Password Baru">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control ds-pw" name="password-konfirmasi"
                                        id="password-konfirmasi" placeholder="Konfirmasi Password Baru">
                                    <div class="invalid-feedback" role="alert" id="password-konfirmasi-error"></div>
                                </div>

                                <button id="submit-button" type="submit" class="btn btn-primary">Update</button>
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
        var passwordInput = $('#password-baru');
        var confirmPasswordInput = $('#password-konfirmasi');
        var submitButton = $('#submit-button');
        var inputs = $('.ds-pw');

        var allFilled = true;

        inputs.each(function() {
            if ($(this).val() === '') {
                allFilled = false;
                return false; // Menghentikan loop jika ada input yang kosong
            }
        });

        submitButton.prop('disabled', !allFilled);

        inputs.on('keyup', function() {
            var allFilled = true;

            inputs.each(function() {
                if ($(this).val() === '') {
                    allFilled = false;
                    return false; // Menghentikan loop jika ada input yang kosong
                }
            });

            var password = passwordInput.val();
            var confirmPassword = confirmPasswordInput.val();

            if (password === confirmPassword) {
                confirmPasswordInput.removeClass('is-invalid');
                $('#password-konfirmasi-error').text('');
            } else {
                confirmPasswordInput.addClass('is-invalid');
                $('#password-konfirmasi-error').text('Konfirmasi password tidak sesuai.');
                allFilled = false; // Set allFilled menjadi false jika konfirmasi password tidak sesuai
            }

            submitButton.prop('disabled', !allFilled);
        });
    });

</script>

@endsection