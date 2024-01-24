<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Data Kehadiran Karyawan</title>
    <style>
        @page { size: F4 landscape}

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

        .tabelpresensi {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid black;
            padding: 8px;
            background: rgb(182, 179, 179);
            font-weight: bold;
            font-size: 11px;
        }
        .tabelpresensi tr td {
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

<body class="F4 landscape">
        <table style="width: 80%">
            <tr>
                <td style="width:10%">
                    <img src="{{ asset('assets/img/logonalanda.png') }}" width="70" height="100" alt="">
                </td>
                <td>
                </td>
                <td>
                    <span id="title">
                        LAPORAN KEHADIRAN SELURUH KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan])}} {{ $tahun }}<br>
                        STAB NALANDA<br>
                    </span>
                    <span><i>Jl. Pulo Gebang Permai No.107, RT.13/RW.4, Kel. Pulo Gebang, Kec. Cakung, Kota Jakarta Timur</i></span>
                </td>
            </tr>

        </table>

        <table class="tabelpresensi">
            <tr>
                <th rowspan="2"> No.</th>
                <th rowspan="2"> NIP</th>
                <th rowspan="2"> Nama Karyawan</th>
                <th colspan="{{ $jmlhari }}"> Bulan {{ $namabulan[$bulan] }}</th>
                <th rowspan="2">H</th>
                <th rowspan="2">I</th>
                <th rowspan="2">S</th>
                <th rowspan="2">C</th>
            </tr>
            <tr>
                @foreach ($rangetanggal as $d )
                @if($d != NULL)
                    <th> {{ date("d", strtotime($d)) }}</th>
                @endif
                @endforeach
            </tr>
            @foreach ($cetaklaporanpresensiall as $r)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $r->nip }}</td>
                <td> {{ $r->nama_lengkap }}</td>
                    <?php
                        $jml_hadir = 0;
                        $jml_ijintidakmasuk = 0;
                        $jml_sakit = 0;
                        $jml_cuti = 0;
                        $jml_alpha = 0;
                        $color = "";

                        for ($i=1; $i<=$jmlhari; $i++) {
                            $tgl = "tgl_".$i;
                            $datapresensi = explode("|", $r->$tgl);

                            if($r->$tgl != NULL) {
                                $status = $datapresensi[2];
                            } else {
                                $status = "";
                            }

                            if ($status =="h") {
                                $jml_hadir += 1;
                                $color = "white";
                            }
                            if ($status =="i") {
                                $jml_ijintidakmasuk += 1;
                                $color = "yellow";
                            }
                            if ($status =="s") {
                                $jml_sakit += 1;
                                $color = "blue";
                            }
                            if ($status =="c") {
                                $jml_cuti += 1;
                                $color = "orange";
                            }
                            if (empty($status)) {
                                $jml_alpha += 1;
                                $color = "red";
                            }

                    ?>
                    <td align="center" style="background-color:{{ $color }}">
                        {{  $status }}
                    </td>
                    <?php
                        }
                    ?>
                    <td align="center"> {{ !empty($jml_hadir) ? $jml_hadir : "" }}</td>
                    <td align="center"> {{ !empty($jml_ijintidakmasuk) ? $jml_ijintidakmasuk : "" }}</td>
                    <td align="center"> {{ !empty($jml_sakit) ? $jml_sakit : "" }}</td>
                    <td align="center"> {{ !empty($jml_cuti) ? $jml_cuti : "" }}</td>


            </tr>
            @endforeach
        </table>


        <table>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u>...............</u><br>
                    <i>HRD Manajer</i>
                </td>
            </tr>
        </table>

        <script type="text/javascript">
        window.print();

        </script>
</body>
</html>
