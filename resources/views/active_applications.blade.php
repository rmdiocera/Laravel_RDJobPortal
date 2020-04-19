@extends('layouts.app')

@section('content')
    <h1>Active Applications</h1>
    @if (count($applications) > 0)
        <div class="row d-flex justify-content-around">
            @foreach ($applications as $application)
            <div class="card col-md-5 py-2">
                <h3>{{$application->title}}</h3>
                <h5>{{$application->company_name}}</h5>
                <span>{{$application->status}}</span>
                <p>{{App\Http\Controllers\HomeController::getJobPostApplicantsCount($application->job_post_id, $application->comp_id)}} Applicant(s)</p>
                <p>Applied on {{ Carbon\Carbon::parse($application->created_at)->format('F j, Y')}}</p>
                <a href="/job-post/{{$application->id}}/withdraw"><button class="btn btn-sm btn-primary" type="button" >Withdraw Application</button></a>
            </div>
            @endforeach
        </div>
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection