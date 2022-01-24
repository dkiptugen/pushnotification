@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title">Templates</h2>
                <a class="btn btn-outline-dark btn-sm " href="">
                    <i class="align-middle" data-feather="plus"></i> Add Template
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="template-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Product</th>
                                <th>Number Of Posts</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Product</th>
                                <th>Number Of Posts</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('header')

@endsection
@section('footer')
    <script type="application/javascript">
        $('#template-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('newsletter-template.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "title" },
                { "data": "product" },
                { "data": "noofposts" },
                { "data": "status" },
                { "data": "createddate" },
                { "data": "action" }
            ],
            "order": [[ 5, "desc" ]]
        });
    </script>
@endsection
