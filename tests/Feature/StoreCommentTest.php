<?php

namespace Tests\Feature;

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
            'commentable_id' => 1,
            'commentable_type' => 'blog',
            'body' => 'This is a root comment for blog #1',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('blogs', 1);
        $this->assertDatabaseCount('comments', 1);
        $this->assertDatabaseHas('comments', [
            'commentable_id' => $blog->id,
            'commentable_type' => 'App\Models\Blog',
            'body' => 'This is a root comment for blog #1',
        ]);
    }

    public function test_add_comment_to_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->for(
            Blog::factory(),
            'commentable'
        )->create();

        $response = $this->actingAs($user)->postJson(route('comments.store'), [
            'commentable_id' => $comment->id,
            'commentable_type' => 'comment',
            'body' => 'This is a reply to comment #1',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('comments', 2);
        $this->assertDatabaseHas('comments', [
            'commentable_id' => $comment->id,
            'commentable_type' => 'App\\Models\\Comment',
            'body' => 'This is a reply to comment #1',
        ]);
    }

    // TODO: create a test that adds a comment to an unknown commentable type
    // TODO: create a test that adds a comment to a comment 2 layers deep
    // TODO: create a test that adds a comment to a comment 3 layers deep
    // TODO: create a test that adds a comment to a comment 4 layers deep and assert it is not allowed
    // TODO: make sure that comments on blogs are root comment nodes
    // TODO: make sure that comments on comments are not root comment nodes
}
