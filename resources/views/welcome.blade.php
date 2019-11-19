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
                            {{-- <p>{{$post->name}}</p>
                            <p>{{$post->avatar}}</p> --}}
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
                <div class="card">
                    <div class="card-body text-justify">
                        <div class="site-badge orange mb-3">Challenge</div>
                        <h4>Let's Go Camping</h4>
                        <p>Need to disconnect? Camping is the perfect fall outdoor activity to get you out of the house as you escape into the woods.</p>
                        <img src="{{url('storage/common/bg-3.jpg')}}" class="img-fluid rounded mb-3" />
                        <p>Need to disconnect? Camping is the perfect fall outdoor activity to get you out of the house as you escape into the woods. Feel at one with nature as you visit scenic campsites off-the-grid before you return to the hustle and bustle of city life.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body bg-light">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body text-justify">
                                    <div class="site-badge orange mb-3">Challenge</div>
                                    <h4>Let's Go Camping</h4>
                                    <p>Need to disconnect? Camping is the perfect fall outdoor activity to get you out of the house as you escape into the woods.</p>
                                    <img src="{{url('storage/common/bg-3.jpg')}}" class="img-fluid rounded mb-3" />
                                    <p>Need to disconnect? Camping is the perfect fall outdoor activity to get you out of the house as you escape into the woods. Feel at one with nature as you visit scenic campsites off-the-grid before you return to the hustle and bustle of city life.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="login-wrapper">
                                <div class="text-center">
                                    <img class="mb-5" src="{{ url('storage/'.setting('site.logo') )}}" alt="{{ setting('site.title')}}"/>
                                    <h4>Indian journal of photography</h4>
                                    <div class="sub-title mb-3">By Indians, for Indians</h6>
                                </div>
                                <form class="login-form" autocomplete="off" action="/action_page.php" method="POST">
                                    <div class="border mb-3 bg-white">
                                        <div class="input-group border-bottom">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-0" placeholder="Email" autocomplete="off" value="">
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-0 color-secondary" id="inputGroup-sizing-default"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" class="form-control border-0" placeholder="Password" autocomplete="off" value="">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block mb-3">Login</button>
                                    <div class="other-options">
                                        <div class="border-bottom"></div>
                                        <div class="text">OR</div>
                                    </div>
                                    <a href="/redirect/google" class="btn btn-primary btn-block mb-3 google"><i class="fab fa-google mr-2"></i> Continue with Google</a>
                                    <a href="/redirect/facebook" class="btn btn-primary btn-block mb-3 facebook"><i class="fab fa-facebook-square mr-2"></i> Continue with Facebook</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
