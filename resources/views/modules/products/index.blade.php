@extends('includes.body')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Products</h2>
                <div class="actionbtn">
                    <a href="{{ url('backend/products/create') }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus"></i> Add Product</a>
                    <a href="{{ url('backend/products/export') }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-file-export"></i> Export</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-hover" id="products-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Domain</th>
                                <th>Author</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Domain</th>
                                <th>Author</th>
                                <th>Date Created</th>
                                <th>Status</th>
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
        $('#products-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('backend/products/get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "name" },
                { "data": "domain" },
                { "data": "author" },
                { "data": "datecreated" },
                { "data": "status" },
                { "data": "action" }

            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection
