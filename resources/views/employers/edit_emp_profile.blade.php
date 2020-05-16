@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => ['EmployersController@updateEmployerProfile', $data['emp_profile']['comp_id']], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}    
        <div class="row">
            <div class="col-md-12">
                <h1>Build Your Profile</h1>
                <div class="form-group">
                    {{Form::label('company_name', 'Company Name')}}
                    {{Form::text('company_name', $data['emp_profile']['company_name'], ['class' => ['form-control'], 'placeholder' => 'Company Name'])}}
                    {{Form::label('industry', 'Industry', ['class' => 'mt-2'])}}
                    <select name="industry" id="" class="custom-select">
                        {{-- <option value="">Select an option</option> --}}
                        @foreach ($data['industries'] as $industry)
                            @if ($industry->id === $data['emp_profile']['industry_id'])
                                <option value="{{$industry->id}}" selected>{{$industry->industry}}</option>
                            @else
                                <option value="{{$industry->id}}">{{$industry->industry}}</option>
                            @endif
                        @endforeach
                    </select>
                    {{Form::label('address', 'Address', ['class' => 'mt-2'])}}
                    {{Form::text('address', $data['emp_profile']['address'], ['class' => 'form-control', 'placeholder' => 'Address'])}}
                </div>
                <div class="form-group">
                    {{Form::label('profile_picture', 'Change Company Logo', ['class' => 'mt-2'])}}
                    {{Form::file('profile_picture')}}
                </div>
            </div>
            <div class="col-md-12">
                <h1>Other Information</h1>
                <div class="form-group">
                    {{Form::label('website_link', 'Website Link')}}
                    {{Form::text('website_link', $data['emp_profile']['website_link'], ['class' => 'form-control', 'placeholder' => 'Website Link'])}}
                    <small class="form-text text-muted">Leave blank if not applicable.</small>
                    {{Form::label('company_size', 'Company Size', ['class' => 'mt-2'])}}
                    {{Form::text('company_size', $data['emp_profile']['company_size'], ['class' => 'form-control', 'placeholder' => 'Company Size'])}}
                    {{Form::label('benefits', 'Benefits', ['class' => 'mt-2'])}}
                    {{Form::text('benefits', $data['emp_profile']['benefits'], ['class' => 'form-control', 'placeholder' => 'Benefits'])}}
                    {{Form::label('dress_code', 'Dress Code', ['class' => 'mt-2'])}}
                    {{Form::text('dress_code', $data['emp_profile']['dress_code'], ['class' => 'form-control', 'placeholder' => 'Dress Code'])}}
                    {{Form::label('spoken_language', 'Spoken Language', ['class' => 'mt-2'])}}
                    {{Form::text('spoken_language', $data['emp_profile']['spoken_language'], ['class' => 'form-control', 'placeholder' => 'Spoken Language'])}}
                    {{Form::label('work_hours', 'Work Hours', ['class' => 'mt-2'])}}
                    {{Form::text('work_hours', $data['emp_profile']['work_hours'], ['class' => 'form-control', 'placeholder' => 'Work Hours'])}}
                    {{Form::label('avg_processing_time', 'Average Processing Time', ['class' => 'mt-2'])}}
                    {{Form::text('avg_processing_time', $data['emp_profile']['avg_processing_time'], ['class' => 'form-control', 'placeholder' => 'Average Processing Time'])}}
                </div>
                {{Form::button('<i class="fas fa-check-circle mr-1"></i>Save', ['type' => 'submit', 'class' => 'btn btn-sm btn-primary'])}}
                {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary', 'value' => 'Save'])}} --}}
            </div>
        </div>
    {!! Form::close() !!}
@endsection