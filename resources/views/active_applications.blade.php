@extends('layouts.app')

@section('content')
    <h1>Active Applications</h1>
    @if (count($applications) > 0)
        <div class="row">
            @foreach ($applications as $application)
            <div class="col-md-6 py-2" data-card-id="{{$application->id}}">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{$application->title}}</h3>
                        <h5 class="card-title">{{$application->company_name}}</h5>
                        <span data-status-id="{{$application->id}}">{{$application->status}}</span>
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
            @endforeach
        </div>
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection