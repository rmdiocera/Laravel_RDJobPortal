@extends('layouts.app')

@section('content')
    <h1>Active Applications</h1>
    @if (count($applications) > 0)
        <div class="row">
            @foreach ($applications as $application)
            <div class="col-md-6 py-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{$application->title}}</h3>
                        <h5 class="card-title">{{$application->company_name}}</h5>
                        <span>{{$application->status}}</span>
                        <p class="card-text">{{App\Http\Controllers\HomeController::getJobPostApplicantsCount($application->job_post_id, $application->comp_id)}} Applicant(s)</p>
                        <p class="card-text">Applied on {{ Carbon\Carbon::parse($application->created_at)->format('F j, Y')}}</p>
                        <a href="/job-post/{{$application->id}}/withdraw"><button class="btn btn-sm btn-primary" type="button" >Withdraw Application</button></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>There doesn't seem to be anything here.</p>
    @endif
@endsection