@extends('layouts.app')

@section('content')
@foreach ($profile as $profile_info)
    <div class="row my-3">
        <div class="col-md-8">
            <div class="row">
                <div class="card col-md-12 mb-3 pb-3 pt-2">
                    <h3 class="card-title">Company Information</h3>
                    <div class="row">
                        <div class="col-md-3 d-flex">
                            <img src="/storage/emp_profile_pictures/{{$profile_info->profile_picture}}" class="emp-profile-pic mx-2 img-thumbnail" alt="">
                        </div>
                        <div class="col-md-9 mt-2 d-flex flex-column">
                            <h4 class="card-title">{{$profile_info->company_name}}</h4>
                            <h5 class="card-subtitle">{{$profile_info->industry}}</h5>
                            <span class="card-text">{{$profile_info->address}}</span>
                            @if ($profile_info->website_link)
                            <span><a href="{{$profile_info->website_link}}" target="_blank">{{$profile_info->website_link}}</a></span>
                            @endif
                            <a href="/employer/{{$profile_info->comp_id}}/edit" class="btn btn-sm btn-primary ml-auto mt-auto"><i class="fas fa-edit mr-1"></i>Edit Profile</a>
                        </div>
                    </div>
                </div>
                <div class="card col-md-12 mb-3 pb-3 pt-2">
                    <h3 class="card-title">Company Overview</h3>
                    <div class="row">
                        <div class="col">
                            <div>{!!$profile_info->company_overview!!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="card col mx-3 py-2">
                    <div class="row d-flex flex-column">
                        <div class="col">
                            <div class="m-1 border rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-3 d-flex align-items-center">
                                            <span class="fa-stack fa-2x fa-fw ml-2">
                                                <i class="fas fa-circle text-cali fa-stack-2x"></i>
                                                <i class="fas fa-users fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <div class="text ml-2">
                                                <span class="other-info-heading">Company Size</span>
                                                <span class="other-info-text d-block">{{$profile_info->company_size}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-1 border rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-3 d-flex align-items-center">
                                            <span class="fa-stack fa-2x fa-fw ml-2">
                                                <i class="fas fa-circle text-ds-blue fa-stack-2x"></i>
                                                <i class="fas fa-gift fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <div class="text ml-2">
                                                <span class="other-info-heading">Benefits</span>
                                                <span class="other-info-text d-block">{{$profile_info->benefits}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-1 border rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-3 d-flex align-items-center">
                                            <span class="fa-stack fa-2x fa-fw ml-2">
                                                <i class="fas fa-circle text-madang fa-stack-2x"></i>
                                                <i class="fas fa-tshirt fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <div class="text ml-2">
                                                <span class="other-info-heading">Dress Code</span>
                                                <span class="other-info-text d-block">{{$profile_info->dress_code}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-1 border rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-3 d-flex align-items-center">
                                            <span class="fa-stack fa-2x fa-fw ml-2">
                                                <i class="fas fa-circle text-kkova fa-stack-2x"></i>
                                                <i class="fas fa-language fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <div class="text ml-2">
                                                <span class="other-info-heading">Spoken Language</span>
                                                <span class="other-info-text d-block">{{$profile_info->spoken_language}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-1 border rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-3 d-flex align-items-center">
                                            <span class="fa-stack fa-2x fa-fw ml-2">
                                                <i class="fas fa-circle text-mauve fa-stack-2x"></i>
                                                <i class="fas fa-clock fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <div class="text ml-2">
                                                <span class="other-info-heading d-block">Work Hours</span>
                                                <span class="other-info-text">{{$profile_info->work_hours}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="m-1 border rounded">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-3 d-flex align-items-center">
                                            <span class="fa-stack fa-2x fa-fw ml-2">
                                                <i class="fas fa-circle text-valencia fa-stack-2x"></i>
                                                <i class="fas fa-stopwatch fa-stack-1x fa-inverse"></i>
                                            </span>
                                            <div class="text ml-2">
                                                <span class="other-info-heading d-block">Average Processing Time</span>
                                                <span class="other-info-text">{{$profile_info->avg_processing_time}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


<div class="col-md-3 col-xs-6 border rounded">
    <div class="row">
        <div class="col-md-3 d-flex">
            <i class="fas fa-language fa-2x mr-1 my-auto"></i>
        </div>
        <div class="col-md-9 p-3 d-flex flex-column">
            <span>Spoken Language</span>
            <span>{{$profile_info->spoken_language}}</span>
        </div>
    </div>
</div>
<div class="col-md-3 col-xs-6 border rounded">
    <div class="row">
        <div class="col-md-3 d-flex">
            <i class="far fa-clock mr-1 fa-2x mr-1 my-auto"></i>
        </div>
        <div class="col-md-9 p-3 d-flex flex-column">
            <span>Work Hours</span>
            <span>{{$profile_info->work_hours}}</span>
        </div>
    </div>
</div>
<div class="col-md-3 col-xs-6 border rounded">
    <div class="row">
        <div class="col-md-3 d-flex">
            <i class="fas fa-stopwatch mr-1 fa-2x mr-1 my-auto"></i>
        </div>
        <div class="col-md-9 p-3 d-flex flex-column">
            <span>Average Processing Time</span>
            <span>{{$profile_info->avg_processing_time}}</span>
        </div>
    </div>
</div>
@endsection