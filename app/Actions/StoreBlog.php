<?php

namespace App\Actions;

use App\Exceptions\DuplicatedBlogException;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
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

    public function asController(ActionRequest $request): RedirectResponse
    {
        try {
            $blog = $this->handle($request->get('title'), $request->get('body'));
        } catch (DuplicatedBlogException $e) {
            Session::flash('flash.banner', $e->getMessage());
            Session::flash('flash.bannerStyle', 'danger');

            return redirect()->back();
        }

        Session::flash('flash.banner', "Blog $blog->title created successfully.");
        Session::flash('flash.bannerStyle', 'success');

        return redirect()->route('blogs.show', $blog);
    }
}
