<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\Intro;

class IntroTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Intro $intro)
    {
        return [
				'id'				   => $intro->id,
                'nama'                 => $intro->nama,
                'gambar'               => $intro->gambar,
				'url'                  => $intro->url,
                'created_at'           => $intro->created_at->diffForHumans(),
            
        ];
    }
}
