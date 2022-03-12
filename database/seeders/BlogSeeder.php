<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class BlogSeeder extends Seeder
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

        if (Blog::count() > 0) {
            return false;
        }

        Blog::factory(2)->create();
    }
}
