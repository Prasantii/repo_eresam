<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\AppVersion;
use App\Http\Models\Identitas;
use App\Http\Models\Tagihan;
use League\Fractal\TransformerAbstract;

use DB;

class TagihanTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tagihan $tagihan)
    {

        $wr = WajibRetribusi::where('id',$tagihan->id_wr)->first();

        $databukti = DB::table('lokasi_tugas as a')
                    ->select('a.*','b.nik','b.nama','b.hp')
                    ->leftJoin('petugas as b','a.id_petugas','=','b.id')
                    ->whereRaw('a.villages_id = '.$wr->villages_id.'')
                    // ->groupBy('a.id_wr')
                    ->first();

        if($databukti){
            $pp = $databukti->nama;
            $hp = $databukti->hp;
        }else{
            $pp = 'BELUM ADA PETUGAS YANG TERDAFTAR DI DAERAH TERSEBUT';
            $hp = '-';
        }
        $identitas = Identitas::first();

        if($tagihan->tgl_bayar == ""){
            $byr = '-';
        }else{
            $byr = $tagihan->tgl_bayar;
        }
        return [
            
            'success'      => true,
            'id'           => $tagihan->id,
            'bulan'         => date('F-Y',strtotime($tagihan->bulan)),
            'tarif'         => $tagihan->tarif,
            'status'        => $tagihan->status,
            'tgl_bayar'     => $byr,
            'penanggung_jawab' => $pp,
            'hp_penanggung_jawab' => $hp,
            'rek'           => $identitas->rek,
            'atas_nama' => $identitas->nama,
            'alamat_perusahaan' => $identitas->alamat
                
        ];
    }
}
