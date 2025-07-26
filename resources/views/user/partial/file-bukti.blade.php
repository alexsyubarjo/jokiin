@foreach($Tugas as $key => $value)
@php
$labels = [
'proof1' => 'Bukti File 1',
'proof2' => 'Bukti File 2',
'proof3' => 'Bukti File 3',
// Tambahkan label lainnya sesuai kebutuhan
];
$label = isset($labels[$key]) ? $labels[$key] : $key;
@endphp

<div class="mb-3 pb-5">
    <h5 class="fw-bold">{{ count($Tugas) === 1 && $key === 'proof1' ? 'Bukti File' : $label }}</h5>
    <a href="{{ asset('storage/tugas/' . $value) }}" target="_blank">
        <img src="{{ asset('storage/tugas/' . $value) }}" class="img-fluid" alt="">
    </a>
</div>
@endforeach