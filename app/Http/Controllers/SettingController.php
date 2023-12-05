<?php

namespace App\Http\Controllers;

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
}
