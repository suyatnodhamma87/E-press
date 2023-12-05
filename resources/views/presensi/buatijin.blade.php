@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 430px !important;
    }
</style>
{{-- App Header --}}
<div class="appHeader bg-primary text.light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"><ion-icon>
        </a>
    </div>
    <div class="pagetitle">Form Ijin</div>
    <div class="right"></div>
</div>
{{-- App Header --}}
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <form method="POST" action="/presensi/storeijin" id="formijin" enctype="multypart/form-data">
            @csrf
            <div class="form-group basic">
                <div class="input-wrapper">
                   <input type="text" class="form-control datepicker" id="tgl_ijin" name="tgl_ijin" placeholder="Tanggal" autocomplete="off">
                     <i class="clear-input">
                        <ion-icon name="close-outline"></ion-icon>
                     </i>
                </div>
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Ijin/Sakit</option>
                    <option value="i">Ijin</option>
                    <option value="s">Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="keterangan"></textarea>
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

        $("#tgl_ijin").change(function(e) {
            var tgl_ijin = $(this).val();
            $.ajax ( {
                type:'POST',
                url: '/presensi/cekpengajuanijin',
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_ijin: tgl_ijin
                },
                cache:false,
                success: function(respond) {
                    if(respond == 1) {
                        Swal.fire({
                        title: 'Oops!',
                        text: 'Anda sudah mengajukan pada tanggal tersebut!',
                        icon: 'warning'
                        }).then((result) => {
                            $("tgl_ijin").val("");
                        });
                    }
                }
            });
        });
    });

    $('#formijin').submit(function() {
        var tgl_ijin = $("#tgl_ijin").val();
        var status = $("#status").val();
        var keterangan = $("#keterangan").val();
        if (tgl_ijin == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Tanggal harus diisi!',
                icon: 'warning'
                });
        } else if (status == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Status harus diisi!',
                icon: 'warning'
                });
        } else if (keterangan == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Keterangan harus diisi!',
                icon: 'warning'
                });
            return false;
        }

        });


</script>
@endpush
