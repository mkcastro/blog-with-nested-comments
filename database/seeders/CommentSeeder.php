<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::isProduction()) {
            return false;
        }

        // TODO: use Comment::factory() instead of Comment::create()
        Comment::create([
            'blog_id' => 1,
            'body' => 'This is a root comment for blog #1',
            'children' => [
                [
                    'body' => 'This is the first child comment of comment #1',
                    'children' => [
                        [
                            'body' => 'This is the first child comment of comment #2',
                        ],
                    ],
                ],
            ],
        ]);

        Comment::create([
            'blog_id' => 2,
            'body' => 'This is a root comment for blog #2',
            'children' => [
                [
                    'body' => 'This is the first child comment of comment #4',
                    'children' => [
                        [
                            'body' => 'This is the first child comment of comment #5',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
