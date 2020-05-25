@extends('layouts.app')

@section('content')
@foreach ($profile as $profile_info)
    <div class="row my-3">
        <div class="card col-md-9 mb-3 pb-3 pt-2">
            {{-- Replace this with span-inlines --}}
            <h3 class="card-title">Applicant Information</h3>
            <div class="row">
                <div class="col-md-3 d-flex">
                    <img src="/storage/app_profile_pictures/{{$profile_info->profile_picture}}" class="app-profile-pic mx-auto img-thumbnail" alt="">
                </div>
                <div class="col-md-9 mt-2 d-flex flex-column">
                    <h4 class="pl-2">{{$profile_info->first_name." ".$profile_info->last_name}}</h4>
                    <div class="form-inline">
                        <span class="card-text border-right px-2">{{$profile_info->age}} years old</span>
                        <span class="card-text border-right px-2">{{$profile_info->gender}}</span>
                        <span class="card-text border-right px-2"><i class="text-ds-blue far fa-envelope mr-1"></i>{{$profile_info->email}}</span>
                        <span class="card-text border-right px-2"><i class="fas fa-mobile-alt mr-1"></i>{{$profile_info->mobile_phone_no}}</span>
                        <span class="card-text border-right px-2"><i class="text-cali fas fa-home mr-1"></i>{{$profile_info->address}}</span>
                        <span class="card-text border-right px-2"><i class="em em-flag-{{$profile_info->country_code}}" aria-role="presentation" aria-label="{{$profile_info->country_name}} Flag"></i><span class="align-middle pl-2">{{$profile_info->country_name}}</span></span>
                        <span class="card-text px-2">{{$profile_info->nationality}}</span>
                    </div>
                    <a href="/home/{{$profile_info->user_id}}/edit" class="btn btn-sm btn-primary ml-auto mt-auto"><i class="fas fa-edit mr-1"></i>Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="card col-md-9 mb-3 pb-3 pt-2">
            <h3 class="card-title">Most Recent Work Experience</h3>
            <div class="row">
                <div class="col-md-3">
                    <span>{{ Carbon\Carbon::parse($profile_info->start_date)->format('F j, Y')}} - 
                        @if (is_null($profile_info->end_date))
                            Present
                        @else
                            {{Carbon\Carbon::parse($profile_info->end_date)->format('F j, Y')}}
                        @endif
                    </span>
                </div>
                <div class="col-md-9 d-flex flex-column">
                    <h5 class="font-weight-bold mb-0">{{$profile_info->job_title}}</h5>
                    <span class="font-weight-bold">{{$profile_info->company_name}}</span>
                    <span class="text-ds-blue">{{$profile_info->currency.' '.$profile_info->salary}}</span>
                    <span>Tasks</span>
                    <span>{!! $profile_info->tasks !!}</span>
                </div>
            </div>
        </div>
        <div class="card col-md-9 mb-3 pb-3 pt-2">
            <h3 class="card-title">Last College/University Attended</h3>
            <div class="row">
                <div class="col-md-4">
                    <span>
                        {{ Carbon\Carbon::parse($profile_info->univ_start_date)->format('F j, Y')}} - {{ Carbon\Carbon::parse($profile_info->univ_end_date)->format('F j, Y')}}
                    </span>
                </div>
                <div class="col-md-8 d-flex flex-column">
                    <h5 class="font-weight-bold mb-0">{{$profile_info->course}} ({{$profile_info->degree}})</h5>
                    <span class="font-weight-bold">{{$profile_info->university}}</span>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection