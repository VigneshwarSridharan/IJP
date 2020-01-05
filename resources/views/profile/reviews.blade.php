@extends('layouts.client')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-8">
            <ul class="nav nav-tabs user-posts-filter" id="post-filter" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab">Review List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="published-tab" data-toggle="tab" href="#published" role="tab">Approved</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="rejected-post-tab" data-toggle="tab" href="#rejected-post" role="tab">Rejected</a>
                </li>
            </ul>
            <div class="tab-content" id="post-filter-content">
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    @foreach ($posts['pending'] as $key => $post)
                        <div class="card mb-3 post-item pointer" data-post="{{$post->id}}">
                            <div class="card-body d-flex">
                                <div class="site-badge {{$post->status == 'PUBLISHED' ? 'blue':'orange'}} mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                <div class="content">
                                    <h4 class="title">{{$post->title}}</h4>
                                    <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($posts['pending']) == 0)
                        <div class="card mb-3 post-item">
                            <div class="card-body text-center">
                                <h3>No results</h3>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="published" role="tabpanel" aria-labelledby="published-tab">
                    @foreach ($posts['published'] as $key => $post)
                        <div class="card mb-3 post-item pointer" data-post="{{$post->id}}">
                            <div class="card-body d-flex">
                                <div class="site-badge {{$post->status == 'PUBLISHED' ? 'blue':'orange'}} mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                <div class="content">
                                    <h4 class="title">{{$post->title}}</h4>
                                    <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($posts['published']) == 0)
                        <div class="card mb-3 post-item">
                            <div class="card-body text-center">
                                <h3>No results</h3>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="rejected-post" role="tabpanel" aria-labelledby="rejected-post-tab">
                    @foreach ($posts['rejected'] as $key => $post)
                        <div class="card mb-3 post-item pointer" data-post="{{$post->id}}">
                            <div class="card-body d-flex">
                                <div class="site-badge danger mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                <div class="content">
                                    <h4 class="title">{{$post->title}}</h4>
                                    <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($posts['rejected']) == 0)
                        <div class="card mb-3 post-item">
                            <div class="card-body text-center">
                                <h3>No results</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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

    @foreach (array_merge($posts['published'],$posts['pending'],$posts['rejected'],$posts['draft']) as $key => $post)
        <div class="modal fade" id="post-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg rounded post-details" role="document">
                <div class="modal-content border-0">
                    <div class="modal-body bg-light rounded">
                        <div class="site-badge blue mb-3">Issue #{{$post->id+1}}</div>
                        <h4 class="title">{{$post->title}}</h4>
                        <p class="excerpt">{{$post->excerpt }}</p>
                        <img src="{{ url('storage/'.$post->image) }}" class="img-fluid rounded mb-3" />
                        {!!$post->body!!}

                        @if($post->status == "PENDING")
                            <h4>Review comment</h4>
                            <div class="card">
                                <div class="card-body">
                                    <form id="review-comment" method="POST" action="/posts/{{$post->id}}/review">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="post_id" value="{{$post->id}}" />
                                        <div class="form-group">
                                            <textarea class="form-control" name="review" rows="5" placeholder="Leave your comment here!!!"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status1" name="status" class="custom-control-input" value="PUBLISHED" required>
                                                <label class="custom-control-label" for="status1">Accept</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status2" name="status" class="custom-control-input" value="REJECTED" required>
                                                <label class="custom-control-label" for="status2">Reject</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>

                        @endif

                        @if($post->review)
                            <h4>Reason</h4>
                            <p>{{$post->review}}</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
@endsection

@push('scripts')
    <script src="{{url('js/site/profile.js')}}"></script>
    <script src="{{url('js/site/review.js')}}"></script>
@endpush