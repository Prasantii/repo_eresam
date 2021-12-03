<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ErorValidasiTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($error_messages)
    {
        return [
            'success'              => false,
            'error_code'           => 401,
            'validasi_eror'       => $error_messages,
            

        ];
    }
}
