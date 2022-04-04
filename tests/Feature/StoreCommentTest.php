<?php

namespace Tests\Feature;

use App\Actions\StoreComment;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_can_be_added_to_a_blog()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create();

        $response = $this->actingAs($user)->postJson(route('comments.store'), [
            // ! this makes system vulnerable to any user creating comments on behalf of other users
            'user_id' => $user->id,
            'commentable_id' => $blog->id,
            'commentable_type' => 'blog',
            'body' => 'This is a root comment for blog #1',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount('blogs', 1);
        $this->assertDatabaseCount('comments', 1);
        $this->assertDatabaseHas('comments', [
            'commentable_id' => $blog->id,
            'commentable_type' => 'App\Models\Blog',
            'body' => 'This is a root comment for blog #1',
        ]);

        $comment = Comment::withDepth()->first();

        $this->assertTrue($comment->isRoot());
        $this->assertEquals(0, $comment->depth);
    }

    public function test_add_comment_to_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->for(
            Blog::factory(),
            'commentable'
        )->create();

        $response = $this->actingAs($user)->postJson(route('comments.store'), [
            // ! this makes system vulnerable to any user creating comments on behalf of other users
            'user_id' => $user->id,
            'commentable_id' => $comment->id,
            'commentable_type' => 'comment',
            'body' => 'This is a reply to comment #1',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount('comments', 2);
        $this->assertDatabaseHas('comments', [
            'commentable_id' => $comment->id,
            'commentable_type' => 'App\\Models\\Comment',
            'body' => 'This is a reply to comment #1',
        ]);

        $secondComment = Comment::withDepth()->find(2);

        $this->assertFalse($secondComment->isRoot());
        $this->assertTrue($secondComment->isChildOf($comment));
        // * depth is zero based
        $this->assertEquals(1, $secondComment->depth);
    }

    public function test_add_comment_with_unknown_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('comments.store'), [
            // ! this makes system vulnerable to any user creating comments on behalf of other users
            'user_id' => $user->id,
            'commentable_id' => 1,
            'commentable_type' => 'unknown',
            'body' => 'This is a reply to comment #1',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('commentable_type');

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_add_comment_to_a_comment_that_is_2_layers_deep()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->for(
            Blog::factory(),
            'commentable'
        )->create();

        $secondComment = StoreComment::run($user, $comment, 'This is a reply to comment #1');

        $this->assertDatabaseCount('comments', 2);
        $this->assertFalse($secondComment->isRoot());
        $this->assertTrue($secondComment->isChildOf($comment));

        StoreComment::run(
            User::factory()->create(),
            $secondComment,
            'This is a reply to comment #2'
        );

        $this->assertDatabaseCount('comments', 3);

        $this->assertDatabaseHas('comments', [
            'commentable_id' => $secondComment->id,
            'commentable_type' => 'App\\Models\\Comment',
            'body' => 'This is a reply to comment #2',
        ]);

        $thirdComment = Comment::withDepth()->find(3);

        $this->assertFalse($thirdComment->isRoot());
        $this->assertTrue($thirdComment->isChildOf($secondComment));
        // * depth is zero based
        $this->assertEquals(2, $thirdComment->depth);
    }

    public function test_store_comment_to_a_comment_that_is_4_layers_deep()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->for(
            Blog::factory(),
            'commentable'
        )->create();

        $secondComment = StoreComment::run(
            User::factory()->create(),
            $comment,
            'This is a reply to comment #1'
        );

        $this->assertDatabaseCount('comments', 2);
        $this->assertFalse($secondComment->isRoot());
        $this->assertTrue($secondComment->isChildOf($comment));

        StoreComment::run(
            User::factory()->create(),
            $secondComment,
            'This is a reply to comment #2'
        );

        $this->assertDatabaseCount('comments', 3);

        $this->assertDatabaseHas('comments', [
            'commentable_id' => $secondComment->id,
            'commentable_type' => 'App\\Models\\Comment',
            'body' => 'This is a reply to comment #2',
        ]);

        $thirdComment = Comment::withDepth()->find(3);

        $this->assertFalse($thirdComment->isRoot());
        $this->assertTrue($thirdComment->isChildOf($secondComment));
        // * depth is zero based
        $this->assertEquals(2, $thirdComment->depth);

        $thirdResponse = $this->actingAs($user)->postJson(route('comments.store'), [
            'user_id' => $user->id,
            'commentable_id' => $thirdComment->id,
            'commentable_type' => 'comment',
            'body' => 'This is a reply to comment #3',
        ]);

        $thirdResponse->assertUnprocessable();
        $this->assertDatabaseCount('comments', 3);
    }
}
