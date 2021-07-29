@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Add Notification</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('api/dynamic/push') }}" class="create-form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="FormControlStoryTitle"><strong>Story Title</strong></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="FormControlStoryTitle" placeholder="Story Title">
                </div>
                <div class="form-group">
                    <label for="FormControlStoryLink"><strong>Story Link</strong></label>
                    <input type="text" name="link" class="form-control" value="{{ old('link') }}" id="FormControlStoryLink" placeholder="Story Link">
                </div>
                <div class="form-group">
                    <label for="FormControlStoryThumbnail"><strong>Story Thumbnail</strong></label>
                    <input type="text" name="thumbnail" class="form-control" value="{{ old('thumbnail') }}" id="FormControlStoryThumbnail" placeholder="Story Thumbnail">
                </div>
                <div class="form-group">
                    <label for="FormControlStorySummary"><strong>Story Summary</strong></label>
                    <textarea class="form-control" name="summary" id="FormControlStorySummary" rows="4">{{ old('summary') }}</textarea>
                </div>
                <div class="form-group form-row">
                    <button class="btn btn-primary ml-auto">
                        Post Notification
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
