@extends('layouts.app')

@section('content')
    {!! Form::open(['action' => 'EmployersController@saveEmployerProfile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}    
        <div class="row">
            <div class="col-md-12">
                <h1>Build Your Profile</h1>
                <div class="form-group">
                    {{Form::label('company_name', 'Company Name')}}
                    {{Form::text('company_name', '', ['class' => ['form-control'], 'placeholder' => 'Company Name'])}}
                    {{Form::label('company_overview', 'Overview')}}
                    {{Form::textarea('company_overview', '', ['id' => 'multi_editor', 'class' => 'form-control', 'placeholder' => 'Put details about your company here.', 'rows' => 10])}}
                    {{Form::label('industry', 'Industry', ['class' => 'mt-2'])}}
                    <select name="industry" id="" class="custom-select">
                        {{-- <option value="">Select an option</option> --}}
                        @foreach ($industries as $industry)
                            <option value="{{$industry->id}}">{{$industry->industry}}</option>
                        @endforeach
                    </select>
                    {{Form::label('address', 'Address', ['class' => 'mt-2'])}}
                    {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
                    {{-- {{Form::label('description', 'Description')}}
                    {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Enter the description here', 'rows' => 20])}} --}}
                </div>
                <div class="form-group">
                    {{Form::label('profile_picture', 'Add Company Logo', ['class' => 'mt-2'])}}
                    {{Form::file('profile_picture')}}
                </div>
            </div>
            <div class="col-md-12">
                <h1>Other Information</h1>
                <div class="form-group">
                    {{Form::label('website_link', 'Website Link')}}
                    {{Form::text('website_link', '', ['class' => 'form-control', 'placeholder' => 'Website Link'])}}
                    <small class="form-text text-muted">Leave blank if not applicable.</small>
                    {{Form::label('company_size', 'Company Size', ['class' => 'mt-2'])}}
                    {{Form::text('company_size', '', ['class' => 'form-control', 'placeholder' => 'Company Size'])}}
                    {{Form::label('benefits', 'Benefits', ['class' => 'mt-2'])}}
                    {{Form::text('benefits', '', ['class' => 'form-control', 'placeholder' => 'Benefits'])}}
                    {{Form::label('dress_code', 'Dress Code', ['class' => 'mt-2'])}}
                    {{Form::text('dress_code', '', ['class' => 'form-control', 'placeholder' => 'Dress Code'])}}
                    {{Form::label('spoken_language', 'Spoken Language', ['class' => 'mt-2'])}}
                    {{Form::text('spoken_language', '', ['class' => 'form-control', 'placeholder' => 'Spoken Language'])}}
                    {{Form::label('work_hours', 'Work Hours', ['class' => 'mt-2'])}}
                    {{Form::text('work_hours', '', ['class' => 'form-control', 'placeholder' => 'Work Hours'])}}
                    {{Form::label('avg_processing_time', 'Average Processing Time', ['class' => 'mt-2'])}}
                    {{Form::text('avg_processing_time', '', ['class' => 'form-control', 'placeholder' => 'Average Processing Time'])}}
                </div>
                {{Form::button('<i class="fas fa-check-circle mr-1"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary'])}}
                {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary', 'value' => 'Post'])}} --}}
            </div>
        </div>
    {!! Form::close() !!}
@endsection