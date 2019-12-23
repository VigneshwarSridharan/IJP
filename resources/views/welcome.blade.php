@extends('layouts.client')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-8">
            @if(count($posts) == 0)
                <div class="card mb-3 post-item">
                    <div class="card-body text-center">
                        <h3>No results found</h3>
                    </div>
                </div>
            @endif
            @foreach ($posts as $key => $post)
                <div class="card mb-3 post-item pointer" data-toggle="modal" data-target="#post-{{$key}}">
                    <div class="card-body d-flex">
                        <div class="site-badge blue mb-3">Issue #{{$post->id+1}}</div>
                        <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                        <div class="content">
                            <h4 class="title">{{$post->title}}</h4>
                            <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="post-info">
                                    <li><i class="fas fa-thumbs-up"></i> 45</li>
                                    <li><i class="fas fa-comment"></i> 32</li>
                                </ul>
                                <div class="d-flex align-items-center">
                                    <div class="avatar" style="background-image: url({{url('storage/'.$post->avatar)}});"></div>
                                    <div>{{$post->name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="col-sm-4">
                @if(!Auth::check())
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Get Weekly updates</h4>
                            <p>Join 172,400 photographers who get useful photo tips from our newsletter</p>
                            <div class="border p-2 d-flex rounded bg-light">
                                <input class="form-control border-0 bg-transparent" placeholder="Your Email" />
                                <button class="btn btn-primary">Subscribe</button>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card mb-2">
                    <div class="card-body text-justify">
                        <div class="site-badge orange mb-3">Challenge</div>
                        <h4>Let's Go Camping</h4>
                        <p>Need to disconnect? Camping is the perfect fall outdoor activity to get you out of the house as you escape into the woods.</p>
                        <img src="{{url('storage/common/bg-3.jpg')}}" class="img-fluid rounded mb-3" />
                        <p>Need to disconnect? Camping is the perfect fall outdoor activity to get you out of the house as you escape into the woods. Feel at one with nature as you visit scenic campsites off-the-grid before you return to the hustle and bustle of city life.</p>
                    </div>
                </div>
                <div class="categories">
                    @foreach ($categories as $category )
                        <a href="/category/{{$category['slug']}}" class="category" style="background-image: url({{url('storage/'.str_replace('\\','/',$category['image']))}});">
                            <h5>{{$category['name']}}</h5>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @foreach ($posts as $key => $post)
        <div class="modal fade" id="post-{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg rounded post-details" role="document">
                <div class="modal-content border-0">
                    <div class="modal-body bg-light rounded">
                        <div class="site-badge blue mb-3">Issue #{{$post->id+1}}</div>
                        <h4 class="title">{{$post->title}}</h4>
                        <p class="excerpt">{{$post->excerpt }}</p>
                        <img src="{{ url('storage/'.$post->image) }}" class="img-fluid rounded mb-3" />
                        {!!$post->body!!}
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between align-items-center bg-light mt-2 w-100">
                            <ul class="post-info">
                                <li><i class="fas fa-thumbs-up"></i> 45</li>
                                <li><i class="fas fa-comment"></i> 32</li>
                            </ul>
                            <div class="d-flex align-items-center">
                                <div class="avatar" style="background-image: url({{url('storage/'.$post->avatar)}});"></div>
                                <div>{{$post->name}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('css/lib/perfect-scrollbar.css')}}" />
@endpush

@push('scripts')
    <script src="{{url('js/lib/perfect-scrollbar.min.js')}}"></script>
    @if(!Auth::check())
        <script src="{{url('js/site/welcome.js')}}"></script>
    @endif
    
@endpush