<?php

namespace App\Listeners;

use \App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdateListener
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
        if($event->dataType->name == "users" && $event->data->role->name == "reviewer") {
            $token = Str::random(20);
            $event->data->remember_token = $token;
            $event->data->save();
            $user = $event->data;
            $mailData= [
                'name' => $user->name,
                'token' => $token
            ];
            Mail::send('mail.reviewerVerify', $mailData, function($message) use ($user,$token) {
                $message->to($user->email, $user->name)
                        ->subject('Reviewer Role');
                $message->from(setting('site.email'),setting('site.title'));
            });
        }
    }
}
