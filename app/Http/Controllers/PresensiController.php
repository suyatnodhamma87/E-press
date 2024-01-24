<?php

namespace App\Http\Controllers;

use App\Exports\ExportLaporan;
use App\Exports\ExportLaporanIndividu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Karyawan;
use App\Models\Karyawan as ModelsKaryawan;
use App\Models\Perijinankaryawan;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\AssignOp\Div;

class PresensiController extends Controller
{
    public function gethari() {
        $hari = date("D");

        switch ($hari) {
            case 'Sun' :
                $hari_ini = "Minggu";
                break;

            case 'Mon' :
                $hari_ini = "Senin";
                break;

            case 'Tue' :
                $hari_ini = "Selasa";
                break;

            case 'Wed' :
                $hari_ini = "Rabu";
                break;

            case 'Thu' :
                $hari_ini = "Kamis";
                break;

            case 'Fri' :
                $hari_ini = "Jumat";
                break;

            case 'Sat' :
                $hari_ini = "Sabtu";
                break;

            case 'Min' :
                $hari_ini = "Minggu";
                break;
        }
        return $hari_ini;

    }
    public function create () {
        $hariini = date("Y-m-d");
        $namahari = $this->gethari();
        $nip = Auth::guard('karyawan')->user()->nip;
        $kode_div = Auth::guard('karyawan')->user()->kode_div;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nip', $nip)->count();
        $kode_anper = Auth::guard('karyawan')->user()->kode_anper;
        $lok_kantor = DB::table('anakperusahaan')->where('kode_anper', $kode_anper)->first();
        $jamkerja =  DB::table('setting_jam_kerja')
            ->join('jam_kerja','setting_jam_kerja.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
            ->where('nip', $nip)->where('hari', $namahari)->first();
//dd($lok_kantor);
        if ($jamkerja == null) {
        $jamkerja =  DB::table('setting_jamker_div_detail')
            ->join('setting_jamker_div', 'setting_jamker_div_detail.kode_jk_div', '=', 'setting_jamker_div.kode_jk_div')
            ->join('jam_kerja','setting_jamker_div_detail.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')

            ->where('kode_div', $kode_div)
            ->where('kode_anper', $kode_anper)
            ->where('hari', $namahari)->first();
        }

        if ($jamkerja == null) {
            return view('presensi.notifikasijadwal');
        } else {
            return view('presensi.create', compact('cek', 'lok_kantor', 'jamkerja'));
        }
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
        $namahari = $this->gethari();
        $jamkerja =  DB::table('setting_jam_kerja')
            ->join('jam_kerja','setting_jam_kerja.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
            ->where('nip', $nip)->where('hari', $namahari)->first();

        //cek jam kerja karyawan
        $presensi = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nip', $nip);
        $cek = $presensi->count();
        $datapresensi = $presensi->first();

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

        if($radius >$lok_kantor->radius) {
            echo "error|Maaf Anda berada di luar radius, Jarak Anda ".$radius." meter dari kantor|radius";
        } else {
            if($cek > 0){
                if ($jam < $jamkerja->jam_pulang) {
                    echo "error|Maaf belum waktunya pulang|out";
                } else if (!empty($datapresensi->jam_out)) {
                    echo "error|Maaf Anda sudah melakukan absensi pulang!|out";
                } else {
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
                }
            } else {
                if ($jam < $jamkerja->awal_jam_masuk) {
                    echo "error|Maaf belum waktunya presensi!|in";
                } else if ($jam > $jamkerja->akhir_jam_masuk) {
                    echo "error|Maaf waktu presensi habis!|in";
                } else {
                $data = [
                    'nip' => $nip,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                    'status' => 'h',
                    'kode_jamkerja' => $jamkerja->kode_jamkerja
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
        $request->validate([
            'foto' => 'image | mimes:png,jpg,jpeg | max:2000'
        ]);
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
         ->select('presensi.*', 'alasan', 'nama_cuti', 'kode_lokasi', 'jam_masuk')
         ->leftjoin('ijin', 'presensi.kode_ijin', '=', 'ijin.kode_ijin')
         ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
         ->leftjoin('data_cuti', 'ijin.kode_cuti', '=', 'data_cuti.kode_cuti')
         ->where('presensi.nip', $nip)
         ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
         ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
         ->orderBy('tgl_presensi')
         ->get();

        return view('presensi.gethistory', compact('history'));
    }
    public function ijin(Request $request) {
        $nip = Auth::guard('karyawan')->user()->nip;

        if(!empty($request->bulan) && !empty($request->tahun)) {
            $dataijin = DB::table('ijin')
            ->leftjoin('data_cuti', 'ijin.kode_cuti', '=', 'data_cuti.kode_cuti')
            ->orderBy('tgl_ijin_dari', 'desc')
            ->where('nip', $nip)
            ->whereRaw('MONTH(tgl_ijin_dari)="'.$request->bulan.'"')
            ->whereRaw('YEAR(tgl_ijin_dari)="'.$request->tahun.'"')
            ->get();
        } else {
        $dataijin = DB::table('ijin')
        ->leftjoin('data_cuti', 'ijin.kode_cuti', '=', 'data_cuti.kode_cuti')
        ->orderBy('tgl_ijin_dari', 'desc')
        ->where('nip', $nip)->limit(6)->orderBy('tgl_ijin_dari', 'desc')
        ->get();
        }
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view ('presensi.ijin', compact ('dataijin', 'namabulan'));
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
            ->select('presensi.*','nama_lengkap','nama_div', 'jam_masuk', 'nama_jamkerja', 'jam_masuk', 'jam_pulang', 'alasan')
            ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=' , 'jam_kerja.kode_jamkerja')
            ->leftjoin('ijin', 'presensi.kode_ijin', '=' , 'ijin.kode_ijin')
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
            ->select('presensi.*', 'alasan', 'jam_kerja.*')
            ->leftjoin('jam_kerja', 'presensi.kode_jamkerja', '=' , 'jam_kerja.kode_jamkerja')
            ->leftjoin('ijin', 'presensi.kode_ijin', "=", 'ijin.kode_ijin')
            ->where('presensi.nip', $nip)
            ->whereRaw('MONTH(tgl_presensi)="' .$bulan.'"')
            ->whereRaw('YEAR(tgl_presensi)="' .$tahun.'"')
            ->orderBy('tgl_presensi')
            ->get();


        if (isset($_POST['exportexcel'])) {
            set_time_limit(100);
            $time = date("d-m-Y H:i:s");
            return Excel::download(new ExportLaporanIndividu($bulan,$tahun,$nip,$presensi,count($presensi)),"Rekap Presensi Karyawan $time.xlsx");
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function laporanpresensiall() {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
         "September", "Oktober", "November", "Desember"];
        $divisi = DB::table('divisi')->get();
        return view ('presensi.laporanpresensiall', compact('namabulan', 'divisi'));
    }

    public function cetaklaporanpresensiall(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kode_div = $request->kode_div;
        $dari = $tahun . "-" . $bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $select_date = "";
        $field_date = "";
        $i=1;
        while(strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari;
            $select_date .="MAX(IF(tgl_presensi = '$dari',
            CONCAT(
                IFNULL(jam_in,'NA'),'|',
                IFNULL(jam_out,'NA'),'|',
                IFNULL(presensi.status,'NA'),'|',
                IFNULL(presensi.kode_ijin,'NA'),'|',
                IFNULL(alasan,'NA'),'|'),
                NULL)) as tgl_".$i.",";

                $field_date .= "tgl_". $i. ",";
            $i++;
            $dari =date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetanggal[$lastrange];

        if($jmlhari == 30) {
            array_push($rangetanggal, NULL);
        } elseif($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        } elseif($jmlhari == 28) {
            array_push($rangetanggal, NULL, NULL, NULL);
        }

        $query = Karyawan::query();
        $query-> selectRaw(
            "$field_date karyawan.nip, nama_lengkap, jabatan"
        );
        $query->leftjoin(
            DB::raw("(
                SELECT
                $select_date
                presensi.nip

                    FROM presensi
                    LEFT JOIN ijin ON presensi.kode_ijin = ijin.kode_ijin
                    WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
                    GROUP BY nip

            ) presensi"),
            function($join) {
                $join->on('karyawan.nip', '=', 'presensi.nip');
            }
        );
        if(!empty($kode_div)) {
            $query->where('kode_div', $kode_div);
        }
        $query->orderBy('nip');
        $cetaklaporanpresensiall = $query->get();

        if (isset($_POST['exportexcel'])) {
            $time = date("d-m-Y H:i:s");
            return Excel::download(new ExportLaporan($bulan,$tahun,$kode_div),"Rekap Laporan Kehadiran Karyawan $time.xlsx");
        }
        return view ('presensi.cetaklaporanpresensiall', ['bulan'=>$bulan, 'tahun'=>$tahun, 'namabulan'=>$namabulan, 'cetaklaporanpresensiall'=>$cetaklaporanpresensiall, 'rangetanggal'=>$rangetanggal, 'jmlhari'=>$jmlhari]);

    }

    public function perijinankaryawan(Request $request) {
        $query = Perijinankaryawan::query();
        $query->select('kode_ijin', 'tgl_ijin_dari','tgl_ijin_sampai','ijin.nip','nama_lengkap', 'jabatan', 'status', 'status_approval', 'alasan');
        $query->join('karyawan', 'ijin.nip', '=', 'karyawan.nip');
        if(!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_ijin_dari', [$request->dari, $request->sampai]);
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
        $query->orderBy('tgl_ijin_dari', 'desc');
        $perijinankaryawan = $query->paginate(10);
        $perijinankaryawan->appends($request->all());
        return view('presensi.perijinankaryawan', compact ('perijinankaryawan'));
    }

    public function approvalijinkaryawan (Request $request) {

        $status_approval = $request->status_approval;
        $kode_ijin = $request->kode_ijin_form;
        $dataijin = DB::table('ijin')->where('kode_ijin', $kode_ijin)->first();
        $nip = $dataijin->nip;
        $tgl_dari = $dataijin->tgl_ijin_dari;
        $tgl_sampai = $dataijin->tgl_ijin_sampai;
        $status = $dataijin->status;

        DB::beginTransaction();
        try {
            if($status_approval ==1) {
                while(strtotime($tgl_dari)<= strtotime($tgl_sampai)) {

                    DB::table('presensi')->insert([
                        'nip' => $nip,
                        'tgl_presensi' => $tgl_dari,
                        'status' => $status,
                        'kode_ijin' => $kode_ijin
                    ]);
                    $tgl_dari = date("Y-m-d", strtotime("+1 days", strtotime($tgl_dari)));
                }
            }

            DB::table('ijin')->where('kode_ijin', $kode_ijin)->update([
                'status_approval' => $status_approval
            ]);
            DB::commit();
            return redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function batalkanapproval ($kode_ijin) {

        DB::beginTransaction();
        try {
            DB::table('ijin')->where('kode_ijin', $kode_ijin)->update([
                'status_approval' => 0
            ]);
            DB::table('presensi')->where('kode_ijin', $kode_ijin)->delete();
            DB::commit();
            return Redirect::back()->with(['success' => 'Approval berhasil dibatalkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Approval gagal dibatalkan']);
        }

        // $update = DB::table('ijin')->where('kode_ijin', $kode_ijin)->update([
        //     'status_approval' => 0
        // ]);
        // if($update) {
        //     return Redirect::back()->with(['success' => 'Approval berhasil dibatalkan']);
        // } else {
        //     return Redirect::back()->with(['warning' => 'Approval gagal dibatalkan']);
        // }
    }

    public function cekpengajuanijin(Request $request) {
        $tgl_ijin = $request->tgl_ijin;
        $nip = Auth::guard('karyawan')->user()->nip;

        $cek = DB::table('ijin')->where('nip', $nip)->where('tgl_ijin', $tgl_ijin)->count();
        return $cek;
    }

    public function showact($kode_ijin) {
        $dataijin = DB::table('ijin')->where('kode_ijin', $kode_ijin)->first();

        return view('presensi.showact', compact('dataijin'));
    }

    public function deleteijin ($kode_ijin) {
        $cekdataijin = DB::table('ijin')->where('kode_ijin', $kode_ijin)->first();
        $doc_sid = $cekdataijin->doc_sid;

        try {
            DB::table('ijin')->where('kode_ijin', $kode_ijin)->delete();
            if ($doc_sid != null) {
                Storage::delete('/public/uploads/sid/'.$doc_sid);
            }
            return redirect('/presensi/ijin')->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect('/presensi/ijin')->with(['warning' => 'Data gagal dihapus']);

        }
    }
}
