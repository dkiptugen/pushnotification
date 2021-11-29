@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1> Edit Newsletter Products</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('newsletter_product.update',$product->id) }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label for="feedlink" class="control-label">Feedlink</label>
                        <input type="text" name="feedlink" id="feedlink" class="form-control" value="{{ $product->feedlink }}">
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-dark ml-auto">Edit Newsletter Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
