@extends('layouts.app')

@section('content')
{{-- Applicant Info Modal --}}
<div id="applicantInfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Applicant Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center app-img"></div>
                    <div class="col-md-6 app-main-info"></div>
                </div>
                <hr class="modal-divider">
                <div class="row">
                    <div class="col-md-12 app-work-exp"></div>
                </div>
                <hr class="modal-divider">
                <div class="row">
                    <div class="col-md-12 app-educ-bg"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h1 class="card-title">{{$job_post->title}}</h1>
        <table id="app-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $applicant)
                    <tr>
                        {{-- <td><a href="" id="{{$applicant->app_id}}" class="show_app_info">{{$applicant->first_name." ".$applicant->last_name}}</a></td> --}}
                        <td><a href="/applicant/{{$applicant->app_id}}">{{$applicant->first_name." ".$applicant->last_name}}</a></td>
                        <td class="text-center">
                        @if ($applicant->resume)
                        {{-- <button class="btn btn-sm btn-secondary" type="button" disabled>Not Available</button></a>     --}}
                            <a href="/storage/app_resume/{{$applicant->resume}}" download><button class="btn btn-sm btn-primary" type="button"><i class="fas fa-file-download mr-1"></i>Download</button></a>
                        @else
                            <button class="btn btn-sm btn-secondary" type="button" disabled>Not Available</button></a>
                        @endif
                        </td>
                        <td data-jp-app-status-id="{{$applicant->id}}" class="text-center">
                            @if ($applicant->app_status_id === 2 || $applicant->app_status_id === 4)
                                <span class="badge badge-success app-status-text align-middle">{{$applicant->status}}</span>
                            @elseif ($applicant->app_status_id === 3 || $applicant->app_status_id === 5)
                                <span class="badge badge-secondary app-status-text align-middle">{{$applicant->status}}</span>
                            @else
                                <span class="badge badge-primary app-status-text align-middle">{{$applicant->status}}</span>
                            @endif
                        </td>
                        <td class="d-flex justify-content-around">
                            {{-- {!! Form::open(['action' => ['EmployersController@inviteApplicantToInterview', $applicant->id], 'method' => 'PUT']) !!}
                                {{Form::submit('Invite to Interview', ['class' => 'btn btn-sm btn-success'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-app-id="{{$applicant->id}}" class="btn btn-sm btn-success invite-app" type="button"><i class="fas fa-check-circle mr-1"></i>Invite to Interview</button>
                            {{-- {!! Form::open(['action' => ['EmployersController@rejectApplicantApplication', $applicant->id], 'method' => 'PUT']) !!}
                                {{Form::submit('Reject Application', ['class' => 'btn btn-sm btn-danger'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-app-id="{{$applicant->id}}" class="btn btn-sm btn-danger reject-app" type="button"><i class="fas fa-times-circle mr-1"></i>Reject Application</button>
                            {{-- <a href="/job-post/{{$applicant->id}}/invite"><button class="btn btn-sm btn-success" type="button">Save Job Post</button></a> --}}
                            {{-- <a href="/job-post/{{$applicant->id}}/reject"><button class="btn btn-sm btn-danger" type="button">Apply to Job Post</button></a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection