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
    public function user(Request $request, $status="") {

        $profile =  DB::table('posts')
                        ->select([
                            DB::raw('SUM(status = "PUBLISHED") as published'),
                            DB::raw('SUM(status = "DRAFT") as draft'),
                            DB::raw('SUM(status = "PENDING") as pending'),
                            DB::raw('SUM(status = "REJECTED") as rejected'),
                        ])
                        ->where('author_id','=',Auth::user()->id)
                        ->first();
        $where = [
            ['posts.author_id','=',Auth::user()->id]
        ];
        if($status) {
            $where[] = ['posts.status','=',strtoupper($status)];
        }
        $posts  = DB::table('posts')
                ->select([
                        'posts.*',
                        'users.name',
                        'users.avatar',
                        DB::raw("COUNT(DISTINCT comments.id) as comments_count"),
                        DB::raw("COUNT(DISTINCT likes.id) as likes_count"),
                        DB::raw("COUNT(DISTINCT li.id) as active_like"),
                        DB::raw("COUNT(DISTINCT com.id) as active_comment"),
                    ])
                ->leftjoin('users', 'users.id', '=', 'posts.author_id')
                ->leftjoin('comments', 'posts.id', '=', 'comments.post_id')
                ->leftjoin('likes', 'posts.id', '=', 'likes.post_id')
                ->leftjoin('likes as li', function($join) {
                    $join->on('posts.id', '=', 'li.post_id')->on('li.liked_by', '=', DB::raw(Auth::check() ? Auth::user()->id : 'NULL'));
                })
                ->leftjoin('comments as com', function($join) {
                    $join->on('posts.id', '=', 'com.post_id')->on('com.comment_by', '=', DB::raw(Auth::check() ? Auth::user()->id : 'NULL'));
                })
                ->where($where)
                ->groupBy('posts.id')
                ->latest()
                ->paginate()
                ->toArray();
                // ->get();
                
                // dd($posts);  

        $result= $posts;

        return view('profile.user')->with([
            'posts'=>$result,
            'profile' => $profile,
            'status' => $status
        ]);
    }

    public function reviews($status="") {

        $where = [
            ['posts.status','=','PENDING']
        ];
        $orWhere = [
            ['reviews.reviewed_by','=',Auth::user()->id],
            
        ];
        
        $profile =  DB::table('posts')
                        ->select([
                            DB::raw('SUM(status = "PUBLISHED") as published'),
                            DB::raw('SUM(status = "DRAFT") as draft'),
                            DB::raw('SUM(status = "PENDING") as pending'),
                            DB::raw('SUM(status = "REJECTED") as rejected'),
                        ])
                        ->where('author_id','=',Auth::user()->id)
                        ->first();

        $info =  DB::table('posts')
                        ->select([
                            DB::raw('SUM(posts.status = "PUBLISHED") as published'),
                            DB::raw('SUM(posts.status = "PENDING") as pending'),
                            DB::raw('SUM(posts.status = "REJECTED") as rejected'),
                        ])
                        ->leftjoin('reviews','reviews.post_id','=','posts.id')
                        ->where($where)
                        ->orWhere($orWhere)
                        ->first();
                        
        // dd($info);
        if($status) {
            $orWhere[] = ['posts.status','=',strtoupper($status)];
            if($status != 'pending') {
                $where = [];
            }
        }

        $posts  = DB::table('posts')
                ->select([
                        'posts.*',
                        "categories.name as category_name",
                        'reviews.review'
                    ])
                ->leftjoin('reviews','reviews.post_id','=','posts.id')
                ->leftjoin('categories','posts.category_id','=','categories.id')
                // ->whereNull('posts.reviewed_by')
                ->where($where)
                ->orWhere($orWhere)
                ->groupBy('posts.id')
                ->latest()
                ->paginate()
                ->toArray();
                
        // dd($posts);
        // $result= [];
        // $result['published'] = $posts->filter(function($item) {
        //     return $item->status == 'PUBLISHED' ? TRUE : FALSE;
        // })->toArray();
        
        // $result['pending'] = $posts->filter(function($item) {
        //     return $item->status == 'PENDING' ? TRUE : FALSE;
        // })->toArray();
        
        // $result['rejected'] = $posts->filter(function($item) {
        //     return $item->status == 'REJECTED' ? TRUE : FALSE;
        // })->toArray();

        // $result['draft'] = $posts->filter(function($item) {
        //     return $item->status == 'DRAFT' ? TRUE : FALSE;
        // })->toArray();

        return view('profile.reviews')->with([
            'posts' => $posts,
            'status' => $status,
            'profile' => $profile,
            'info' => $info
            ]);
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
