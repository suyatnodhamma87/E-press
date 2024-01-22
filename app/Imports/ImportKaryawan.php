<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Collection;
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
            "no_hp"=>$arr[4],
            "foto"=>null,
            "kode_div"=>$arr[6],
            'password'=>Hash::make(123),
            "kode_anper"=>null

        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
