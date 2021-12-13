<?php

namespace App\Imports;
use App\Http\Models\wrGampong;
use App\Http\Models\DetailImage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class wrKomersil_import implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key=>$row)
        {
            if($key>0)
            {
           $wr_gampong = wrGampong::create([
                'nik'               =>$row[1],
                'nama'             	=>$row[2],
                'hp'               	=>$row[3],
                'alamat'    	    =>$row[4],
                'district_id'       =>$row[5],
                'villages_id'      	=>$row[6],
                'username'	        =>$row[7],
                'email'		        =>$row[8],
                'password'		    =>hash::make($row[9]),
            ]);

            DetailImage::create([
        'id_wr' =>$wr_gampong->id
            ]);
        }
    }
        //return $rows;
    }
}
