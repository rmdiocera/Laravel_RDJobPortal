@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="card-title mb-0">Create Job Post</h1>  
        <hr class="modal-divider mb-2">
        {!! Form::open(['action' => 'JobPostsController@store', 'method' => 'POST']) !!}
            <div class="form-inline">
                <div class="form-group">
                    <select name="industry" id="" title="Industry" class="selectpicker border rounded border-secondary">
                        @foreach ($data['industries'] as $industry)
                            <option value="{{$industry->id}}" @if (old('industry') == $industry->id) selected="selected" @endif>{{$industry->industry}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group ml-2">
                    <select name="emp_type" id="" title="Employment Type" class="selectpicker border rounded border-secondary">
                        @foreach ($data['emp_types'] as $emp_type)
                            <option value="{{$emp_type->id}}" @if (old('emp_type') == $emp_type->id) selected="selected" @endif>{{$emp_type->emp_type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group ml-2">      
                    <select name="level" id="" title="Job Level" class="selectpicker border rounded border-secondary">
                        @foreach ($data['levels'] as $level)
                            <option value="{{$level->id}}" @if (old('level') == $level->id) selected="selected" @endif>{{$level->job_level}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group my-2">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Enter your job title here'])}}
                {{Form::label('description', 'Description', ['class' => 'mt-2'])}}
                {{Form::textarea('description', '', ['id' => 'multi_editor','class' => 'form-control', 'placeholder' => 'Enter the description here', 'rows' => 20])}}
            </div>
            {{Form::button('<i class="fas fa-check-circle mr-1"></i>Post', ['type' => 'submit', 'class' => 'btn btn-primary float-right'])}}
        {!! Form::close() !!}
    </div>
</div>
@endsection