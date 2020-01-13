@extends('layouts.client')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-tabs user-posts-filter" id="post-filter" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="published-tab" data-toggle="tab" href="#published" role="tab">Published</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab">Under Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rejected-post-tab" data-toggle="tab" href="#rejected-post" role="tab">Rejected</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="draft-post-tab" data-toggle="tab" href="#draft-post" role="tab">Draft</a>
                    </li>
                </ul>
                <div class="tab-content" id="post-filter-content">
                    <div class="tab-pane fade show active" id="published" role="tabpanel" aria-labelledby="published-tab">
                        @foreach ($posts['published'] as $key => $post)
                            <div class="card mb-3 post-item pointer" data-post="{{$post->id}}">
                                <div class="card-body d-sm-flex">
                                    <div class="site-badge {{$post->status == 'PUBLISHED' ? 'blue':'orange'}} mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                    <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                    <div class="content">
                                        <h4 class="title">{{$post->title}}</h4>
                                        <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="post-info">
                                                <li class="like-{{$post->id}} {{$post->active_like == 1 ? 'text-primary': '' }}"><i class="fas fa-thumbs-up"></i> <span>{{$post->likes_count}}</span></li>
                                                <li class="comment-{{$post->id}} {{$post->active_comment ? 'text-primary' : ''}}"><i class="fas fa-comment"></i> <span>{{$post->comments_count}}</span></li>
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
                        @if(count($posts['published']) == 0)
                            <div class="card mb-3 post-item">
                                <div class="card-body text-center">
                                    <h3>No results</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        @foreach ($posts['pending'] as $key => $post)
                            <div class="card mb-3 post-item pointer" data-post="{{$post->id}}">
                                <div class="card-body d-sm-flex">
                                    <div class="site-badge {{$post->status == 'PUBLISHED' ? 'blue':'orange'}} mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                    <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                    <div class="content">
                                        <h4 class="title">{{$post->title}}</h4>
                                        <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="post-info">
                                                <li class="like-{{$post->id}} {{$post->active_like == 1 ? 'text-primary': '' }}"><i class="fas fa-thumbs-up"></i> <span>{{$post->likes_count}}</span></li>
                                                <li class="comment-{{$post->id}} {{$post->active_comment ? 'text-primary' : ''}}"><i class="fas fa-comment"></i> <span>{{$post->comments_count}}</span></li>
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
                        @if(count($posts['pending']) == 0)
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
                                <div class="card-body d-sm-flex">
                                    <div class="site-badge danger mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                    <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                    <div class="content">
                                        <h4 class="title">{{$post->title}}</h4>
                                        <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="post-info">
                                                <li class="like-{{$post->id}} {{$post->active_like == 1 ? 'text-primary': '' }}"><i class="fas fa-thumbs-up"></i> <span>{{$post->likes_count}}</span></li>
                                                <li class="comment-{{$post->id}} {{$post->active_comment ? 'text-primary' : ''}}"><i class="fas fa-comment"></i> <span>{{$post->comments_count}}</span></li>
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
                        @if(count($posts['rejected']) == 0)
                            <div class="card mb-3 post-item">
                                <div class="card-body text-center">
                                    <h3>No results</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="draft-post" role="tabpanel" aria-labelledby="draft-post-tab">
                        @foreach ($posts['draft'] as $key => $post)
                            <div class="card mb-3 post-item pointer" data-edit="{{$post->id}}">
                                <div class="card-body d-sm-flex">
                                    <div class="site-badge {{$post->status == 'PUBLISHED' ? 'blue':'orange'}} mb-3 text-capitalize">{{strtolower($post->status)}}</div>
                                    <div class="featured-image" style="background-image: url({{url('storage/'.$post->image)}});"></div>
                                    <div class="content">
                                        <h4 class="title">{{$post->title}}</h4>
                                        <p class="excerpt">{{Str::words($post->excerpt,40,'...') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <ul class="post-info">
                                                <li class="like-{{$post->id}} {{$post->active_like == 1 ? 'text-primary': '' }}"><i class="fas fa-thumbs-up"></i> <span>{{$post->likes_count}}</span></li>
                                                <li class="comment-{{$post->id}} {{$post->active_comment ? 'text-primary' : ''}}"><i class="fas fa-comment"></i> <span>{{$post->comments_count}}</span></li>
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
                        @if(count($posts['published']) == 0)
                            <div class="card mb-3 post-item">
                                <div class="card-body text-center">
                                    <h3>No results</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-img-top bg-primary pt-5 text-white">
                        <div class="profile-pic mb-3 text-center">
                            <img class="img-fluid rounded-circle img-thumbnail mb-2" width="150" src="{{ url('storage/'.Auth::user()->avatar) }}" alt="{{Auth::user()->name}}" />
                            <h5 class="font-weight-normal text-white mb-3" style="opacity:.9">{{Auth::user()->name}}</h5>
                            <div class="d-flex align-items-center justify-content-around mb-3" style="opacity:.9">
                                <div>
                                    <h5 class="text-white m-0">{{$profile->published > 10 ? $profile->published : '0'.$profile->published}}</h5>
                                    <span>Published</span>
                                </div>
                                <div>
                                    <h5 class="text-white m-0">{{$profile->rejected > 10 ? $profile->rejected : '0'.$profile->rejected}}</h5>
                                    <span>Rejected</span>
                                </div>
                                <div>
                                    <h5 class="text-white m-0">{{$profile->pending > 10 ? $profile->pending : '0'.$profile->pending}}</h5>
                                    <span>Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="profile-update" action="/profile" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
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
                        <h4>Comments</h4>
                        <div id="comments-{{$post->id}}">
                            <h1 class="text-primary text-center">
                                <i class="fas fa-spinner fa-pulse"></i>
                            </h1>
                        </div>
                        @if(Auth::check()) 
                            <div class="card">
                                <div class="card-body">
                                    <form class="add-comment">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="post_id" value="{{$post->id}}" />
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" rows="5" placeholder="Leave your comment here!!!" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Comment</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Add Comment</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between align-items-center bg-light mt-2 w-100">
                            <ul class="post-info">
                                <li class="like-{{$post->id}} {{$post->active_like == 1 ? 'text-primary': '' }}"><i class="fas fa-thumbs-up"></i> <span>{{$post->likes_count}}</span></li>
                                <li class="comment-{{$post->id}} {{$post->active_comment ? 'text-primary' : ''}}"><i class="fas fa-comment"></i> <span>{{$post->comments_count}}</span></li>
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