@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        <div class="card col-md-12 mb-2 pt-2">
            <h3>{{$job_post->title}}</h3>
            <p>{{$job_post->desc}}</p>
            <p>Industry: {{$job_post->industry}}</p>
            <p>Employment Type: {{$job_post->emp_type}}</p>
            <p>Job Level: {{$job_post->job_level}}</p>
            <p>{{$job_post->created_at}}</p>
            <div>
                <a href="/job-search" class="btn btn-sm btn-primary float-right mb-2">Go Back</a>
            </div>
        </div>
    </div>
@endsection