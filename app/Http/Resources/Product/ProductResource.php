<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'type' => 'products',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price,
                'status' => $this->status,
                'stock' => $this->stock,
                'images' => $this->getMedia('images')->map(function($image){
                    return [
                        'url' => $image->getUrl()
                    ];
                })
            ]
        ];

        // if( $this->getMedia('images')->count() ){
            
        //     $data['images'] = $this->getMedia('images')->map(function($image){
        //         return [
        //             'url' => $image->getUrl()
        //         ];
        //     });
            
        // }

        return $data;

    }
}
