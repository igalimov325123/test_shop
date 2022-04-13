<?php

namespace App\Http\Resources\V1;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => floatval($this->price),
            'image' => $this->image,
            'categories' => CategoryResource::collection($this->categories),
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
        ];
    }
}
