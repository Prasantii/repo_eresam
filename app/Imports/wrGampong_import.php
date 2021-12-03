<?php

namespace App\Imports;

use App\wrGampong;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class wrGampong_import implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new wrGampong([
            'code' =>$row['code'],
            'nik'  =>$row['nik'],
            'nama' =>$row['nama'],
            'alamat' =>$row['alamat'],
            'jenis_retribusi' =>$row['jenis_id'],
            'tarif_gampong' =>$row['tarif_gampong'],
            'is_active' =>$row['is_active']

                        // 'KODE'              =>$row['code'],
                        // 'NIK'               =>$row['nik'],
                        // 'NAMA'              =>$row['nama'],
                        // 'ALAMAT'            =>$row['alamat'],
                        // 'JENIS RETRIBUSI'   =>$row['jenis_retribusi'],
                        // 'TARIF'             =>$row['tarif_gampong'],
                        // 'VERIFIKASI'        =>$row['is_active']
        ]);
    }
}
