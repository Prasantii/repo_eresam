<?php

namespace App\Imports;
use App\Http\Models\wrGampong;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class wrKomersil_import implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            wrGampong::create([
            'code' => $row[1],
            'nik' => $row[2],
            'nama' => $row[3],
            'alamat' => $row[4],
            'jenis_id' => $row[5],
            'is_active' => $row[6]
            //dd($row);
            ]);
        }
        //return $rows;
    }
}
