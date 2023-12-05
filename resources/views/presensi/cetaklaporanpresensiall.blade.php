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
        @page { size: A4 landscape}

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
            background: gray;
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

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="F4 landscape">

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
                        LAPORAN KEHADIRAN SELURUH KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan])}} {{ $tahun }}<br>
                        PT. RAJAWALI PARAMA KONSTRUKSI<br>
                    </span>
                    <span><i>Jl. Bhayangkara 1 No. 1 Kel. Pakujaya Kec. Serpong, Tangerang Selatan</i></span>
                </td>
            </tr>

        </table>

        <table class="tabelpresensi">
            <tr>
                <th rowspan="2"> No.</th>
                <th rowspan="2"> NIP</th>
                <th rowspan="2"> Nama Lengkap</th>
                <th colspan="31" align="center"> Tanggal</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TL</th>
            </tr>
            <tr>
                <?php
                    for ($i=1; $i<=31; $i++) {
                ?>
                <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>
            @foreach ($laporanpresensiall as $p)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $p->nip }}</td>
                <td> {{ $p->nama_lengkap }}</td>

                <?php
                    $totalhadir= 0;
                    $totalterlambat= 0;
                    for ($i=1; $i<=31; $i++) {
                        $tgl = "tgl_".$i;
                        if(empty($p->$tgl)) {
                            $hadir = ['', ''];
                            $totalhadir += 0;
                        } else {
                            $hadir = explode("-",$p->$tgl);
                            $totalhadir +=1;
                            if($hadir[0] > "08:30:00") {
                                $totalterlambat +=1;
                            }

                        }
                ?>

                    <td>
                    <span style="color:{{ $hadir[0] > "08:30:00" ? "red" : ""}}">{{ $hadir[0] }}</span> <br>
                    <span style="color:{{ $hadir[1] < "17:30:00" ? "red" : ""}}">{{ $hadir[1] }} </span>
                    </td>
                <?php
                    }
                ?>
                <td>{{ $totalhadir }}</td>
                <td>{{ $totalterlambat }}</td>
            </tr>
            @endforeach
        </table>


        <table>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u>Selamet</u><br>
                    <i>HRD Manajer</i>
                </td>
            </tr>
        </table>


  </section>
</body>
</html>
