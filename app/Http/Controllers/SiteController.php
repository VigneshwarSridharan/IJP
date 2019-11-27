<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \TCG\Voyager\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function home() {
        // $Posts = Post::all();
        $Posts  = DB::table('posts')
                    ->join('users', 'users.id', '=', 'posts.author_id')
                    ->select('posts.*', 'users.name', 'users.avatar')
                    ->where('posts.status','=','PUBLISHED')
                    ->latest()
                    ->get();

        return view('welcome')->with('posts',$Posts);

    }

    public function addPost(Request $request) {

        $post = new Post;

        $post->title = $request->title;
        $post->slug = str_replace(' ','-',strtolower($request->title));
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->author_id = $request->user()->id;
        $post->category_id = 3;
        $post->status = 'PENDING';
        $post->featured = 0;
        
        if($request->hasFile('image')) {
            $directory = 'posts/';
            $path = $request->file('image')->store($directory,'public');
            $post->image = $path;
        }

        $post->save();

        return redirect('/')->with('message','Sent for peer review');
    }
}
