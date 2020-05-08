@extends('layouts.app')

@section('content')
{{-- Employer Info Modal --}}
<div id="companyInfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Company Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center comp-img"></div>
                    <div class="col-md-6 comp-main-info"></div>
                </div>
                <hr class="modal-divider">
                <div class="row">
                    <div class="col-md-12 comp-other-info"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
        </div>
    </div>
</div>

<h1>Job Posts</h1>
    @if (!Auth::guard('employer')->check())
    {!! Form::open(['action' => 'PagesController@showJobPosts', 'method' => 'GET']) !!}
        {{-- @isset($industry_id)
            {{$industry_id}}
        @endisset
        @isset($emp_type_id)
            {{$emp_type_id}}
        @endisset --}}
        <div class="form-inline d-flex justify-content-around mb-2">
            <div class="form-group">
                {{Form::label('industry', 'Industry')}}
                <select onchange="this.form.submit()" name="industry" id="" class="ml-2">
                    <option value="">Select industry</option>
                    @isset($industry_id)
                        @foreach ($sort_by['industries'] as $industry)    
                                @if ($industry->id == $industry_id)
                                    <option value="{{$industry->id}}" selected>{{$industry->industry}}</option>
                                @else
                                    <option value="{{$industry->id}}">{{$industry->industry}}</option>
                                @endif
                        @endforeach
                    @else
                        @foreach ($sort_by['industries'] as $industry)
                            <option value="{{$industry->id}}">{{$industry->industry}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="form-group">
                {{Form::label('emp_type', 'Employment Type')}}
                <select onchange="this.form.submit()" name="emp_type" id="" class="ml-2">
                    <option value="">Select employment type</option>
                    @isset($emp_type_id)
                        @foreach ($sort_by['emp_types'] as $emp_type)    
                                @if ($emp_type->id == $emp_type_id)
                                    <option value="{{$emp_type->id}}" selected>{{$emp_type->emp_type}}</option>
                                @else
                                    <option value="{{$emp_type->id}}">{{$emp_type->emp_type}}</option>
                                @endif
                        @endforeach
                    @else
                        @foreach ($sort_by['emp_types'] as $emp_type)
                            <option value="{{$emp_type->id}}">{{$emp_type->emp_type}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="form-group ml-2">
                {{Form::label('level', 'Job Level')}}
                <select onchange="this.form.submit()" name="level" id="" class="ml-2">
                    <option value="">Select job level</option>
                    @isset($level_id)
                        @foreach ($sort_by['levels'] as $level)
                            @if ($level->id == $level_id)
                                <option value="{{$level->id}}" selected>{{$level->job_level}}</option>
                            @else
                                <option value="{{$level->id}}">{{$level->job_level}}</option>
                            @endif
                        @endforeach
                    @else
                        @foreach ($sort_by['levels'] as $level)
                            <option value="{{$level->id}}">{{$level->job_level}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="input-group mb-2">
            @isset($search)
                {{Form::text('search', $search, ['class' => 'form-control', 'placeholder' => 'Search jobs'])}}
            @else
                {{Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search jobs'])}}
            @endisset
            <div class="input-group-append">
                {{Form::submit('Search', ['class' => 'btn btn-primary'])}}
            </div>
        </div>
    {!! Form::close() !!}
    @endif
    @isset($results)
        @if (count($results) > 0)
            @isset($search)
                <span class="mb-2">You searched for: {{$search}}</span>
            @endisset
            @foreach ($results as $result)
                <div class="card col-md-12 mb-2 pt-2" data-card-id="{{$result->id}}">
                    <h3><a href="/job-post/{{$result->id}}">{{$result->title}}</a></h3>
                    <p class="font-weight-bold">{{$result->company_name}}</p>
                    <div class="job-desc">{!! Str::words($result->desc, 100, '...')!!}</div>
                    <div class="form-inline">
                        <p>Industry: <span class="badge badge-primary align-middle">{{$result->industry}}</span></p>
                        <p class="ml-2">Employment Type: <span class="badge badge-primary align-middle">{{$result->emp_type}}</span></p>
                        <p class="ml-2">Job Level: <span class="badge badge-primary align-middle">{{$result->job_level}}</span></p>
                    </div>
                    <span>{{ Carbon\Carbon::parse($result->created_at)->format('F j, Y')}}</span>
                    <div class="form-inline d-flex mb-2">
                        {{-- @if (Auth::guard('employer')->check() && Auth::user()->id === $result->comp_id)
                            <a href="/job-post/{{$result->id}}/view"><button class="btn btn-sm btn-primary" type="button">View Applicants</button></a>
                            <a href="/job-post/{{$result->id}}/edit"><button class="btn btn-sm btn-primary ml-2" type="button">Edit Job Post</button></a>
                            {!! Form::open(['action' => ['JobPostsController@destroy', $result->id], 'method' => 'DELETE']) !!}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                            {!! Form::close() !!}
                            <button data-jp-id="{{$result->id}}" class="btn btn-sm btn-danger ml-2 delete-jp" type="button">Delete</button>
                        @else --}}
                            {{-- {!! Form::open(['action' => ['HomeController@saveJobPost'], 'method' => 'POST']) !!}
                                {{Form::hidden('job_post_id', $result->id)}}
                                {{Form::hidden('comp_id', $result->comp_id)}}
                                {{Form::submit('Save Job Post', ['class' => 'btn btn-sm btn-primary save-jp'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-id="{{$result->id}}" data-comp-id="{{$result->comp_id}}" class="btn btn-sm btn-primary save-jp" type="button">Save Job Post</button>
                            {{-- {!! Form::open(['action' => ['HomeController@storeApplicantJobPostApplication'], 'method' => 'POST']) !!}
                                {{Form::hidden('job_post_id', $result->id)}}
                                {{Form::hidden('comp_id', $result->comp_id)}}
                                {{Form::submit('Apply to Job Post', ['class' => 'btn btn-sm btn-primary ml-2'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-id="{{$result->id}}" data-comp-id="{{$result->comp_id}}" class="btn btn-sm btn-primary ml-2 apply-to-jp" type="button">Apply to Job Post</button>
                            {{-- <a href="/job-post/{{$result->id}}/{{$result->comp_id}}/save"><button class="btn btn-sm btn-primary" type="button">Save Job Post</button></a>
                            <a href="/job-post/{{$result->id}}/{{$result->comp_id}}/apply"><button class="btn btn-sm btn-primary ml-2" type="button">Apply to Job Post</button></a>
                        @endif --}}
                    </div>
                </div>
            @endforeach
            @if (!Auth::guard('employer')->check())
                {{ $results->links() }}
            @endif
        @else
            <p>No results have been found.</p>
        @endif
    @endisset
    
    @isset($job_posts)
        @if (count($job_posts) > 0)
            @foreach ($job_posts as $job_post)
                <div class="card col-md-12 mb-2 pt-2" data-card-id="{{$job_post->id}}">
                    <h3><a href="/job-post/{{$job_post->id}}">{{$job_post->title}}</a></h3>
                    <p class="font-weight-bold"><a href="" id="{{$job_post->comp_id}}" class="show_emp_info">{{$job_post->company_name}}</a></p>
                    <div class="job-desc">
                        {!! Str::words($job_post->desc, 100, '...')!!}
                    </div>
                    <div class="form-inline">
                        <p>Industry: <span class="badge badge-primary align-middle">{{$job_post->industry}}</span></p>
                        <p class="ml-2">Employment Type: <span class="badge badge-primary align-middle">{{$job_post->emp_type}}</span></p>
                        <p class="ml-2">Job Level: <span class="badge badge-primary align-middle">{{$job_post->job_level}}</span></p>
                    </div>
                    <span>{{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</span>
                    <div class="form-inline d-flex mb-2">
                        @if (Auth::guard('employer')->check() && Auth::user()->id === $job_post->comp_id)
                            <a href="/job-post/{{$job_post->id}}/view"><button class="btn btn-sm btn-primary" type="button">View Applicants</button></a>
                            <a href="/job-post/{{$job_post->id}}/edit"><button class="btn btn-sm btn-primary ml-2" type="button">Edit Job Post</button></a>
                            {{-- {!! Form::open(['action' => ['JobPostsController@destroy', $job_post->id], 'method' => 'DELETE']) !!}
                                {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-id="{{$job_post->id}}" class="btn btn-sm btn-danger ml-2 delete-jp" type="button">Delete</button>
                        @else
                            {{-- {!! Form::open(['action' => ['HomeController@saveJobPost'], 'method' => 'POST']) !!}
                                {{Form::hidden('job_post_id', $job_post->id)}}
                                {{Form::hidden('comp_id', $job_post->comp_id)}}
                                {{Form::submit('Save Job Post', ['class' => 'btn btn-sm btn-primary save-jp'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-id="{{$job_post->id}}" data-comp-id="{{$job_post->comp_id}}" class="btn btn-sm btn-primary save-jp" type="button">Save Job Post</button>
                            {{-- {!! Form::open(['action' => ['HomeController@storeApplicantJobPostApplication'], 'method' => 'POST']) !!}
                                {{Form::hidden('job_post_id', $job_post->id)}}
                                {{Form::hidden('comp_id', $job_post->comp_id)}}
                                {{Form::submit('Apply to Job Post', ['class' => 'btn btn-sm btn-primary ml-2'])}}
                            {!! Form::close() !!} --}}
                            <button data-jp-id="{{$job_post->id}}" data-comp-id="{{$job_post->comp_id}}" class="btn btn-sm btn-primary ml-2 apply-to-jp" type="button">Apply to Job Post</button>
                            {{-- <a href="/job-post/{{$job_post->id}}/{{$job_post->comp_id}}/save"><button class="btn btn-sm btn-primary" type="button">Save Job Post</button></a> --}}
                            {{-- <a href="/job-post/{{$job_post->id}}/{{$job_post->comp_id}}/apply"><button class="btn btn-sm btn-primary ml-2" type="button">Apply to Job Post</button></a> --}}
                        @endif
                    </div>
                </div>
            @endforeach
            {{-- @if (!Auth::guard('employer')->check()) --}}
                {{ $job_posts->links() }}
            {{-- @endif --}}
        @else
            <p>There doesn't seem to be anything here.</p>
        @endif    
    @endisset
@endsection