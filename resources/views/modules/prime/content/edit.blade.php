@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Edit Content</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('content.update',$content->id) }}" method="post" class="form form-horizontal">
                    @csrf
                    @method('put')
                    <div class="form-group form-row">
                        <div class="col col-md-8">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $content->title }}">
                        </div>
                        <div class="col col-md">
                            <label for="publishdate" class="control-label">Publish Date</label>
                            <input type="text" name="datesingle" id="publishdate" class="form-control" value="{{ $content->publishdate }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label">Content</label>
                        <textarea name="content" id="content" class="form-control editor">value="{{ $content->content }}"</textarea>
                    </div>
                    <div class="form-group">
                        <label for="sms" class="control-label">Sms</label>
                        <textarea name="sms" id="sms" rows="6" class="form-control">value="{{ $content->sms }}"</textarea>
                    </div>
                    <div class="form-group">
                        <label for="similar" class="control-label">Similar Kenyans Link</label>
                        <input type="url" name="similar" id="similar" class="form-control" value="{{ $content->similar }}">
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn ml-auto btn-primary">
                            Update Content
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
