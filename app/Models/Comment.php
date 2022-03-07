<?php

namespace App\Models;

use App\Contracts\HasBlogInterface;
use App\Traits\HasBlogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model implements HasBlogInterface
{
    use HasFactory;
    use NodeTrait;
    use HasBlogTrait;
}
