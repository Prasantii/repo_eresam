<?php

namespace App\Imports;

use App\Http\Models\wrGampong;
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
            
            //dd($row)
            //========== atribut DB         => atribut excel huruf kecil ===========
                        //'code'              =>$row['kode'],
                  
                'nik'               =>$row['nik'],
                'nama'             	=>$row['nama'],
                'hp'               	=>$row['no_hp'],
               // 'kabupatenDB'   	=>$row['kabupatenDB'],
                //'kecamatan.nama'	=>$row['kecamatan'],
                //'villages.name'	    =>$row['gampong']
                'alamat'           	=>$row['alamat'],
                'username'	        =>$row['username'],
                'email'		        =>$row['email'],
                'password'		    =>$row['password']               
    ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
