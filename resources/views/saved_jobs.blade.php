@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Saved Job Posts</h1>
            @if (count($job_posts) > 0)
                <div class="row">
                    @foreach ($job_posts as $job_post)
                    <div class="col-md-6 py-2 saved-job" data-card-id="{{$job_post->id}}">
                        <div class="card">
                            <div class="card-body d-flex">
                                <img src="/storage/emp_profile_pictures/{{$job_post->profile_picture}}" class="emp-profile-pic-sm d-block mr-4" alt="">
                                <div>
                                <h5 class="card-title mb-1"><a href="/job-post/{{$job_post->job_post_id}}">{!! Str::words($job_post->title, 4, '...') !!}</a></h5>
                                <h6 class="card-title">{{$job_post->company_name}}</h6>
                                <p class="card-text">Saved on {{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</p>
                                <div class="mt-5">
                                    <button data-saved-jp-id="{{$job_post->id}}" class="btn btn-sm btn-danger unsave-jp" type="button"><i class="fas fa-minus-circle mr-1"></i>Unsave Job Post</button>
                                </div>
                                {{-- {!! Form::open(['action' => ['HomeController@unsaveJobPost', $job_post->id], 'method' => 'DELETE']) !!}
                                    {{Form::submit('Unsave Job Post', ['class' => 'btn btn-sm btn-danger'])}}
                                {!! Form::close() !!} --}}
                                {{-- <a href="/job-post/{{$job_post->id}}/unsave"><button class="btn btn-sm btn-primary" type="button">Unsave Job Post</button></a> --}}
                                </div>
                            </div>
                            {{-- <button data-saved-jp-id="{{$job_post->id}}" class="btn btn-sm btn-danger mr-2 mb-2 ml-auto unsave-jp" type="button"><i class="fas fa-minus-circle mr-1"></i>Unsave Job Post</button> --}}
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p>There doesn't seem to be anything here.</p>
            @endif
        </div>
    </div>
@endsection