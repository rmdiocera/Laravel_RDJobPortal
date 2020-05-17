@extends('layouts.app')

@section('content')
    <h1>Create Job Post</h1>
    {!! Form::open(['action' => ['JobPostsController@update', $data['job_post']['id']], 'method' => 'PUT']) !!}
        <div class="form-inline">
            <div class="form-group">
                {{Form::label('industry', 'Industry')}}
                <select name="industry" id="">
                    @foreach ($data['industries'] as $industry)                    
                        <option value="{{$industry->id}}" @if ($industry->id === $data['job_post']['industry_id']) selected @endif>{{$industry->industry}}</option>
                        {{-- @if ($industry->id === $data['job_post']['industry_id'])
                            <option value="{{$industry->id}}" selected>{{$industry->industry}}</option>    
                        @else
                            <option value="{{$industry->id}}">{{$industry->industry}}</option>
                        @endif --}}
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {{Form::label('emp_type', 'Employment Type')}}
                <select name="emp_type" id="">
                    @foreach ($data['emp_types'] as $emp_type)
                        <option value="{{$emp_type->id}}" @if ($emp_type->id === $data['job_post']['emp_type_id']) selected @endif>{{$emp_type->emp_type}}</option>
                        {{-- @if ($emp_type->id === $data['job_post']['emp_type_id'])
                            <option value="{{$emp_type->id}}" selected>{{$emp_type->emp_type}}</option>
                        @else
                            <option value="{{$emp_type->id}}">{{$emp_type->emp_type}}</option>
                        @endif --}}
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {{Form::label('level', 'Job Level')}}
                <select name="level" id="">
                    @foreach ($data['levels'] as $level) 
                        <option value="{{$level->id}}" @if ($level->id === $data['job_post']['level_id']) selected @endif>{{$level->job_level}}</option>
                        {{-- @if ($level->id === $data['job_post']['level_id']) 
                            <option value="{{$level->id}}" selected>{{$level->job_level}}</option>
                        @else
                            <option value="{{$level->id}}">{{$level->job_level}}</option>
                        @endif --}}
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $data['job_post']['title'], ['class' => 'form-control', 'placeholder' => 'Enter your job title here'])}}
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', $data['job_post']['desc'], ['id' => 'multi_editor', 'class' => 'form-control', 'placeholder' => 'Enter the description here', 'rows' => 20])}}
        </div>
        {{Form::button('<i class="fas fa-check-circle mr-1"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary'])}}
        {{-- {{Form::submit('Submit', ['class' => 'btn btn-primary', 'value' => 'Post'])}} --}}
    {!! Form::close() !!}
@endsection