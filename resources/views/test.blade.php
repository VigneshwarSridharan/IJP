@extends('voyager::master')

@section('css')
    <link rel="stylesheet" href="{{url('css/review.css')}}" />
@stop

@section('content')
    <div class="page-content px-3">
        @include('voyager::alerts')
        <div class="line-navs">
            <div class="nav {{$status == "new" || $status == "" ? 'active':''}}">
                <a href="/admin/reviews/status/new">New Post</a>
            </div>
            <div class="nav {{$status == "reviewed" ? 'active':''}}">
                <a href="/admin/reviews/status/reviewed">Reviewed Post</a>
            </div>
        </div>
        <div class="post-grid-wrppaer row no-gutters">
            @foreach ($posts['data'] as $key => $post)
                <div class="col-sm-3 p-2">
                    <div class="post-grid">
                        <div class="content">
                            <img src="{{url('storage/'.$post['image'])}}" alt="{{$post['title']}}" class="w-100" />
                            <span class="text-capitalize badge badge-primary">
                                # {{$post['post_id']}}
                            </span>
                        </div>
                        <a href="#post-{{$post['post_id']}}" data-toggle="modal" class="overlay" >
                        {{-- <a href="/admin/reviews/edit/{{$post['post_id']}}/{{$post['id']}}" class="overlay" > --}}
                            View
                        </a>
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
    @foreach ($posts['data'] as $key => $post)
        <div class="modal modal-info fade" id="post-{{$post['post_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg rounded post-details" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{$post['title']}} ( #{{$post['post_id']}} )</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/admin/reviews/edit/{{$post['post_id']}}/{{$post['id']}}">
                            {{ csrf_field() }}
                            <h3 class="panel-title pl-0">Id</h3>
                            <p>#{{$post['post_id']}}</p>
                            <h3 class="panel-title pl-0">Title</h3>
                            <p>{{$post['title']}}</p>
                            <hr class="m-0" />
                            <h3 class="panel-title pl-0">Category</h3>
                            {{-- <p>{{$post['category']}}</p> --}}
                            <hr class="m-0" />
                            <h3 class="panel-title pl-0">Body</h3>
                            {!!$post['body']!!}
                            <hr class="m-0" />
                            <h3 class="panel-title pl-0">Post Image</h3>
                            <img src="{{url('storage/'.$post['image'])}}" class="mb-3" height="350" />
                            <hr class="m-0" />
                            <h3 class="panel-title pl-0">Review Comments</h3>
                            @if($post['review'])
                                <p>{{$post['review']}}</p>
                            @else
                                <div class="form-group">
                                    <textarea class="form-control" rows="6" placeholder="Leave your comments!" required name="review"></textarea>
                                </div>
                            @endif
                            <hr class="m-0" />
                            <h3 class="panel-title pl-0">Ratings</h3>
                            @foreach ($post['ratings'] as $rating)
                                <div class="form-group">
                                    <label>{{$rating['rating_name']}}</label>
                                    @if($rating['stars'])
                                        <p>{{$rating['stars']}} Stars
                                    @else
                                        <div class="d-flex">
                                            @foreach (array(1,2,3,4,5) as $n)
                                                <div class="custom-control custom-radio custom-control-inline mr-2">
                                                    <input type="radio" id="rating-{{$rating['id']}}" name="rating[{{$rating['id']}}]" class="custom-control-input" value="{{$n}}" required="">
                                                    <label class="custom-control-label text-body" for="rating-{{$rating['id']}}">{{$n}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <hr class="m-0" />
                            <div class="d-flex justify-content-between">
                                @if(!$post['review'])
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                @else
                                    <div></div>
                                @endif
                                <div class="btn-group">
                                    @if(isset($posts['data'][$key-1]))
                                        <button type="button" class="btn btn-info" data-post="{{$posts['data'][$key-1]['post_id']}}"><i class="voyager-angle-left"></i> Previous</button>
                                    @endif
                                    @if(isset($posts['data'][$key+1]))
                                        <button type="button" class="btn btn-info"  data-post="{{$posts['data'][$key+1]['post_id']}}" >Next <i class="voyager-angle-right"></i></button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@section('javascript')
    <script src="{{url('js/lib/isotope-docs.min.js')}}"></script>
    <script src="{{url('js/site/profile.js')}}"></script>
    <script src="{{url('js/site/review.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('[data-post]').on('click',function() {
                let id = $(this).data('post');
                $('.modal').modal('hide');
                setTimeout(function() {
                    $('#post-'+id).modal('show');
                },500)
            })
        })
    </script>
@stop