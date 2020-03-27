<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'url' => url($this->categories[0]->name.'/'.$this->slug),
            'desc' => $this->desc,
            'status' => $this->status,
            'percentage' => $this->percentage,
            'pic' => $this->pic,
            'course_items' => $this->course_items,
            'price' => $this->price,
            'offer' => $this->offer,
            'user_id' => $this->user_id,
            'meta' => $this->meta,
            'files' => $this->files,
            'user' => $this->user,
        ];
    }
}
