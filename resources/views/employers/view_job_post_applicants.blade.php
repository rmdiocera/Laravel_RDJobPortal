@extends('layouts.app')

@section('content')
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
                    <td>{{$applicant->first_name." ".$applicant->last_name}}</td>
                    <td><a href="">Resume Link</a></td>
                    <td>{{$applicant->status}}</td>
                    <td class="d-flex justify-content-around">
                        {!! Form::open(['action' => ['EmployersController@inviteApplicantToInterview', $applicant->id], 'method' => 'PUT']) !!}
                            {{Form::submit('Invite to Interview', ['class' => 'btn btn-sm btn-success'])}}
                        {!! Form::close() !!}
                        {!! Form::open(['action' => ['EmployersController@rejectApplicantApplication', $applicant->id], 'method' => 'PUT']) !!}
                            {{Form::submit('Reject Application', ['class' => 'btn btn-sm btn-danger'])}}
                        {!! Form::close() !!}
                        {{-- <a href="/job-post/{{$applicant->id}}/invite"><button class="btn btn-sm btn-success" type="button" >Save Job Post</button></a> --}}
                        {{-- <a href="/job-post/{{$applicant->id}}/reject"><button class="btn btn-sm btn-danger" type="button">Apply to Job Post</button></a> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>
@endsection