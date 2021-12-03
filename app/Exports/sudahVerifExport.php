<?php

namespace App\Exports\Report;

//use App\Models\sudahVerif;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controller\LaporanController;

class sudahVerifExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	
        return sudahVerif::all();
    }
}
