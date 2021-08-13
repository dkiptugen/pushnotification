@extends('frontend.includes.body')
@section('content')
    <div class="row h-100 mt-5">
        <div class="col-12">
            <div class="subscribe my-auto w-100">
                <h1 class="text text-center">ALL
                    <br>
                    DAY NEWS
                    <br>
                    FOR ONLY 10/=
                    <br>
                    KSHS</h1>
                <hr>
                <form action="{{ url('prime/subscribe') }}" class="form form-horizontal mx-3 mt-4" method="post">
                    <div class="form-group">
                        <label for="" class="control-label">
                            Enter No. e.g. 0722000000
                        </label>
                        <input type="text" class="form-control" name="phone_number">
                    </div>
                    <button type="submit" class="btn btn-block btn-danger">
                        Subscribe Now
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')

@endsection
