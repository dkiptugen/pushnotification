@extends('layouts.app')

@section('content')
<div class="container">
    <table id="queued_jobs_table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>attempts</th>
                <th>queue</th>
                <th>payload</th>
                <th>reserved at</th>
                <th>available at</th>
                <th>created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($queued_jobs as $queued_job)
                <tr>
                    <td>{{ $queued_job->id }}</td>
                    <td>{{ $queued_job->attempts }}</td>
                    <td>{{ $queued_job->queue }}</td>
                    <td>{{ $queued_job->payload }}</td>
                    <td>{{ $queued_job->reserved_at }}</td>
                    <td>{{ $queued_job->available_at }}</td>
                    <td>{{ $queued_job->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
