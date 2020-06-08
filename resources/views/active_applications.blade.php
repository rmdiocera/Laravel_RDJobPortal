@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
        <h1 class="card-title mb-0">Active Applications</h1>
        <hr class="modal-divider my-1">
            @if (count($applications) > 0)
                <div class="row">
                    @foreach ($applications as $application)
                    <div class="col-md-6 py-2" data-card-id="{{$application->id}}">
                        <div class="card">
                            <div class="card-body d-flex">
                                <img src="/storage/emp_profile_pictures/{{$application->profile_picture}}" class="emp-profile-pic-sm d-block mr-4" alt="">
                                <div>
                                    <h5 class="card-title mb-1"><a href="/job-post/{{$application->job_post_id}}">{!! Str::words($application->title, 4, '...') !!}</a></h5>
                                    <h6 class="card-title">{{$application->company_name}}</h6>
                                    <span data-jp-app-status-id="{{$application->id}}">
                                        @if ($application->app_status_id === 2 || $application->app_status_id === 4)
                                            <span class="badge badge-success app-status-text">{{$application->status}}</span>
                                        @elseif ($application->app_status_id === 3 || $application->app_status_id === 5)
                                            <span class="badge badge-secondary app-status-text">{{$application->status}}</span>
                                        @else
                                            <span class="badge badge-primary app-status-text">{{$application->status}}</span>
                                        @endif
                                    </span>
                                    <p class="card-text">{{App\Http\Controllers\HomeController::getJobPostApplicantsCount($application->job_post_id, $application->comp_id)}} Applicant(s)</p>
                                    <p class="card-text">Applied on {{ Carbon\Carbon::parse($application->created_at)->format('F j, Y')}}</p>
                                    <div class="form-inline mb-2">
                                        @if ($application->app_status_id === 2)
                                            {{-- {!! Form::open(['action' => ['HomeController@acceptInterviewInvitation', $application->id], 'method' => 'PUT']) !!}
                                                {{Form::submit('Accept Interview Invitation', ['class' => 'btn btn-sm btn-success'])}}
                                            {!! Form::close() !!} --}}
                                            <button data-jp-app-id="{{$application->id}}" class="btn btn-sm btn-success mr-1 accept-int" type="button"><i class="fas fa-check-circle mr-1"></i>Accept</button>
                                            {{-- {!! Form::open(['action' => ['HomeController@declineInterviewInvitation', $application->id], 'method' => 'PUT']) !!}
                                                {{Form::submit('Reject Interview Invitation', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                                            {!! Form::close() !!} --}}
                                            <button data-jp-app-id="{{$application->id}}" class="btn btn-sm btn-secondary mr-1 decline-int" type="button"><i class="fas fa-times-circle mr-1"></i>Decline</button>
                                        @endif
                                        {{-- {!! Form::open(['action' => ['HomeController@removeApplicantJobPostApplication', $application->id], 'method' => 'DELETE']) !!}
                                            {{Form::submit('Withdraw Application', ['class' => 'btn btn-sm btn-danger'])}}
                                        {!! Form::close() !!} --}}
                                        <button data-jp-app-id="{{$application->id}}" class="btn btn-sm btn-danger withdraw-jp" type="button"><i class="fas fa-minus-circle mr-1"></i>Withdraw Application</button>
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
        </div>
    </div>
@endsection