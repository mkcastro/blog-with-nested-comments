<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_blog()
    {
        $response = $this->postJson(route('blogs.store'), [
            'title' => 'Test Title',
            'body' => 'Test Body',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Title',
            'body' => 'Test Body',
        ]);
    }
}
