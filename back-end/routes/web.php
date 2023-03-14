<?php

use Illuminate\Support\Facades\Route;

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

// check if user login or not, auth auto..
Auth::routes();

// landing page
Route::get('/', function () {
    return view('index');
})->name('index');


// main page
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// user profile page
Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');

// edit profile page
Route::get('/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('profile.edit');
Route::post('/edit', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');

// look for user
Route::get('/user/{username}', [App\Http\Controllers\UserController::class, 'user'])->name('profile.user');

// follow & Unfollow another user
Route::get('/user/{id}/follow', [App\Http\Controllers\FollowControler::class, 'follow'])->name('profile.followUser');
Route::get('/user/{id}/unfollow', [App\Http\Controllers\FollowControler::class, 'unfollow'])->name('profile.unfollowUser');

// search for profile page
Route::get('/search', [App\Http\Controllers\UserController::class, 'search'])->name('profile.search');


//category page
Route::get('/category/{id}', [App\Http\Controllers\CategoryController::class, 'category'])->name('category.category');

// events page
// Route::get('/myEvents', [App\Http\Controllers\EventContoller::class, 'myEvent'])->name('events');
Route::get('/event/{id}', [App\Http\Controllers\EventContoller::class, 'event'])->name('events.event');

// signup and withdraw
Route::get('/event/{id}/signup', [App\Http\Controllers\EventSignController::class, 'signup'])->name('events.signup');
Route::get('/event/{id}/withdraw', [App\Http\Controllers\EventSignController::class, 'withdraw'])->name('events.withdraw');

//check event
Route::get('/check/{id}/', [App\Http\Controllers\EventControlController::class, 'check'])->name('events.check');
Route::get('/checkAttendance/{id}/', [App\Http\Controllers\EventControlController::class, 'checkAttendance'])->name('events.checkAttendance');
Route::get('/checkAttendance/{id}/{user}', [App\Http\Controllers\EventControlController::class, 'checkAttendanceUser'])->name('events.checkAttendanceUser');


// create new event
Route::get('/create', [App\Http\Controllers\EventContoller::class, 'create'])->name('events.create');
Route::post('/create', [App\Http\Controllers\EventContoller::class, 'createEvent'])->name('events.createEvent');
Route::get('/remove/{id}', [App\Http\Controllers\EventContoller::class, 'remove'])->name('events.remove');
Route::get('/modify/{id}', [App\Http\Controllers\EventContoller::class, 'modify'])->name('events.modify');
Route::post('/modify/{id}', [App\Http\Controllers\EventContoller::class, 'modifyEvent'])->name('events.modifyEvent');