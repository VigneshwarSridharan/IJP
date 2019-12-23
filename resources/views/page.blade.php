@extends('layouts.client')

@section('content')
    <div class="container">
        <div class="card my-3">
            <div class="card-body">
                {!!$page->body!!}
            </div>
        </div>
    </div>
@endsection