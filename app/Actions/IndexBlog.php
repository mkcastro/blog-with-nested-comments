<?php

namespace App\Actions;

use App\Models\Blog;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Lorisleiva\Actions\Concerns\AsAction;

class IndexBlog
{
    use AsAction;

    public function handle(): Collection
    {
        return Blog::all();
    }

    public function asController(): Response
    {
        return Inertia::render('Blog/Index', [
            'blogs' => $this->handle(),
        ]);
    }
}
