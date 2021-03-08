@extends('layouts.app')

@section('content')
<div class="container">
    <table id="failed_jobs_table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>connection</th>
                <th>queue</th>
                <th>payload</th>
                <th>exception</th>
                <th>failed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($failed_jobs as $failed_job)
                <tr>
                    <td>{{ $failed_job->id }}</td>
                    <td>{{ $failed_job->connection }}</td>
                    <td>{{ $failed_job->queue }}</td>
                    <td>{{ $failed_job->payload }}</td>
                    <td>{{ $failed_job->exception }}</td>
                    <td>{{ $failed_job->failed_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection