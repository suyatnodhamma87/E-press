<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IjinsakitController extends Controller
{
    public function ijinsakit() {
        return view ('ijinsakit.ijinsakit');
    }

    public function store(Request $request) {
        $nip = Auth::guard('karyawan')->user()->nip;
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tgl_ijin_sampai = $request->tgl_ijin_sampai;
        $status = "s";
        $alasan = $request->alasan;

        $bulan = date("m", strtotime($tgl_ijin_dari));
        $tahun = date("Y", strtotime($tgl_ijin_dari));
        $thn = substr($tahun,2,2);
        $lastijin = DB::table('ijin')
            ->whereRaw('MONTH(tgl_ijin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_ijin_dari)="' . $tahun . '"')
            ->orderBy('kode_ijin', 'desc')
            ->first();

        $lastkodeijin = $lastijin != null ? $lastijin->kode_ijin : "";
        $format = "IJ".$bulan.$thn;
        $kode_ijin = buatkode($lastkodeijin,$format, 3);

            if ($request->hasFile('sid')) {
                $sid = $kode_ijin . "." . $request->file('sid')->getClientOriginalExtension();
            } else {
                $sid = null;
            }

        $data = [
            'kode_ijin' => $kode_ijin,
            'nip' => $nip,
            'tgl_ijin_dari' => $tgl_ijin_dari,
            'tgl_ijin_sampai' => $tgl_ijin_sampai,
            'status' => $status,
            'alasan' => $alasan,
            'doc_sid' => $sid
            ];

            //cek apakah sudah pernah absen/belum
        $cekpresensi = DB::table('presensi')
            ->whereBetween('tgl_presensi',[$tgl_ijin_dari, $tgl_ijin_sampai])
            ->where('nip', $nip);

        //cek apakah sudah pernah mengajukan ijin/belum
        $cekpengajuan = DB::table('ijin')
            ->whereRaw('"' . $tgl_ijin_dari . '" BETWEEN tgl_ijin_dari AND tgl_ijin_sampai')
            ->where('nip', $nip);

        $datapresensi = $cekpresensi->get();

        if($cekpresensi->count() > 0) {
            $blacklistdate="";
            foreach($datapresensi as $d) {
                $blacklistdate .= date('d', strtotime($d->tgl_presensi)) . ",";
            }
            return Redirect('/presensi/ijin')->with(['error'=> 'Tidak bisa mengajukan tanggal ' . $blacklistdate . ' Anda sudah sudah absensi atau mengajukan pada tanggal tersebut!']);
        } else if ($cekpengajuan->count() > 0) {
            return Redirect('/presensi/ijin')->with(['error'=> 'Tidak bisa mengajukan tanggal tersebut Anda sudah gunakan sebelumnya!']);
        } else {
                $simpan = DB::table('ijin')->insert($data);
                if ($simpan) {
                    if ($request->hasFile('sid')) {
                        $sid = $kode_ijin . "." . $request->file('sid')->getClientOriginalExtension();
                        $folderPath = "public/uploads/sid/";
                        $request->file('sid')->storeAs($folderPath, $sid);
                    }
                    return redirect('/presensi/ijin')->with(['success' => 'Data berhasil disimpan']);
                } else {
                    return redirect('/presensi/ijin')->with(['error'=> 'Data Gagal disimpan']);
                }
            }
    }

    public function edit ($kode_ijin) {

        $dataijin = DB::table('ijin')->where('kode_ijin', $kode_ijin)->first();
        return view ('ijinsakit.edit', compact('dataijin'));
    }

    public function update(Request $request, $kode_ijin) {
        $tgl_ijin_dari = $request->tgl_ijin_dari;
        $tgl_ijin_sampai = $request->tgl_ijin_sampai;
        $alasan = $request->alasan;


            if ($request->hasFile('sid')) {
                $sid = $kode_ijin . "." . $request->file('sid')->getClientOriginalExtension();
            } else {
                $sid = null;
            }

        $data = [
            'tgl_ijin_dari' => $tgl_ijin_dari,
            'tgl_ijin_sampai' => $tgl_ijin_sampai,
            'alasan' => $alasan,
            'doc_sid' => $sid
            ];

            try {
                DB::table('ijin')
                ->where('kode_ijin', $kode_ijin)
                ->update($data);
                if ($request->hasFile('sid')) {
                    $sid = $kode_ijin . "." . $request->file('sid')->getClientOriginalExtension();
                    $folderPath = "public/uploads/sid/";
                    $request->file('sid')->storeAs($folderPath, $sid);
                }
                return redirect('/presensi/ijin')->with(['success' => 'Data berhasil diupdate']);
            } catch (\Exception $e) {
                return redirect('/presensi/ijin')->with(['warning' => 'Data gagal diupdate']);
            }
    }
}
