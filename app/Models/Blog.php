<?php

namespace App\Models;

use App\Contracts\Commentable;
use App\Contracts\HasAuthorInterface;
use App\Traits\HasAuthorTrait;
use App\Traits\HasCommentsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model implements HasAuthorInterface, Commentable
{
    use HasFactory;
    use HasAuthorTrait;
    use HasCommentsTrait;
}
