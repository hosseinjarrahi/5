<?php

namespace Quizviran\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResourse extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => url("/quiz/exam/{$this->id}"),
            'desc' => $this->desc,
            'start' => $this->start->diffForHumans(),
            'duration' => $this->duration - Carbon::now()->diffInMinutes($this->start),
            'time' => $this->duration,
            'isInTime' => $this->isInTime(),
        ];
    }
}
