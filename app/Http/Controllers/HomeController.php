<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function index() {
      $hariini = date("Y-m-d");
      $bulanini = date("m") * 1;
      $tahunini = date("Y");
      $nip = Auth::guard('karyawan')->user()->nip;
      $presensihariini = DB::table('presensi')->where('nip', $nip)->where('tgl_presensi', $hariini)->first();
      $historybulanini = DB::table('presensi')
         ->select('presensi.*', 'alasan', 'nama_cuti', 'nama_jamkerja', 'jam_masuk')
         ->leftjoin('ijin', 'presensi.kode_ijin', '=', 'ijin.kode_ijin')
         ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
         ->leftjoin('data_cuti', 'ijin.kode_cuti', '=', 'data_cuti.kode_cuti')
         ->where('presensi.nip', $nip)
         ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
         ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
         ->orderBy('tgl_presensi', 'desc')
         ->get();

      $rekappresensi = DB::table('presensi')
      ->selectRaw('
      SUM(IF(status= "h", 1, 0)) as jmlhadir,
      SUM(IF(status= "i", 1, 0)) as jmlijin,
      SUM(IF(status= "s", 1, 0)) as jmlsakit,
      SUM(IF(status= "c", 1, 0)) as jmlcuti,
      SUM(IF(jam_in > jam_masuk ,1,0)) as jmlterlambat
      ')
      ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
      ->where('nip', $nip)
      ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
      ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
      ->first();

      $leaderboard = DB::table('presensi')
      ->join('karyawan', 'presensi.nip', '=', 'karyawan.nip')
         ->where('tgl_presensi', $hariini)
         ->orderBy ('jam_in')
         ->get();
      $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    //   $rekapijin = DB::table('ijin')
    //      ->selectRaw('SUM(IF(status="i",1,0)) as jmlijin, SUM(IF(status="s",1,0)) as jmlsakit')
    //      ->where('nip', $nip)
    //      ->whereRaw('MONTH(tgl_ijin_dari)="' . $bulanini . '"')
    //      ->whereRaw('YEAR(tgl_ijin_dari)="' . $tahunini . '"')
    //      ->where('status_approval', 1)
    //      ->first();

         return view('home.home', compact('presensihariini', 'historybulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard'));
   }

   public function homeadmin() {

      $hariini = date('Y-m-d');

      $rekappresensi = DB::table('presensi')
      ->selectRaw('
      SUM(IF(status= "h", 1, 0)) as jmlhadir,
      SUM(IF(status= "i", 1, 0)) as jmlijin,
      SUM(IF(status= "s", 1, 0)) as jmlsakit,
      SUM(IF(status= "c", 1, 0)) as jmlcuti,
      SUM(IF(jam_in > jam_masuk ,1,0)) as jmlterlambat
      ')
      ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
      ->where('tgl_presensi', $hariini)
      ->first();

      return view ('home.homeadmin', compact('rekappresensi'));
   }

}
