@extends('mail.base')

@section('title', 'Thanks for submitting your post')

@section('content')
    <p>
        <b>Hey {{$name}},</b>
    </p>

    <p>
        Thanks for submitting the post of <b>{{$title}}</b>, your post has waiting for approval, keep in touch.
    </p>

    <p style="margin-top: 0">
        Regards,<br>
        {{setting('site.title')}} Team
    </p>

@endsection