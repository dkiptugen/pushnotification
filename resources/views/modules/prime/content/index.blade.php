@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Content</h1>
            <div class="active-btn">
                <a href="{{ route('prime-content.create') }}" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-plus"></i>
                    Content
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-condensed" id="content-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Sms</th>
                        <th>Moderator</th>
                        <th>Author</th>
                        <th>Send Time</th>
                        <th>Deliveries</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Sms</th>
                        <th>Moderator</th>
                        <th>Author</th>
                        <th>Send Time</th>
                        <th>Deliveries</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('header')

@endsection
@section('footer')
    <script type="application/javascript">
        $('#content-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('prime-content.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "title" },
                { "data": "message" },
                { "data": "moderator" },
                { "data": "author" },
                { "data": "status" },
                { "data": "sendtime" },
                { "data": "deliveries" },
                { "data": "action" }
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection
