@extends('layouts.client')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-8">
            @foreach ($posts as $post)
                <div class="card mb-3 post-item">
                    <div class="card-body d-flex">
                        <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                        <div class="content">
                            <h4 class="title">{{$post->title}}</h4>
                            <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Get Weekly updates</h4>
                        <p>Join 172,400 photographers who get useful photo tips from our newsletter</p>
                        <div class="border p-2 d-flex rounded">
                            <input class="form-control border-0" placeholder="Your Email" />
                            <button class="btn btn-primary">Subscribe</button>
                        </div>
                        {{-- <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
