<?php

namespace App\Imports;

use App\Http\Models\wrGampong;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use maatwebsite\Excel\Concerns\WithChunkReading;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\Importable;

class wrGampongimport implements ToModel
{
   

    use Importable;
    public function model(array $row)
    {
        return new wrGampong([
            //             $row[1],
             //'Kode' => $row[1]
            // 'nik'   => $row[3],
            // 'nama'   => $row[4],
            // 'alamat'    => $row[5],
            // 'jenis_id' =>$row[6],
            // 'is_active' => $row[7]
        dd($row)

          
        ]);
    }
        
  
}
