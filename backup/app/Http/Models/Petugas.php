<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
