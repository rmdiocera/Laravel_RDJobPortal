@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        @foreach ($job_post as $job_post)
            <div class="card col-md-12 mb-2 pt-2">
                <h3>{{$job_post->title}}</h3>
                <p>{!! $job_post->desc !!}</p>
                <div class="form-inline">
                    <p>Industry: <span class="badge badge-primary align-middle">{{$job_post->industry}}</span></p>
                    <p class="ml-2">Employment Type: <span class="badge badge-primary align-middle">{{$job_post->emp_type}}</span></p>
                    <p class="ml-2">Job Level: <span class="badge badge-primary align-middle">{{$job_post->job_level}}</span></p>
                </div>
                <span>Posted on {{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</span>
                <div>
                    @if (Auth::guard('employer')->check() && Auth::user()->id === $job_post->comp_id)
                        <a href="/job-posts" class="btn btn-sm btn-primary float-right mb-2">Go Back</a>
                    @else
                        <a href="/job-search" class="btn btn-sm btn-primary float-right mb-2">Go Back</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection