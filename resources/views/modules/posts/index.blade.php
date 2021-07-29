@extends('includes.body')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Notifications</h3>
            <div class="actionbtn">
                <a href="" class="btn btn-sm btn-outline-dark"></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="notificationtable" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Date</th>
                            <th>flag</th>
                            <th>offset</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Date</th>
                            <th>flag</th>
                            <th>offset</th>
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
                "url": "{{ url('backend/notifications/get') }}",
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
                { "data": "status" }

            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection
