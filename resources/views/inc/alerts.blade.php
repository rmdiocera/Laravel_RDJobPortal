@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" id="alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif

@if (session('success'))
    <div class="alert alert-success" id="alert-success">
        {{session('success')}}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning" id="alert-warning">
        {{session('warning')}}
    </div>
@endif

<div id="modal_alert"></div>