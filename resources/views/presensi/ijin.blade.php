@extends('layouts.presensi')
@section('header')
{{-- App Header --}}
<div class="appHeader bg-primary text.light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"><ion-icon>
        </a>
    </div>
    <div class="pagetitle">Data Ijin / Sakit</div>
    <div class="right"></div>
</div>
{{-- App Header --}}
@endsection
@section('content')
<div class="col" style="margin-top:60px">
    @foreach ($dataijin as $d)
<ul class="listview image-listview">
    <li>
        <div class="item">
            <div class="in">
                <div>
                    <b>{{ date ("d-m-Y", strtotime($d->tgl_ijin)) }} ({{ $d->status== "s" ? "Sakit" : "Ijin" }})</b><br>
                    <small class="text-muted">{{ $d->keterangan }}</small>
                </div>
                @if ($d->status_approval == 0)
                    <span class="badge bg-warning">Waiting</span>
                @elseif ($d->status_approval == 1)
                    <span class="badge bg-success">Approved</span>
                @elseif ($d->status_approval == 2)
                    <span class="badge bg-danger">Ditolak</span>
                @endif
             </div>
        </div>
    </li>
</ul>
@endforeach
</div>
<div class="fab-button bottom-right" style="margin-bottom:70px">
    <a href="/presensi/buatijin" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection
