<?php

namespace App\Http\Controllers;

use App\User;
use App\Star;
use App\Review;
use App\Rating;
use Carbon\Carbon;
use TCG\Voyager\Models\Post;
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

        $ratings = Rating::all()
            ->toArray();

        // $ratings = array_map(funtion($item) { }, $ratings);
        $ratings = array_map(function($item) {
            $item['stars'] = 0;
            return $item;
        }, $ratings);
        $where = [];

        // dd($ratings);
        if($status==""||$status == 'new') {
            $where[] = ['review','=',NULL];
        }
        else {
            $where[] = ['review','!=',NULL];
        }
        $reviewList  = Review::select(['posts.*','reviews.*'])
            ->where('reviews.reviewed_by', '=', Auth::user()->id)
            ->leftjoin('posts','posts.id','=','reviews.post_id')
            ->where($where)
            ->paginate()
            ->toArray();
        $post_ids = array_map(function($item) {
            return $item['post_id'];
        },$reviewList['data']);

        $stars = Star::select(['ratings.id','ratings.rating_name','stars.post_id','stars.stars'])
            ->whereIn('post_id',$post_ids)
            ->leftjoin('ratings','ratings.id','=','stars.rating_id')
            ->get()
            ->toArray();
        $reviewList['data'] = array_map(function($item) use($stars,$ratings) {
            $filterStars = array_filter($stars,function($fItem) use($item) {
                return $fItem['post_id'] == $item['post_id'];
            });
            if(count($filterStars)) {
                $item['ratings'] = $filterStars;
            }
            else {
                $item['ratings'] = $ratings;
            }
            return $item;
        },$reviewList['data']);
        // dd($reviewList['data']);
        
        return view('test')->with([
            'posts' => $reviewList,
            'status' => $status,
            'ratings' => $ratings
        ]);
    }

    public function updateReviews($post_id,$id) {
        $post = DB::table('posts')
            ->select('posts.*', 'categories.name as category')
            ->where('posts.id','=',$post_id)
            ->leftjoin('categories','categories.id','=','posts.category_id')
            ->first();

        $stars = Star::where('post_id','=',$post_id)
            ->get()
            ->toArray();
        
        if(count($stars) > 0) {
            $ratings = DB::table('ratings')
                ->select(['ratings.*','stars.post_id','stars.stars'])
                ->leftjoin('stars','stars.rating_id','=','ratings.id')
                ->where('stars.post_id','=',$post_id)
                ->get(); 
        }
        else {

            $ratings = Rating::all();
        }


        $review = Review::find($id);
        // dd(count($stars));
        return view('admin.reviewForm')->with([
            'post'=>$post,
            'ratings'=>$ratings,
            'review'=>$review
        ]);
    }

    public function submitReviews(Request $request, $post_id, $id) {
        $reviewComment = Review::find($id);
        $reviewComment->review = $request->review;
        // dd($review);
        $reviewComment->save();
        foreach ($request->rating as $rating_id => $stars) {
            $star = new Star;
            $star->post_id = $post_id;
            $star->rating_id = $rating_id;
            $star->stars = $stars;
            $star->save();
        }

        $post = Post::find($post_id);
        $post->status = 'REVIEWED';
        $post->save();

        return redirect()->route('voyager.reviews.index');
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

    public function findReviewer(Request $request)
    {
        $result = [
            "results" => [],
            "pagination" => [
                "more" => FALSE
            ]
            ];
        if($request->search) {
            $result['results'] = User::select(['id','name as text'])
                ->where([
                    ['role_id','=',5],
                    ['reviewer_verify','=','VERIFIED'],
                    ['name','LIKE','%'.$request->search.'%'],
                ])->get();
            return response()->json($result);
        }
        else {
            $result['results'] = User::select(['id','name as text'])
                ->where([
                    ['role_id','=',5],
                    ['reviewer_verify','=','VERIFIED'],
                ])->get();
            return response()->json($result);
        }
    }
}
