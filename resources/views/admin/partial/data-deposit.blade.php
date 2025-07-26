<!-- Basic Bootstrap Table -->
<h5 class="card-header">@yield('page')</h5>
<div class="card-body">
    <div class="table-responsive" style="height: 500px;">
        @if($DataTabel && $DataTabel->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Ke Rekening</th>
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($DataTabel as $d)
                @php
                if($d->status === 'Sukses'){
                $stat = "success";
                }elseif ($d->status === 'Pending') {
                $stat = "warning";
                }elseif ($d->status === 'Cancel') {
                $stat = "danger";
                }elseif ($d->status === 'Error') {
                $stat = "danger";
                }else{
                $stat = "primary";
                }
                @endphp
                <tr>
                    <td><strong>{{ $d->user->name }}</strong></td>
                    <td>{{ $d->bank }}</td>
                    <td class="fw-bold">Rp {{ $d->nominal }}</td>
                    <td>
                        @if ($d->metode == "Manual")
                        <span class="badge bg-label-primary me-1">Manual</span>
                        @elseif ($d->metode == "Otomatis")
                        <span class="badge bg-label-success me-1">Otomatis</span>
                        @endif
                    </td>
                    <td>Permintaan Deposit {{ $d->created_at->format('d M Y, H:i') }}WIB</td>
                    <td>
                        <span class="badge bg-label-{{ $stat }} me-1">{{ $d->status }}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">

                                @if (request()->segment(3) == "permintaan-deposit")
                                <a id="data-konfirmasi" data-id="{{ $d->id }}" class="dropdown-item"
                                    href="javascript:void(0);">
                                    <i class="bx bx-check-circle me-1"></i> Konfirmasi
                                </a>
                                <a id="data-cancel" data-id="{{ $d->id }}" class="dropdown-item"
                                    href="javascript:void(0);">
                                    <i class="bx bx-x-circle me-1"></i> Cancel
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