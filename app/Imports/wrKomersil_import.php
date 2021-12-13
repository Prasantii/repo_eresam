<?php

namespace App\Imports;
use App\Http\Models\wrGampong;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


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
            'no' => $row[0],
            'nama' => $row[3],
            'alamat' => $row[4],
            'jenis_id' => $row[5],
            'kota'     => $row[6],
            'is_active' => $row[7]
            //dd($row)
            ]);
        }
        //return $rows;
    }
}
