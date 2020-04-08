@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="card col-md-12">
            <h1>Company Information</h1>
            <h3>{{$profile->company_name}}</h3>
            <p>{{$profile->industry}}</p>
            <p>{{$profile->address}}</p>
            <br>
            <h1>Other Information</h1>
            <span>Company Size</span>
            <p>{{$profile->company_size}}</p>
            <span>Benefits</span>
            <p>{{$profile->benefits}}</p>
            <span>Dress Code</span>
            <p>{{$profile->dress_code}}</p>
            <span>Spoken Language</span>
            <p>{{$profile->spoken_language}}</p>
            <span>Work Hours</span>
            <p>{{$profile->work_hours}}</p>
            <span>Average Processing Time</span>
            <p>{{$profile->avg_processing_time}}</p>
        </div>
    </div>

@endsection