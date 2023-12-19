@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 460px !important;
    }
    #alasan {
        height: 6rem !important;
    }
</style>
{{-- App Header --}}
<div class="appHeader bg-primary text.light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"><ion-icon>
        </a>
    </div>
    <div class="pagetitle">Edit Ijin Sakit</div>
    <div class="right"></div>
</div>
{{-- App Header --}}
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <form method="POST" action="/ijinsakit/{{ $dataijin->kode_ijin }}/update" id="formijinsakit" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" value="{{ $dataijin->tgl_ijin_dari }}" id="tgl_ijin_dari" name="tgl_ijin_dari" placeholder="Dari" class="form-control datepicker" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" value="{{ $dataijin->tgl_ijin_sampai }}" id="tgl_ijin_sampai" name="tgl_ijin_sampai" placeholder="Sampai" class="form-control datepicker" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" value="" id="total_hari" name="total_hari" class="form-control" placeholder="Total Hari" readonly>
            </div>
            @if ($dataijin->doc_sid != null)
                <div class="row">
                    <div class="col-12">
                        @php
                            $docsid = Storage::url('/uploads/sid/'.$dataijin->doc_sid);
                        @endphp
                        <img src="{{ url($docsid) }}" alt="" width="100">
                    </div>
                </div>
            @endif
            <div class="custom-file-upload" id="fileUpload1" style="height: 90px !important">
                <input type="file" name="sid" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                            <i>Upload Surat Dokter</i>
                        </strong>
                    </span>
                </label>
            </div>
            <div class="form-group">
                <input type="text" value="{{ $dataijin->alasan }}"   id="alasan" name="alasan" class="form-control" placeholder="Alasan">
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


        // $("#tgl_ijin").change(function(e) {
        //     var tgl_ijin = $(this).val();
        //     $.ajax ( {
        //         type:'POST',
        //         url: '/presensi/cekpengajuanijin',
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             tgl_ijin: tgl_ijin
        //         },
        //         cache:false,
        //         success: function(respond) {
        //             if(respond == 1) {
        //                 Swal.fire({
        //                 title: 'Oops!',
        //                 text: 'Anda sudah mengajukan pada tanggal tersebut!',
        //                 icon: 'warning'
        //                 }).then((result) => {
        //                     $("tgl_ijin").val("");
        //                 });
        //             }
        //         }
        //     });
        // });
    });

    $('#formijin').submit(function() {
        var tgl_ijin_dari = $("#tgl_ijin_dari").val();
        var tgl_ijin_sampai = $("#tgl_ijin_sampai").val();
        var status = $("#status").val();
        var keterangan = $("#alasan").val();
        if (tgl_ijin_dari == "" || tgl_ijin_sampai == "") {
            Swal.fire({
                title: 'Oops!',
                text: 'Tanggal harus diisi!',
                icon: 'warning'
                });
        } else if (alasan == "") {
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
