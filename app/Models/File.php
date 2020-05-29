<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File as FileFacade;

class File extends Model
{
    protected $guarded = ['id'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function isOwn()
    {
        return auth()->id() == $this->user_id;
    }

    public function getMimeAttribute()
    {
        return Str::of($this->name)->afterLast('.');
    }

    public function getSizeAttribute()
    {
        $kb = FileFacade::size(storage_path('app/'.$this->path)) / 1000;

        return  $kb > 1000 ? floor($kb/1000) . ' Mb' : floor($kb) . ' Kb';
    }
}
