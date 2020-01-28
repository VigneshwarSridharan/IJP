@extends('layouts.client')

@php
    function getCount($arr,$type) {
        return count(
            array_filter($arr, function($item) use($type) {
                    return $item->status == $type;
                })
        );
    }
@endphp

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-8">
                @if(Auth::user()->role->name == 'reviewer' && Auth::user()->reviewer_verify == "VERIFIED")
                    <ul class="nav nav-tabs user-posts-filter" id="post-filter" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " href="/profile" >Your Submission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/profile/reviews" >Your Review</a>
                        </li>
                    </ul>
                @endif
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter"></i> 
                        @if($status == '')
                            All ( {{$info->published+$info->pending+$info->rejected}} )
                        @elseif($status == 'published')
                            Approved ( {{$info->published}} )
                        @elseif($status == 'pending')
                            Under Review ( {{$info->pending}} )
                        @elseif($status == 'rejected')
                            Rejected ( {{$info->rejected}} )
                        @endif
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{$status == '' ? 'active' : ''}}" href="/profile/reviews">All ( {{$info->published+$info->pending+$info->rejected}} )</a>
                        <a class="dropdown-item {{$status == 'published' ? 'active' : ''}}" href="/profile/reviews/status/published">Approved ( {{$info->published}} )</a>
                        <a class="dropdown-item {{$status == 'pending' ? 'active' : ''}}" href="/profile/reviews/status/pending">Under Review ( {{$info->pending}} )</a>
                        <a class="dropdown-item {{$status == 'rejected' ? 'active' : ''}}" href="/profile/reviews/status/rejected">Rejected ( {{$info->rejected}} )</a>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts['data'] as $key => $post)
                                    <tr>
                                        <td scope="row">{{$post->id}}</td>
                                        <td><img src="{{url('storage/'.$post->image)}}" height="50" alt="{{$post->title}}" /></td>
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->category_name}}</td>
                                        <td class="text-capitalize">
                                            <span class="badge @if($post->status == 'PUBLISHED') badge-primary @elseif($post->status == 'PENDING') badge-warning @elseif($post->status == 'REJECTED') badge-danger @elseif($post->status == 'DRAFT') badge-secondary @endif ">
                                                @if($post->status == 'PUBLISHED') Approved @elseif($post->status == 'PENDING') Under Review @elseif($post->status == 'REJECTED') Rejected @endif
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
            </div>
            <div class="col-sm-4">
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