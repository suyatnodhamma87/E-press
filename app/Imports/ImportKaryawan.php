<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportKaryawan implements ToModel,WithStartRow
{
    public function model(array $arr){
        return new Karyawan([
            "nip"=>$arr[1],
            "nama_lengkap"=>$arr[2],
            "jabatan"=>$arr[3],
            "kode_div"=>$arr[4],
            "no_hp"=>$arr[5],
            "foto"=>null,
            'password'=>Hash::make($arr[1].'123')

        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
