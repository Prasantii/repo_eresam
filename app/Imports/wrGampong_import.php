<?php

namespace App\Imports;

use App\wrGampong;
            use Maatwebsite\Excel\Imports\HeadingRowFormatter;
            use Maatwebsite\Excel\Concerns\ToModel;
            use Maatwebsite\Excel\Concerns\WithHeadingRow;
            //use Maatwebsite\Excel\Imports\HeadingRowFormatter;

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
        
            $row['No'],
            'code'  => $row['Kode'],
            'nik' => $row['Nik'],
            'nama'  => $row['Nama'],
            'alamat' => $row['Alamat'],
            'jenis_id' => $row['Jenis Retribusi'],
            'is_active' => $row['Verifikasi']
    ]);

                        // 'KODE'              =>$row['code'],
                        // 'NIK'               =>$row['nik'],
                        // 'NAMA'              =>$row['nama'],
                        // 'ALAMAT'            =>$row['alamat'],
                        // 'JENIS RETRIBUSI'   =>$row['jenis_retribusi'],
                        // 'TARIF'             =>$row['tarif_gampong'],
                        // 'VERIFIKASI'        =>$row['is_active']
    
    }
}
