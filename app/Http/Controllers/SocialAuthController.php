<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\Auth;
use Storage;

class SocialAuthController extends Controller
{
    // 
    public function callback($service) {
        $user = Socialite::with ( $service )->user ();
        // dd($user);
        // echo '<pre>';
        $res = User::where('email', $user->email)->first();
        // echo isset($res);
        // print_r($res);
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
        }


        return redirect('/');
        
        // return view ( 'welcome' )->withDetails ( $user )->withService ( $service );
    }

    public function redirect($service) {
        return Socialite::driver ( 'google' )->redirect ();
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
