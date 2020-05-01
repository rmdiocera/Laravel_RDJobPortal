@extends('layouts.app')

@section('content')
    <h1>Job Posts</h1>
    {!! Form::open(['action' => 'PagesController@showJobPosts', 'method' => 'GET']) !!}
        <div class="input-group mb-2">
            {{Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search jobs', 'required'])}}
            <div class="input-group-append">
                {{Form::submit('Search', ['class' => 'btn btn-primary'])}}
            </div>
        </div>
    {!! Form::close() !!}
    @isset($results)
        @if (count($results) > 0)
        <span class="mb-2">You searched for: {{$search}}</span>
        @foreach ($results as $result)
            <div class="card col-md-12 mb-2 pt-2" data-card-id="{{$result->id}}">
                <h3><a href="/job-post/{{$result->id}}">{{$result->title}}</a></h3>
                <p>{!! $result->desc !!}</p>
                <p>Industry: {{$result->industry}}</p>
                <p>Employment Type: {{$result->emp_type}}</p>
                <p>Job Level: {{$result->job_level}}</p>
                <p>{{$result->created_at}}</p>
                <div class="form-inline d-flex mb-2">
                    @if (Auth::guard('employer')->check() && Auth::user()->id === $result->comp_id)
                        <a href="/job-post/{{$result->id}}/view"><button class="btn btn-sm btn-primary" type="button">View Applicants</button></a>
                        <a href="/job-post/{{$result->id}}/edit"><button class="btn btn-sm btn-primary ml-2" type="button">Edit Job Post</button></a>
                        {{-- {!! Form::open(['action' => ['JobPostsController@destroy', $result->id], 'method' => 'DELETE']) !!}
                            {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-id="{{$result->id}}" class="btn btn-sm btn-danger ml-2 delete-jp" type="button">Delete</button>
                    @else
                        {{-- {!! Form::open(['action' => ['HomeController@saveJobPost'], 'method' => 'POST']) !!}
                            {{Form::hidden('job_post_id', $result->id)}}
                            {{Form::hidden('comp_id', $result->comp_id)}}
                            {{Form::submit('Save Job Post', ['class' => 'btn btn-sm btn-primary save-jp'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-id="{{$result->id}}" data-comp-id="{{$result->comp_id}}" class="btn btn-sm btn-primary save-jp" type="button">Save Job Post</button>
                        {{-- {!! Form::open(['action' => ['HomeController@storeApplicantJobPostApplication'], 'method' => 'POST']) !!}
                            {{Form::hidden('job_post_id', $result->id)}}
                            {{Form::hidden('comp_id', $result->comp_id)}}
                            {{Form::submit('Apply to Job Post', ['class' => 'btn btn-sm btn-primary ml-2'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-id="{{$result->id}}" data-comp-id="{{$result->comp_id}}" class="btn btn-sm btn-primary ml-2 apply-to-jp" type="button">Apply to Job Post</button>
                        {{-- <a href="/job-post/{{$result->id}}/{{$result->comp_id}}/save"><button class="btn btn-sm btn-primary" type="button">Save Job Post</button></a> --}}
                        {{-- <a href="/job-post/{{$result->id}}/{{$result->comp_id}}/apply"><button class="btn btn-sm btn-primary ml-2" type="button">Apply to Job Post</button></a> --}}
                    @endif
                </div>
            </div>
        @endforeach
        @endif
    @endisset
    
    @isset($job_posts)
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
    @endisset
@endsection