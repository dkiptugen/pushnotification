@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="d-flex"><div class="text-danger  text-uppercase"> {{ $product->domain }} &nbsp; </div>  Edit Notification</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('product.notification.edit',[$product->id,$story->id]) }}" class="create-form form form-horizontal" method="POST">
                @csrf
                @method('put')
                <div class="form-group form-row">
                    <label for="FormControlStoryTitle">Story Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $story->title }}" id="FormControlStoryTitle" placeholder="Story Title">
                </div>
                <div class="form-group">
                    <label for="FormControlStoryLink">Story Link</label>
                    <input type="text" name="link" class="form-control" value="{{ $story->link }}" id="FormControlStoryLink" placeholder="Story Link">
                </div>
                <div class="form-group">
                    <label for="FormControlStoryThumbnail">Story Thumbnail</label>
                    <input type="text" name="thumbnail" class="form-control" value="{{ $story->thumbnail }}" id="FormControlStoryThumbnail" placeholder="Story Thumbnail">
                </div>

                <div class="form-group">
                    <label for="FormControlStorySummary">Story Summary</label>
                    <textarea class="form-control" name="summary" id="FormControlStorySummary" >{{ $story->summary }}</textarea>
                </div>
                <div class="form-group form-row">
                    <div class="col-12 col-md">
                        <label for="ttl" class="control-label">TTL</label>
                        <input type="number" name="ttl" id="ttl" class="form-control" value="{{ $story->ttl/(3600*24) }}" min="1">
                        <small class="text">Period of which the notification will stay active in days. Default is <strong>15 days</strong>.</small>
                    </div>
                    <div class="col-12 col-md">
                        <label for="publishdate" class="control-label">Publishdate</label>
                        <input type="text" name="publishdate" id="publishdate" class="form-control datetime" value="{{ $story->publishdate }}">
                    </div>
                </div>
                <div class="form-group form-row">
                    <button class="btn btn-dark ml-auto">
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
