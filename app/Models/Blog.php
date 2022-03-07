<?php

namespace App\Models;

use App\Contracts\HasAuthorInterface;
use App\Traits\HasAuthorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model implements HasAuthorInterface
{
    use HasFactory;
    use HasAuthorTrait;
}
