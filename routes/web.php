<?php

use Illuminate\Support\Facades\Auth;

use \TCG\Voyager\Models\Post;

// use Mail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;


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

Route::get('/', 'SiteController@home');

Route::get('/login', 'SiteController@home')->name('login');

Route::get('/register', 'SiteController@home');


Route::post('/login','SiteController@login');

Route::post('/checkLogin','SiteController@checkLogin');

Route::post('/register','SiteController@register');

Route::post('/checkRegister','SiteController@checkRegister');

Route::post('/addPost', 'SiteController@addPost')->middleware('auth');

Route::get('/profile', 'ProfileController@user')->middleware('auth');

Route::post('/profile', 'ProfileController@update')->middleware('auth');

Route::post('/posts', 'SiteController@posts');

Route::get('/category/{category}',"siteController@category");

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get('/admin/posts',function() {
        return 'sdfdsfsf';
    });
    Voyager::routes();
});

Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );

Route::post ( '/test', function() {
    return response()->json(Auth::user());
} );

Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
 
    return "Cleared!";
 
 });

 Route::get('/storage', function() {
     
    Artisan::call('storage:link');

    return 'Storage linked done!';
 });