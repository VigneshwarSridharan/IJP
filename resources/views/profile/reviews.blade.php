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

@push('styles')
    <link rel="stylesheet" href="{{url('css/review.css')}}" />
@endpush

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
                <div class="post-grid-wrppaer row no-gutters">
                    @foreach ($posts['data'] as $key => $post)
                        <div class="col-sm-3 p-2">
                            <div class="post-grid">
                                <div class="content">
                                    <img src="{{url('storage/'.$post->image)}}" alt="{{$post->title}}" class="w-100" />
                                    <span class="text-capitalize badge @if($post->status == 'PUBLISHED') badge-primary @elseif($post->status == 'PENDING') badge-warning @elseif($post->status == 'REJECTED') badge-danger @elseif($post->status == 'DRAFT') badge-secondary @endif ">
                                        <i class="fas fa-circle mr-1"></i> @if($post->status == 'PUBLISHED') Approved @elseif($post->status == 'PENDING') Under Review @elseif($post->status == 'REJECTED') Rejected @endif
                                    </span>
                                </div>
                                <div class="overlay" @if($post->status == "DRAFT") data-edit="{{$post->id}}" @else data-post="{{$post->id}}" @endif>
                                    {{$post->status == "DRAFT" ? 'Edit' :'View'}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(count($posts['data']) == 0)
                    <div class="card mb-3 post-item">
                        <div class="card-body text-center">
                            <h3>No results found</h3>
                        </div>
                    </div>
                @endif
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
                        <span class="text-capitalize badge badge-lg badge-primary mb-2">
                            <i class="fas fa-circle mr-1"></i> {{$post->category_name}}
                        </span>
                        
                        {!!$post->body!!}

                        @if($post->status == "PENDING")
                            <h4>Review comment</h4>
                            <div class="card">
                                <div class="card-body">
                                    <form class="review-comment" method="POST" action="/posts/{{$post->id}}/review">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="post_id" value="{{$post->id}}" />
                                        <div class="form-group">
                                            <textarea class="form-control" name="review" rows="5" placeholder="Leave your comment here!!!"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status-{{$post->id}}-1" name="status" class="custom-control-input" value="PUBLISHED" required>
                                                <label class="custom-control-label" for="status-{{$post->id}}-1">Accept</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status-{{$post->id}}-2" name="status" class="custom-control-input" value="REJECTED" required>
                                                <label class="custom-control-label" for="status-{{$post->id}}-2">Reject</label>
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
    <script src="{{url('js/lib/isotope-docs.min.js')}}"></script>
    <script src="{{url('js/site/profile.js')}}"></script>
    <script src="{{url('js/site/review.js')}}"></script>
@endpush