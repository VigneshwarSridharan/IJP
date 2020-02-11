@extends('voyager::master')

@section('page_title', 'Reviews List')


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bubble"></i> Reviews List
        </h1>
    <div>
@endsection

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="panel panel-bordered">
            <div class="panel-body">
                @if($post->status == 'PENDING')
                    <div class="d-flex justify-content-end mb-3">
                        <form method="POST">
                            {{ csrf_field() }}
                            <button type="submit" name="status" value="PUBLISHED" class="btn btn-primary mr-2">Publish</button>
                            <button type="submit" name="status" value="REJECTED" class="btn btn-danger">Reject</button>
                        </form>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            @foreach ($columns as $column)
                                <th class="text-capitalize">{{str_replace('_',' ',$column)}}</th>
                            @endforeach
                            <th>Action</th>
                        <thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    @foreach ($columns as $column)
                                        <td>{{$review[$column]}}</td>
                                    @endforeach
                                    <td>
                                        <a href="{{route('voyager.reviews.edit',[11,13])}}" class="btn btn-sm btn-primary pull-right">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    <table>
                <div>
            </div>
        </div>
    <div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@stop

@section('javascript')
    <!-- DataTables -->
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#dataTable').DataTable({
                "order": [],
                "language": {
                    "sEmptyTable": "No data available in table",
                    "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                    "sInfoFiltered": "(filtered from _MAX_ total entries)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Show _MENU_ entries",
                    "sLoadingRecords": "Loading...",
                    "sProcessing": "Processing...",
                    "sSearch": "Search:",
                    "sZeroRecords": "No matching records found",
                    "oPaginate": {
                        "sFirst": "First",
                        "sLast": "Last",
                        "sNext": "Next",
                        "sPrevious": "Previous"
                    },
                    "oAria": {
                        "sSortAscending": ": activate to sort column ascending",
                        "sSortDescending": ": activate to sort column descending"
                    }
                },
                "columnDefs": [{
                    "targets": -1,
                    "searchable": false,
                    "orderable": false
                }]
            });
        });
    </script>
@stop



