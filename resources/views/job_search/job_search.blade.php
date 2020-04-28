@extends('layouts.app')

@section('content')
    <h1>Job Posts</h1>
    @if (count($job_posts) > 0)
        @foreach ($job_posts as $job_post)
            <div class="card col-md-12 mb-2 pt-2" data-card-id="{{$job_post->id}}">
                <h3><a href="/job-post/{{$job_post->id}}">{{$job_post->title}}</a></h3>
                <p>{!! $job_post->desc !!}</p>
                <p>Industry: {{$job_post->industry}}</p>
                <p>Employment Type: {{$job_post->emp_type}}</p>
                <p>Job Level: {{$job_post->job_level}}</p>
                <p>{{$job_post->created_at}}</p>
                <div class="form-inline d-flex mb-2">
                    @if (Auth::guard('employer')->check() && Auth::user()->id === $job_post->comp_id)
                        <a href="/job-post/{{$job_post->id}}/view"><button class="btn btn-sm btn-primary" type="button">View Applicants</button></a>
                        <a href="/job-post/{{$job_post->id}}/edit"><button class="btn btn-sm btn-primary ml-2" type="button">Edit Job Post</button></a>
                        {{-- {!! Form::open(['action' => ['JobPostsController@destroy', $job_post->id], 'method' => 'DELETE']) !!}
                            {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-id="{{$job_post->id}}" class="btn btn-sm btn-danger ml-2 delete-jp" type="button">Delete</button>
                    @else
                        {{-- {!! Form::open(['action' => ['HomeController@saveJobPost'], 'method' => 'POST']) !!}
                            {{Form::hidden('job_post_id', $job_post->id)}}
                            {{Form::hidden('comp_id', $job_post->comp_id)}}
                            {{Form::submit('Save Job Post', ['class' => 'btn btn-sm btn-primary save-jp'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-id="{{$job_post->id}}" data-comp-id="{{$job_post->comp_id}}" class="btn btn-sm btn-primary save-jp" type="button">Save Job Post</button>
                        {{-- {!! Form::open(['action' => ['HomeController@storeApplicantJobPostApplication'], 'method' => 'POST']) !!}
                            {{Form::hidden('job_post_id', $job_post->id)}}
                            {{Form::hidden('comp_id', $job_post->comp_id)}}
                            {{Form::submit('Apply to Job Post', ['class' => 'btn btn-sm btn-primary ml-2'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-id="{{$job_post->id}}" data-comp-id="{{$job_post->comp_id}}" class="btn btn-sm btn-primary ml-2 apply-to-jp" type="button">Apply to Job Post</button>
                        {{-- <a href="/job-post/{{$job_post->id}}/{{$job_post->comp_id}}/save"><button class="btn btn-sm btn-primary" type="button">Save Job Post</button></a> --}}
                        {{-- <a href="/job-post/{{$job_post->id}}/{{$job_post->comp_id}}/apply"><button class="btn btn-sm btn-primary ml-2" type="button">Apply to Job Post</button></a> --}}
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection