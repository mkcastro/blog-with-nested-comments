<?php

namespace App\Actions;

use App\Models\Blog;
use Inertia\Inertia;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowBlog
{
    use AsAction;

    public function handle(Blog $blog): Blog
    {
        return $blog->with('comments.user')->findOrFail($blog->id);
    }

    public function asController(Blog $blog)
    {
        return Inertia::render('Blog/Show', [
            'blog' => $this->handle($blog),
        ]);
    }
}
