@extends('layouts.client')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-tabs user-posts-filter" id="post-filter" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{$status == '' ? 'active' : ''}}" href="/profile">All ( {{$profile->published+$profile->pending+$profile->rejected+$profile->draft}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$status == 'published' ? 'active' : ''}}" href="/profile/status/published">Published ( {{$profile->published}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$status == 'review' ? 'active' : ''}}" href="/profile/status/review">Under Review ( {{$profile->pending}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$status == 'rejected' ? 'active' : ''}}" href="/profile/status/rejected">Rejected ( {{$profile->rejected}} )</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$status == 'draft' ? 'active' : ''}}" href="/profile/status/draft">Draft ( {{$profile->draft}} )</a>
                    </li>
                </ul>
                <div class="card mb-3">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts['data'] as $key => $post)
                                    <tr>
                                        <th scope="row">{{$post->id}}</th>
                                        <td>{{$post->title}}</td>
                                        <td class="text-capitalize">
                                            <span class="badge @if($post->status == 'PUBLISHED') badge-primary @elseif($post->status == 'PENDING') badge-warning @elseif($post->status == 'REJECTED') badge-danger @elseif($post->status == 'DRAFT') badge-secondary @endif ">
                                                {{strtolower($post->status)}}
                                            </span>
                                        </td>
                                        <td><a href="javascript:void(0)" @if($post->status == "DRAFT") data-edit="{{$post->id}}" @else data-post="{{$post->id}}" @endif>{{$post->status == "DRAFT" ? 'Edit' :'View'}}</a></td>
                                    </tr>
                                @endforeach
                                @if(count($posts['data']) == 0)
                                    <tr>
                                        <td colspan="4" class="text-center">No results found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($posts['prev_page_url'] || $posts['next_page_url'])
                    <div class="row">
                        <div class="col-sm-4">
                            @if($posts['prev_page_url'])
                                <a class="btn btn-primary" href="{{$posts['prev_page_url']}}">Previous</a>
                            @endif
                        </div>
                        <div class="col-sm-4 text-center">
                            <p>{{$posts['current_page']}} / {{$posts['last_page']}}</p>
                        </div>
                        <div class="col-sm-4 text-right">
                            @if($posts['next_page_url'])
                                <a class="btn btn-primary" href="{{$posts['next_page_url']}}">Next</a>
                            @endif
                        </div>
                    </div>
                @endif
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

    @foreach ($posts['data'] as $key => $post)
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