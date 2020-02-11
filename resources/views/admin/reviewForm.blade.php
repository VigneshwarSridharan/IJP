@extends('voyager::master')

@section('page_title', 'Review')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-bubble"></i> Review
    </h1>
@endsection

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Title</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            <p>{{$post->title}}</p>
                        </div>
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Category</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            <p>{{$post->category}}</p>
                        </div>
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Body</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            {!!$post->body!!}
                        </div>
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Post Image</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            <img src="{{url('storage/'.$post->image)}}" height="350" />
                        </div>
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Review Comments</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            @if($review->review)
                                <p>{{$review->review}}</p>
                            @else
                                <div class="form-group">
                                    <textarea class="form-control" rows="6" placeholder="Leave your comments!" required name="review"></textarea>
                                </div>
                            @endif
                        </div>
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Ratings</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            @foreach ($ratings as $rating)
                                <div class="form-group">
                                    <label>{{$rating->rating_name}}</label>
                                    @if($rating->stars)
                                        <p>{{$rating->stars}} Stars
                                    @else
                                        <div class="d-flex">
                                            @foreach (array(1,2,3,4,5) as $n)
                                                <div class="custom-control custom-radio custom-control-inline mr-2">
                                                    <input type="radio" id="rating-{{$rating->id}}" name="rating[{{$rating->id}}]" class="custom-control-input" value="{{$n}}" required="">
                                                    <label class="custom-control-label text-body" for="rating-{{$rating->id}}">{{$n}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                     @if(!$review->review)
                        <button type="submit" class="btn btn-primary">Submit</button>
                     @endif
                </form>
            </div>
        </div>
    </div>
@endsection