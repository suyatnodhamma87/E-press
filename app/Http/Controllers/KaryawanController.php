<?php

namespace App\Http\Controllers;

use App\Imports\ImportKaryawan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    public function index(Request $request) {
        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_div');
        $query->join('divisi', 'karyawan.kode_div', '=', 'divisi.kode_div');
        $query->orderBy('create_at',  'asc');
            if (!empty($request->nama_karyawan)) {
                $query->where('nama_lengkap', 'like', '%' .$request->nama_karyawan . '%');
            }

            if (!empty($request->kode_div)) {
                $query->where('karyawan.kode_div', $request->kode_div);
            }
        $karyawan = $query->paginate(60);

        $divisi = DB::table('divisi')->get();
        // $anakperusahaan = DB::table('anakperusahaan')->orderBy('kode_anper')->get();
        return view ('karyawan.index', compact('karyawan', 'divisi'));
    }

    public function store (Request $request) {
        $nip = $request->nip;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_div = $request->kode_div;
        $password = Hash::make($nip.'123');
        if ($request -> hasFile('foto')) {
            $foto = $nip.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nip' => $nip,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_div' => $kode_div,
                'foto' => $foto,
                'password' => $password,
            ];

            $simpan = DB::table('karyawan')->insert($data);
            if($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request ->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
            }

        } catch (\Exception $e ) {
    //    dd($e);
            if($e->getCode() == 23000) {
                $message = "Data dengan NIP " . $nip . "Sudah ada";
            } else {
                $message = " Hubungi Tim IT";
            }
           return Redirect::back()->with(['error' =>'Data gagal disimpan' . $message]);
        }
    }
    public function edit(Request $request) {
        $nip =  $request->nip;
        $divisi = DB::table('divisi')->get();
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();

        return view('karyawan.edit', compact('divisi', 'karyawan'));
    }

    public function update($nip, Request $request) {
        $nip = $request->nip;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_div = $request->kode_div;
        $password = Hash::make($nip.'123');
        $old_foto = $request->old_foto;
        if ($request -> hasFile('foto')) {
            $foto = $nip.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_div' => $kode_div,
                'foto' => $foto,
                'password' => $password
            ];

            $update = DB::table('karyawan')->where('nip', $nip)->update($data);
            if($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request ->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
            }

        } catch (\Exception $e ) {
           return Redirect::back()->with(['error' =>'Data gagal disimpan']);
        }
    }

    public function delete($nip) {
        $delete = DB::table('karyawan')->where('nip', $nip)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data berhasil dihapus!']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus!']);
        }
    }

    public function resetpassword($nip) {

        $nip = Crypt::decrypt($nip);
        $password = Hash::make($nip.'123');
        $reset = DB::table('karyawan')->where('nip',$nip)->update([
            'password' => $password
        ]);

        if($reset) {
            return Redirect::back()->with(['success' => 'Password berhasil direset']);
        } else {
            return Redirect::back()->with(['warning' => 'Password gagal direset']);
        }
    }

    public function importexcel(Request $request){
        //Validasi
        $this->validate($request,[
            'file'=>'required|mimes:xls,xlsx'
        ]);

        $file=$request->file("file");

        $namaFile=$file->getClientOriginalName();

        $file->move("importexcel",$namaFile);

        Excel::import(new ImportKaryawan,public_path('/importexcel/'.$namaFile));

        return redirect()->back();

    }
}
