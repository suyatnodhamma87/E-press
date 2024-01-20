<?php

namespace App\Exports;

use App\Models\Karyawan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExportLaporanIndividu implements FromView,WithDrawings,WithEvents
{
    use Exportable;

    public $bulan,$tahun,$nip,$presensi,$listRow;
    public function __construct($bulan,$tahun,$nip,$presensi,$row){
        $this->tahun=$tahun;
        $this->bulan=$bulan;
        $this->nip=$nip;
        $this->presensi=$presensi;
        $this->listRow=10+$row;
    }
    public function view() : View
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')
            ->where('nip', $this->nip)
            ->join('divisi', 'karyawan.kode_div', '=', 'divisi.kode_div')
            ->first();

        $presensi = DB::table('presensi')
            ->select('presensi.*', 'alasan', 'jam_kerja.*')
            ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=' , 'jam_kerja.kode_jamkerja')
            ->leftjoin('ijin', 'presensi.kode_ijin', "=", 'ijin.kode_ijin')
            ->where('presensi.nip', $this->nip)
            ->whereRaw('MONTH(tgl_presensi)="' .$this->bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="' .$this->tahun.'"')
            ->orderBy('tgl_presensi')
            ->get();


        return view('presensi.cetaklaporanexcel', ['bulan'=>$this->bulan, 'tahun'=>$this->tahun, 'namabulan'=>$namabulan, 'karyawan'=>$karyawan, 'presensi'=>$presensi]);
    }
    public function drawings()
    {
        $count=10;
        foreach($this->presensi as $key=>$p)
    {
        if ($p->status=="h"){
            if(is_file(public_path("/storage/uploads/absensi/".$p->foto_in))){
                $drawing = new Drawing();
                $path_in= public_path("/storage/uploads/absensi/".$p->foto_in);
                $drawing->setPath($path_in);
                $drawing->setHeight(50);
                $drawing->setWidth(50);
                $drawing->setCoordinates('D'.($count));
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawings [] = ($drawing);
            }
            if(is_file(public_path('/storage/uploads/absensi/'.$p->foto_out))){
                $drawing = new Drawing();
                $path_out= public_path('/storage/uploads/absensi/'.$p->foto_out);
                $drawing->setPath($path_out);
                $drawing->setHeight(50);
                $drawing->setWidth(50);
                $drawing->setCoordinates('F'.($count));
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawings [] = ($drawing);

            }

        }
        $count++;
    }
    return $drawings;

    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                for ($i=10; $i <$this->listRow; $i++) {
                    $event->sheet->getDelegate()->getRowDimension(($i))->setRowHeight(40);
                }

                foreach (['A','B','C','D','E','F','G','H','I'] as $key => $value) {
                    if ($value=="D" || $value=="F"){
                        $event->sheet->getDelegate()->getColumnDimension($value)->setWidth(40);
                    }
                    else{
                        $event->sheet->getDelegate()->getColumnDimension($value)->setAutoSize(true);
                    }

                }

            },
        ];
    }
}
