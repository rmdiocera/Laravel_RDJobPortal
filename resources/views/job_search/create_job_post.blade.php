@extends('layouts.app')

@section('content')
    <h1>Create Job Post</h1>
    {!! Form::open(['action' => 'JobPostsController@store', 'method' => 'POST']) !!}
        <div class="form-inline">
            <div class="form-group">
                {{Form::label('industry', 'Industry')}}
                <select name="industry" id="">
                    @foreach ($data['industries'] as $industry)
                        <option value="{{$industry->id}}">{{$industry->industry}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group ml-2">
                {{Form::label('emp_type', 'Employment Type')}}
                <select name="emp_type" id="">
                    @foreach ($data['emp_types'] as $emp_type)
                        <option value="{{$emp_type->id}}">{{$emp_type->emp_type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group ml-2">
                {{Form::label('level', 'Job Level')}}
                <select name="level" id="">
                    @foreach ($data['levels'] as $level)
                        <option value="{{$level->id}}">{{$level->job_level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Enter your job title here'])}}
            {{Form::label('description', 'Description')}}
            {{Form::textarea('description', '', ['id' => 'multi_editor','class' => 'form-control', 'placeholder' => 'Enter the description here', 'rows' => 20])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary', 'value' => 'Post'])}}
    {!! Form::close() !!}
@endsection