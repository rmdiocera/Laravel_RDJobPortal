@extends('layouts.app')

@section('content')
    {{-- {!! Form::open(['action' => 'EmployersController@saveEmployerProfile', 'method' => 'POST']) !!}     --}}
        <div class="row">
            <div class="col-md-12">
                <h1>Build Your Profile</h1>
                <div class="form-group">
                    {{Form::label('first_name', 'First Name')}}
                    {{Form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'First Name'])}}
                    {{Form::label('last_name', 'Last Name', ['class' => 'mt-2'])}}
                    {{Form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Last Name'])}}
                    {{Form::label('age', 'Age', ['class' => 'mt-2'])}}
                    {{Form::text('age', '', ['class' => 'form-control', 'placeholder' => 'Age'])}}
                    {{Form::label('age', 'Gender', ['class' => 'mt-2'])}}
                    {{Form::text('age', '', ['class' => 'form-control', 'placeholder' => 'Gender'])}}
                    {{Form::label('address', 'Address', ['class' => 'mt-2'])}}
                    {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
                    {{Form::label('country', 'Country', ['class' => 'mt-2'])}}
                    <select class="selectpicker form-control" name="country" id="country-select" data-live-search="true" title="Select a country">
                        @foreach ($data['countries'] as $country)
                            <option data-content='<i class="em em-flag-{{$country->country_code}}" aria-role="presentation" aria-label="{{$country->country_name}} Flag"></i><span class="align-middle pl-2">{{$country->country_name}}</span>' value="{{$country->id}}"></option>
                        @endforeach
                    </select>
                    {{Form::label('nationality', 'Nationality', ['class' => 'mt-2'])}}
                    <select class="selectpicker form-control" name="nationality" id="" data-live-search="true" title="Select a nationality">
                        <option value="" selected>Select an option</option>
                        @foreach ($data['nationalities'] as $nationality)
                            <option value="{{$nationality->id}}">{{$nationality->nationality}}</option>
                        @endforeach
                    </select>
                    
                </div>
                
            </div>
            <div class="col-md-12">
                <h1>Work Experience</h1>
                <div class="form-group">
                    {{Form::label('job_title', 'Job Title')}}
                    {{Form::text('job_title', '', ['class' => 'form-control', 'placeholder' => 'Job Title'])}}
                    {{Form::label('company_name', 'Company Name', ['class' => 'mt-2'])}}
                    {{Form::text('company_name', '', ['class' => 'form-control', 'placeholder' => 'Company Name'])}}
                    {{Form::label('start_date', 'Start Date', ['class' => 'mt-2'])}}
                    {{Form::date('start_date', '', ['class' => 'form-control'])}}
                    {{Form::label('end_date', 'End Date', ['class' => 'mt-2'])}}
                    {{Form::date('end_date', '', ['class' => 'form-control'])}}
                    {{Form::label('present', 'Present', ['class' => 'mt-2'])}}
                    {{Form::checkbox('present', '')}}
                    <br>
                    <div class="form-inline mt-2">
                        {{Form::label('salary', 'Salary')}}
                        <select class="selectpicker" name="currency" id="" data-live-search="true" title="Select a nationality">
                            <option value="" selected>Select an option</option>
                            @foreach ($data['currencies'] as $currency)
                                <option value="{{$currency->id}}">{{$currency->currency}}</option>
                            @endforeach
                        </select>
                        {{Form::text('salary', '', ['class' => 'form-control', 'placeholder' => 'Salary'])}}
                    </div>
                    {{Form::label('tasks', 'Tasks')}}
                    {{Form::textarea('tasks', '', ['class' => 'form-control', 'placeholder' => 'List down your tasks and responsibilities here.', 'rows' => 20])}}
                </div>
                {{Form::submit('Submit', ['class' => 'btn btn-primary', 'value' => 'Post'])}}
            </div>
            <div class="col-md-12">
                <h1>Educational Background</h1>
                <div class="form-group">
                    
                </div>
            </div>
        </div>
    {{-- {!! Form::close() !!} --}}
@endsection