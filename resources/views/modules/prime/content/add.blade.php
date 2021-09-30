@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Add Content</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('prime-content.store') }}" method="post" class="form form-horizontal">
                    @csrf
                    <div class="form-group form-row">
                        <div class="col col-md-8">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="col col-md">
                            <label for="publishdate" class="control-label">Publish Date</label>
                            <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                <input type="text" name="datesingle" id="publishdate" class="form-control">
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md">
                            <label for="publishdate" class="control-label">Time</label>
                            <div class="input-group date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="time">
                                <div class="input-group-append" data-target="#time" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label">Content</label>
                        <textarea name="content" id="content" class="form-control editor"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sms" class="control-label">Sms</label>
                        <textarea name="sms" id="sms" rows="6" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="similar" class="control-label">Similar Kenyans Link</label>
                        <input type="url" name="similar" id="similar" class="form-control">
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn ml-auto btn-primary">
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
