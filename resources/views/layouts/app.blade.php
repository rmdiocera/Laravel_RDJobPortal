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

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/827dc3e5bf.js" crossorigin="anonymous"></script>

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
            @include('inc.modals')
            @yield('content')
            @include('components.who')
        </div>
    </div>
    <script>
        
        // Setting Selectpicker Bootstrap ver.
        $.fn.selectpicker.Constructor.BootstrapVersion = '4';
        
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Setting Emoji CSS as iconBase
            $('#country-select').attr('data-iconBase', 'em');

            // For disabling end date input when present checkbox checked
            $('#present').on('click', function(){
                if ($(this).is(':checked')) {
                    $('#end_date').attr('disabled', true);
                } else {
                    $('#end_date').attr('disabled', false);
                }
            });

            // Actions Modal
            let job_post_id;
            let comp_id;

            // Confirm Save
            let urlSave = '{{ route('user.save_job_post') }}';
            $(document).on('click', '.save-jp', function(){
                job_post_id = $(this).data('jp-id');
                comp_id = $(this).data('comp-id');

                $('#actionsModal').modal('show');
                $('.modal-title').text('Save Job Post');
                $('.modal-body').text('Are you sure you want to save this job post?');
                $('.modal-btn').attr('id', 'save');
            });

            $(document).on('click', '#save', function(e){
                e.preventDefault();
                
                $.ajax({
                    method: 'POST',
                    url: urlSave,
                    data: { 
                        job_post_id: job_post_id, 
                        comp_id: comp_id
                    },
                    success: function(data) {
                        let html = '';
                        
                        if (data.success) {
                            $('#actionsModal').modal('hide');
                            window.scrollTo(0, 0);
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#modal_alert').html(html);
                        }

                        if (data.error) {
                            // console.log(data.error);
                            $('#actionsModal').modal('hide');
                            window.scrollTo(0, 0);
                            html = '<div class="alert alert-warning">' + data.error + '</div>';
                            $('#modal_alert').html(html);
                        }
                    }
                });
            });

            // Confirm Unsave
            let saved_job_post_id;
            $(document).on('click', '.unsave-jp', function(){
                saved_job_post_id = $(this).data('saved-jp-id');

                $('#actionsModal').modal('show');
                $('.modal-title').text('Unsave Job Post');
                $('.modal-body').text('Are you sure you want to unsave this job post?');
                $('.modal-btn').attr('id', 'unsave');
            });

            $(document).on('click', '#unsave', function(e){
                e.preventDefault();
                
                $.ajax({
                    type: 'DELETE',
                    url: '/job-post/' + saved_job_post_id + '/unsave',
                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    success: function(data) {
                        let html = '';
                        
                        if (data.success) {
                            // Remove element
                            $('[data-card-id="' + saved_job_post_id + '"]').fadeOut(function(){ $(this).remove(); });
                            // Hide modal
                            $('#actionsModal').modal('hide');
                            // Bring to top
                            window.scrollTo(0, 0);
                            // Show alert
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#modal_alert').html(html);
                        }
                    }
                });
            });

            // Confirm Applying to Job Post
            let urlApply = '{{ route('user.apply_to_job_post') }}';
            $(document).on('click', '.apply-to-jp', function(){
                job_post_id = $(this).data('jp-id');
                comp_id = $(this).data('comp-id');

                $('#actionsModal').modal('show');
                $('.modal-title').text('Apply to Job Post');
                $('.modal-body').text('Are you sure you want to apply to this job post?');
                $('.modal-btn').attr('id', 'apply');
            });

            $(document).on('click', '#apply', function(e){
                e.preventDefault();
                
                $.ajax({
                    method: 'POST',
                    url: urlApply,
                    data: { 
                        job_post_id: job_post_id, 
                        comp_id: comp_id
                    },
                    success: function(data) {
                        let html = '';
                        
                        if (data.success) {
                            $('#actionsModal').modal('hide');
                            window.scrollTo(0, 0);
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#modal_alert').html(html);
                        }

                        if (data.error) {
                            // console.log(data.error);
                            $('#actionsModal').modal('hide');
                            window.scrollTo(0, 0);
                            html = '<div class="alert alert-warning">' + data.error + '</div>';
                            $('#modal_alert').html(html);
                        }
                    }
                });
            });

            // Confirm Withdrawing Application
            let job_post_app_id;
            $(document).on('click', '.withdraw-jp', function(){
                job_post_app_id = $(this).data('jp-app-id');

                $('#actionsModal').modal('show');
                $('.modal-title').text('Unsave Job Post');
                $('.modal-body').text('Are you sure you want to unsave this job post?');
                $('.modal-btn').attr('id', 'withdraw');
            });

            $(document).on('click', '#withdraw', function(e){
                e.preventDefault();
                
                $.ajax({
                    type: 'DELETE',
                    url: '/job-post/' + job_post_app_id + '/withdraw',
                    // headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    success: function(data) {
                        let html = '';
                        
                        if (data.success) {
                            // Remove element
                            $('[data-card-id="' + job_post_app_id + '"]').fadeOut(function(){ $(this).remove(); });
                            // Hide modal
                            $('#actionsModal').modal('hide');
                            // Bring to top
                            window.scrollTo(0, 0);
                            // Show alert
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#modal_alert').html(html);
                        }
                    }
                });
            });

            

            // View Applicant Info
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
                        html.applicant.forEach(applicant => {
                            let app_img = '<img src="/storage/app_profile_pictures/' + applicant.profile_picture + '" class="img-fluid app-img">';
                            $('.app-img').append(app_img);

                            let app_name = '<h5>' + applicant.first_name + " " + applicant.last_name + "</h5>";
                            let app_address = '<p><i class="fas fa-home mr-1"></i>Address: ' + applicant.address  + '</p>';
                            let app_email = '<p><i class="far fa-envelope mr-1"></i>E-mail Address:  ' + applicant.email + '</p>';
                            let app_phone = '<p><i class="fas fa-mobile-alt mr-1"></i> Phone Number: ' + applicant.mobile_phone_no  + '</p>';
                            $('.app-main-info').append(app_name, app_address, app_email, app_phone);

                            let app_work_heading = '<h5>Recent Work Experience</h5>';
                            let app_job_title = '<p><i class="fas fa-user-tie mr-1"></i>Job Title: ' + applicant.job_title  + '</p>';
                            let app_company_name = '<p><i class="fas fa-building mr-1"></i>Company Name: ' + applicant.company_name  + '</p>';
                            let app_emp_date;
                            if (!applicant.end_date) {
                                app_emp_date = '<p><i class="fas fa-calendar mr-1"></i>Date of Employment: ' + moment(applicant.start_date).format('LL') + " - Present" + '</p>';
                            } else {
                                app_emp_date = '<p><i class="fas fa-calendar mr-1"></i>Date of Employment: ' + moment(applicant.start_date).format('LL') + " - " + moment(applicant.end_date).format('LL') + '</p>';
                            }
                            let app_salary = '<p><i class="fas fa-money-bill mr-1"></i>Salary: ' + applicant.currency + " " + applicant.salary  + '</p>';

                            $('.app-work-exp').append(app_work_heading, app_job_title, app_company_name, app_emp_date, app_salary);

                            let app_educ_heading = '<h5>University/College Attended</h5>';
                            let app_univ ='<p><i class="fas fa-university mr-1"></i>College/University: ' + applicant.university  + '</p>';
                            let app_degree ='<p><i class="fas fa-graduation-cap mr-1"></i>Degree: ' + applicant.degree  + '</p>';
                            let app_course ='<p><i class="fas fa-book-open mr-1"></i></i>Course: ' + applicant.course  + '</p>';
                            let app_start_date = '<p><i class="fas fa-chalkboard mr-1"></i>Start Date: ' + moment(applicant.univ_start_date).format('LL') + '</p>';
                            let app_end_date = '<p><i class="fas fa-user-graduate mr-1"></i>Date of Graduation: ' + moment(applicant.univ_end_date).format('LL') + '</p>';

                            $('.app-educ-bg').append(app_educ_heading, app_univ, app_degree, app_course, app_start_date, app_end_date);
                        });
                    },
                    error: function() {
                        alert('There\'s an unexpected error.');
                    }
                });
            });

            $('#applicantInfoModal').on('hidden.bs.modal', function (e) {
                $('.app-img').empty();
                $('.app-main-info').empty();
                $('.app-work-exp').empty();
                $('.app-educ-bg').empty();
            });
        });
        
    </script>
</body>
</html>
