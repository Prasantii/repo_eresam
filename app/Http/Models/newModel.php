<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class newModel extends Model
{
    protected $table='detail_trs_wr';

    //=============GAK DIPAKE=============
    protected $dates=['bulan'];
    //protected $date_format='U';

    public function getFromDateAttribute() {
    return Carbon::parse($this->attribute['bulan'])
    ->translatedFormat('1, d F Y');
}
}
