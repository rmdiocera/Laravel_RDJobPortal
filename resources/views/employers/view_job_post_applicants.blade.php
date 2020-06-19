@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="card-title mb-0">{{$job_post->title}}</h1>
        <hr class="modal-divider my-2">
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
                        <td><a href="/applicant/{{$applicant->app_id}}">{{$applicant->first_name." ".$applicant->last_name}}</a></td>
                        <td class="text-center">
                        @if ($applicant->resume)
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
                            <button data-jp-app-id="{{$applicant->id}}" class="btn btn-sm btn-success invite-app" type="button"><i class="fas fa-check-circle mr-1"></i>Invite to Interview</button>
                            <button data-jp-app-id="{{$applicant->id}}" class="btn btn-sm btn-danger reject-app" type="button"><i class="fas fa-times-circle mr-1"></i>Reject Application</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection