@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="card-title mb-0">Edit Profile</h1>
        <hr class="modal-divider mb-2">
        {!! Form::open(['action' => ['HomeController@updateApplicantProfile', $data['app_profile']['user_id']], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}    
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('first_name', 'First Name')}}
                        {{Form::text('first_name', $data['app_profile']['first_name'], ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                        {{Form::label('last_name', 'Last Name', ['class' => 'mt-2'])}}
                        {{Form::text('last_name', $data['app_profile']['last_name'], ['class' => 'form-control', 'placeholder' => 'Last Name'])}}
                        {{Form::label('age', 'Age', ['class' => 'mt-2'])}}
                        {{Form::text('age', $data['app_profile']['age'], ['class' => 'form-control', 'placeholder' => 'Age'])}}
                        {{Form::label('gender', 'Gender', ['class' => 'mt-2'])}}
                        <select class="selectpicker form-control" name="gender" id="" title="Select your gender">
                            @foreach ($data['genders'] as $gender)
                                <option value="{{$gender->id}}" @if ($gender->id === $data['app_profile']['gender_id']) selected @endif>{{$gender->gender}}</option> 
                            @endforeach
                        </select>
                        {{Form::label('address', 'Address', ['class' => 'mt-2'])}}
                        {{Form::text('address', $data['app_profile']['address'], ['class' => 'form-control', 'placeholder' => 'Address'])}}
                        {{Form::label('country', 'Country', ['class' => 'mt-2'])}}
                        <select class="selectpicker form-control" name="country" id="country-select" data-live-search="true" title="Select a country">
                            @foreach ($data['countries'] as $country)
                                <option data-content='<i class="em em-flag-{{$country->country_code}}" aria-role="presentation" aria-label="{{$country->country_name}} Flag"></i><span class="align-middle pl-2">{{$country->country_name}}</span>' value="{{$country->id}}" @if ($country->id === $data['app_profile']['country_id']) selected @endif></option>
                            @endforeach
                        </select>
                        {{Form::label('nationality', 'Nationality', ['class' => 'mt-2'])}}
                        <select class="selectpicker form-control" name="nationality" id="" data-live-search="true" title="Select a nationality">
                            <option value="" selected>Select an option</option>
                            @foreach ($data['nationalities'] as $nationality)
                                <option value="{{$nationality->id}}" @if ($nationality->id === $data['app_profile']['nationality_id']) selected @endif>{{$nationality->nationality}}</option>  
                            @endforeach
                        </select>
                        {{Form::label('mobile_phone_no', 'Mobile Number', ['class' => 'mt-2'])}}
                        {{Form::text('mobile_phone_no', $data['app_profile']['mobile_phone_no'], ['class' => 'form-control', 'placeholder' => 'Mobile Number'])}}     
                    </div>
                    <div class="form-group">
                        {{Form::label('profile_picture', 'Change Profile Picture', ['class' => 'mt-2'])}}
                        {{Form::file('profile_picture')}}
                        {{Form::label('resume', 'Change Resume/CV', ['class' => 'mt-2'])}}
                        {{Form::file('resume')}}
                    </div>
                </div>
                <div class="col-md-12">
                    <h1>Work Experience</h1>
                    <div class="form-group">
                        {{Form::label('job_title', 'Job Title')}}
                        {{Form::text('job_title', $data['app_profile']['job_title'], ['class' => 'form-control', 'placeholder' => 'Job Title'])}}
                        {{Form::label('company_name', 'Company Name', ['class' => 'mt-2'])}}
                        {{Form::text('company_name', $data['app_profile']['company_name'], ['class' => 'form-control', 'placeholder' => 'Company Name'])}}
                        {{Form::label('start_date', 'Start Date', ['class' => 'mt-2'])}}
                        {{Form::date('start_date', $data['app_profile']['start_date'], ['class' => 'form-control'])}}
                        {{Form::label('end_date', 'End Date', ['class' => 'mt-2'])}}
                        @if ($data['app_profile']['end_date'])
                            {{Form::date('end_date', $data['app_profile']['end_date'], ['class' => 'form-control'])}}
                        @else
                            {{Form::date('end_date', '', ['class' => 'form-control', 'disabled' => 'disabled'])}}
                        @endif
                        {{Form::label('present', 'Present', ['class' => 'mt-2'])}}
                        @if (!$data['app_profile']['end_date'])
                            {{Form::checkbox('present', null, (old('present') ? false : true))}}
                        @else
                            {{Form::checkbox('present', '')}}
                        @endif
                        <br>
                        <div class="form-inline mt-2">
                            {{Form::label('salary', 'Salary')}}
                            <select class="selectpicker ml-2" name="currency" id="" data-live-search="true" title="Select a nationality">
                                <option value="" selected>Select an option</option>
                                @foreach ($data['currencies'] as $currency)
                                    <option value="{{$currency->id}}" @if ($currency->id === $data['app_profile']['currency_id']) selected @endif>{{$currency->currency}}</option>
                                @endforeach
                            </select>
                            {{Form::text('salary', $data['app_profile']['salary'], ['class' => 'form-control ml-2', 'placeholder' => 'Salary'])}}
                        </div>
                        {{Form::label('tasks', 'Tasks')}}
                        {{Form::textarea('tasks', $data['app_profile']['tasks'], ['id' => 'multi_editor', 'class' => 'form-control', 'placeholder' => 'List down your tasks and responsibilities here.', 'rows' => 10])}}
                    </div>
                </div>
                <div class="col-md-12">
                    <h1>Educational Background</h1>
                    <div class="form-group">
                        {{Form::label('university', 'College/University')}}
                        {{Form::text('university', $data['app_profile']['university'], ['class' => 'form-control', 'placeholder' => 'College/University'])}}
                        {{Form::label('degree', 'Degree')}}
                        <select class="selectpicker form-control" name="degree" id="" data-live-search="true" title="Select highest degree">
                            <option value="" selected>Select an option</option>
                            @foreach ($data['degrees'] as $degree)
                                <option value="{{$degree->id}}" @if ($degree->id === $data['app_profile']['degree_id']) selected @endif>{{$degree->degree}}</option>
                            @endforeach
                        </select>
                        {{Form::label('course', 'Course')}}
                        <select class="selectpicker form-control" name="course" id="" data-live-search="true" title="Select a course">
                            <option value="" selected>Select an option</option>
                            @foreach ($data['courses'] as $course)
                                <option value="{{$course->id}}" @if ($course->id === $data['app_profile']['course_id']) selected @endif>{{$course->course}}</option>
                            @endforeach
                        </select>
                        {{Form::label('univ_start_date', 'Start Date', ['class' => 'mt-2'])}}
                        {{Form::date('univ_start_date', $data['app_profile']['univ_start_date'], ['class' => 'form-control'])}}
                        {{Form::label('univ_end_date', 'Date of Graduation', ['class' => 'mt-2'])}}
                        {{Form::date('univ_end_date', $data['app_profile']['univ_end_date'], ['class' => 'form-control'])}}
                    </div>
                    {{Form::hidden('app_info_id', $data['app_profile']['id'])}}
                    {{Form::button('<i class="fas fa-edit mr-1"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary'])}}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection