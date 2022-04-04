<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\HasBlogInterface;
use App\Traits\HasBlogTrait;
use App\Traits\HasCommentsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model implements HasBlogInterface, Commentable
{
    use HasFactory;
    use NodeTrait;
    use HasBlogTrait;
    use HasCommentsTrait;

    public $fillable = [
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
