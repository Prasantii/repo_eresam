<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class wrGampong extends Model
{
    protected $table = 'wajib_retribusi';
     protected $fillable = ['nik','nama','hp','alamat','username','email','password'];
    // ->select('a.*','b.nama as j_retribusi','b.tarif_gampong','c.name as namaDistrict','d.name as namaVillage')
    // ->leftJoin('jenis_retribusi as b','a.jenis_id','=','b.id')
    // ->leftJoin('districts as c','a.district_id','=','c.id')
    // ->leftJoin('villages as d','a.villages_id','=','d.id')
    // ->get();
    //protected $fillable = ['code', 'nik','nama','jenis_id','alamat','is_active'];
               
}

