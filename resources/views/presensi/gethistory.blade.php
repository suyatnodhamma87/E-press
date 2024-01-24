@if ($history->isEmpty())
<div class="alert alert-outline-warning">
    <p> Tidak ada data!</p>
</div>
@endif

<style>
    .historicontent {
        display: flex;
    }
    .datapresensi {
        margin-left:10px;
    }
</style>

@foreach ($history as $h)
@if ($h->status == "h")
<div class="card mt-1">
    <div class="card-body">
        <div class="historicontent">
            <div class="iconpresensi">
                <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
            </div>
            <div class="datapresensi">
                <h3 style="line-height: 2px;"> {{ $h->kode_jamkerja }}</h3>
                <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($h->tgl_presensi)) }}</h4>
                <span>
                    {!! $h->jam_in != null ? date("H:i |", strtotime($h->jam_in)) : '<span class="text-danger">Belum Absen</span>' !!}
                </span>
                <span>
                    {!! $h->jam_out != null ? date("H:i", strtotime($h->jam_out)) : '<span class="text-danger">- Belum Absen</span>' !!}
                </span>

                <div id="keterangan" class="mt-2">
                    @php
                        $jam_in = date("H:i", strtotime($h->jam_in));
                        $jam_masuk = date("H:i", strtotime($h->jam_masuk));

                        $jadwal_jam_masuk = $h->tgl_presensi. " " .$jam_masuk;
                        $jam_presensi = $h->tgl_presensi. " " .$jam_in
                    @endphp
                    @if ($jam_in > $jam_masuk)
                    @php
                        $jamterlambat = hitungjamterlambat($jadwal_jam_masuk, $jam_presensi);
                    @endphp
                        <span class="danger">Terlambat - {{ $jamterlambat }}</span>
                    @else
                        <span class="color:green">Tepat Waktu</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@elseif($h->status=="i")
<div class="card mt-1">
    <div class="card-body">
        <div class="historicontent">
            <div class="iconpresensi">
                <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
            </div>
            <div class="datapresensi">
                <h3 style="line-height: 2px;">IJIN (Tidak Masuk)</h3>
                <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($h->tgl_presensi)) }}</h4>
                <span class="text-info">{{ $h->nama_cuti }}</span>
                <span> {{ $h->alasan }}</span>
            </div>
        </div>
    </div>
</div>
@elseif($h->status=="s")
<div class="card mt-1">
    <div class="card-body">
        <div class="historicontent">
            <div class="iconpresensi">
                <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
            </div>
            <div class="datapresensi">
                <h3 style="line-height: 2px;">IJIN (Sakit)</h3>
                <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($h->tgl_presensi)) }}</h4>
                <span class="text-info">{{ $h->nama_cuti }}</span>
                <span> {{ $h->alasan }}</span>
            </div>
        </div>
    </div>
</div>
@elseif($h->status=="c")
<div class="card mt-1">
    <div class="card-body">
        <div class="historicontent">
            <div class="iconpresensi">
                <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
            </div>
            <div class="datapresensi">
                <h3 style="line-height: 2px;">IJIN (Cuti)</h3>
                <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($h->tgl_presensi)) }}</h4>
                <span class="text-info">{{ $h->nama_cuti }}</span>
                <span> {{ $h->alasan }}</span>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
