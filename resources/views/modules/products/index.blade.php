@extends('includes.body');
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Products</h3>
                <div class="actionbtn">
                    <a href="" class="btn btn-outline-dark"><i class="fas fa-plus"></i> Add Product</a>
                    <a href="" class="btn btn-outline-dark"><i class="fas fa-file-export"></i> Export</a>
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
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
