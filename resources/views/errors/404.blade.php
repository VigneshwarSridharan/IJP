@extends('layouts.client')

@section('content')
<div class="d-flex align-items-center justify-content-center w-100 h-100">
    <div class="page-not-found">
        <img src="{{url('storage/common/404.png')}}" class="img-fluid" />
        <div class="content">
            <h1>404</h1>
            <h3>Sorry, this page isn't available</h3>
        </div>

    </div>
</div>
@endsection