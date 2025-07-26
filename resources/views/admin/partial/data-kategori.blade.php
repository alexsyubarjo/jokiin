<!-- Basic Bootstrap Table -->
<div class="card-header d-flex justify-content-between align-items-center mb-3">
    <h5 class="m-0">@yield('page')</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahdataModal">
        Tambah Kategori</button>
</div>
<div class="card-body">
    <div class="table-responsive" style="height: 500px;">
        @if($DataTabel && $DataTabel->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Icon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($DataTabel as $d)
                <tr>
                    <td>
                        <strong class="ms-2">{{ $d->name }}</strong>
                    </td>
                    <td>{{ $d->slug }}</td>
                    <td>{{ $d->description }}</td>
                    <td>{{ $d->icon }}</td>
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