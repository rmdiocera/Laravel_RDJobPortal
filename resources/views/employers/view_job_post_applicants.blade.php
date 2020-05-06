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

<h1>{{$job_post->title}}</h1>
    <table data-toggle="table">
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
                    <td><a href="" id="{{$applicant->app_id}}" class="show_app_info">{{$applicant->first_name." ".$applicant->last_name}}</a></td>
                    <td class="d-flex justify-content-center">
                        <a href="/storage/app_resume/{{$applicant->resume}}" download><button class="btn btn-sm btn-primary" type="button">Download</button></a>
                    </td>
                    <td data-status-id="{{$applicant->id}}">{{$applicant->status}}</td>
                    <td class="d-flex justify-content-around">
                        {{-- {!! Form::open(['action' => ['EmployersController@inviteApplicantToInterview', $applicant->id], 'method' => 'PUT']) !!}
                            {{Form::submit('Invite to Interview', ['class' => 'btn btn-sm btn-success'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-app-id="{{$applicant->id}}" class="btn btn-sm btn-primary invite-app" type="button">Invite to Interview</button>
                        {{-- {!! Form::open(['action' => ['EmployersController@rejectApplicantApplication', $applicant->id], 'method' => 'PUT']) !!}
                            {{Form::submit('Reject Application', ['class' => 'btn btn-sm btn-danger'])}}
                        {!! Form::close() !!} --}}
                        <button data-jp-app-id="{{$applicant->id}}" class="btn btn-sm btn-danger reject-app" type="button">Reject Application</button>
                        {{-- <a href="/job-post/{{$applicant->id}}/invite"><button class="btn btn-sm btn-success" type="button">Save Job Post</button></a> --}}
                        {{-- <a href="/job-post/{{$applicant->id}}/reject"><button class="btn btn-sm btn-danger" type="button">Apply to Job Post</button></a> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>
@endsection