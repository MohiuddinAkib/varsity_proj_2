<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\SuperAdmin\PostList;
use App\Http\Livewire\Superadmin\FarmList;
use App\Http\Livewire\SuperAdmin\PostDetails;
use App\Http\Livewire\Superadmin\FarmDetails;
use App\Http\Livewire\LocalAdmin\FarmDetails as LocalAdminFarmDetails;
use App\Http\Livewire\LocalAdmin\PostDetails as LocalAdminPostDetails;

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
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::as("superadmin.")->prefix("superadmin")->middleware(["auth", "role:superadmin"])->group(function () {
    Route::get('/farms', FarmList::class)->name("farm.index");
    Route::get('/farms/{farm}', FarmDetails::class)->name("farm.show"); // farm specific post list o show hobe

    Route::get('/posts', PostList::class)->name("post.index"); // sob farm er sob post
    Route::get('/posts/{post}', PostDetails::class)->name("post.show"); // ekta post details
});

Route::as("localadmin.")->prefix("localadmin")->middleware(["auth", "role:localadmin"])->group(function () {
    Route::get('/farm/{farm}', LocalAdminFarmDetails::class)->name("farm.show"); // farm specific post list o show hobe
    Route::get('/farm/{farm}/posts/{post}', LocalAdminPostDetails::class)->name("post.show");
});

