@extends('layouts.app')

@section('content')
<div class="container">
    @if ($stories)
    <table id="display_stories" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>title</th>
                <th>Date</th>
                <th>flag</th>
                <th>offset</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stories as $story)
                <tr>
                    <td>{{ $story->id }}</td>
                    <td>{{ $story->title }}</td>
                    <td>{{ $story->created_at }}</td>
                    <td>{{ $story->flag }}</td>
                    <td>{{ $story->offset }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif  
</div>
@endsection
