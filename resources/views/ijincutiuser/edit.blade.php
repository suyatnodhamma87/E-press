@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 460px !important;
    }
    #alasan {
        height: 9rem !important;
    }
</style>
{{-- App Header --}}
<div class="appHeader bg-primary text.light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"><ion-icon>
        </a>
    </div>
    <div class="pagetitle">Edit Ijin Cuti</div>
    <div class="right"></div>
</div>
{{-- App Header --}}
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <form method="POST" action="/ijincuti/{{ $dataijin->kode_ijin }}/update" id="formijincuti" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" value="{{ $dataijin->tgl_ijin_dari }}"  id="tgl_ijin_dari" name="tgl_ijin_dari" placeholder="Dari" class="form-control datepicker" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" value="{{ $dataijin->tgl_ijin_sampai }}"  id="tgl_ijin_sampai" name="tgl_ijin_sampai" placeholder="Sampai" class="form-control datepicker" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" value=""  id="total_hari" name="total_hari" class="form-control" placeholder="Total Hari" readonly>
            </div>
            <div class="form-group">
                <select id="kode_cuti" name="kode_cuti" class="form-control selectmaterialize">
                    <option value="">Pilih Jenis Cuti</option>
                    @foreach ($datacuti as $d)
                    <option {{ $dataijin->kode_cuti == $d->kode_cuti ? 'selected' : '' }} value="{{ $d->kode_cuti }}">{{ $d->nama_cuti }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="text" value="{{ $dataijin->alasan }}"  id="alasan" name="alasan" class="form-control" placeholder="Alasan">
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <ion-icon name="send-outline"></ion-icon>
                    Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });

        function loadtotalhari(){
            var dari = $("#tgl_ijin_dari").val();
            var sampai = $("#tgl_ijin_sampai").val();
            var date1 = new Date(dari);
            var date2 = new Date(sampai);

            var Difference_In_Time = date2.getTime() - date1.getTime();
            var Difference_In_Days = Difference_In_Time / (1000*3600*24);

            if(dari=="" || sampai=="") {
                var totalhari = 0;
            }else {
                var totalhari = Difference_In_Days + 1;
            }

            $("#total_hari").val(totalhari + " hari");
        }

        $("#tgl_ijin_dari, #tgl_ijin_sampai").change(function(e) {
            loadtotalhari();
        });
        loadtotalhari();

    });

    $('#formijincuti').submit(function() {
        var tgl_ijin_dari = $("#tgl_ijin_dari").val();
        var tgl_ijin_sampai = $("#tgl_ijin_sampai").val();
        var alasan = $("#alasan").val();
        var kode_cuti = $("#kode_cuti").val();
        if (tgl_ijin_dari == "" || tgl_ijin_sampai == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Tanggal harus diisi!',
                icon: 'warning'
                });
                return false;
        }else if (kode_cuti == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Jenis Cuti harus diisi!',
                icon: 'warning'
                });
                return false;
        } else if (alasan == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Alasan harus diisi!',
                icon: 'warning'
                });
                return false;
        }

        });


</script>
@endpush
