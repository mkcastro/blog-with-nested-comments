<?php

namespace App\Actions;

use App\Contracts\Commentable;
use App\Enums\CommentableType;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Enum;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreComment
{
    use AsAction;

    public function rules(): array
    {
        return [
            'commentable_id' => 'required|integer',
            'commentable_type' => [
                'required',
                'string',
                new Enum(CommentableType::class),
            ],
            'body' => 'required|string',
        ];
    }

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
            case CommentableType::Blog->value:
                $commentable = Blog::findOrFail($request->get('commentable_id'));
                break;
            case CommentableType::Comment->value:
                $commentable = Comment::findOrFail($request->get('commentable_id'));
                break;
            default:
                // TODO: consider removing default case since this is already validated on rules() method

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
