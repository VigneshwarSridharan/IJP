@extends('mail.base')

@section('title', 'Thanks for submitting your post')

@section('content')
    <p>
        <b>Hey {{$name}},</b>
    </p>

    <p>
        The {{$title}} post has approved, keep in touch.
    </p>

    <p style="margin-top: 0">
        Regards,<br>
        {{setting('site.title')}} Team
    </p>

@endsection