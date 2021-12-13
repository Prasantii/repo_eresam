<?php

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class wrGampong extends Model
{
    protected $table = 'wajib_retribusi';
    protected $fillable = ['nik','nama','hp','alamat','district_id','villages_id','username','email','password'];  
}

