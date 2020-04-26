@extends('layouts.app')

@section('content')
    <h1>Saved Job Posts</h1>
    @if (count($job_posts) > 0)
        <div class="row">
            @foreach ($job_posts as $job_post)
            <div class="col-md-6 py-2 saved-job" data-card-id="{{$job_post->id}}">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{$job_post->title}}</h3>
                        <h5 class="card-title">{{$job_post->company_name}}</h5>
                        <p class="card-text">Saved on {{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</p>
                        <button data-saved-jp-id="{{$job_post->id}}" class="btn btn-sm btn-danger unsave-jp" type="button" >Unsave Job Post</button>
                        {{-- {!! Form::open(['action' => ['HomeController@unsaveJobPost', $job_post->id], 'method' => 'DELETE']) !!}
                            {{Form::submit('Unsave Job Post', ['class' => 'btn btn-sm btn-danger'])}}
                        {!! Form::close() !!} --}}
                        {{-- <a href="/job-post/{{$job_post->id}}/unsave"><button class="btn btn-sm btn-primary" type="button" >Unsave Job Post</button></a> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection