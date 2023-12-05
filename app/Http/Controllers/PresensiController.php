<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\karyawan;
use App\Models\Perijinankaryawan;
use PhpParser\Node\Expr\AssignOp\Div;

class PresensiController extends Controller
{
    public function create () {
        $hariini = date("Y-m-d");
        $nip = Auth::guard('karyawan')->user()->nip;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nip', $nip)->count();
        $kode_anper = Auth::guard('karyawan')->user()->kode_anper;
        $lok_kantor = DB::table('anakperusahaan')->where('kode_anper', $kode_anper)->first();
        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store (Request $request) {
        $nip = Auth::guard('karyawan')->user()->nip;
        $kode_anper = Auth::guard('karyawan')->user()->kode_anper;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('anakperusahaan')->where('kode_anper', $kode_anper)->first();
        $lok = explode(",", $lok_kantor->lokasi_anper);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nip', $nip)->count();

        if($cek>0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName= $nip."-".$tgl_presensi. "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath. $fileName;

        if($radius >$lok_kantor->radius_anper) {
            echo "error|Maaf Anda berada di luar radius, Jarak Anda ".$radius." meter dari kantor|radius";
        } else {
            if($cek > 0){
                $data_pulang = [
                    'jam_out'=> $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where ('tgl_presensi', $tgl_presensi)-> where ('nip', $nip)->update($data_pulang);
                if($update){
                    echo "success|Terima kasih, Sampai Jumpa besok!|out";
                    storage::put($file, $image_base64);
                } else{
                    echo "error|Maaf gagal absen, Hubungi Tim IT|out";
                }
            } else {
                $data = [
                    'nip' => $nip,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi
                    ];

                $simpan = DB::table('presensi')->insert($data);
                if($simpan){
                    echo "success|Terima kasih, Selamat bekerja!|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf gagal absen, Hubungi Tim IT|in";
                }
            }

        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $karyawan = DB::table('karyawan')->where('nip', $nip)->first();

        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nip = Auth::guard('karyawan')->user()->nip;
        $nama_lengkap = $request -> nama_lengkap;
        $no_hp = $request ->no_hp;
        $password = Hash::make($request -> password);
        $karyawan = DB::table('karyawan')->where('nip',$nip)->first();
        if ($request -> hasFile('foto')) {
            $foto = $nip.".".$request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }

        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table ('karyawan')->where('nip', $nip)->update($data);
        if ($update) {
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Update BERHASIL!']);
        } else {
            return Redirect::back()->with(['error'=> 'Update GAGAL!']);
        }
    }

    public function history() {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('presensi.history', compact('namabulan'));
    }

    public function gethistory(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nip = Auth::guard('karyawan')->user()->nip;

        $history = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
        ->where('nip', $nip)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistory', compact('history'));
    }
    public function ijin() {
        $nip = Auth::guard('karyawan')->user()->nip;
        $dataijin = DB::table('ijin')->where('nip', $nip)->get();
        return view ('presensi.ijin', compact ('dataijin'));
    }

    public function buatijin() {
        return view ('presensi.buatijin');
    }

    public function storeijin(Request $request) {
        $nip = Auth::guard('karyawan')->user()->nip;
        $tgl_ijin = $request->tgl_ijin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nip' => $nip,
            'tgl_ijin' => $tgl_ijin,
            'status' => $status,
            'keterangan' => $keterangan
            ];

        $simpan = DB::table('ijin')->insert($data);

        if ($simpan) {
            return redirect('/presensi/ijin')->with(['success' => 'Data berhasil disimpan']);
        } else {
            return redirect('/presensi/ijin')->with(['error'=> 'Data Gagal disimpan']);
        }
    }

    public function livereport () {
        return view ('presensi.livereport');
    }

    public function getpresensi(Request $request){

        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
            ->select('presensi.*','nama_lengkap','nama_div')
            ->join('karyawan', 'presensi.nip','=','karyawan.nip')
            ->join('divisi', 'karyawan.kode_div', '=', 'divisi.kode_div')
            ->where('tgl_presensi', $tanggal)
            ->get();

        return view ('presensi.getpresensi', compact ('presensi'));
    }
    public function tampilkanmap(Request $request) {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
        ->join('karyawan', 'presensi.nip', '=', 'karyawan.nip')
        ->first();
        return view ('presensi.showmap', compact('presensi'));
    }

    public function laporanpresensi() {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view ('presensi.laporanpresensi', compact('namabulan', 'karyawan'));
    }
    public function cetaklaporan(Request $request) {
        $nip = $request->nip;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')
            ->where('nip', $nip)
            ->join('divisi', 'karyawan.kode_div', '=', 'divisi.kode_div')
            ->first();

        $presensi = DB::table('presensi')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' .$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="' .$tahun.'"')
            ->orderBy('tgl_presensi')
            ->get();
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function laporanpresensiall() {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('presensi.laporanpresensiall', compact('namabulan'));
    }

    public function cetaklaporanpresensiall(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $laporanpresensiall = DB::table('presensi')
            ->selectRaw('presensi.nip, nama_lengkap,
                MAX(IF(DAY(tgl_presensi)= 1, CONCAT(jam_in, "-" , jam_out),0)) as tgl_1,
                MAX(IF(DAY(tgl_presensi)= 2, CONCAT(jam_in, "-" , jam_out),0)) as tgl_2,
                MAX(IF(DAY(tgl_presensi)= 3, CONCAT(jam_in, "-" , jam_out),0)) as tgl_3,
                MAX(IF(DAY(tgl_presensi)= 4, CONCAT(jam_in, "-" , jam_out),0)) as tgl_4,
                MAX(IF(DAY(tgl_presensi)= 5, CONCAT(jam_in, "-" , jam_out),0)) as tgl_5,
                MAX(IF(DAY(tgl_presensi)= 6, CONCAT(jam_in, "-" , jam_out),0)) as tgl_6,
                MAX(IF(DAY(tgl_presensi)= 7, CONCAT(jam_in, "-" , jam_out),0)) as tgl_7,
                MAX(IF(DAY(tgl_presensi)= 8, CONCAT(jam_in, "-" , jam_out),0)) as tgl_8,
                MAX(IF(DAY(tgl_presensi)= 9, CONCAT(jam_in, "-" , jam_out),0)) as tgl_9,
                MAX(IF(DAY(tgl_presensi)= 10, CONCAT(jam_in, "-" , jam_out),0)) as tgl_10,
                MAX(IF(DAY(tgl_presensi)= 11, CONCAT(jam_in, "-" , jam_out),0)) as tgl_11,
                MAX(IF(DAY(tgl_presensi)= 12, CONCAT(jam_in, "-" , jam_out),0)) as tgl_12,
                MAX(IF(DAY(tgl_presensi)= 13, CONCAT(jam_in, "-" , jam_out),0)) as tgl_13,
                MAX(IF(DAY(tgl_presensi)= 14, CONCAT(jam_in, "-" , jam_out),0)) as tgl_14,
                MAX(IF(DAY(tgl_presensi)= 15, CONCAT(jam_in, "-" , jam_out),0)) as tgl_15,
                MAX(IF(DAY(tgl_presensi)= 16, CONCAT(jam_in, "-" , jam_out),0)) as tgl_16,
                MAX(IF(DAY(tgl_presensi)= 17, CONCAT(jam_in, "-" , jam_out),0)) as tgl_17,
                MAX(IF(DAY(tgl_presensi)= 18, CONCAT(jam_in, "-" , jam_out),0)) as tgl_18,
                MAX(IF(DAY(tgl_presensi)= 19, CONCAT(jam_in, "-" , jam_out),0)) as tgl_19,
                MAX(IF(DAY(tgl_presensi)= 20, CONCAT(jam_in, "-" , jam_out),0)) as tgl_20,
                MAX(IF(DAY(tgl_presensi)= 21, CONCAT(jam_in, "-" , jam_out),0)) as tgl_21,
                MAX(IF(DAY(tgl_presensi)= 22, CONCAT(jam_in, "-" , jam_out),0)) as tgl_22,
                MAX(IF(DAY(tgl_presensi)= 23, CONCAT(jam_in, "-" , jam_out),0)) as tgl_23,
                MAX(IF(DAY(tgl_presensi)= 24, CONCAT(jam_in, "-" , jam_out),0)) as tgl_24,
                MAX(IF(DAY(tgl_presensi)= 25, CONCAT(jam_in, "-" , jam_out),0)) as tgl_25,
                MAX(IF(DAY(tgl_presensi)= 26, CONCAT(jam_in, "-" , jam_out),0)) as tgl_26,
                MAX(IF(DAY(tgl_presensi)= 27, CONCAT(jam_in, "-" , jam_out),0)) as tgl_27,
                MAX(IF(DAY(tgl_presensi)= 28, CONCAT(jam_in, "-" , jam_out),0)) as tgl_28,
                MAX(IF(DAY(tgl_presensi)= 29, CONCAT(jam_in, "-" , jam_out),0)) as tgl_29,
                MAX(IF(DAY(tgl_presensi)= 30, CONCAT(jam_in, "-" , jam_out),0)) as tgl_30,
                MAX(IF(DAY(tgl_presensi)= 31, CONCAT(jam_in, "-" , jam_out),0)) as tgl_31')
            ->join('karyawan', 'presensi.nip', '=', 'karyawan.nip')
            ->whereRaw('MONTH(tgl_presensi)="' .$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="' .$tahun.'"')
            ->groupByRaw('presensi.nip , nama_lengkap')
            ->get();

        return view ('presensi.cetaklaporanpresensiall', compact ('bulan', 'tahun', 'namabulan', 'laporanpresensiall'));
    }

    public function perijinankaryawan(Request $request) {
        $query = Perijinankaryawan::query();
        $query->select('id', 'tgl_ijin', 'ijin.nip','nama_lengkap', 'jabatan', 'status', 'status_approval', 'keterangan');
        $query->join('karyawan', 'ijin.nip', '=', 'karyawan.nip');
        if(!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_ijin', [$request->dari, $request->sampai]);
        }

        if(!empty($request->nip)) {
            $query->where('ijin.nip', $request->nip);
        }

        if(!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%'.$request->nama_lengkap. '%');
        }

        if($request->statusapproval === '0' ||$request->statusapproval === '1' || $request->statusapproval === '2' ) {
            $query->where('status_approval', $request->statusapproval);
        }
        $query->orderBy('tgl_ijin', 'desc');
        $perijinankaryawan = $query->paginate(5);
        $perijinankaryawan->appends($request->all());
        return view('presensi.perijinankaryawan', compact ('perijinankaryawan'));
    }

    public function approvalijinkaryawan (Request $request) {

        $status_approval = $request->status_approval;
        $id_formperijinankaryawan = $request->id_formperijinankaryawan;
        $update = DB::table('ijin')->where('id', $id_formperijinankaryawan)->update([
            'status_approval' => $status_approval
        ]);
        if($update) {
            return Redirect::back()->with(['success' => 'Approval berhasil diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Approval gagal diupdate']);
        }
    }

    public function batalkanapproval ($id) {
        $update = DB::table('ijin')->where('id', $id)->update([
            'status_approval' => 0
        ]);
        if($update) {
            return Redirect::back()->with(['success' => 'Approval berhasil dibatalkan']);
        } else {
            return Redirect::back()->with(['warning' => 'Approval gagal dibatalkan']);
        }
    }

    public function cekpengajuanijin(Request $request) {
        $tgl_ijin = $request->tgl_ijin;
        $nip = Auth::guard('karyawan')->user()->nip;

        $cek = DB::table('ijin')->where('nip', $nip)->where('tgl_ijin', $tgl_ijin)->count();
        return $cek;
    }
}
