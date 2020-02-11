@extends('voyager::master')

@section('css')
    <link rel="stylesheet" href="{{url('css/review.css')}}" />
@stop

@section('content')
    
    <div class="page-content px-3">
        @include('voyager::alerts')
        
        <div class="post-grid-wrppaer row no-gutters">
            @foreach ($posts['data'] as $key => $post)
                <div class="col-sm-3 p-2">
                    <div class="post-grid">
                        <div class="content">
                            <img src="{{url('storage/'.$post['image'])}}" alt="{{$post['title']}}" class="w-100" />
                            <span class="text-capitalize badge @if($post['status'] == 'PUBLISHED') badge-primary @elseif($post['status'] == 'PENDING') badge-warning @elseif($post['status'] == 'REJECTED') badge-danger @elseif($post['status'] == 'DRAFT') badge-secondary @endif ">
                                @if($post['status'] == 'PUBLISHED') Approved @elseif($post['status'] == 'PENDING') Under Review @elseif($post['status'] == 'REJECTED') Rejected @endif
                            </span>
                        </div>
                        <a href="/admin/reviews/edit/{{$post['post_id']}}/{{$post['id']}}" class="overlay" >
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

@endsection


@section('javascript')
    <script src="{{url('js/lib/isotope-docs.min.js')}}"></script>
    <script src="{{url('js/site/profile.js')}}"></script>
    <script src="{{url('js/site/review.js')}}"></script>
@stop