jQuery( function( $ ) {

    const igj_jobs = {
        $job_section: $('.igj_jobs'),
        $pagination_section: $('.igj_pagination'),
        page: 1,
        length: 10,
        jobsTotal: 0,
        $cities: $('#igj_cities'),
        $states: $('#igj_states'),
        $job_categories: $('#igj_job_categories'),
        $job_search: $('#job_search'),
        $get_jobs_btn: $('#get_jobs_btn'),
        $sort: $('#job_ordering'),
        $current_location: $('#current_location'),
        init: function () {

            this.getJobs(10, 0, 1);
            $('.igj_pagination').on('click', '.page-item', this.pageNavigation);

            this.$get_jobs_btn.on('click', this.getJobsReload);
            this.$sort.on('change', this.getJobs);
            this.$current_location.on('change', this.currentLocation);
           // this.$job_categories.on('change', this.getJobs);

            $('#job_search').on('keyup', this.getJobSuggestion);

            $(document).on('click', this.closeResultsBody );

            $('.job-result-wrapper').on('click', '.job-suggestion', this.jobSuggestionHandler);

            this.$states.on('change', this.getCities);
            


        },
        getCities: function(){
            $('#igj_cities').attr('disabled');
            $('#igj_cities').empty();
            $('#igj_cities').append('<option value="all">All Cities</option>');
            $.ajax( {
                type: 'POST',
                url:  parameters.ajax_url,
                data:{
                    action: 'igj_job_cities',
                    state: $(this).val(),
                },
                dataType: "json",
                success: function (response) {
                    let cities = response.cities;
                    if(cities.length > 0){
                        for(let i = 0; i < cities.length; i++){
                            $('#igj_cities').append('<option value="'+ cities[i].term_id +'">'+cities[i].name+'</option>');
                            $('#igj_cities').removeAttr('disabled')
                        }
                    }

                },
                error : function(jqXHR, exception){
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg)
                }

            });
        },
        closeResultsBody: function(e){
            if ($(e.target).closest(".job-result-wrapper").length === 0) {
                $(".job-result-wrapper").hide();
            }
        },
        jobSuggestionHandler: function(e){
            let name = $(this).data('name');

            $('#job_search').val(name);
            $('.job-result-wrapper').hide();

        },
        getJobSuggestion: function(){
            let $result_wrapper = $('.job-result-wrapper');

            $result_wrapper.show();

            if (window.xhr) { // if any previous ajaxRequest is running, abort
                window.xhr.abort();
            }

            window.xhr = $.ajax( {
                type: 'POST',
                url:  parameters.ajax_url,
                data:{
                    action: 'igj_job_suggestion',
                    search: $('#job_search').val(),
                },
                dataType: "json",
                beforeSend: function () {

                    $result_wrapper.empty().append('<p>Loading...</p>');
                },
                complete: function () {
                },
                success: function (response) {
                    let jobs = response.jobs;
                    $('.autocomplete-results').css('display', 'block');
                    $result_wrapper.empty();
                    if(jobs.length > 0){

                        for(let i = 0; i < jobs.length; i++){
                            $result_wrapper.append('<p data-name="'+ jobs[i].post_title +'" class="job-suggestion">'+jobs[i].post_title+'</p>');
                        }
                    }else{
                        $result_wrapper.append('<p class="job-suggestion">No results</p>');
                    }
                },
                error : function(jqXHR, exception){
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg)
                }

            });

        },
        currentLocation: function(){
            if(this.checked) {
                $('.location_filter').css('display', 'none');
            }else{
                $('.location_filter').css('display', 'block');
            }
        },
        getJobsReload: function(){

            var city = $('#igj_cities').val() ? $('#igj_cities').val() : 'all';
            var state = $('#igj_states').val() ? $('#igj_states').val() : 'all';
            var job_category = $('#igj_job_categories').val() ?  $('#igj_job_categories').val() : 'all';
            var job_search = $('#job_search').val() ?  $('#job_search').val() : '';
            var sort = $('#job_ordering').val() ?  $('#job_ordering').val() : '';
            var current_location = $("#current_location").is(':checked') ? 1 : 0;

            window.location.href = parameters.site_url + '/job-listing/?city='+city+'&state=' + state + '&job_category=' + job_category + '&search=' + job_search + '&sort=' + sort + '&current_location=' + current_location;
        },
        pageNavigation: function(e){

            let page = $(this).data('page');
            igj_jobs.page = page;
            igj_jobs.getJobs();

        },
        pagination: function(){

            igj_jobs.$pagination_section.empty();

            let totalPages = Math.ceil(parseInt(igj_jobs.jobsTotal)/parseInt(igj_jobs.length));

            for(let i = 1; i <= totalPages; i++){
                let active =  i === parseInt(igj_jobs.page) ? 'active' : '';
                igj_jobs.$pagination_section.append('<li data-page="'+ i +'" class="page-item ' + active + ' page-' + i +'"><span class="page-link">' + i +'</span></li>');
            }

        },
        getJobs: function () {
            $.ajax({
                type: 'POST',
                url: parameters.ajax_url,
                data: {
                    'action': 'igj_get_jobs',
                    'length': igj_jobs.length,
                    'page': igj_jobs.page,
                    'city': $('#igj_cities').val(),
                    'state': $('#igj_states').val(),
                    'job_category': $('#igj_job_categories').val(),
                    'search': $('#job_search').val(),
                    'sort': $('#job_ordering').val(),
                    'current_location': $("#current_location").is(':checked') ? 1 : 0,
                },
                dataType: "json",
                beforeSend: function () {
                    igj_jobs.$job_section.empty().append('<h5 class="text-center">Loading...</h5>');
                },
                complete: function () {
                },
                success: function (response) {

                    if (response.success) {

                        /*var jobs_html = response.jobs;
                        var job_search = $('#job_search').val();

                        if(job_search != ''){
                            jobs_html = jobs_html.replace("/" + job_search + "/","<span>"+job_search+"</span>");
                        }*/

                        igj_jobs.$job_section.empty().append(response.jobs);
                        igj_jobs.jobsTotal = response.totalJobs;
                        igj_jobs.page = response.page;
                        igj_jobs.length = response.length;
                        igj_jobs.pagination();

                    } else {
                        alert("There was an error, please try again!");
                    }

                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg);
                }

            });
        }
    }

    $(window).load(function(){

        igj_jobs.init();

    });

});


