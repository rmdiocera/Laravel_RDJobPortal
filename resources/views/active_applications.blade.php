@extends('layouts.app')

@section('content')
    <h1>Active Applications</h1>
    @if (count($applications) > 0)
        <div class="row">
            @foreach ($applications as $application)
            <div class="col-md-6 py-2" data-card-id="{{$application->id}}">
                <div class="card">
                    <div class="card-body d-flex">
                        <img src="/storage/emp_profile_pictures/{{$application->profile_picture}}" class="emp-profile-pic-sm d-block mr-4" alt="">
                        <div class="">
                            <h5 class="card-title mb-1">{{$application->title}}</h5>
                            <h6 class="card-title">{{$application->company_name}}</h6>
                            <span data-jp-app-status-id="{{$application->id}}">
                                @if ($application->app_status_id === 2 || $application->app_status_id === 4)
                                    <span class="badge badge-success" style="font-size: 1em">{{$application->status}}</span>
                                @elseif ($application->app_status_id === 3 || $application->app_status_id === 5)
                                    <span class="badge badge-secondary" style="font-size: 1em">{{$application->status}}</span>
                                @else
                                    <span class="badge badge-primary" style="font-size: 1em">{{$application->status}}</span>
                                @endif
                            </span>
                            <p class="card-text">{{App\Http\Controllers\HomeController::getJobPostApplicantsCount($application->job_post_id, $application->comp_id)}} Applicant(s)</p>
                            <p class="card-text">Applied on {{ Carbon\Carbon::parse($application->created_at)->format('F j, Y')}}</p>
                            <div class="form-inline mb-2">
                                {{-- @if ($application->app_status_id === 2) --}}
                                    {{-- {!! Form::open(['action' => ['HomeController@acceptInterviewInvitation', $application->id], 'method' => 'PUT']) !!}
                                        {{Form::submit('Accept Interview Invitation', ['class' => 'btn btn-sm btn-success'])}}
                                    {!! Form::close() !!} --}}
                                    <button data-jp-app-id="{{$application->id}}" class="btn btn-sm btn-success accept-int" type="button"><i class="fas fa-check-circle mr-1"></i>Accept</button>
                                    {{-- {!! Form::open(['action' => ['HomeController@declineInterviewInvitation', $application->id], 'method' => 'PUT']) !!}
                                        {{Form::submit('Reject Interview Invitation', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                                    {!! Form::close() !!} --}}
                                    <button data-jp-app-id="{{$application->id}}" class="btn btn-sm btn-secondary ml-1 decline-int" type="button"><i class="fas fa-times-circle mr-1"></i>Decline</button>
                                {{-- @endif --}}
                                {{-- {!! Form::open(['action' => ['HomeController@removeApplicantJobPostApplication', $application->id], 'method' => 'DELETE']) !!}
                                    {{Form::submit('Withdraw Application', ['class' => 'btn btn-sm btn-danger'])}}
                                {!! Form::close() !!} --}}
                                <button data-jp-app-id="{{$application->id}}" class="btn btn-sm btn-danger ml-1 withdraw-jp" type="button"><i class="fas fa-minus-circle mr-1"></i>Withdraw Application</button>
                                {{-- <a href="/job-post/{{$application->id}}/withdraw"><button class="btn btn-sm btn-primary" type="button">Withdraw Application</button></a> --}}
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection