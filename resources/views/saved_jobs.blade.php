@extends('layouts.app')

@section('content')
    <h1>Saved Job Posts</h1>
    @if (count($job_posts) > 0)
        <div class="row d-flex justify-content-around">
            @foreach ($job_posts as $job_post)
            <div class="card col-md-5 py-2">
                <h3>{{$job_post->title}}</h3>
                <h5>{{$job_post->company_name}}</h5>
                <p>Saved on {{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</p>
                <a href="/job-post/{{$job_post->id}}/unsave"><button class="btn btn-sm btn-primary" type="button" >Unsave Job Post</button></a>
            </div>
            @endforeach
        </div>
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection