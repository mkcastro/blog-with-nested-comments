<?php

namespace App\Models;

use App\Contracts\HasAuthorInterface;
use App\Contracts\HasCommentsInterface;
use App\Traits\HasAuthorTrait;
use App\Traits\HasCommentsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model implements HasAuthorInterface, HasCommentsInterface
{
    use HasFactory;
    use HasAuthorTrait;
    use HasCommentsTrait;
}
