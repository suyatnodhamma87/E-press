@extends('layouts.presensi')
@section('content')

<style>
    .logout {
        position: absolute;
        color: white;
        font-size: 30px;
        text-decoration: none;
        right:20px;
    }
</style>

<!-- App Capsule -->
<div id="appCapsule">
    <div class="section" id="user-section">
        <a href="/proseslogout" class="logout">
            <ion-icon name="power-outline"></ion-icon>
        </a>
        <div id="user-detail">
            <div class="avatar">
                @if(!empty(Auth::guard('karyawan')->user()->foto))
                @php
                    $path = Storage::url('uploads/karyawan/'.Auth::guard('karyawan')->user()->foto);
                @endphp
                <img src="{{ url($path) }}" alt="avatar" class="imaged w64" style="height:60px">
                @else
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>

            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard ('karyawan')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
                <span style="font-size:8" id="user-role"> - {{ Auth::guard('karyawan')->user()->kode_anper}}</span>
            </div>
        </div>
    </div>


    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <h3>PT. Rajawali Parama Konstruksi <br>E-Press</h3>
                           {{-- <img class="responsive" width="100%" height="auto" src="{{ asset('assets/img/home/1_rpk.png') }}"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/ijin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="section mt-5" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                {{-- <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum absen'  }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini != null && $presensihariini->jam_out ? $presensihariini->jam_out : 'Belum absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <div class="section mt-3" id="rekappresensi">
            <h3 style="text-align: center">Informasi {{ $namabulan[$bulanini] }} {{ $tahunini }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger"
                            style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999">{{ $rekappresensi->jmlhadir }}</span>
                            <ion-icon name="finger-print-outline" style="font-size: 1.8rem" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger"
                            style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999">{{ $rekappresensi->jmlijin }}</span>
                            <ion-icon name="mail-unread-outline" style="font-size: 1.8rem" class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Ijin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger"
                            style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999">{{ $rekappresensi->jmlsakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.8rem" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger"
                            style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999"> {{ $rekappresensi->jmlcuti }}</span>
                            <ion-icon name="mail-unread-outline" style="font-size: 1.8rem" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Cuti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <style>
                        .historicontent {
                            display: flex;
                            margin-top: 10px;
                        }
                        .datapresensi {
                            margin-left:10px;
                        }
                    </style>
                    @foreach($historybulanini as $item)
                    @if ($item->status == "h")
                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="historicontent">
                                <div class="iconpresensi">
                                    <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
                                </div>
                                <div class="datapresensi">
                                    <h3 style="line-height: 2px;"> {{ $item->nama_jamkerja }}</h3>
                                    <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($item->tgl_presensi)) }}</h4>
                                    <span>
                                        {!! $item->jam_in != null ? date("H:i", strtotime($item->jam_in)) : '<span class="text-danger">Belum Absen</span>' !!}
                                    </span>
                                    <span>
                                        {!! $item->jam_out != null ? date("H:i", strtotime($item->jam_out)) : '<span class="text-danger">- Belum Absen</span>' !!}
                                    </span>

                                    <div id="keterangan" class="mt-2">
                                        @php
                                            $jam_in = date("H:i", strtotime($item->jam_in));
                                            $jam_masuk = date("H:i", strtotime($item->jam_masuk));

                                            $jadwal_jam_masuk = $item->tgl_presensi. " " .$jam_masuk;
                                            $jam_presensi = $item->tgl_presensi. " " .$jam_in
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
                    @elseif($item->status=="i")
                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="historicontent">
                                <div class="iconpresensi">
                                    <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
                                </div>
                                <div class="datapresensi">
                                    <h3 style="line-height: 2px;">IJIN (Tidak Masuk)</h3>
                                    <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($item->tgl_presensi)) }}</h4>
                                    <span class="text-info">{{ $item->nama_cuti }}</span>
                                    <span> {{ $item->alasan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($item->status=="s")
                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="historicontent">
                                <div class="iconpresensi">
                                    <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
                                </div>
                                <div class="datapresensi">
                                    <h3 style="line-height: 2px;">IJIN (Sakit)</h3>
                                    <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($item->tgl_presensi)) }}</h4>
                                    <span class="text-info">{{ $item->nama_cuti }}</span>
                                    <span> {{ $item->alasan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($item->status=="c")
                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="historicontent">
                                <div class="iconpresensi">
                                    <ion-icon style="font-size:48px; color:orange" name="finger-print-outline"></ion-icon>
                                </div>
                                <div class="datapresensi">
                                    <h3 style="line-height: 2px;">IJIN (Cuti)</h3>
                                    <h4 style="margin:0px !important"> {{ date("d-m-y", strtotime($item->tgl_presensi)) }}</h4>
                                    <span class="text-info">{{ $item->nama_cuti }}</span>
                                    <span> {{ $item->alasan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * App Capsule -->
@endsection
