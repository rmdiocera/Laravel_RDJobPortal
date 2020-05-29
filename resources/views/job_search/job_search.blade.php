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
        <div class="form-inline mb-2 d-flex">
            <div class="form-group pr-1">
                {{-- {{Form::label('industry', 'Industry')}} --}}
                <select onchange="this.form.submit()" name="industry" id="" title="Industry" class="selectpicker border rounded border-secondary">
                    @isset($industry_id)
                    <option value="">Clear selected option</option>
                        @foreach ($filter_by['industries'] as $industry)
                            <option value="{{$industry->id}}" @if ($industry->id == $industry_id) selected @endif>{{$industry->industry}}</option>    
                                {{-- @if ($industry->id == $industry_id)
                                    <option value="{{$industry->id}}" selected>{{$industry->industry}}</option>
                                @else
                                    <option value="{{$industry->id}}">{{$industry->industry}}</option>
                                @endif --}}
                        @endforeach
                    @else
                    {{-- <option value="">Select industry</option> --}}
                        @foreach ($filter_by['industries'] as $industry)
                            <option value="{{$industry->id}}">{{$industry->industry}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="form-group pr-1">
                {{-- {{Form::label('emp_type', 'Employment Type')}} --}}
                <select onchange="this.form.submit()" name="emp_type" id="" title="Employment Type" class="selectpicker border rounded border-secondary">
                    @isset($emp_type_id)
                    <option value="">Clear selected option</option>
                        @foreach ($filter_by['emp_types'] as $emp_type)
                            <option value="{{$emp_type->id}}" @if ($emp_type->id == $emp_type_id) selected @endif>{{$emp_type->emp_type}}</option>    
                                {{-- @if ($emp_type->id == $emp_type_id)
                                    <option value="{{$emp_type->id}}" selected>{{$emp_type->emp_type}}</option>
                                @else
                                    <option value="{{$emp_type->id}}">{{$emp_type->emp_type}}</option>
                                @endif --}}
                        @endforeach
                    @else
                    {{-- <option value="">Select employment type</option> --}}
                        @foreach ($filter_by['emp_types'] as $emp_type)
                            <option value="{{$emp_type->id}}">{{$emp_type->emp_type}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="form-group">
                {{-- {{Form::label('level', 'Job Level')}} --}}
                <select onchange="this.form.submit()" name="level" id="" title="Job Level" class="selectpicker border rounded border-secondary">
                    @isset($level_id)
                    <option value="">Clear selected option</option>
                        @foreach ($filter_by['levels'] as $level)
                            <option value="{{$level->id}}" @if ($level->id == $level_id) selected @endif>{{$level->job_level}}</option>
                                {{-- @if ($level->id == $level_id)
                                    <option value="{{$level->id}}" selected>{{$level->job_level}}</option>
                                @else
                                    <option value="{{$level->id}}">{{$level->job_level}}</option>
                                @endif --}}
                        @endforeach
                    @else
                    {{-- <option value="">Select job level</option> --}}
                        @foreach ($filter_by['levels'] as $level)
                            <option value="{{$level->id}}">{{$level->job_level}}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
            <div class="form-group ml-auto">
                {{-- {{Form::label('level', 'Job Level')}} --}}
                <select onchange="this.form.submit()" name="sort_by" id="" title="Sort By" class="selectpicker border rounded border-secondary">
                    <option value="1" @if(isset($order_by_id) && $order_by_id == 1) selected @endif>Date Posted</option>
                    <option value="2" @if(isset($order_by_id) && $order_by_id == 2) selected @endif>Company Name</option>
                    <option value="3" @if(isset($order_by_id) && $order_by_id == 3) selected @endif>Job Title</option>
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
                {{Form::button('<i class="fas fa-search mr-1"></i>Search', ['type' => 'submit', 'class' => 'btn btn-primary'])}}
                {{-- {{Form::submit('<i class="fas fa-save mr-1"></i>Search', ['class' => 'btn btn-primary'])}} --}}
            </div>
        </div>
    {!! Form::close() !!}
    @endif
    @isset($results)
        @if (count($results) > 0)
            @isset($search)
                <span class="mb-2">{{count($results)}} @if (count($results) > 1) results @else result @endif found for: {{$search}}</span>
            @endisset
            @foreach ($results as $result)
                <div class="card col-md-10 mb-2 pt-2" data-card-id="{{$result->id}}">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <img class="jp-comp-img" src="storage/emp_profile_pictures/{{$result->profile_picture}}" alt="">
                        </div>
                        <div class="col-md-9 col-sm-9 d-flex flex-column">
                            <h3 class="card-title"><a href="/job-post/{{$result->id}}">{{$result->title}}</a></h3>
                            <p class="font-weight-bold"><a href="/company/{{$result->comp_id}}">{{$result->company_name}}</a></p>
                            {{-- <p class="font-weight-bold">{{$result->company_name}}</p> --}}
                            <div class="form-inline">
                                <p>Industry: <span class="badge badge-primary align-middle">{{$result->industry}}</span></p>
                                <p class="ml-2">Employment Type: <span class="badge badge-primary align-middle">{{$result->emp_type}}</span></p>
                                <p class="ml-2">Job Level: <span class="badge badge-primary align-middle">{{$result->job_level}}</span></p>
                            </div>
                            <div class="job-desc card-text">{!! Str::words($result->desc, 50, '...') !!} @if (str_word_count(strip_tags($result->desc)) >= 50) <a href="/job-post/{{$result->id}}">Read More</a>  @endif</div>
                            <div class="form-inline mt-auto mb-2">
                                <span>{{ Carbon\Carbon::parse($result->created_at)->format('F j, Y')}}</span>
                                <div class="ml-auto">
                                    <button data-jp-id="{{$result->id}}" data-comp-id="{{$result->comp_id}}" class="btn btn-sm btn-primary save-jp" type="button"><i class="fas fa-save mr-1"></i>Save Job Post</button>
                                    <button data-jp-id="{{$result->id}}" data-comp-id="{{$result->comp_id}}" class="btn btn-sm btn-primary ml-2 apply-to-jp" type="button"><i class="fas fa-plus-circle mr-1"></i>Apply to Job Post</button>
                                </div>
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
                                    {{-- {!! Form::open(['action' => ['HomeController@storeApplicantJobPostApplication'], 'method' => 'POST']) !!}
                                        {{Form::hidden('job_post_id', $result->id)}}
                                        {{Form::hidden('comp_id', $result->comp_id)}}
                                        {{Form::submit('Apply to Job Post', ['class' => 'btn btn-sm btn-primary ml-2'])}}
                                    {!! Form::close() !!} --}}
                                    {{-- <a href="/job-post/{{$result->id}}/{{$result->comp_id}}/save"><button class="btn btn-sm btn-primary" type="button">Save Job Post</button></a>
                                    <a href="/job-post/{{$result->id}}/{{$result->comp_id}}/apply"><button class="btn btn-sm btn-primary ml-2" type="button">Apply to Job Post</button></a>
                                @endif --}}
                            </div>
                        </div>
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
                <div class="card h-100 col-md-10 mb-2 pt-2" data-card-id="{{$job_post->id}}">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 mb-2">
                            <img class="jp-comp-img" src="storage/emp_profile_pictures/{{$job_post->profile_picture}}" style="width: 100%"  alt="">
                        </div>
                        <div class="col-md-9 col-sm-9 d-flex flex-column">
                            <h3 class="card-title"><a href="/job-post/{{$job_post->id}}">{{$job_post->title}}</a></h3>
                            <p class="font-weight-bold"><a href="/company/{{$job_post->comp_id}}">{{$job_post->company_name}}</a></p>
                            {{-- <p class="font-weight-bold"><a href="" id="{{$job_post->comp_id}}" class="show_emp_info">{{$job_post->company_name}}</a></p> --}}
                            <div class="form-inline">
                                <p>Industry: <span class="badge badge-primary align-middle">{{$job_post->industry}}</span></p>
                                <p class="ml-2">Employment Type: <span class="badge badge-primary align-middle">{{$job_post->emp_type}}</span></p>
                                <p class="ml-2">Job Level: <span class="badge badge-primary align-middle">{{$job_post->job_level}}</span></p>
                            </div>
                            <div class="job-desc card-text">{!! Str::words($job_post->desc, 50, '...') !!} @if (str_word_count(strip_tags($job_post->desc)) >= 50) <a href="/job-post/{{$job_post->id}}">Read More</a>  @endif</div>
                            <div class="form-inline mt-auto mb-2">
                                @if (Auth::guard('employer')->check() && Auth::user()->id === $job_post->comp_id)
                                    <span>{{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</span>
                                    <div class="ml-auto">
                                        <a href="/job-post/{{$job_post->id}}/view"><button class="btn btn-primary" type="button"><i class="far fa-eye mr-1"></i>View Applicants</button></a>
                                        <a href="/job-post/{{$job_post->id}}/edit"><button class="btn btn-primary ml-2" type="button"><i class="fas fa-edit mr-1"></i>Edit Job Post</button></a>
                                        <button data-jp-id="{{$job_post->id}}" class="btn btn-danger ml-2 delete-jp" type="button"><i class="fas fa-times-circle mr-1"></i>Delete</button>
                                    </div>
                                    {{-- {!! Form::open(['action' => ['JobPostsController@destroy', $job_post->id], 'method' => 'DELETE']) !!}
                                        {{Form::submit('Delete', ['class' => 'btn btn-sm btn-danger ml-2'])}}
                                    {!! Form::close() !!} --}}
                                @else
                                    <span>{{ Carbon\Carbon::parse($job_post->created_at)->format('F j, Y')}}</span>
                                    <div class="ml-auto">
                                        <button data-jp-id="{{$job_post->id}}" data-comp-id="{{$job_post->comp_id}}" class="btn btn-primary save-jp" type="button"><i class="fas fa-save mr-1"></i>Save Job Post</button>
                                        <button data-jp-id="{{$job_post->id}}" data-comp-id="{{$job_post->comp_id}}" class="btn btn-primary ml-2 apply-to-jp" type="button"><i class="fas fa-plus-circle mr-1"></i>Apply to Job Post</button>
                                    </div>
                                    {{-- {!! Form::open(['action' => ['HomeController@saveJobPost'], 'method' => 'POST']) !!}
                                        {{Form::hidden('job_post_id', $job_post->id)}}
                                        {{Form::hidden('comp_id', $job_post->comp_id)}}
                                        {{Form::submit('Save Job Post', ['class' => 'btn btn-sm btn-primary save-jp'])}}
                                    {!! Form::close() !!} --}}
                                    
                                    {{-- {!! Form::open(['action' => ['HomeController@storeApplicantJobPostApplication'], 'method' => 'POST']) !!}
                                        {{Form::hidden('job_post_id', $job_post->id)}}
                                        {{Form::hidden('comp_id', $job_post->comp_id)}}
                                        {{Form::submit('Apply to Job Post', ['class' => 'btn btn-sm btn-primary ml-2'])}}
                                    {!! Form::close() !!} --}}
                                    {{-- <a href="/job-post/{{$job_post->id}}/{{$job_post->comp_id}}/save"><button class="btn btn-sm btn-primary" type="button">Save Job Post</button></a> --}}
                                    {{-- <a href="/job-post/{{$job_post->id}}/{{$job_post->comp_id}}/apply"><button class="btn btn-sm btn-primary ml-2" type="button">Apply to Job Post</button></a> --}}
                                @endif
                            </div>
                        </div>
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