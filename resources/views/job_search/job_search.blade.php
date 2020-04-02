@extends('layouts.app')

@section('content')
    <h1>Job Posts</h1>
    @if (count($job_posts) > 0)
        @foreach ($job_posts as $job_post)
            <div class="card col-md-12 mb-2 pt-2">
                <h3><a href="/job-post/{{$job_post->id}}">{{$job_post->title}}</a></h3>
                <p>{{$job_post->desc}}</p>
                <p>Industry: {{$job_post->industry}}</p>
                <p>Employment Type: {{$job_post->emp_type}}</p>
                <p>Job Level: {{$job_post->job_level}}</p>
                <p>{{$job_post->created_at}}</p>
                <a href="/job-post/{{$job_post->id}}/edit" class="btn btn-primary">Edit Job Post</a>
                {!! Form::open(['action' => ['JobPostsController@destroy', $job_post->id], 'method' => 'DELETE']) !!}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!! Form::close() !!}
            </div>
        @endforeach    
    @endif
@endsection