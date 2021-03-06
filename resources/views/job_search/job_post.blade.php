@extends('layouts.app')

@section('content')
    <div class="row mt-3">
        @foreach ($job_post as $job_post)
            <div class="card col-md-12 mb-2 pt-2">
                <div class="card-body">
                    <img src="/storage/emp_profile_pictures/{{$job_post->profile_picture}}" class="app-profile-pic mx-auto mb-1 img-thumbnail" alt="">
                    <h3 class="card-title mb-1">{{$job_post->title}}</h3>
                    <h5 class="card-title mb-0">{{$job_post->company_name}}</h5>
                    <hr class="modal-divider mb-2">
                    <p>{!! $job_post->desc !!}</p>
                    <div class="form-inline">
                        <p>Industry: <span class="badge badge-primary align-middle">{{$job_post->industry}}</span></p>
                        <p class="ml-2">Employment Type: <span class="badge badge-primary align-middle">{{$job_post->emp_type}}</span></p>
                        <p class="ml-2">Job Level: <span class="badge badge-primary align-middle">{{$job_post->job_level}}</span></p>
                    </div>
                    <span>Posted on {{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</span>
                    <div>
                        @if (Auth::guard('employer')->check() && Auth::guard('employer')->user()->id === $job_post->comp_id)
                            <a href="/job-posts" class="btn btn-sm btn-primary float-right mb-2"><i class="fas fa-arrow-alt-circle-left mr-1"></i>Go Back</a>
                        @else
                            <a href="/job-search" class="btn btn-sm btn-primary float-right mb-2"><i class="fas fa-arrow-alt-circle-left mr-1"></i>Go Back</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection