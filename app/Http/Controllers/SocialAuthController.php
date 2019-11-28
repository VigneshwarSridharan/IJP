<?php

namespace App\Http\Controllers;


use Storage;
use App\User;
use Socialite;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SocialAuthController extends Controller
{
    // 
    public function callback($service) {
        $user = Socialite::with ( $service )->user ();
        $res = User::where('email', $user->email)->first();
        if(isset($res)) {
            Auth::login($res);
        }
        else {
            $newUser = new User;

            $newUser->role_id = 2;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = '';

            if($user->avatar) {
                $url = $user->avatar;
                $contents = file_get_contents($url);
                $directory = 'users/'.Carbon::now()->format('FY').'/';
                $name = Str::random(20).'.jpg';
                Storage::disk('public')->put($directory.$name, $contents);
                $newUser->avatar = $directory.$name;
            }
            // $newUser->settings = '{"locale":"en"}';
            $newUser->save();

            $mailData= ['name' => $newUser->name];
            Mail::send('mail.basic', $mailData, function($message) use ($newUser) {
                $message->to($newUser->email, $newUser->name)
                        ->subject(setting('site.title'));
                $message->from(setting('site.email'),setting('site.title'));
            });


            Auth::login($newUser);
        }


        return redirect('/');
        
    }

    public function redirect($service) {
        return Socialite::driver ( $service )->redirect ();
    }

    public function users() {
        $users = User::all();
        foreach ($users as $user) {
            echo $user->name;
        }
        return 'sdf';
        dd($user);
    }
}
