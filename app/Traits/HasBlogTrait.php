<?php

namespace App\Traits;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasBlogTrait
{
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
