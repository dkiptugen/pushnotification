@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2  class="card-title">Edit Newsletter</h2>
            </div>
            <div class="card-body">
                <form action="" method="post" class="form form-horizontal create-form">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group form-row">
                        <div class="col">
                            <label for="publishdate" class="control-label">Publish date</label>
                            <input type="text" name="publishdate" id="publishdate" class="form-control">
                        </div>
                        <div class="col">
                            <label for="template" class="control-label">Template</label>
                            <input type="text" name="template" id="template" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary ml-auto">
                            Save
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
