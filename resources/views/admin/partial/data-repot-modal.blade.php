@if($DataTabel && $DataTabel->count() > 0)
@php $no=1; @endphp
@foreach ($DataTabel as $d)
<tr>
    <td>
        {{ $no++ }}
    </td>
    <td>
        {{ $d->user->name }}
    </td>
    <td>
        {!! $d->alasan !!}
    </td>
</tr>
@endforeach
@else
<tr class="text-center">
    <td colspan="3">Data Kosong</td>
</tr>
@endif