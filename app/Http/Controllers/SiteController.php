<?php

namespace App\Http\Controllers;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \TCG\Voyager\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    public function register(Request $request) {
        $newUser = new User;

        $newUser->role_id = 2;
        $newUser->name = $request->name;
        $newUser->email = $request->username;
        $newUser->password = Hash::make($request->password);

        if($request->avatar) {
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

        $toast = [
            "type" => "success",
            "message" => "Hey ".$newUser->name." welcome to ".setting('site.title')
        ];

        return redirect('/')->with('toast',$toast);
    }

    public function checkRegister(Request $request) {
        $res = User::where('email', $request->username)->first();
        $response = [
            "status" => "error",
            "data" => "User already exists"
        ];
        if(!isset($res)) {
            $response['status'] = 'success';
            $response['data'] = 'Username available';
        }
        return response()->json($response);
    }

    public function login(Request $request) {
        $res = User::where('email', $request->username)->first();

        $toast = [
            "type" => "error"
        ];

        if(isset($res)) {
            if(Hash::check($request->password, $res->password)) {
                if(isset($res)) {
                    Auth::login($res);
                    return redirect('/');
                }
            }
            else {
                $toast['message'] = 'Password doesn\'t match.';
                return redirect('/')->with('toast',$toast);
            }
        }
        $toast['message'] = 'Username doesn\'t match.';
        return redirect('/')->with('toast',$toast);

    }

    public function checkLogin(Request $request) {
        $res = User::where('email', $request->username)->first();
        
        $response = [
            "status" => "error",
            "data" => "Username doesn't match."
        ];
        if(isset($res)) {
            if(Hash::check($request->password, $res->password)) {                
                $response['status']="success";
                $response['data']="Valid user.";
            }
            else {
                $response['data']="Password doesn't match.";
            }
        }
        return response()->json($response);
    }

    public function home(Request $request) {
        // $Posts = Post::all();
        $Posts  = DB::table('posts')
                    ->join('users', 'users.id', '=', 'posts.author_id')
                    ->select('posts.*', 'users.name', 'users.avatar')
                    ->where('posts.status','=','PUBLISHED')
                    ->latest()
                    ->get();
        $toast = [
            "type"=>"info",
            "message" => "someting went wrong. please try again later."
        ];
        // $request->session()->flash('toast', $toast);
        return view('welcome')->with(['posts'=>$Posts]);

    }

    public function posts() {
        $result  = DB::table('posts')
                    ->join('users', 'users.id', '=', 'posts.author_id')
                    ->select('posts.*', 'users.name', 'users.avatar')
                    ->where('posts.status','=','PUBLISHED')
                    ->latest()
                    // ->get()
                    ->paginate(2)
                    ->toArray();
        $result['data'] = array_map(function($post) {
            $post->excerpt=Str::words($post->excerpt,40,'...');
            return $post;
        },$result['data']);
        return response()->json([
            'status'=>'success',
            'response' => $result,
            'timestamp'=>Carbon::now()->toDateTimeLocalString()
        ]);
    }

    public function addPost(Request $request) {
        dd($request->all());

        $post = new Post;
        $user = Auth::user();

        $post->title = $request->title;
        $post->slug = str_replace(' ','-',strtolower($request->title));
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->author_id = $user->id;
        $post->category_id = 3;
        $post->status = 'PENDING';
        $post->featured = 0;
        
        if($request->hasFile('image')) {
            $directory = 'posts/';
            $path = $request->file('image')->store($directory,'public');
            $post->image = $path;
        }

        
        $post->save();

        $mailData= [
            'name' => $user->name,
            'title' => $post->title
        ];
        Mail::send('mail.postSubmit', $mailData, function($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Post Submission');
            $message->from(setting('site.email'),setting('site.title'));
        });

        return redirect('/')->with('message','Sent for peer review');
    }
}
