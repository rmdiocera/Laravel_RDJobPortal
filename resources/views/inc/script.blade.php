<script>
    // Initialize CKEditor
    CKEDITOR.replace( 'multi_editor' );

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

        // fadeOut for alerts not coming from JSON responses 
        $('#alert-success').fadeOut(3000);

        $('#alert-warning').fadeOut(3000);

        setTimeout(function() {
            if ($('.alert-danger').is(':visible')) {
                $('.alert-danger').fadeOut(3000);
            }
        }, 5000);

        // For disabling end date input when present checkbox checked
        $('#present').on('click', function() {
            if ($(this).is(':checked')) {
                $('#end_date').val("").attr('disabled', true);
            } else {
                $('#end_date').attr('disabled', false);
            }
        });

        // Disabling end date input if checkbox already checked
        if ($('#present').is(':checked')) {
                $('#end_date').attr('disabled', true);
            } else {
                $('#end_date').attr('disabled', false);
        }

        // Front Page Applicant/Employer Login
        $('#btn-app-login, #back-to-app-login').click(function(){
            $('#index-app-login').removeClass('d-none').show();
            $('#index-app-register').addClass('d-none');
            $('#index-emp-login').addClass('d-none');
            $('#index-emp-register').addClass('d-none');
            return false;
        });

        $('#link-app-register').click(function(){
            $('#index-app-register').removeClass('d-none').show();
            $('#index-app-login').addClass('d-none');
            $('#index-emp-login').addClass('d-none');
            $('#index-emp-register').addClass('d-none');
            return false;
        });

        $('#btn-emp-login, #back-to-emp-login').click(function(){
            $('#index-emp-login').removeClass('d-none').show();
            $('#index-emp-register').addClass('d-none');
            $('#index-app-login').addClass('d-none');
            $('#index-app-register').addClass('d-none');
            return false;
        });

        $('#link-emp-register').click(function(){
            $('#index-emp-register').removeClass('d-none').show();
            $('#index-app-login').addClass('d-none');
            $('#index-emp-login').addClass('d-none');
            $('#index-app-register').addClass('d-none');
            return false;
        });

        // Modal variables
        let job_post_id;
        let comp_id;
        let job_post_app_id;
        let saved_job_post_id;

        // Applicant Actions Modal
        // Confirm Save
        let urlSave = '{{ route('user.save_job_post') }}';
        $(document).on('click', '.save-jp', function(){
            let status = '{{Auth::guard('web')->check()}}';
            if (!status) {
                window.location.href = '{{route('login')}}';
            } else {
                job_post_id = $(this).data('jp-id');
                comp_id = $(this).data('comp-id');

                $('#actionsModal').modal('show');
                $('.modal-title').text('Save Job Post');
                $('.modal-body').text('Are you sure you want to save this job post?');
                $('.modal-btn').attr('id', 'save');
            }
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
                    
                    // Redirect user to create profile page
                    if (data.url) {
                        $('#actionsModal').modal('hide');
                        // console.log(data.url + "/0");
                        window.location = data.url;
                        // html = '<div class="alert alert-warning">' + data.message + '</div>';
                        // $('#modal_alert').html(html).show().fadeOut(3000);
                    }

                    if (data.success) {
                        $('#actionsModal').modal('hide');
                        window.scrollTo(0, 0);
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }

                    if (data.error) {
                        // console.log(data.error);
                        $('#actionsModal').modal('hide');
                        window.scrollTo(0, 0);
                        html = '<div class="alert alert-warning">' + data.error + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // Confirm Unsave
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
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // Confirm Applying to Job Post
        let urlApply = '{{ route('user.apply_to_job_post') }}';
        $(document).on('click', '.apply-to-jp', function(){
            let status = '{{Auth::guard('web')->check()}}';
            if (!status) {
                window.location.href = '{{route('login')}}';
            } else {
                job_post_id = $(this).data('jp-id');
                comp_id = $(this).data('comp-id');

                $('#actionsModal').modal('show');
                $('.modal-title').text('Apply to Job Post');
                $('.modal-body').text('Are you sure you want to apply to this job post?');
                $('.modal-btn').attr('id', 'apply');
            }
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

                    // Redirect user to create profile page
                    if (data.url) {
                        $('#actionsModal').modal('hide');
                        // console.log(data.url + "/0");
                        window.location = data.url;
                        // html = '<div class="alert alert-warning">' + data.message + '</div>';
                        // $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                    
                    if (data.success) {
                        $('#actionsModal').modal('hide');
                        window.scrollTo(0, 0);
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }

                    if (data.error) {
                        // console.log(data.error);
                        $('#actionsModal').modal('hide');
                        window.scrollTo(0, 0);
                        html = '<div class="alert alert-warning">' + data.error + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // Confirm Withdrawing Application
        $(document).on('click', '.withdraw-jp', function(){
            job_post_app_id = $(this).data('jp-app-id');

            $('#actionsModal').modal('show');
            $('.modal-title').text('Unsave Job Post');
            $('.modal-body').text('Are you sure you want to withdraw your application to this job post?');
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
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // Confirm Accepting Interview Invitation
        $(document).on('click', '.accept-int', function(){
            job_post_app_id = $(this).data('jp-app-id');

            $('#actionsModal').modal('show');
            $('.modal-title').text('Accept Interview Invitation');
            $('.modal-body').text('Are you sure you want to accept the interview invitation?');
            $('.modal-btn').attr('id', 'accept');
        });

        $(document).on('click', '#accept', function(e){
            e.preventDefault();
            
            $.ajax({
                type: 'PUT',
                url: '/accept/' + job_post_app_id,
                // headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
                        // Change status on span element
                        $('[data-jp-app-status-id="' + job_post_app_id + '"]').html('<span class="badge badge-success app-status-text">' + data.status + '</span>');
                        // Hide modal
                        $('#actionsModal').modal('hide');
                        // Bring to top
                        window.scrollTo(0, 0);
                        // Show alert
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });
        
        // Confirm Rejecting Interview Invitation
        $(document).on('click', '.decline-int', function(){
            job_post_app_id = $(this).data('jp-app-id');

            $('#actionsModal').modal('show');
            $('.modal-title').text('Reject Interview Invitation');
            $('.modal-body').text('Are you sure you want to reject the interview invitation?');
            $('.modal-btn').attr('id', 'decline');
        });

        $(document).on('click', '#decline', function(e){
            e.preventDefault();
            
            $.ajax({
                type: 'PUT',
                url: '/decline/' + job_post_app_id,
                // headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
                        // Change status on span element
                        $('[data-jp-app-status-id="' + job_post_app_id + '"]').html('<span class="badge badge-secondary app-status-text">' + data.status + '</span>');
                        // Hide modal
                        $('#actionsModal').modal('hide');
                        // Bring to top
                        window.scrollTo(0, 0);
                        // Show alert
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // Employer Actions Modal
        // Delete Job Post
        $(document).on('click', '.delete-jp', function(){
            job_post_id = $(this).data('jp-id');

            $('#actionsModal').modal('show');
            $('.modal-title').text('Delete Job Post');
            $('.modal-body').text('Are you sure you want to delete this job post?');
            $('.modal-btn').attr('id', 'destroy');
        });

        $(document).on('click', '#destroy', function(e){
            e.preventDefault();
            
            $.ajax({
                type: 'DELETE',
                url: '/destroy/' + job_post_id,
                // headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
                        // Remove element
                        $('[data-card-id="' + job_post_id + '"]').fadeOut(function(){ $(this).remove(); });
                        // Hide modal
                        $('#actionsModal').modal('hide');
                        // Bring to top
                        window.scrollTo(0, 0);
                        // Show alert
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        let table = $('#app-table').DataTable({
            "language": {
                "search": '<i class="fas fa-search mr-1"></i>'
            },
            "columnDefs": [
                { "orderable": false, "targets": [1, 2, 3] }
            ],
            "drawCallback": function() {
                $('#app-table th').addClass('text-center');
                $('#app-table_filter input').attr('placeholder', 'Search...');
                // $('#app-table_length label').addClass('form-inline');
                // $('#app-table_length select').addClass('form-control form-control-sm mb-0 mx-1');
                // $('#app-table_filter label').addClass('form-inline');
                // $('#app-table_paginate').addClass('pagination pagination-sm');
                // $('#app-table_paginate a').addClass('page-item page-link');
            }
        });

        // Confirm Inviting Applicant to Interview
        $(document).on('click', '.invite-app', function(){
            job_post_app_id = $(this).data('jp-app-id');

            $('#actionsModal').modal('show');
            $('#actionsModal .modal-title').text('Invite Applicant to Interview');
            $('#actionsModal .modal-body').text('Are you sure you want to invite this applicant for the interview?');
            $('#actionsModal .modal-btn').attr('id', 'invite');
        });

        $(document).on('click', '#invite', function(e){
            e.preventDefault();
            
            $.ajax({
                type: 'PUT',
                url: '/invite/' + job_post_app_id,
                // headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
                        // Reload table
                        // table.ajax.reload(null, false);
                        // // Change status on table cell
                        $('[data-jp-app-status-id="' + job_post_app_id + '"]').html('<span class="badge badge-success app-status-text align-middle">' + data.status + '</span>');
                        // Hide modal
                        $('#actionsModal').modal('hide');
                        // Bring to top
                        window.scrollTo(0, 0);
                        // Show alert
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // Confirm Rejecting Applicant's Application
        $(document).on('click', '.reject-app', function(){
            job_post_app_id = $(this).data('jp-app-id');

            $('#actionsModal').modal('show');
            $('#actionsModal .modal-title').text('Reject Application');
            $('#actionsModal .modal-body').text('Are you sure you want to reject this applicant\'s application?');
            $('#actionsModal .modal-btn').attr('id', 'reject');
        });

        $(document).on('click', '#reject', function(e){
            e.preventDefault();
            
            $.ajax({
                type: 'PUT',
                url: '/reject/' + job_post_app_id,
                // headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
                        // Reload table
                        // table.ajax.reload(null, false);
                        // Change status on table cell
                        $('[data-jp-app-status-id="' + job_post_app_id + '"]').html('<span class="badge badge-secondary app-status-text align-middle">' + data.status + '</span>');
                        // Hide modal
                        $('#actionsModal').modal('hide');
                        // Bring to top
                        window.scrollTo(0, 0);
                        // Show alert
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }
                }
            });
        });

        // View Applicant Info
        // $(document).on('click', '.show_app_info', function(e){
        // e.preventDefault();
        // let id = $(this).attr('id');
        
        // $('#applicantInfoModal').modal('show');
        // $.ajax({
        //         type: 'ajax',
        //         method: 'get',
        //         url: '/app-info/'+id,
        //         dataType: 'json',
        //         success: function(html) {
        //             html.applicant.forEach(applicant => {
        //                 let app_img = '<img src="/storage/app_profile_pictures/' + applicant.profile_picture + '" class="img-fluid app-img">';
        //                 $('.app-img').append(app_img);

        //                 let app_name = '<h5>' + applicant.first_name + " " + applicant.last_name + "</h5>";
        //                 let app_address = '<p><i class="fas fa-home mr-1"></i>Address: ' + applicant.address  + '</p>';
        //                 let app_email = '<p><i class="far fa-envelope mr-1"></i>E-mail Address:  ' + applicant.email + '</p>';
        //                 let app_phone = '<p><i class="fas fa-mobile-alt mr-1"></i> Phone Number: ' + applicant.mobile_phone_no  + '</p>';
        //                 $('.app-main-info').append(app_name, app_address, app_email, app_phone);

        //                 let app_work_heading = '<h5>Most Recent Work Experience</h5>';
        //                 let app_job_title = '<p><i class="fas fa-user-tie mr-1"></i>Job Title: ' + applicant.job_title  + '</p>';
        //                 let app_company_name = '<p><i class="fas fa-building mr-1"></i>Company Name: ' + applicant.company_name  + '</p>';
        //                 let app_emp_date;
        //                 if (!applicant.end_date) {
        //                     app_emp_date = '<p><i class="fas fa-calendar mr-1"></i>Date of Employment: ' + moment(applicant.start_date).format('LL') + " - Present" + '</p>';
        //                 } else {
        //                     app_emp_date = '<p><i class="fas fa-calendar mr-1"></i>Date of Employment: ' + moment(applicant.start_date).format('LL') + " - " + moment(applicant.end_date).format('LL') + '</p>';
        //                 }
        //                 let app_salary = '<p><i class="fas fa-money-bill mr-1"></i>Salary: ' + applicant.currency + " " + applicant.salary  + '</p>';
        //                 let app_tasks = '<div><i class="fas fa-tasks mr-1"></i>Tasks/Responsibilities: ' + applicant.tasks  + '</div>';
        //                 $('.app-work-exp').append(app_work_heading, app_job_title, app_company_name, app_emp_date, app_salary, app_tasks);

        //                 let app_educ_heading = '<h5>University/College Attended</h5>';
        //                 let app_univ ='<p><i class="fas fa-university mr-1"></i>College/University: ' + applicant.university  + '</p>';
        //                 let app_degree ='<p><i class="fas fa-graduation-cap mr-1"></i>Degree: ' + applicant.degree  + '</p>';
        //                 let app_course ='<p><i class="fas fa-book-open mr-1"></i>Course: ' + applicant.course  + '</p>';
        //                 let app_start_date = '<p><i class="fas fa-chalkboard mr-1"></i>Start Date: ' + moment(applicant.univ_start_date).format('LL') + '</p>';
        //                 let app_end_date = '<p><i class="fas fa-user-graduate mr-1"></i>Date of Graduation: ' + moment(applicant.univ_end_date).format('LL') + '</p>';

        //                 $('.app-educ-bg').append(app_educ_heading, app_univ, app_degree, app_course, app_start_date, app_end_date);
        //             });
        //         },
        //         error: function() {
        //             alert('There\'s an unexpected error.');
        //         }
        //     });
        // });

        // $('#applicantInfoModal').on('hidden.bs.modal', function (e) {
        //     $('.app-img').empty();
        //     $('.app-main-info').empty();
        //     $('.app-work-exp').empty();
        //     $('.app-educ-bg').empty();
        // });

        // View Applicant Info
        // $(document).on('click', '.show_emp_info', function(e){
        // e.preventDefault();
        // let id = $(this).attr('id');
        
        // $('#companyInfoModal').modal('show');
        // $.ajax({
        //         type: 'ajax',
        //         method: 'get',
        //         url: '/emp-info/'+id,
        //         dataType: 'json',
        //         success: function(html) {
        //             html.company.forEach(company => {
        //                 let comp_img = '<img src="/storage/emp_profile_pictures/' + company.profile_picture + '" class="img-fluid app-img">';
        //                 $('.comp-img').append(comp_img);

        //                 let comp_name = '<h5>' + company.company_name + "</h5>";
        //                 let comp_ind = '<p><i class="fas fa-industry mr-1"></i>Industry:  ' + company.industry + '</p>';
        //                 let comp_address = '<p><i class="fas fa-home mr-1"></i>Address: ' + company.address  + '</p>';
                        
        //                 if (company.website_link) {
        //                     let comp_website = '<p><i class="fas fa-globe-americas mr-1"></i> Phone Number: ' + company.website_link  + '</p>';
        //                     $('.comp-main-info').append(comp_name, comp_ind, comp_address, comp_website);
        //                 } else {
        //                     $('.comp-main-info').append(comp_name, comp_ind, comp_address);
        //                 }
                        
                        
        //                 let comp_other_heading = '<h5>Other Information</h5>';
        //                 let comp_size ='<p><i class="fas fa-users mr-1"></i>Company Size: ' + company.company_size  + '</p>';
        //                 let comp_benefits ='<p><i class="fas fa-gift mr-1"></i>Benefits: ' + company.benefits  + '</p>';
        //                 let comp_dress_code ='<p><i class="fas fa-tshirt mr-1"></i>Dress Code: ' + company.dress_code  + '</p>';
        //                 let comp_spoken_language ='<p><i class="fas fa-language mr-1"></i>Spoken Language: ' + company.spoken_language  + '</p>';
        //                 let comp_work_hours ='<p><i class="far fa-clock mr-1"></i>Work Hours: ' + company.work_hours  + '</p>';
        //                 let comp_avg_proc_time ='<p><i class="fas fa-stopwatch mr-1"></i>Average Processing Time: ' + company.avg_processing_time  + '</p>';
        //                 $('.comp-other-info').append(comp_other_heading, comp_size, comp_benefits, comp_dress_code, comp_spoken_language, comp_work_hours, comp_avg_proc_time);
        //             });
        //         },
        //         error: function() {
        //             alert('There\'s an unexpected error.');
        //         }
        //     });
        // });

        // $('#companyInfoModal').on('hidden.bs.modal', function (e) {
        //     $('.comp-img').empty();
        //     $('.comp-main-info').empty();
        //     $('.comp-other-info').empty();
        // });
    });
    
</script>