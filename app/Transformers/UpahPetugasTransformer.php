<?php

namespace App\Transformers;

use App\Http\Models\JenisRetribusi;
use App\Http\Models\AppVersion;
use App\Http\Models\UploadBukti;
use League\Fractal\TransformerAbstract;

use DB;

class UpahPetugasTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($upah)
    {

        $data = "SELECT a.id_petugas,
                       SUM(CASE 
                            WHEN a.status = 0 
                            THEN c.total_bayar 
                            ELSE 0 
                        END) AS total_setor
                FROM `upah_petugas` as a 
                LEFT JOIN upload_bukti_trs as c ON a.id = c.id_upah ";
        $data .= ' WHERE a.id_petugas = '.$upah->id.' GROUP BY a.id_petugas';

        $upahda = DB::select($data);
        
        $getdata = "SELECT a.id_petugas,
                        SUM(CASE 
                            WHEN a.status_upah = 0 
                            THEN a.total_pungut 
                            ELSE 0 
                        END) AS total_pungut
                FROM `upah_petugas` as a  ";
        $getdata .= ' WHERE a.id_petugas = '.$upah->id.' GROUP BY a.id_petugas';
        
        $getdataak = DB::select($getdata);
        
        
        if($upahda){
            if($getdataak){
                foreach ($upahda as $upa) {
                    foreach ($getdataak as $datapu) {
                        return [
                            'success'               => true,
                            'id_petugas'           => $upa->id_petugas,
                            'total_pungut'         => $datapu->total_pungut*1000,
                            'total_setor'         => $upa->total_setor
                            
                        ]; 
                    }
                }
            }else{
                foreach ($upahda as $upa) {
                    return [
                        'success'               => true,
                        'id_petugas'           => $upa->id_petugas,
                        'total_pungut'         => 0,
                        'total_setor'         => $upa->total_setor
                        
                    ]; 
                }
            }
        }else{
            return [
                    'success'              => 'false',
                    'error'                => 'DATA TIDAK DITEMUKAN!',
                    'messages'           => array('DATA TIDAK DITEMUKAN!'),
                    
                ];
        }
    }
}
