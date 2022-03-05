<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class UserSeeder extends Seeder
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

        if (User::whereEmail('john@example.com')->exists()) {
            return false;
        }

        User::factory()->create([
            'email' => 'john@example.com',
        ]);
    }
}
