<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use \TCG\Voyager\Models\Post;
use \App\User;

class PostUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        if($event->dataType->name == "posts" && $event->data->status == "PUBLISHED") {
            $post = Post::find($event->data->id);
            if($post->reviewed_by == null) {
                $user = User::find($post->author_id);
                $post->reviewed_by = Auth::user()->id;
                $post->save();
                // $mailData= [
                //     'name' => $user->name,
                //     'title' => $post->title
                // ];
                // Mail::send('mail.postApproved', $mailData, function($message) use ($user) {
                //     $message->to($user->email, $user->name)
                //             ->subject('Post Submission');
                //     $message->from(setting('site.email'),setting('site.title'));
                // });
            }
        }
    }
}
