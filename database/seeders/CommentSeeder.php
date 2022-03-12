<?php

namespace Database\Seeders;

use App\Actions\StoreComment;
use App\Models\Blog;
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

        if (Comment::count() > 0) {
            return false;
        }

        foreach (Blog::all() as $blog) {
            $firstComment = StoreComment::run($blog, 'This is a comment to the blog: ' . $blog->title);
            $secondComment = StoreComment::run($firstComment, 'This is a reply to the first comment');
            StoreComment::run($secondComment, 'This is a reply to the second comment');
        }
    }
}
