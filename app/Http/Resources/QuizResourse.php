<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResourse extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'link' => url("quiz/{$this->id}"),
            'desc' => $this->desc,
            'start' => $this->start->diffForHumans(),
            'duration' => $this->duration - Carbon::now()->diffInMinutes($this->start),
        ];
    }
}
