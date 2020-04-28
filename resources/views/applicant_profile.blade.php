@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="card col-md-12">
            {{-- Replace this with span-inlines --}}
            <h1>Applicant Information</h1>
            @foreach ($profile as $profile_info)
            <div class="row">
                <div class="col-md-4">
                    <img src="/storage/app_profile_pictures/{{$profile_info->profile_picture}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8">
                    <h3>{{$profile_info->first_name." ".$profile_info->last_name}}</h3>
                    <span>{{$profile_info->mobile_phone_no}}</span>
                    <p>Age: {{$profile_info->age}}</p>
                    <p>Gender: {{$profile_info->gender}}</p>
                    <p>Address: {{$profile_info->address}}</p>
                    <p>Country: <i class="em em-flag-{{$profile_info->country_code}}" aria-role="presentation" aria-label="{{$profile_info->country_name}} Flag"></i><span class="align-middle pl-2">{{$profile_info->country_name}}</span></p>
                    <p>Nationality: {{$profile_info->nationality}}</p>
                </div>
            </div>
                <br>
                <h1>Work Experience</h1>
                <span>Job Title</span>
                <p>{{$profile_info->job_title}}</p>
                <span>Company Name</span>
                <p>{{$profile_info->company_name}}</p>
                <span>Employment Date</span>
                <p>{{ Carbon\Carbon::parse($profile_info->start_date)->format('F j, Y')}} - 
                    @if (is_null($profile_info->end_date))
                        Present
                    @else
                        {{Carbon\Carbon::parse($profile_info->end_date)->format('F j, Y')}}
                    @endif
                </p>
                <span>Monthly Salary</span>
                <p>{{$profile_info->currency.' '.$profile_info->salary}}</p>
                <span>Tasks</span>
                <p>{!! $profile_info->tasks !!}</p>
                <br>
                <h1>Educational Background</h1>
                <span>College/University</span>
                <p>{{$profile_info->university}}</p>
                <span>Degree</span>
                <p>{{$profile_info->degree}}</p>
                <span>Course</span>
                <p>{{$profile_info->course}}</p>
                <span>Start Date</span>
                <p>{{ Carbon\Carbon::parse($profile_info->univ_start_date)->format('F j, Y')}}</p>
                <span>Date of Graduation</span>
                <p>{{ Carbon\Carbon::parse($profile_info->univ_end_date)->format('F j, Y')}}</p>
                <div>
                    <a href="/home/{{$profile_info->user_id}}/edit" class="btn btn-sm btn-primary float-right mb-2">Edit Profile</a>
                </div>
            @endforeach
        </div>
    </div>

@endsection