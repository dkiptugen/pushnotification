@extends('includes.body')
@section('content')
    <div class="d-flex justify-content-end w-100">
        <div class="ml-auto">
            <input class="form-control" type="text" name="daterange" value="01/01/2018 - 01/15/2018" id="reportrange" />
        </div>
    </div>
    <div class="row mt-2">
        @foreach($product as $key => $value)
        <div class="col-12 col-md-3 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <h1>{{ $key }}</h1>
                </div>
                <div class="card-body py-4">
                    <div class="row flex-column">
                        <div class="col">
                            <h3 class="mb-2">Subscribers</h3>
                            <p class="text-muted"></p>
                            <div class="mb-0">
                                <strong class="text-muted font-23">
                                    {{ number_format($value['subscriptions']) }}
                                </strong>

                            </div>
                        </div>
                        <div class="col mt-3">
                            <h3 class="mb-2">Notifications</h3>
                            <p class="text-muted"></p>
                            <div class="mb-0">
                                <strong class="text-muted font-23">
                                    {{ number_format($value['notifications']) }}
                                </strong>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
