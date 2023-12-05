@extends('layouts.presensi')
@section('header')
    <!-- Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            E-Press
        </div>
        <div class="right"></div>
    </div>
    <!-- *Header -->

<style>
    .webcam-capture,
    .webcam-capture video{
       display: inline-block;
       width: 100% !important;
       margin: auto;
       height: auto !important;
       border-radius: 15px;
    }
       #map { height: 210px; }
</style>

{{-- css maps  --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <input type="hidden" id="lokasi">
        <div class="webcam-capture"></div>
    </div>
</div>
<div class="row mt-2">
    <div class="col">
        @if($cek > 0)
            <Button class="btn btn-danger btn-block" id="takeabsen">
                <ion-icon name="camera-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                Absen pulang
            </button>
        @else
            <Button class="btn btn-primary btn-block" id="takeabsen">
                <ion-icon name="camera-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                Absen masuk
        @endif

    </div>
</div>
<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
<audio id="notifikasi_in">
    <source src="{{ asset('assets/sound/audio_in.wav') }}" type="audio/wav">
</audio>
<audio id="notifikasi_out">
    <source src="{{ asset('assets/sound/audio_out.wav') }}" type="audio/wav">
</audio>
<audio id="error_radius">
    <source src="{{ asset('assets/sound/error_radius.wav') }}" type="audio/wav">
</audio>
@endsection

@push('myscript')
<script>
    var notifikasi_in = document.getElementById('notifikasi_in');
    var notifikasi_out = document.getElementById('notifikasi_out');
    var error_radius = document.getElementById('error_radius');

    Webcam.set({
        height:480,
        width:640,
        image_format:'jpeg',
        jpeg_quality:80
    });
    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(succesCallback, errorCallback);
    }
    var nama_karyawan = "{{ Auth::guard('karyawan')->user()->nama_lengkap }}";

    function succesCallback(position){
        lokasi.value = position.coords.latitude+","+position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 15);
        var lokasi_kantor = "{{ $lok_kantor->lokasi_anper }}"
        var lok = lokasi_kantor.split(",");
        var lat_kantor = lok[0];
        var long_kantor = lok[1];
        var radius = "{{ $lok_kantor->radius_anper }}";
        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

        //Maps Kantor (latitude, longitude)
        var circle = L.circle([lat_kantor, long_kantor], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);
    }

   function errorCallback(){
   }

    $('#takeabsen').click(function(e) {
        Webcam.snap(function(uri) {
            image = uri
        });

        var lokasi = $("#lokasi").val();
        $.ajax({
            type: 'POST',
            url: '/presensi/store',
            data:{
                _token:"{{ csrf_token() }}",
                image: image,
                lokasi:lokasi
                }
            ,cache: false
            ,success: function(respond){
                var status = respond.split("|");
                if(status[0] == "success") {
                    if(status[2]== "in") {
                        notifikasi_in.play();
                    } else {
                        notifikasi_out.play();
                    }
                    Swal.fire({
                        title: 'Berhasil!',
                        text: status[1],
                        icon: 'success'
                        })
                        setTimeout("location.href='/home'", 3000);
                } else {
                    if(status[2] == "radius") {
                        error_radius.play();
                    }
                    Swal.fire({
                        title: 'error',
                        text: status[1],
                        icon: 'error'
                        })
                }
            }
        });
    });
</script>
@endpush

