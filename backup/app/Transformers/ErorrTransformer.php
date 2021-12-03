<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ErorrTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($messages)
    {
        return [
            'success'              => 'false',
            'error'                => $messages,
            'messages'           => array($messages),
            
        ];
    }
}
