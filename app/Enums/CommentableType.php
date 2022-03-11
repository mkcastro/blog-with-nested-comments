<?php

namespace App\Enums;

enum CommentableType: string
{
    case Blog = 'blog';
    case Comment = 'comment';
}
