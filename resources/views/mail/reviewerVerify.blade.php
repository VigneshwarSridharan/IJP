@extends('mail.base')

@section('title', 'Reviewer Role')

@section('content')
    <p>
        <b>Hey {{$name}},</b>
    </p>

    <p>
        Confirm to reviewer role.
    </p>

    <p>
        Verify: <a href="{{url('verify-reviewer/'.$token)}}">Click to Confirm</a>
    </p>

    <p style="margin-top: 0">
        Regards,<br>
        {{setting('site.title')}} Team
    </p>

@endsection