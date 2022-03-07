<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_blog()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('blogs.store'), [
                'title' => 'Test Title',
                'body' => 'Test Body',
            ]);

        $response->assertRedirect(route('blogs.show', 1));

        $this->assertDatabaseCount('blogs', 1);
        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Title',
            'body' => 'Test Body',
        ]);
    }
}
