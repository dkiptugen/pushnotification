@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-center"><strong>{{ __('Stories') }}</strong></div>
                <div class="card-body">
                    <!-- Check for errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Check for success -->
                    @if(session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <!-- Change this -->
                    <form action="http://localhost/notifications/api/dynamic/push" method="POST">
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
                        <div class="form-group">
                            <button class="btn btn-primary form-control d-flex justify-content-center">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
