<?php

namespace App\Imports;

use App\wrGampong;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;


class wrGampongimport implements ToModel, WithChunkReading,ShouldQueue ,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new wrGampong([

            'code' => $row[1],
            'nik'   => $row[2],
            'nama'   => $row[3],
            'alamat'    => $row[4],
            'jenis_id' =>$row[5],
            'is_active' => $row[6]

            // 'code' =>$row["code"],
            // 'nik'  =>$row["nik"],
            // 'nama' =>$row["nama"],
            // 'alamat' =>$row["alamat"],
            // 'jenis_retribusi' =>$row["jenis_id"],
            // 'tarif_gampong' =>$row["tarif_gampong"],
            // 'is_active' =>$row["is_active"]
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
