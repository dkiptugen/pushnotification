@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1> Add Newsletter Products</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('newsletter_product_type.store') }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-dark ml-auto">Add Newsletter Product Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
