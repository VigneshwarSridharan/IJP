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

Route::post('/addPost', 'SiteController@addPost')->middleware('auth');;

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

Route::get ( '/test', function() {
    $data = array('name'=>"Virat Gandhi");
   
    Mail::send('mail.basic', $data, function($message) {
        $message->to('abc@gmail.com', 'Tutorials Point')
                ->subject('Laravel Basic Testing Mail');
        $message->from('xyz@gmail.com','Virat Gandhi');
    });

    // $name = "Virat Gandhi";
    // Mail::send('viky.viky884@gmail.com')->send(new SendMailable($name));

    return view('mail.basic')->with($data);
} );

Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
 
    return "Cleared!";
 
 });

 Route::get('/storage', function() {
     
     Artison::call('storage:link');

     return 'Storage linked done!';
 });