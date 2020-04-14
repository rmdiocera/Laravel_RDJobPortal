@extends('layouts.app')

@section('content')

    <div class="row my-3">
        <div class="card col-md-12">
            {{-- Replace this with span-inlines --}}
            <h1>Applicant Information</h1>
            <h3>{{$profile->first_name." ".$profile->last_name}}</h3>
            <span>{{$profile->mobile_phone_no}}</span>
            <p>Age: {{$profile->age}}</p>
            <p>Gender: {{$profile->gender}}</p>
            <p>Address: {{$profile->address}}</p>
            <p>Country: <i class="em em-flag-{{$country_code->country_code}}" aria-role="presentation" aria-label="{{$country_code->country_name}} Flag"></i><span class="align-middle pl-2">{{$profile->country}}</span></p>
            <p>Nationality: {{$profile->nationality}}</p>
            <br>
            <h1>Work Experience</h1>
            <span>Job Title</span>
            <p>{{$profile->job_title}}</p>
            <span>Company Name</span>
            <p>{{$profile->company_name}}</p>
            <span>Employment Date</span>
            <p>{{ Carbon\Carbon::parse($profile->start_date)->format('F j, Y')}} - 
                @if (is_null($profile->end_date))
                    Present
                @else
                    {{$profile->end_date}}
                @endif
            </p>
            <span>Monthly Salary</span>
            <p>{{$profile->salary}}</p>
            <span>Tasks</span>
            <p>{{$profile->tasks}}</p>
            <br>
            <h1>Educational Background</h1>
            <span>College/University</span>
            <p>{{$profile->university}}</p>
            <span>Degree</span>
            <p>{{$profile->degree}}</p>
            <span>Course</span>
            <p>{{$profile->course}}</p>
            <span>Start Date</span>
            <p>{{ Carbon\Carbon::parse($profile->univ_start_date)->format('F j, Y')}}</p>
            <span>Date of Graduation</span>
            <p>{{ Carbon\Carbon::parse($profile->univ_end_date)->format('F j, Y')}}</p>
        </div>
    </div>

@endsection