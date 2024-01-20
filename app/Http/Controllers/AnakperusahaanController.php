<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AnakperusahaanController extends Controller
{
    public function index () {
        $anakperusahaan = DB::table('anakperusahaan')->orderBy('kode_anper')->get();
        return view ('anakperusahaan.index', compact('anakperusahaan'));
    }

    public function store (Request $request) {
        $kode_anper = $request->kode_anper;
        $nama_anper = $request->nama_anper;
        $lokasi_anper = $request->lokasi_anper;
        $radius = $request->radius;

        try {
            $data = [
                'kode_anper' => $kode_anper,
                'nama_anper' => $nama_anper,
                'lokasi_anper' => $lokasi_anper,
                'radius' => $radius
            ];
            DB::table('anakperusahaan') -> insert($data);
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function edit (Request $request) {
        $kode_anper = $request->kode_anper;
        $anakperusahaan = DB::table('anakperusahaan')->where('kode_anper', $kode_anper)->first();
        return view ('anakperusahaan.edit', compact('anakperusahaan'));
    }

    public function update (Request $request) {
        $kode_anper = $request->kode_anper;
        $nama_anper = $request->nama_anper;
        $lokasi_anper = $request->lokasi_anper;
        $radius = $request->radius;

        try {
            $data = [
                'nama_anper' => $nama_anper,
                'lokasi_anper' => $lokasi_anper,
                'radius' => $radius
            ];
            DB::table('anakperusahaan')
                ->where('kode_anper', $kode_anper)
                ->update($data);
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function delete($kode_anper) {
        $hapus = DB::table('anakperusahaan')->where('kode_anper', $kode_anper)->delete();
        if($hapus) {
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
