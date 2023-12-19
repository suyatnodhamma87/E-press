@extends('layouts.presensi')
@section('header')
{{-- App Header --}}
<div class="appHeader bg-dongker text.light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"><ion-icon>
        </a>
    </div>
    <div class="pagetitle">Data Ijin / Sakit / Cuti</div>
    <div class="right"></div>
</div>

<style>
    .historicontent {
        display: flex;
        gap: 1px;
    }
    .datapresensi {
        margin-left: 10px;
    }
    .status {
        position:absolute;
        right: 20px;
    }
</style>
{{-- App Header --}}

@endsection
@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <div class="col">
            @php
            $messagesuccess = Session::get('success');
            $messageerror = Session::get('error');
            @endphp
            @if(Session::get('success'))
            <div class="alert alert-success">
                {{ $messagesuccess }}
            </div>
            @endif
            @if(Session::get('error'))
            <div class="alert alert-warning">
                {{ $messageerror }}
            </div>
            @endif
        </div>
        <form method="GET" action="/presensi/ijin">
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
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row" style="position: fixed; width:100%; margin:auto; overflow-y:scroll; height:430px">
    <div class="col" style="margin-top:40px; margin-bottom:100px">
        @foreach ($dataijin as $d)
        @php
            if($d->status=="i") {
                $status= "Ijin";
            } else if ($d->status=="s") {
                $status= "Sakit";
            } else if ($d->status== "c") {
                $status= "Cuti";
            } else {
                $status= "Not found";
            }
        @endphp
        <div class="card mt-1 card_ijin" kode_ijin="{{ $d->kode_ijin }}" data-toggle="modal" status_approval="{{ $d->status_approval }}" data-target="#actionSheetIconed">
            <div class="card-body">
                <div class="historicontent">
                    <div class="iconpresensi">
                        @if ($d->status=="i")
                        <ion-icon name="information-circle-outline" style="font-size: 45px; color:blue"></ion-icon>
                        @elseif ($d->status== "s")
                        <ion-icon name="medkit-outline" style="font-size: 45px; color:red"></ion-icon>
                        @elseif ($d->status=="c")
                        <ion-icon name="mail-unread-outline" style="font-size: 45px; color:orange"></ion-icon>
                        @endif
                    </div>
                    <div class="datapresensi">
                        <h3 style="line-height: 3px">{{ date("d-m-Y", strtotime($d->tgl_ijin_dari)) }} ({{ $status }})</h3>
                        <small>{{ date("d-m-Y",strtotime($d->tgl_ijin_dari)) }} s/d {{ date("d-m-Y", strtotime($d->tgl_ijin_sampai)) }} </small>
                        <p>
                            @if ($d->status=="c")
                                <span class="badge bg-warning">{{ $d->nama_cuti }}</span>
                            @endif
                            - {{ $d->alasan }}
                            <br>
                            @if (!empty($d->doc_sid))
                            <span style="color:blue">
                            <ion-icon name="document-attach-outline" ></ion-icon>
                            Lihat SID
                            </span>
                            @endif
                        </p>
                    </div>

                    <div class="status">
                        @if ($d->status_approval == "0")
                        <span class="badge bg-warning">Waiting</span>
                        @elseif ($d->status_approval == "1")
                        <span class="badge bg-success">Disetujui</span>
                        @elseif ($d->status_approval == "2")
                        <span class="badge bg-success">Disetujui</span>
                        @endif
                        <p style="margin-top: 5px; font-weight:bold">{{ hitungtotalhari($d->tgl_ijin_dari, $d->tgl_ijin_sampai) }} Hari</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


{{-- tombol ijin user --}}
<div class="fab-button animate bottom-right dropup" style="margin-bottom: 70px">
    <a href="#" class="fab bg-primary" data-toggle="dropdown">
        <ion-icon name="add-circle-outline"></ion-icon>
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item bg-primary" href="/ijintidakmasuk">
            <ion-icon name="information-circle-outline"></ion-icon>
            <p>Tidak Masuk</p>
        </a>
        <a class="dropdown-item bg-primary" href="/ijinsakit">
            <ion-icon name="medkit-outline"></ion-icon>
            <p>Sakit</p>
        </a>
        <a class="dropdown-item bg-primary" href="/ijincuti">
            <ion-icon name="mail-unread-outline"></ion-icon>
            <p>Cuti</p>
        </a>
    </div>
</div>

<div class="modal fade action-sheet" id="actionSheetIconed" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Action</h5>
            </div>
            <div class="modal-body" id="showact">

            </div>
        </div>
    </div>
</div>

<div class="modal fade dialogbox" id="deleteConfirm" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yakin Hapus?</h5>
            </div>
            <div class="modal-body">
                Data Pengajuan Ijin Akan Dihapus
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-dismiss="modal">Batalkan</a>
                    <a href="" class="btn btn-text-primary" id="hapuspengajuan">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $(".card_ijin").click(function(e) {
                var kode_ijin = $(this).attr("kode_ijin");
                var status_approval = $(this).attr("status_approval");

                if(status_approval==1) {
                    Swal.fire({
                        titlle:'Oops !',
                        text: 'Data sudah disetujui, tidak dapat diubah!',
                        icon: 'success'
                    })
                } else {
                $("#showact").load('/ijin/' + kode_ijin + '/showact');
                }
            });
        });
    </script>
@endpush
