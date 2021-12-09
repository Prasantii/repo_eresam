<?php

namespace App\Imports;

use App\Http\Models\wrGampong;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
//use Maatwebsite\Excel\Imports\HeadingRowFormatter;
//use App\Imports\Hash;

class wrGampong_import implements ToModel, WithHeadingRow
{
    // public function __construct(){
    //     $this->wrGampong = wrGampong::select('nik','nama','hp','alamat','username','email','password','districts.name','villages.name')
    //     ->leftJoin('districts','wajib_retribusi.district_id','=','districts.id')
    //     ->leftJoin('villages','wajib_retribusi.villages_id','=','villages.id')
    //     ->get();
        
    // }

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
                        'district_id'	    =>$row['kecamatan'],
                        'villages_id'       =>$row['gampong'],
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
