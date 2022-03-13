<?php

namespace App\Actions;

use App\Contracts\Commentable;
use App\Enums\CommentableType;
use App\Exceptions\TooDeepCommentException;
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
            // TODO: show error message via Inertia
            'body' => 'required|string',
        ];
    }

    public function handle(Commentable $commentable, string $body): Commentable
    {
        if ($commentable instanceof Blog) {
            // TODO: move to own action
            return $commentable->comments()->create([
                'body' => $body,
            ]);
        }

        if ($commentable instanceof Comment) {
            // TODO: move to own action
            $parentComment = Comment::withDepth()->find($commentable->id);

            if ($parentComment->depth >= 2) {
                throw new TooDeepCommentException('Comments can only have a maximum depth of 3.');
            }

            $newComment = $parentComment->comments()->create([
                'body' => $body,
            ]);

            // * we're doing this to keep track of level of nesting
            $newComment->appendToNode($parentComment)->save();

            return $newComment;
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

        try {
            // TODO: return with status
            return back();
        } catch (TooDeepCommentException $e) {
            Session::flash('flash.banner', $e->getMessage());
            Session::flash('flash.bannerStyle', 'danger');

            return redirect()->back()->setStatusCode(422);
        }
    }
}
