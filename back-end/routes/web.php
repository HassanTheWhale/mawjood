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
Route::get('/auth/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback'])->name('login.googlecallback');
Route::get('/auth/microsoft', [App\Http\Controllers\Auth\LoginController::class, 'redirectToMicrosoft'])->name('login.microsoft');
Route::get('/auth/microsoft/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleMicrosoftCallback'])->name('login.microsoftcallback');


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
Route::get('/followingEvent', [App\Http\Controllers\CategoryController::class, 'following'])->name('category.following');

// events page
// Route::get('/myEvents', [App\Http\Controllers\EventContoller::class, 'myEvent'])->name('events');
Route::get('/event/{id}', [App\Http\Controllers\EventContoller::class, 'event'])->name('events.event');

// signup and withdraw
Route::get('/event/{id}/signup', [App\Http\Controllers\EventSignController::class, 'signup'])->name('events.signup');
Route::get('/event/{id}/privatesignup', [App\Http\Controllers\EventSignController::class, 'privatesignup'])->name('events.privatesignup');
Route::get('/event/{id}/withdraw', [App\Http\Controllers\EventSignController::class, 'withdraw'])->name('events.withdraw');

//attend
Route::get('/generateQR/{id}', [App\Http\Controllers\AttendaneContoller::class, 'generateQRCode'])->name('events.qr');
Route::get('/attendEvent/{id}', [App\Http\Controllers\AttendaneContoller::class, 'attend'])->name('events.attend');
Route::get('/open/{id}', [App\Http\Controllers\EventControlController::class, 'open'])->name('events.open');
Route::get('/close/{id}', [App\Http\Controllers\EventControlController::class, 'close'])->name('events.close');
Route::post('/faceCheck/{eid}/{uid}/{iid}', [App\Http\Controllers\AuthController::class, 'captureImage'])->name('auth.facePost');

//check event
Route::get('/check/{id}/', [App\Http\Controllers\EventControlController::class, 'check'])->name('events.check');
Route::get('/checkAttendance/{id}/', [App\Http\Controllers\EventControlController::class, 'checkAttendance'])->name('events.checkAttendance');
Route::get('/checkAttendance/{id}/{user}', [App\Http\Controllers\EventControlController::class, 'checkAttendanceUser'])->name('events.checkAttendanceUser');
// Route::post('/updateGrade/{eid}/{uid}', [App\Http\Controllers\EventControlController::class, 'updateGrade'])->name('events.updateGrade');
Route::get('/setAbsent/{eid}/{uid}/{date}', [App\Http\Controllers\EventControlController::class, 'setAbsent'])->name('events.setAbsent');
Route::get('/setAttend/{eid}/{uid}/{date}', [App\Http\Controllers\EventControlController::class, 'setAttend'])->name('events.setAttend');

// create new event
Route::get('/create', [App\Http\Controllers\EventContoller::class, 'create'])->name('events.create');
Route::post('/create', [App\Http\Controllers\EventContoller::class, 'createEvent'])->name('events.createEvent');
Route::get('/remove/{id}', [App\Http\Controllers\EventContoller::class, 'remove'])->name('events.remove');
Route::get('/modify/{id}', [App\Http\Controllers\EventContoller::class, 'modify'])->name('events.modify');
Route::post('/modify/{id}', [App\Http\Controllers\EventContoller::class, 'modifyEvent'])->name('events.modifyEvent');

Route::get('/PrivateKey/{id}', [App\Http\Controllers\EventContoller::class, 'privateKey'])->name('events.privateKey');
Route::post('/PrivateKey/{id}', [App\Http\Controllers\EventContoller::class, 'privateKeyModify'])->name('events.privateKeyModify');