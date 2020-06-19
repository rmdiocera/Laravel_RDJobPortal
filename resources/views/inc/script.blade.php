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
                        window.location = data.url;
                    }

                    if (data.success) {
                        $('#actionsModal').modal('hide');
                        window.scrollTo(0, 0);
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }

                    if (data.error) {
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
                        window.location = data.url;
                    }
                    
                    if (data.success) {
                        $('#actionsModal').modal('hide');
                        window.scrollTo(0, 0);
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#modal_alert').html(html).show().fadeOut(3000);
                    }

                    if (data.error) {
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
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
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
                success: function(data) {
                    let html = '';
                    
                    if (data.success) {
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
    });
    
</script>