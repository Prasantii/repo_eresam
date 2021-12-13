<?php
//==================== GAK DIPAKE=================================
namespace App\Imports;

<<<<<<< HEAD
use App\Http\Models\wrGampong;
            use Maatwebsite\Excel\Imports\HeadingRowFormatter;
            use Maatwebsite\Excel\Concerns\ToModel;
            use Maatwebsite\Excel\Concerns\WithHeadingRow;
            //use Maatwebsite\Excel\Imports\HeadingRowFormatter;
=======


use App\Http\Models\wrGampong;
use App\Http\Models\DetailImage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
//use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Facades\Hash;
//use App\Imports\Hash;
>>>>>>> 229ad1e7c3251ba3e455e2bb320c0017bcf7c199

class wrGampong_import implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
<<<<<<< HEAD
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
=======
    {   $wr_gampong = new wrGampong([
            
            //dd($row)
            //========== atribut DB         => atribut excel huruf kecil ===========
                      //'code'              =>$row['kode'],
                  
                        'nik'               =>$row['nik'],
                        'nama'             	=>$row['nama'],
                        'hp'               	=>$row['no_hp'],
                    // 'kabupatenDB'   	=>$row['kabupatenDB'],
                        'district_id'	    =>$row['kecamatan'],
                        'villages_id'       =>$row['gampong'],
                        'alamat'           	=>$row['alamat'],
                        'username'	        =>$row['username'],
                        'email'		        =>$row['email'],
                        'password'		    =>hash::make($row['password']),
    ]);

      new DetailImage([
        'id_wr' =>$wr_gampong->id
        //'id_wr'     =>$row['id']
    ]);
    return $wr_gampong;
}

public function headingRow(): int
    {
        return 1;
>>>>>>> 229ad1e7c3251ba3e455e2bb320c0017bcf7c199
    }
}
