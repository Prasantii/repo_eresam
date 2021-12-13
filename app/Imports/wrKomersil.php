<?php

namespace App\Imports;

use App\Http\Models\WajibRetribusi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class wrKomersil implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new WajibRetribusi([
                        
                        'KODE'                   =>$row['code'],

        ]);
    }
}
