@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="card-title mb-0">Edit Job Post</h1>  
        <hr class="modal-divider mb-2">
        {!! Form::open(['action' => ['JobPostsController@update', $data['job_post']['id']], 'method' => 'PUT']) !!}
            <div class="form-inline">
                <div class="form-group">
                    <select name="industry" id="" class="selectpicker border rounded border-secondary">
                        @foreach ($data['industries'] as $industry)                    
                            <option value="{{$industry->id}}" @if ($industry->id === $data['job_post']['industry_id']) selected @endif>{{$industry->industry}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group ml-2">
                    <select name="emp_type" id="" class="selectpicker border rounded border-secondary">
                        @foreach ($data['emp_types'] as $emp_type)
                            <option value="{{$emp_type->id}}" @if ($emp_type->id === $data['job_post']['emp_type_id']) selected @endif>{{$emp_type->emp_type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group ml-2">
                    <select name="level" id="" class="selectpicker border rounded border-secondary">
                        @foreach ($data['levels'] as $level) 
                            <option value="{{$level->id}}" @if ($level->id === $data['job_post']['level_id']) selected @endif>{{$level->job_level}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group my-2">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $data['job_post']['title'], ['class' => 'form-control', 'placeholder' => 'Enter your job title here'])}}
                {{Form::label('description', 'Description', ['class' => 'mt-2'])}}
                {{Form::textarea('description', $data['job_post']['desc'], ['id' => 'multi_editor', 'class' => 'form-control', 'placeholder' => 'Enter the description here', 'rows' => 20])}}
            </div>
            {{Form::button('<i class="fas fa-check-circle mr-1"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary float-right'])}}
        {!! Form::close() !!}
    </div>
</div>
@endsection