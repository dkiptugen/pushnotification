@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Add Product</h1>
        </div>
        <div class="card-body">
            <form action="{{ url('backend/products') }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="domain" class="control-label">Domain</label>
                    <input type="text" name="domains" id="domain" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label w-100" for="icon">Icon</label>
                    <input type="file" id="icon" name="image">
                    <small class="form-text text-muted">Required size is 512PX x 512PX</small>
                </div>

                <div class="form-group form-row">
                    <button type="submit" class="btn btn-dark ml-auto">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
