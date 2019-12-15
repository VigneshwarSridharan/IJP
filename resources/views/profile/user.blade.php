@extends('layouts.client')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-8">
            @foreach ($posts as $key => $post)
                <div class="card mb-3 post-item pointer" data-toggle="modal" data-target="#post-{{$key}}">
                    <div class="card-body d-flex">
                        @if($post->status == 'PUBLISHED')
                            <div class="site-badge blue mb-3">Published</div>
                        @elseif($post->status == 'PENDING')
                            <div class="site-badge orange mb-3">Pending</div>
                        @endif
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
                <div class="card">
                    <div class="card-body">
                        <form class="profile-update" action="/profile" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="profile-pic mb-3 text-center">
                                <img class="img-fluid rounded-circle" width="150" src="{{ url('storage/'.Auth::user()->avatar) }}" alt="{{Auth::user()->name}}" />
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" />
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="email" name="username" class="form-control" value="{{Auth::user()->email}}" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control"  />
                                <small class="form-text text-muted">Leave empty to keep the same.</small>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" aria-describedby="inputGroupFileAddon01" accept="image/*" >
                                        <label class="custom-file-label" for="inputGroupFile01">Choose profile</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">Save</button>
                        </form>
                        
                    </div>
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

@push('scripts')
    <script src="{{url('js/site/profile.js')}}"></script>
@endpush