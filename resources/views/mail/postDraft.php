@extends('mail.base')

@section('title', 'Thanks for submitting your post')

@section('content')
    <p>
        <b>Hey {{$name}},</b>
    </p>

    <p>
        The post of <b>{{$title}}</b> is saved as draft, keep in touch.
    </p>

    <p style="margin-top: 0">
        Regards,<br>
        {{setting('site.title')}} Team
    </p>

@endsection