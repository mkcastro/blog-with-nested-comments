<?php

namespace App\Actions;

use App\Contracts\Commentable;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Support\Facades\Session;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreComment
{
    use AsAction;

    public function handle(Commentable $commentable, string $body): Commentable
    {
        // TODO: refactor to use match
        if ($commentable instanceof Blog) {
            return $commentable->comments()->create([
                'body' => $body,
            ]);
        }

        if ($commentable instanceof Comment) {
            return $commentable->comments()->create([
                'body' => $body,
            ]);
        }
    }

    public function asController(ActionRequest $request)
    {
        switch ($request->get('commentable_type')) {
            case 'blog':
                $commentable = Blog::findOrFail($request->get('commentable_id'));
                break;
            case 'comment':
                $commentable = Comment::findOrFail($request->get('commentable_id'));
                break;
            default:
                Session::flash('flash.banner', 'Commentable type not found');
                Session::flash('flash.bannerStyle', 'danger');

                return redirect()->back();
        }

        return $this->handle(
            $commentable,
            $request->get('body')
        );
    }
}
