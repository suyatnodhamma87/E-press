@extends('layouts.presensi')
@section('header')
{{-- App Header --}}
<div class="appHeader bg-primary text.light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"><ion-icon>
        </a>
    </div>
    <div class="pagetitle">History</div>
    <div class="right"></div>
</div>
{{-- App Header --}}
@endsection

@section ('content')
<div class="row" style="margin-top:70px"> 
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="">Bulan</option>
                        @for ($i=1; $i<=12; $i++) <option value="{{ $i }}"{{ date("m") == $i ? 'selected' : '' }}> {{ $namabulan [$i] }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Tahun</option>
                        @php
                            $tahunmulai = 2023;
                            $tahunini = date ('Y');
                        @endphp
                        @for ($tahun = $tahunmulai; $tahun<= $tahunini; $tahun++) <option value="{{ $tahun }}" {{ date("Y") == $tahunini ? 'selected' : '' }}> {{ $tahun }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                   <button class="btn btn-primary btn-block" id="caridata">
                        <ion-icon name="search-outline"></ion-icon>
                            Seacrh
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="tampilhistory"></div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#caridata").click(function(e) {
           var bulan = $('#bulan').val();
           var tahun = $('#tahun').val();

           $.ajax({
            type: 'POST',
            url: '/gethistory',
            data: {
                _token: "{{ csrf_token() }}",
                bulan: bulan,
                tahun: tahun
            },
            cache: false,
            success: function(respond) {
                $("#tampilhistory").html(respond);
            }
           });
        });
    });
</script>
@endpush
