<?php

namespace Quizviran\Models;

use App\Models\Comment as CommentModel;

class Comment extends CommentModel
{
    public function toArray()
    {
        $array = parent::toArray();

        return array_merge($array, [
            'updateLink' => route('comment.update')
        ]);
    }
}
