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
        return [
            'type' => 'products',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price,
                'status' => $this->status,
                'stock' => $this->stock,
                'images' => $this->getMedia('images')->map(fn($image) => [
                    'type' => 'images',
                    'attributes' => [
                        'url' => $image->getUrl()
                    ]
                ])
            ]
        ];

    }
}
