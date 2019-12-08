<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function user(Request $request) {
        
        $posts  = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.author_id')
        ->select('posts.*', 'users.name', 'users.avatar')
        ->where([
            ['posts.author_id','=',Auth::user()->id],
        ])
        ->latest()
        ->get();
        $toast = [
            "type"=>"info",
            "message" => "someting went wrong. please try again later."
        ];
        return view('profile.user')->with('posts',$posts);
    }

    public function update(Request $request) {
        $user = User::find(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->username;

        if($user->password != "") {
            $user->password = $request->password;
        }

        if($request->hasFile('image')) {
            $directory = 'users/'.Carbon::now()->format('FY').'/';
            // $name = Str::random(20).'.jpg';
            $path = $request->file('image')->store($directory,'public');
            $user->avatar = $path;
        }

        $user->save();

        $toast = [
            "type"=>"success",
            "message" => "Update successfully"
        ];

        return redirect()->back()->with('toast',$toast);



    }
}
