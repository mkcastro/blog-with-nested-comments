<?php

namespace App\Actions;

use Inertia\Inertia;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBlog
{
    use AsAction;

    public function asController()
    {
        return Inertia::render('Blog/Create');
    }
}
