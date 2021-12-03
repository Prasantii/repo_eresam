<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\Slider;

class SliderTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Slider $slider)
    {
        return [
			'id'					=> $slider->id,
            'nama'                 => $slider->nama,
            'gambar'               => $slider->gambar,
			'url'					=> $slider->url,
            'created_at'           => $slider->created_at->diffForHumans(),
            
        ];
    }
}
