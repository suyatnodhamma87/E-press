<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Data Kehadiran Karyawan</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
    <style>
        @page { size: A4 }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 25px;
        }
        .tabeldatakaryawan td {
            padding: 1px;
        }

        /* th {
            padding: 5px;
            font-weight: bold;
            text-align: center;
            font-size: 13px;
        }

        td {
            padding: 5px;
            font-size: 12px;
        } */

        .tablepresensi {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .tablepresensi tr th {
            border: 1px solid black;
            padding: 8px;
            background: gray;
            font-weight: bold;
        }
        .tablepresensi tr td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;

        }
        .foto {
            width: 50px;
            height: 50px;
        }

    </style>

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

    <?php
    function selisihwaktu($jam_in, $jam_out) {
        list($h, $m, $s) = explode(":", $jam_in);
        $dtAwal = mktime ($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(":", $jam_out);
        $dtAkhir = mktime ($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode(".", $totalmenit / 60);
        $sisamenit = ($totalmenit / 60) - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ":" . round($sisamenit2);
        //return (($jml_jam*60) + ($sisamenit2));
    }
    ?>

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->

        <table style="width: 100%">
            <tr>
                <td style="width:10%">
                    <img src="{{ asset('assets/img/logopt.png') }}" width="100" height="100" alt="">
                </td>
                <td>
                    <span id="title">
                        LAPORAN KEHADIRAN KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan])}} {{ $tahun }}<br>
                        PT. RAJAWALI PARAMA KONSTRUKSI<br>
                    </span>
                    <span><i>Jl. Bhayangkara 1 No. 1 Kel. Pakujaya Kec. Serpong, Tangerang Selatanspani</span>
                </td>
            </tr>

        </table>
        <table  class="tabeldatakaryawan">
            <tr>
                <td rowspan="5">
                    @php
                         $path = Storage::url('uploads/karyawan/'.$karyawan->foto);
                     @endphp
                     <img src="{{ url($path) }}" alt="" width="90" height="100">

                 </td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $karyawan->nip }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>NO HP</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        {{-- <table>
            <tr>
                <th rowspan="2"> No.</th>
                <th rowspan="2"> NIP</th>
                <th rowspan="2"> Nama Lengkap</th>
                <th colspan="31" align="center"> Tanggal</th>
            </tr>
            <tr>
                @for($i=1; $i <= 31; $i++)<th>{{ $i }}</th> @endfor
            </tr>
            @foreach ($presensi as $p)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $p->nip }}</td>
            </tr>
            @endforeach
        </table> --}}

        <table class="tablepresensi">
            <tr style="background-color: yellow; font-weight:bold" >
                <td>No.</td>
                <td>Tanggal</td>
                <td>Jam Masuk</td>
                <td>Foto</td>
                <td>Jam Pulang</td>
                <td>Foto</td>
                <td>Keterangan</td>
                <td>Total Jam</td>
            </tr>
            @foreach ($presensi as $p )
            @php
                $path_in= Storage::url('uploads/absensi/'.$p->foto_in);
                $path_out= Storage::url('uploads/absensi/'.$p->foto_out);
                $jamterlambat = (selisihwaktu('08:30:00', $p->jam_in));
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date("d-m-Y", strtotime($p->tgl_presensi)) }}</td>
                <td>{{ $p->jam_in }}</td>
                <td> <img class="foto" src="{{ $path_in }}"> </td>
                <td>{{ $p->jam_out != null ? $p->jam_out : 'Belum absen' }}</td>
                <td>
                    @if($p->jam_out != null)
                    <img class="foto" src="{{ $path_out }}">
                    @else
                    Tidak ada
                    @endif
                </td>
                <td>
                    @if ($p->jam_in > '08:30')
                    Terlambat <b>{{ $jamterlambat }}</b>
                    @else Tepat Waktu
                    @endif
                </td>
                <td>
                    @if ($p->jam_out != null)
                    @php
                    $jmljamkerja = selisihwaktu($p->jam_in, $p->jam_out);
                    @endphp
                    @else
                    @php
                    $jmljamkerja = 0;
                    @endphp
                    @endif
                    {{ $jmljamkerja }}
                </td>
            </tr>
            @endforeach
        </table>

        <table>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="150px">
                    <u>Selamet</u><br>
                    <i>HRD Manajer</i>
                </td>
            </tr>
        </table>


  </section>
</body>
</html>
