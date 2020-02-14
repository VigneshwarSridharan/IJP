@extends('voyager::master')

@section('page_title', "Assign to Reviewer")

@section('css')

@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-pen"></i>
        Assign to Reviewer
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form method="POST" action="/admin/posts/{{$post->id}}/assign">
            {{ csrf_field() }}
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                    <label>Select Reviewer</label>
                        <select class="form-control select2-ajax select2-hidden-accessible" name="approved_by[]" data-get-items-route="{{url('/admin/comments/relation')}}" data-get-items-field="comment_belongsto_user_relationship" data-method="edit" data-select2-id="1" tabindex="-1" aria-hidden="true" multiple>
                            @foreach ($reviews  as $review)
                                <option value="{{$review->reviewed_by}}" selected="selected">{{$review->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="icon wb-plus-circle"></i> Assign
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection