@extends('layouts.app')

@section('content')
<div class="container">
    <table id="failed_jobs_table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>title</th>
                <th>flag</th>
                <th>offset</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stories as $story)
                <tr>
                    <td>{{ $story->id }}</td>
                    <td>{{ $story->title }}</td>
                    <td>{{ $story->flag }}</td>
                    <td>{{ $story->offset }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
