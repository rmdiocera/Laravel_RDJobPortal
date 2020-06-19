@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="card-title mb-0">Build Your Company Profile</h1>
        <hr class="modal-divider my-1">
        {!! Form::open(['action' => 'EmployersController@saveEmployerProfile', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}    
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('company_name', 'Company Name')}}
                        {{Form::text('company_name', '', ['class' => ['form-control'], 'placeholder' => 'Company Name'])}}
                        {{Form::label('company_overview', 'Overview', ['class' => 'mt-2'])}}
                        {{Form::textarea('company_overview', '', ['id' => 'multi_editor', 'class' => 'form-control', 'placeholder' => 'Put details about your company here.', 'rows' => 10])}}
                        {{Form::label('industry', 'Industry', ['class' => 'mt-2'])}}
                        <select class="selectpicker form-control" name="industry" id="" data-live-search="true" title="Select an industry">
                            @foreach ($industries as $industry)
                                <option value="{{$industry->id}}">{{$industry->industry}}</option>
                            @endforeach
                        </select>
                        {{Form::label('address', 'Address', ['class' => 'mt-2'])}}
                        {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
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
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection