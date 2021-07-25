@extends('layouts.app')

@section('content')
<div class="container">
    <table id="subscriber_table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>End Point</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ mb_strimwidth($subscriber->endpoint, 0, 50, "...") }}</td>
                    <td>{{ $subscriber->created_at }}</td>
                    <td>{{ $subscriber->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
