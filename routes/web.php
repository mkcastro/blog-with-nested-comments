<?php

use App\Actions\CreateBlog;
use App\Actions\IndexBlog;
use App\Actions\ShowBlog;
use App\Actions\StoreBlog;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/blogs', IndexBlog::class)->name('blogs.index');
    Route::get('/blogs/create', CreateBlog::class)->name('blogs.create');
    Route::get('/blogs/{blog}', ShowBlog::class)->name('blogs.show');
    Route::post('/blogs', StoreBlog::class)->name('blogs.store');
});
