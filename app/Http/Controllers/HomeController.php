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
         ->where('nip', $nip)
         ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
         ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
         ->orderBy('tgl_presensi')
         ->get();

      $rekappresensi = DB::table('presensi')
      ->selectRaw('COUNT(nip) as jmlhadir, SUM(IF(jam_in >"08:00",1,0)) as jmlterlambat')
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

      $rekapijin = DB::table('ijin')
         ->selectRaw('SUM(IF(status="i",1,0)) as jmlijin, SUM(IF(status="s",1,0)) as jmlsakit')
         ->where('nip', $nip)
         ->whereRaw('MONTH(tgl_ijin)="' . $bulanini . '"')
         ->whereRaw('YEAR(tgl_ijin)="' . $tahunini . '"')
         ->where('status_approval', 1)
         ->first();

         return view('home.home', compact('presensihariini', 'historybulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapijin'));
   }

   public function homeadmin() {

      $hariini = date('Y-m-d');
      $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nip) as jmlhadir, SUM(IF(jam_in >"08:00",1,0)) as jmlterlambat')
        ->where('tgl_presensi', $hariini)
        ->first();

      $rekapijin = DB::table('ijin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlijin, SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('tgl_ijin', $hariini)
        ->where('status_approval', 1)
        ->first();
      return view ('home.homeadmin', compact('rekappresensi','rekapijin'));
   }

}
