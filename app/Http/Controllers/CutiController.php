<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CutiController extends Controller
{
    public function indexcuti() {

        $cuti = DB::table('data_cuti')->orderBy('kode_cuti', 'asc')->get();
        return view ('cuti.indexcuti', compact ('cuti'));
    }

    public function storecuti (Request $request) {

        $kode_cuti = $request->kode_cuti;
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        $cekcuti = DB::table('data_cuti')->where('kode_cuti', $kode_cuti)->count();
        if ($cekcuti > 0) {
            return Redirect::back()->with(['warning' => 'Data Kode Cuti Sudah Ada!']);
        }

        try {
            DB::table('data_cuti')->insert ([
                'kode_cuti' => $kode_cuti,
                'nama_cuti' => $nama_cuti,
                'jml_hari' => $jml_hari
            ]);
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);

        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit (Request $request) {
        $kode_cuti = $request->kode_cuti;
        $cuti = DB::table('data_cuti')->where('kode_cuti', $kode_cuti)->first();
        return view ('cuti.edit', compact('cuti'));
    }

    Public function update (Request $request, $kode_cuti) {
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        try {
            DB::table('data_cuti')->where('kode_cuti', $kode_cuti)
            ->update([
                'nama_cuti' => $nama_cuti,
                'jml_hari' => $jml_hari
            ]);

            return Redirect::back()->with(['success' => 'Data berhasil diupdate!']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data gagal diupdate'.$e->getMessage()]);
        }
    }

    public function delete ($kode_cuti) {
        try {
            DB::table('data_cuti')->where('kode_cuti', $kode_cuti)->delete();
            return Redirect::back()->with(['success' => 'Data berhasil dihapus!']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus!'. $e->getMessage()]);
        }
    }
}
