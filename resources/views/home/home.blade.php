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
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                    {{-- @if ($presensihariini != null)
                                    @php
                                        $path =Storage::url('uploads/absensi/', $presensihariini->foto_in);
                                    @endphp
                                    <img src= "{{ url($path) }}" alt="">
                                    @endif --}}
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
                </div>
            </div>
        </div>

        <div id="rekappresensi">
            <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} {{ $tahunini }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999">{{ $rekappresensi->jmlhadir }}</span>
                            <ion-icon name="body-outline" style="font-size: 1.8rem" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999">{{ $rekapijin->jmlijin }}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.8rem" class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Ijin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999">{{ $rekapijin->jmlsakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.8rem" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 16px 12px">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.5rem; z-index:999"> {{ $rekappresensi->jmlterlambat }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.8rem" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size:0.7rem">Terlambat</span>
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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach($historybulanini as $item)
                        <li>
                            <div class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="image-outline" role="img" class="md hydrated"
                                        aria-label="image outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>{{ date("d-m-y", strtotime($item->tgl_presensi)) }}</div>
                                    <span class="badge badge-success">{{ $item->jam_in }}</span>
                                    <span class="badge badge-danger">{{ $presensihariini !=null && $item->jam_out ? $item->jam_out : 'Belum'}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $item)
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>
                                       <b> {{ $item -> nama_lengkap }} </b><br>
                                       <small class="text-muted"> {{ $item -> jabatan }}</small>
                                    </div>
                                    <span class="badge {{ $item->jam_in < "08:30" ? "bg-success" : "bg-danger" }}">
                                        {{ $item->jam_in }}
                                    </span>
                                </div>
                            </div>
                        </li>
                       @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- * App Capsule -->

@endsection
