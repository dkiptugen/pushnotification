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
            </div>
        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')
    <script type="application/javascript">
        $('#notificationtable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
        "url": "{{ route('prime-subscription.datatable',$product->id) }}",
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"}
        },
        "columns": [
        { "data": "pos" },
        { "data": "title" },
        { "data": "date" },
        { "data": "deliveries" },
        { "data": "author" },
        { "data": "status" },
        { "data": "product" }

        ],
        "order": [[ 0, "desc" ]]
        });

    </script>
@endsection

