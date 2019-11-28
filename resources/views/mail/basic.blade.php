@extends('mail.base')

@section('title', 'Welcome to '.setting('site.title').'!')

@section('content')
    <p>
        <b>Hey {{$name}},</b>
    </p>
    
    <p>
        Welcome to {{setting('site.title')}}. At {{setting('site.title')}} we're best photography blogging site in India.
    </p>

    <p style="margin-top: 0">
        Regards,<br>
        {{setting('site.title')}} Team
    </p>
@endsection