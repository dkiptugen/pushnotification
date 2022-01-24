@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h2 class="card-header">Templates</h2>
                <a class="btn btn-outline-dark btn-sm " href="">
                    <i class="align-middle" data-feather="plus"></i> Add Template
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
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

@endsection
