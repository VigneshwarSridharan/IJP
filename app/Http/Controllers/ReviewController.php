<?php

namespace App\Http\Controllers;

use DB;
use App\Review;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Post;

class ReviewController extends Controller
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }

    public function assign(Request $request, $id) {
        $post = Post::find($id);
        $reviews = Review::select('reviews.reviewed_by','users.name')
                            ->where('post_id','=',$id)
                            ->leftjoin('users','users.id','=','reviews.reviewed_by')
                            ->get();
        return view('admin.assignReviewer')->with([
            'post'=>$post,
            'reviews'=>$reviews
        ]);
    }

    public function assignToReviewer(Request $request,$id) {
        $reviews = Review::select('reviewed_by')->where('post_id','=',$id)->get()->toArray();
        $reviews = array_map(function($item) {return $item['reviewed_by'];},$reviews);
        $insetNew = array_filter($request->approved_by, function($approved_by) use($reviews) {
            return array_search($approved_by,$reviews) === FALSE;
        });

        foreach ($insetNew as $key => $reviewer) {
            $review = new Review;

            $review->post_id = $id;
            $review->reviewed_by = $reviewer;
            $review->save();

        }

        $post = Post::find($id);
        $post->status = 'ASSIGNED';
        $post->save();
        
        return redirect()->route('reviewsList',[$id]);
    }

    public function reviews(Request $request, $id) {
        $post = DB::table('posts')->where('id','=',$id)->first();
        $reviews = Review::select(['posts.title','users.name as reviewer','reviews.review','reviews.id'])
                            ->where('reviews.post_id','=',$id)
                            ->where('reviews.review','!=', NULL)
                            ->leftjoin('posts','posts.id', "=", "reviews.post_id")
                            ->leftjoin('users','users.id', "=", "reviews.reviewed_by")
                            ->get();
                            // dd($reviews);
        $columns = ['title', 'reviewer', 'review'];
        return view('admin.reviewsList')->with(['reviews' => $reviews,"columns"=>$columns,'post'=>$post]);
    }

    public function changeStatus(Request $request,$id) {
        $post = Post::find($id);
        $post->status = $request->status;
        $post->save();

        $toast = [
            "type"=>"success",
            "message" => "Updated!"
        ];
        $request->session()->flash('toast', $toast);
        return redirect()->route('voyager.posts.index');
    }
}
