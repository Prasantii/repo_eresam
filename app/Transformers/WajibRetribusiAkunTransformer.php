<?php

namespace App\Transformers;

use App\Http\Models\WajibRetribusi;
use App\Http\Models\DetailImage;
use App\Http\Models\AppVersion;
use App\Http\Models\Tagihan;
use League\Fractal\TransformerAbstract;

use DB;

class WajibRetribusiAkunTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($warr)
    {
        
        return [
            'wajib_retribusi' => array(
                'success'               => true,
                'id'           => $warr->id,
                'code'                   => $warr->code,
                'username'                  => $warr->username,
                'password'                    => $warr->password,
                'code'                  => $warr->code,
                'qrcode'                => $warr->qrcode,
                )
        ];
    }
}
