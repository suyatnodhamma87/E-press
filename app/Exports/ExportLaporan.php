<?php

namespace App\Exports;

use App\Models\Karyawan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportLaporan implements FromView,ShouldAutoSize
{
    use Exportable;

    public $bulan,$tahun,$kodediv;
    public function __construct($bulan,$tahun,$kodediv){
        $this->tahun=$tahun;
        $this->bulan=$bulan;
        $this->kodediv=$kodediv;
    }
    public function view() : View
    {
        $dari = $this->tahun . "-" . $this->bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $select_date = "";
        $field_date = "";
        $i=1;
        while(strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari;
            $select_date .="MAX(IF(tgl_presensi = '$dari',
            CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                IFNULL(presensi.status,'NA'),'|',
                IFNULL(presensi.kode_ijin,'NA'),'|',
                IFNULL(alasan,'NA'),'|'),
                NULL)) as tgl_".$i.",";

                $field_date .= "tgl_". $i. ",";
            $i++;
            $dari =date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetanggal[$lastrange];

        if($jmlhari == 30) {
            array_push($rangetanggal, NULL);
        } elseif($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        } elseif($jmlhari == 28) {
            array_push($rangetanggal, NULL, NULL, NULL);
        }

        $query = Karyawan::query();
        $query-> selectRaw(
            "$field_date karyawan.nip, nama_lengkap, jabatan"
        );
        $query->leftjoin(
            DB::raw("(
                SELECT
                $select_date
                presensi.nip

                    FROM presensi
                    LEFT JOIN ijin ON presensi.kode_ijin = ijin.kode_ijin
                    WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
                    GROUP BY nip

            ) presensi"),
            function($join) {
                $join->on('karyawan.nip', '=', 'presensi.nip');
            }
        );
        if(!empty($this->kodediv)) {
            $query->where('kode_div', $this->kodediv);
        }
        $query->orderBy('nip');
        $cetaklaporanpresensiall = $query->get();

        return view ('presensi.cetaklaporanpresensiall', ['bulan'=>$this->bulan, 'tahun'=>$this->tahun, 'namabulan'=>$namabulan, 'cetaklaporanpresensiall'=>$cetaklaporanpresensiall, 'rangetanggal'=>$rangetanggal, 'jmlhari'=>$jmlhari]);
    }
}
