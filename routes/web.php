<?php

use Illuminate\Support\Facades\Auth;

use \TCG\Voyager\Models\Post;

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

Route::get('/logout', function() {
    Auth::logout();

    return redirect('/');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );

Route::get ( '/test', function() {
    $page = Post::all();
    // echo '<pre>';
    foreach($page as $key => $value) {
        echo $key;
        echo ($value['body']);
        echo '<br/>';
    }
} );