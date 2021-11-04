@extends('includes.body')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="d-flex"><div class="text-danger text-uppercase"> {{ $product->domain }} &nbsp; </div> Notifications</h3>
            <div class="actionbtn">
                <a href="{{ route('product.notification.create',$product->id) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus mr-1"></i>Add Notification</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="notificationtable" class="table table-striped table-condensed" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Date</th>
                            <th>Deliveries</th>
                            <th>Clicks</th>
                            <th>Publishdate</th>
                            <th>On Schedule</th>
                            <th>Author</th>
                            <th>status</th>
                            <th>Product</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Date</th>
                            <th>Deliveries</th>
                            <th>Clicks</th>
                            <th>Publishdate</th>
                            <th>On Schedule</th>
                            <th>Author</th>
                            <th>status</th>
                            <th>Product</th>
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
        $('#notificationtable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('product.notification.datatable',$product->id) }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "title" },
                { "data": "date" },
                { "data": "deliveries" },
                { "data": "clicks" },
                { "data": "publishdate" },
                { "data": "onschedule" },
                { "data": "author" },
                { "data": "status" },
                { "data": "product" },
                { "data": "action" }
            ],
            "order": [[ 5, "desc" ]]
        });
    </script>
@endsection
