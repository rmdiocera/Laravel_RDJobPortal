@extends('layouts.app')

@section('content')
    <h1 class="indigo">Welcome to the Job Portal</h1>
    {!! Form::open(['action' => 'PagesController@showJobPosts', 'method' => 'GET']) !!}
        <div class="input-group">
            {{Form::text('search', '', ['class' => 'form-control', 'placeholder' => 'Search jobs', 'required'])}}
            <div class="input-group-append">
                {{Form::submit('Search', ['class' => 'btn btn-primary'])}}
            </div>
        </div>
    {!! Form::close() !!}
@endsection