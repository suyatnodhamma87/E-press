<?php

namespace App\Http\Controllers;

use App\Models\Setjamkerja;
use App\Models\Setjamkerjadiv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function lokasikantor() {

        $lok_kantor = DB::table('settingradius')->where('id', 1)->first();
        return view ('setting.lokasikantor', compact('lok_kantor'));
    }

    public function updatelokasikantor (Request $request) {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('settingradius')->where('id', 1)->update([
            'lokasi_kantor'=> $lokasi_kantor,
            'radius' => $radius
        ]);

        if($update) {
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function jamkerja() {
        $jamkerja = DB::table('jam_kerja')->orderBy('kode_jamkerja')->get();

        return view ('setting.jamkerja', compact ('jamkerja'));
    }

    public function storejamkerja(Request $request) {
        $kode_jamkerja = $request->kode_jamkerja;
        $nama_jamkerja = $request->nama_jamkerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;
        $lokasi_kerja = $request->lokasi_kerja;
        $radius_kerja = $request->radius_kerja;

        $data = [
            'kode_jamkerja' => $kode_jamkerja,
            'nama_jamkerja' => $nama_jamkerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_pulang' => $jam_pulang,
            'lokasi_kerja' => $lokasi_kerja,
            'radius_kerja' => $radius_kerja
        ];

        try {
            DB::table ('jam_kerja')->insert($data);
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        }catch (\Exception $e){
            return Redirect::back()->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function editjamkerja (Request $request) {
        $kode_jamkerja = $request->kode_jamkerja;
        $jam_kerja = DB::table('jam_kerja')->where('kode_jamkerja', $kode_jamkerja)->first();
        $modekerja = DB::table('anakperusahaan')->get();
        return view ('setting.editjamkerja', compact('jam_kerja', 'modekerja'));
    }

    public function updatejamkerja(Request $request) {
        $kode_jamkerja = $request->kode_jamkerja;
        $nama_jamkerja = $request->nama_jamkerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;

        $data = [
            'nama_jamkerja' => $nama_jamkerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_pulang' => $jam_pulang
        ];

        try {
            DB::table ('jam_kerja')->where('kode_jamkerja', $kode_jamkerja)->update($data);
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        }catch (\Exception $e){
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function deletejamkerja($kode_jamkerja) {
        $hapus = DB::table('jam_kerja')->where('kode_jamkerja', $kode_jamkerja)->delete();
        if($hapus) {
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus']);
        }
    }

    public function setjamkerja($nip) {

        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jamkerja')->get();
        $cekjamkerja = DB::table('setting_jam_kerja')->where('nip', $nip)->count();

        if ($cekjamkerja > 0) {
            $setjamkerja = DB::table('setting_jam_kerja')->where('nip', $nip)->get();
            return view('setting.editsetjamkerja', compact('karyawan', 'jamkerja', 'setjamkerja'));
        } else {
            return view('setting.setjamkerja', compact('karyawan', 'jamkerja', 'cekjamkerja'));
        }
    }

    public function storesetjamkerja(Request $request) {
        $nip = $request->nip;
        $hari = $request->hari;
        $kode_jamkerja = $request->kode_jamkerja;

        for($i=0; $i< count($hari); $i++) {
            $data[] = [
                'nip' => $nip,
                'hari' => $hari[$i],
                'kode_jamkerja' => $kode_jamkerja[$i]
            ];
        }

        try {
            Setjamkerja::insert($data);
            return redirect('/karyawan')->with(['success' => 'Jam kerja berhasil disetting']);
        }catch (\Exception $e) {
            return redirect('/karyawan')->with(['warning' => 'Jam kerja gagal disetting']);
        }
    }

    public function updatesetjamkerja(Request $request) {
        $nip = $request->nip;
        $hari = $request->hari;
        $kode_jamkerja = $request->kode_jamkerja;

        for($i=0; $i< count($hari); $i++) {
            $data[] = [
                'nip' => $nip,
                'hari' => $hari[$i],
                'kode_jamkerja' => $kode_jamkerja[$i]
            ];
        }

        DB::beginTransaction();
        try {
            DB::table('setting_jam_kerja')->where('nip', $nip)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return redirect('/karyawan')->with(['success' => 'Jam kerja berhasil disetting']);
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect('/karyawan')->with(['warning' => 'Jam kerja gagal disetting']);
        }
    }

    public function jamkerjadiv () {

        $jamkerjadiv = DB::table('setting_jamker_div')
            ->join('anakperusahaan', 'setting_jamker_div.kode_anper', '=', 'anakperusahaan.kode_anper')
            ->join('divisi', 'setting_jamker_div.kode_div', '=', 'divisi.kode_div')
            ->get();
        return view ('setting.jamkerjadiv', compact ('jamkerjadiv'));
    }

    public function createjamkerjadiv () {

        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jamkerja')->get();
        $anper = DB::table('anakperusahaan')->get();
        $divisi = DB::table('divisi')->get();
        return view ('setting.createjamkerjadiv', compact ('jamkerja', 'anper', 'divisi'));
    }

    public function storejamkerjadiv(Request $request) {
        $kode_anper = $request->kode_anper;
        $kode_div = $request->kode_div;
        $hari = $request->hari;
        $kode_jamkerja = $request->kode_jamkerja;
        $kode_jk_div = "J". $kode_anper . $kode_div;

        DB::beginTransaction();
        try {
            DB::table('setting_jamker_div')->insert([
                'kode_jk_div' => $kode_jk_div,
                'kode_anper' => $kode_anper,
                'kode_div' => $kode_div
            ]);

            for($i=0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_div' => $kode_jk_div,
                    'hari' => $hari[$i],
                    'kode_jamkerja' => $kode_jamkerja[$i]
                ];
            }
            Setjamkerjadiv::insert($data);
            DB::commit();
            return redirect('/setting/jamkerjadiv')->with(['success' => 'Data berhasil disimpan']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect('/setting/jamkerjadiv')->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function editjamkerjadiv ($kode_jk_div) {

        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jamkerja')->get();
        $anper = DB::table('anakperusahaan')->get();
        $divisi = DB::table('divisi')->get();
        $jamkerjadiv = DB::table('setting_jamker_div')->where('kode_jk_div', $kode_jk_div)->first();
        $jamkerjadiv_detail = DB::table('setting_jamker_div_detail')->where('kode_jk_div', $kode_jk_div)->get();
        return view ('setting.editjamkerjadiv', compact('jamkerja', 'anper', 'divisi','jamkerjadiv', 'jamkerjadiv_detail'));
    }

    public function updatejamkerjadiv($kode_jk_div, Request $request) {
        $hari = $request->hari;
        $kode_jamkerja = $request->kode_jamkerja;

        DB::beginTransaction();
        try {
            DB::table('setting_jamker_div_detail')->where('kode_jk_div', $kode_jk_div)->delete();
            for($i=0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_div' => $kode_jk_div,
                    'hari' => $hari[$i],
                    'kode_jamkerja' => $kode_jamkerja[$i]
                ];
            }
            Setjamkerjadiv::insert($data);
            DB::commit();
            return redirect('/setting/jamkerjadiv')->with(['success' => 'Data berhasil disimpan']);
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect('/setting/jamkerjadiv')->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function showjamkerjadiv($kode_jk_div){
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jamkerja')->get();
        $anper = DB::table('anakperusahaan')->get();
        $divisi = DB::table('divisi')->get();
        $jamkerjadiv = DB::table('setting_jamker_div')->where('kode_jk_div', $kode_jk_div)->first();
        $jamkerjadiv_detail = DB::table('setting_jamker_div_detail')
            ->join('jam_kerja', 'setting_jamker_div_detail.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
            ->where('kode_jk_div', $kode_jk_div)->get();
        return view ('setting.showjamkerjadiv', compact('jamkerja', 'anper', 'divisi','jamkerjadiv', 'jamkerjadiv_detail'));
    }

    public function deletejamkerjadiv($kode_jk_div) {

        try {
            DB::table('setting_jamker_div')->where('kode_jk_div', $kode_jk_div)->delete();
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        }catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus']);
        }
    }
}
