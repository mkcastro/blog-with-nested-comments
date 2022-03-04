<?php

namespace App\Actions;

use App\Exceptions\DuplicatedBlogException;
use App\Models\Blog;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreBlog
{
    use AsAction;

    public function handle(string $title, string $body): Blog
    {
        if (Blog::where('title', $title)->exists()) {
            return throw new DuplicatedBlogException('Blog with title "' . $title . '" already exists.');
        }

        return Blog::forceCreate([
            'title' => $title,
            'body' => $body,
        ]);
    }

    public function asController(ActionRequest $request): Blog
    {
        return $this->handle($request->get('title'), $request->get('body'));
    }
}
