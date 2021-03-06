<?php

use Illuminate\Support\Facades\Auth;

use \TCG\Voyager\Models\Page;

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

Route::get('/profile', 'ProfileController@user')->middleware('auth')->name('profile');

Route::get('/profile/status/{status}', 'ProfileController@user')->middleware('auth');

Route::get('/profile/reviews', 'ProfileController@reviews')->middleware('auth')->name('reviews');

Route::get('/profile/reviews/status/{status}', 'ProfileController@reviews')->middleware('auth');

Route::post('/profile', 'ProfileController@update')->middleware('auth');

Route::post('/posts', 'SiteController@posts');

Route::post('/posts/{id}', 'SiteController@postDetails');

Route::get('/posts/{id}/comments', 'SiteController@comments');

Route::post('/posts/{id}/like', 'LikeController@store')->middleware('auth');

Route::post('/posts/{id}/comments', 'SiteController@addComments');

Route::post('/posts/{id}/review', 'SiteController@review')->middleware('auth');

Route::get('/category/{category}',"SiteController@category");

Route::get('/verify-reviewer/{id}', 'SiteController@verifyReviewer');

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/reviews','ProfileController@reviews')->name('voyager.reviews.index');
    Route::get('/reviews/status/{status}','ProfileController@reviews');
    Route::get('/reviewers', 'ProfileController@findReviewer');
    Route::get('/reviews/edit/{post_id}/{id}','ProfileController@updateReviews')->name('voyager.reviews.edit');
    Route::post('/reviews/edit/{post_id}/{id}','ProfileController@submitReviews');
    Route::get('/posts/{id}/assign','ReviewController@assign')->name('assignToReviewer');
    Route::post('/posts/{id}/assign','ReviewController@assignToReviewer');
    Route::get('/posts/{id}/reviews','ReviewController@reviews')->name('reviewsList');
    Route::post('/posts/{id}/reviews','ReviewController@changeStatus');
});

Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );

Route::get ( '/test', function() {

    dd(Auth::user()->toArray());

    return response()->json(App\Like::all());
});

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


Route::get('{slug}', function($slug) {
    $page = Page::where('slug','=',$slug)->first();
    if(isset($page)) {
        return view('page')->with('page',$page);
    }
    else {
        return view('errors.404');
    }
});