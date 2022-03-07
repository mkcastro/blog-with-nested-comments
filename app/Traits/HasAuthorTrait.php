<?php

namespace App\Traits;

trait HasAuthorTrait
{
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
