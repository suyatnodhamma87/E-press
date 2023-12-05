<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class DivisiController extends Controller
{
    public function indexdivisi(Request $request) {

        $nama_div = $request->nama_div;
        $query = Divisi::query();
        $query->select('*');
        if(!empty($nama_div)){
            $query->where('nama_div', 'like', '%'.$nama_div.'%');
        }
        $divisi = $query->get();

        return view ('divisi.indexdivisi', compact('divisi'));
    }

    public function store(Request $request) {
        $kode_div = $request->kode_div;
        $nama_div = $request->nama_div;
        $data = [
            'kode_div' => $kode_div,
            'nama_div' => $nama_div
        ];

        $simpan = DB::table('divisi')->insert($data);
        if($simpan) {
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal disimpan']);
        }
    }

    public function edit(Request $request) {
        $kode_div = $request->kode_div;
        $divisi = DB::table('divisi')->where('kode_div', $kode_div)->first();
        return view('divisi.edit', compact('divisi'));
    }

    public function update ($kode_div, Request $request) {
        $nama_div = $request->nama_div;
        $data = [
            'nama_div' => $nama_div
        ];

        $update = DB::table('divisi')->where('kode_div', $kode_div)->update($data);
        if($update) {
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function delete($kode_div) {
        $hapus = DB::table('divisi')->where('kode_div', $kode_div)->delete();
        if($hapus) {
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
