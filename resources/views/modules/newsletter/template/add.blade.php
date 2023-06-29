@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="" class="control-label">Name</label>
                        <input type="text" name="" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">No Of Posts</label>
                        <input type="text" name="" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Mail Template</label>
                        <input type="file" name="" id="" class="form-control">
                        <small>Should be a blade template with variables [email,name, image, title, link]</small>
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-primary ml-auto">
                            Save Template
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')

@endsection
