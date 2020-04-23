<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Job Portal') }}</title>

    <!-- Scripts -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js'></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    
    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    {{-- Bootstrap Select --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    {{-- Bootstrap Tables --}}
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
    {{-- Emoji CSS --}}
    <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('inc.navbar')
        <div class="container mt-4">
            @include('inc.alerts')
            @yield('content')
            @include('components.who')
        </div>
    </div>
    <script>
        $.fn.selectpicker.Constructor.BootstrapVersion = '4';

        $('#country-select').attr('data-iconBase', 'em');

        $('#country-select').on('change', function() {
            var test = $('#country-select').val();
            console.log(test);
        });

        $('#present').on('click', function(){
            if ($(this).is(':checked')) {
                $('#end_date').attr('disabled', true);
            } else {
                $('#end_date').attr('disabled', false);
            }
        });

        $(function(){
            $(document).on('click', '.show_app_info', function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            
            $('#applicantInfoModal').modal('show');
            $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '/app-info/'+id,
                    dataType: 'json',
                    success: function(html) {
                        $('.app-info').append('<img src="/storage/app_profile_pictures/' + html.applicant.profile_picture + '" class="img-fluid">');
                    },
                    error: function() {
                        alert('There\'s an unexpected error.');
                    }
                });
            });

            $('#applicantInfoModal').on('hidden.bs.modal', function (e) {
                $('.app-info').empty();
            });
        });
        
    </script>
</body>
</html>
