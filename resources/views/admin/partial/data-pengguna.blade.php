<!-- Basic Bootstrap Table -->

<h5 class="card-header">@yield('page')</h5>
<div class="card-body">
    <div class="table-responsive" style="height: 500px;">
        @if($DataTabel && $DataTabel->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Saldo</th>
                    <th>Verifikasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($DataTabel as $d)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <ul class="list-unstyled users-list m-0 avatar-group">
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-xs pull-up" title="{{ $d->name }}">
                                    <img src="{{ asset('storage/users-avatar/' . $d->avatar) }}" alt="Avatar"
                                        class="rounded-circle" />
                                </li>
                            </ul>
                            <strong class="ms-2">{{ $d->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->email }}</td>
                    <td>{{ number_format($d->saldo, 0,',','.') }}</td>
                    <td>
                        @if ($d->email_verified_at)
                        <span class="badge bg-label-success me-1">Sudah Verifikasi</span>
                        @else
                        <span class="badge bg-label-danger me-1">Belum Verifikasi</span>
                        @endif
                    </td>
                    <td>
                        @if ($d->active_status == 1)
                        <span class="badge bg-label-success me-1">Aktif</span>
                        @else
                        <span class="badge bg-label-danger me-1">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);" id="tombol-edit"
                                    data-id="{{ $d->id }}" data-bs-toggle="modal" data-bs-target="#dataModal">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                @if (request()->segment(3) == "user-verifikasi")
                                <a id="verif" data-id="{{ $d->id }}" class="dropdown-item" href="javascript:void(0);">
                                    <i class="bx bx-user-check me-1"></i> Verifikasi
                                </a>
                                @endif
                                <a id="hapus" data-id="{{ $d->id }}" class="dropdown-item" href="javascript:void(0);">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @else
        <div class="">
            <div class="text-center pt-5" rowpan="5">
                <h6 style="color: #888;">Maaf data kosong</h6>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="card-body">
    @if($DataTabel && $DataTabel->count() > 0)
    <div class="demo-inline-spacing mt-4 ms-4 mb-4 d-flex justify-content-between">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($DataTabel->onFirstPage())
                <li class="disabled">
                    <a class="page-link" href="javascript:void(0);" style="cursor: no-drop">
                        <i class="tf-icon bx bx-chevrons-left"></i>
                    </a>
                </li>
                @else
                <li>
                    <a class="page-link" href="{{ $DataTabel->previousPageUrl() }}">
                        <i class="tf-icon bx bx-chevron-left"></i>
                    </a>
                </li>
                @endif

                @foreach ($DataTabel->getUrlRange(1, $DataTabel->lastPage()) as $page
                =>
                $url)
                @if ($page == $DataTabel->currentPage())
                <li class="page-item active">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endif
                @endforeach

                @if ($DataTabel->hasMorePages())
                <li>
                    <a class="page-link" href="{{ $DataTabel->nextPageUrl() }}">
                        <i class="tf-icon bx bx-chevron-right"></i>
                    </a>
                </li>
                @else
                <li class="disabled">
                    <a class="page-link" href="javascript:void(0);" style="cursor: no-drop">
                        <i class="tf-icon bx bx-chevron-right"></i>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <div class="float-end">
            <p class="pt-3">
                Menampilkan
                @if ($DataTabel->total() > 0)
                {{ $DataTabel->firstItem() }} - {{ $DataTabel->lastItem() }}
                @else
                0
                @endif
                dari {{ $DataTabel->total() }} data
            </p>
        </div>
    </div>
    @endif
</div>