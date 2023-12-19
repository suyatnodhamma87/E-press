@extends('layouts.presensi')
@section('header')
{{-- App Header --}}
<div class="appHeader bg-dongker text.light">
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
            <div class="col-8">
                <div class="form-group">
                    <select name="bulan" id="bulan" class="form-control selectmaterialize">
                        <option value="">Bulan</option>
                        @for ($i= 1; $i<=12; $i++)
                        <option {{ Request('bulan') == $i ? 'selected' : '' }} value="{{ $i }}"> {{ $namabulan[$i] }} </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select name="tahun" id="tahun" class="form-control selectmaterialize">
                        <option value="">Tahun</option>
                        @php
                            $tahun_awal = 2022;
                            $tahun_sekarang = date("Y");
                            for($t = $tahun_awal; $t <= $tahun_sekarang; $t++) {
                                if (Request('tahun')==$t){
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo "<option $selected value='$t'>$t</option>";}
                        @endphp
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary w-100" id="caridata">Search</button>
        </div>
    </div>
</div>
<div class="row mt-2" style="position: fixed; width:100%; margin:auto; overflow-y:scroll; height:430px">
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
