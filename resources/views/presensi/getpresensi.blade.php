@foreach($presensi as $p)
@php
    $foto_in = Storage::url('/uploads/absensi/'.$p->foto_in);
    $foto_out = Storage::url('uploads/absensi/'.$p->foto_out);
@endphp

@if ($p->status=="h")
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $p->nip }}</td>
    <td>{{ $p->nama_lengkap }}</td>
    <td>{{ $p->nama_div }}</td>
    <td>{{ $p->nama_jamkerja }}<br>({{ $p->jam_masuk }} s.d {{ $p->jam_pulang }})</td>
    <td>{{ $p->jam_in }}</td>
    <td>
        <img src="{{ url($foto_in) }}" class="avatar" alt="">
    </td>
    <td>{!! $p->jam_out != null ? $p->jam_out : '<span class="badge bg-warning"> Belum absen </span>'!!}</td>
    <td>
        @if ($p->jam_out != null)
            <img src="{{ url($foto_out) }}" class="avatar" alt="">
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera-rotate" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                <path d="M11.245 15.904a3 3 0 0 0 3.755 -2.904m-2.25 -2.905a3 3 0 0 0 -3.75 2.905" />
                <path d="M14 13h2v2" />
                <path d="M10 13h-2v-2" />
            </svg>
        @endif
    </td>
    <td>{{ $p->status }}</td>
    <td>
        @if($p->jam_in > $p->jam_masuk)
        @php
            $jamterlambat = selisih($p->jam_masuk, $p->jam_in)
        @endphp
            <span class="badge bg-warning"> Terlambat {{ $jamterlambat }}  </span>
        @else
            <span class="badge bg-success"> Tepat waktu</span>
        @endif
    </td>
    <td>
        <a href="#" class="btn btn-primary tampilkanmap" id="{{ $p->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M11 18l-2 -1l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                <path d="M9 4v13" />
                <path d="M15 7v5" />
                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                <path d="M20.2 20.2l1.8 1.8" />
            </svg>
        </a>
    </td>
</tr>
@else
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $p->nip }}</td>
    <td>{{ $p->nama_lengkap }}</td>
    <td>{{ $p->nama_div }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        @if($p->status=="i")
        <span>Ijin</span>
        @elseif($p->status=="s")
        <span>Sakit</span>
        @elseif($p->status=="c")
        <span>Cuti</span>
        @endif
    </td>
    <td>{{ $p->alasan }}</td>
    <td></td>
</tr>
@endif

@endforeach

<script>
    $(function() {
        $(".tampilkanmap").click(function(e) {
            var id = $(this).attr("id");
                $.ajax( {
                    type:'POST',
                    url:'/showmap',
                    data:{
                        _token: "{{ csrf_token() }}",
                        id : id
                    },
                cache: false,
                success: function(respond){
                    $("#loadmap").html(respond);
                    }
            });
            $("#modal-tampilkanmap").modal("show");
        });
    });
</script>
