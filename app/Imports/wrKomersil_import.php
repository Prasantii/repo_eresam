<?php

namespace App\Imports;
use App\Http\Models\wrGampong;
use App\Http\Models\DetailImage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
<<<<<<< HEAD
use Maatwebsite\Excel\Concerns\WithHeadingRow;

=======
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


>>>>>>> 229ad1e7c3251ba3e455e2bb320c0017bcf7c199

class wrKomersil_import implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key=>$row)
        {
<<<<<<< HEAD
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
=======
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
>>>>>>> 229ad1e7c3251ba3e455e2bb320c0017bcf7c199
            ]);
        }
    }
        //return $rows;
    }
}
