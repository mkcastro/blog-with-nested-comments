<?php

namespace App\Traits;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasCommentsTrait
{
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
