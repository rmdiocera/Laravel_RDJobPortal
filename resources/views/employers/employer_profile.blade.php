@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="card col-md-12">
            <h1>Company Information</h1>
            @foreach ($profile as $profile_info)
                <h3>{{$profile_info->company_name}}</h3>
                <p>{{$profile_info->industry}}</p>
                <p>{{$profile_info->address}}</p>
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
                    <a href="/employer/{{$profile_info->comp_id}}/edit" class="btn btn-sm btn-primary float-right mb-2">Edit Profile</a>
                </div>
            @endforeach
        </div>
    </div>

@endsection