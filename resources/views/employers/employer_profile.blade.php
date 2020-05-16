@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="card col-md-12">
            <h1>Company Information</h1>
                @foreach ($profile as $profile_info)
                <div class="row">
                    <div class="col-md-4">
                        <img src="/storage/emp_profile_pictures/{{$profile_info->profile_picture}}" style="width: 100%;" alt="">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{$profile_info->company_name}}</h5>
                            <h6 class="card-subtitle">{{$profile_info->industry}}</h6>
                            <p class="card-text">{{$profile_info->address}}</p>
                            @if ($profile_info->website_link)
                                <a href="{{$profile_info->website_link}}" class="card-link" target="_blank">{{$profile_info->website_link}}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <h1>Other Information</h1>
                <span>Company Size</span>
                <p>{{$profile_info->company_size}}</p>
                <span>Benefits</span>
                <p>{{$profile_info->benefits}}</p>
                <span>Dress Code</span>
                <p>{{$profile_info->dress_code}}</p>
                <span>Spoken Language</span>
                <p>{{$profile_info->spoken_language}}</p>
                <span>Work Hours</span>
                <p>{{$profile_info->work_hours}}</p>
                <span>Average Processing Time</span>
                <p>{{$profile_info->avg_processing_time}}</p>
                <div>
                    <a href="/employer/{{$profile_info->comp_id}}/edit" class="btn btn-sm btn-primary float-right mb-2"><i class="fas fa-edit mr-1"></i>Edit Profile</a>
                </div>
            @endforeach
        </div>
    </div>

@endsection