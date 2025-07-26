<div class="dashboard-sidebar">
    <div class="row align-items-center">
        <div class="user-image col">
            @if ($user->avatar)
            <img src="{{ asset('storage/users-avatar/' . $user->avatar) }}" alt="#">
            @else
            <img src="{{ asset('storage/images/default.jpg') }}" alt="#">
            @endif
            <h3>{{ $user->name }}
                <span><a href="javascript:void(0)">{{ '@' . $user->username }}</a></span>
            </h3>

        </div>

        <div class="col-auto me-3">

            <div class="d-none d-sm-none d-lg-block d-md-block">
                <div class="dropdown">
                    <button class="btn btn-ungu dropdown-toggle btn-sm" type="button" id="dd-role" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $user->role }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dd-role">
                        <li>
                            <a id="a-role" class="dropdown-item" href="{{ url("dashboard/ganti-role") }}">
                                {{ ($user->role === "Worker") ? "Employer" : "Worker" }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-sm-block d-lg-none d-md-none">
                <div class="dropdown">
                    <button class="btn btn-ungu dropdown-toggle btn-sm" type="button" id="dd-role" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $user->role }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dd-role">
                        <li>
                            <a id="a-role" class="dropdown-item" href="{{ url("dashboard/ganti-role") }}">
                                {{ ($user->role === "Worker") ? "Employer" : "Worker" }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    @if ($user->role === "Worker")

    <div class="dashboard-menu">
        <ul>
            <li>
                <a class="{{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <i class="lni lni-dashboard"></i> Dashboard
                </a>
            </li>

            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/pesan') ? 'active' : '' }}"
                    href="{{ url('dashboard/pesan') }}">
                    <i class="lni lni-envelope"></i> Pesan
                    @if (!empty($notif_pesan))
                    <span class="notif-tugas">{{ $notif_pesan }}</span>
                    @endif
                </a>
            </li>

            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/task') ? 'active' : '' }}"
                    href="{{ url('dashboard/task') }}">
                    <i class="lni lni-radio-button"></i> Tugasku
                </a>
            </li>

            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/jobs') ? 'active' : '' }}" target="_blank"
                    href="{{ url('jobs') }}">
                    <i class="lni lni-briefcase"></i> Jobs
                </a>
            </li>

            <li class="nav-item">
                <a class="dd-menu-side collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                    data-bs-target="#submenu-side" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="lni lni-wallet"></i> Dompet
                </a>
                <ul class="sub-menu-side collapse" id="submenu-side" style="margin-left: 30px">

                    <li
                        class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/tarik-saldo') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/tarik-saldo') }}">
                            Tarik Saldo
                        </a>
                    </li>
                    <li
                        class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/riwayat-penarikan') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/riwayat-penarikan') }}">
                            Riwayat Penarikan
                        </a>
                    </li>
                    <li class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/rekening') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/rekening') }}">
                            Rekening
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/logs') ? 'active' : '' }}"
                    href="{{ url('dashboard/logs') }}">
                    <i class="lni lni-alarm-clock"></i> Logs
                </a>
            </li>
            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/referral') ? 'active' : '' }}"
                    href="{{ url('dashboard/referral') }}">
                    <i class="lni lni-handshake"></i> Referral
                </a>
            </li>
            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/edit-profile') ? 'active' : '' }}"
                    href="{{ url('dashboard/edit-profile') }}">
                    <i class="lni lni-pencil-alt"></i> Edit Profile
                </a>
            </li>

        </ul>

        <div class="button">
            <a href="javascript:void(0)" class="btn" id="logoutBtn2">Logout</a>
        </div>
    </div>

    @elseif ($user->role === "Employer")

    <div class="dashboard-menu">
        <ul>
            <li>
                <a class="{{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <i class="lni lni-dashboard"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="dd-menu-side collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                    data-bs-target="#submenu-side-tugas" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="lni lni-briefcase"></i> Data Tugas
                    @if (!empty($notifTugas))
                    <span class="notif-tugas">{{ $notifTugas }}</span>
                    @endif
                </a>
                <ul class="sub-menu-side collapse" id="submenu-side-tugas" style="margin-left: 30px">

                    <li
                        class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/tugas-pending') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/tugas-pending') }}">
                            Tugas Pending
                            @if (!empty($notifTugas))
                            <span class="notif-tugas">{{ $notifTugas }}</span>
                            @endif
                        </a>
                    </li>
                    <li
                        class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/semua-tugas') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/semua-tugas') }}">
                            Semua Tugas
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/pesan') ? 'active' : '' }}"
                    href="{{ url('dashboard/pesan') }}">
                    <i class="lni lni-envelope"></i> Pesan
                    @if (!empty($notif_pesan))
                    <span class="notif-tugas">{{ $notif_pesan }}</span>
                    @endif
                </a>
            </li>

            <li>
                <a class="{{ Request::is('dashboard/posts*') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                    <i class="lni lni-circle-plus"></i> Data Jobs
                </a>
            </li>

            <li class="nav-item">
                <a class="dd-menu-side collapsed {{ Str::startsWith(Request::path(), 'dashboard/invoice-deposit') ? 'active' : '' }}"
                    href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#submenu-side"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="lni lni-wallet"></i> Dompet
                </a>
                <ul class="sub-menu-side collapse" id="submenu-side" style="margin-left: 30px">

                    <li
                        class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/deposit-saldo') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/deposit-saldo') }}">
                            Deposit
                        </a>
                    </li>
                    <li
                        class="nav-item {{ Str::startsWith(Request::path(), 'dashboard/riwayat-deposit') ? 'active' : '' }}">
                        <a href="{{ url('dashboard/riwayat-deposit') }}">
                            Riwayat Deposit
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="{{ Str::startsWith(Request::path(), 'dashboard/edit-profile') ? 'active' : '' }}"
                    href="{{ url('dashboard/edit-profile') }}">
                    <i class="lni lni-pencil-alt"></i> Edit Profile
                </a>
            </li>

        </ul>

        <div class="button">
            <a href="javascript:void(0)" class="btn" id="logoutBtn2">Logout</a>
        </div>
    </div>
    @endif

</div>


<script>
    $(document).ready(function() {
        
        $('#dd-role').on('click', function() {
            $(this).siblings('.dropdown-menu').toggle();
        });
        
        // Mendapatkan URL halaman saat ini
        var currentUrl = window.location.href;

        // Memeriksa setiap tautan submenu
        $('.sub-menu-side li a').each(function() {
            var submenuUrl = $(this).attr('href');

            // Membandingkan URL halaman saat ini dengan tautan submenu
            if (currentUrl.indexOf(submenuUrl) !== -1) {
                // Menambahkan kelas "show" pada submenu
                $(this).parents('.sub-menu-side').addClass('show');
                $(this).addClass('active');
            }
        });
    });
</script>