<?php

namespace App\Imports;

use App\wrGampong;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;


class wrGampongimport implements ToModel,ShouldQueue ,WithHeadingRow    
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        return new wrGampong([
            //             $row[1],
            // 'code' => $row[2],
            // 'nik'   => $row[3],
            // 'nama'   => $row[4],
            // 'alamat'    => $row[5],
            // 'jenis_id' =>$row[6],
            // 'is_active' => $row[7]
          
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
