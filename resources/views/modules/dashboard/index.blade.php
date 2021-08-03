@extends('includes.body')
@section('content')
    <div class="d-flex justify-content-end w-100">
        <div class="ml-auto">
            <input class="form-control" type="text" name="daterange" value="01/01/2018 - 01/15/2018" id="reportrange" />
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 col-md-3 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2">Subscribers</h3>
                            <p class="text-muted"></p>
                            <div class="mb-0">
                                2
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 col-xl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2">Notifications</h3>
                            <p class="text-muted"> 10</p>
                            <div class="mb-0">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
