        <?php include('header.php'); ?>

        <style type="text/css">
            #datatable_previous:hover , #datatable_next:hover {
                color: #593bdb  !important;
                text-decoration: none !important;
                border: none;
            }

            .active_apt_range,.my_active_apt_range {
                background: green;
                color: white;
            }
    </style>

    <?php include('sidebar.php'); ?>

    <div class="content-body">
        <!-- visitors info modal -->
        <div class="modal fade" id="visitor_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Visitors Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="">
                <label class="text-dark font-weight-bold">Meeting Persons</label><br>
                <div class="d-flex meeting_person_section flex-wrap">
                </div>

            </div>
            <table class="table table-striped table-bordered table-hover">
              <thead class="text-center text-dark">
                <tr>
                  <th scope="col">Sno</th>
                  <th scope="col">Visitors Name</th>
                  <th scope="col">Designation</th>
                  <th scope="col">Company Details</th>
                  <th scope="col">EMail</th>                              
              </tr>
          </thead>
          <tbody id="visitors_info_tbody">

          </tbody>
      </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <!-- <button type="button" class="btn btn-primary">Sa/ve changes</button> -->
</div>
</div>
</div>
</div>

<!-- row -->
<div class="container-fluid">
    <div class="row">
       <div class="col-lg-3 col-sm-6">
        <div class="card shadow widget1-border count-card-radius">
            <div class="stat-widget-two card-body">
                <div class="stat-content">
                    <div class="stat-text">Total Appointments</div>
                    <div class="stat-digit widget1-ft" id="apt_total"></div>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-info w-100" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div> 

    <div class="col-lg-3 col-sm-6">
        <a href="appointment_request_list.php">
            <div class="card shadow widget2-border count-card-radius">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Appointment Request</div>
                        <div class="stat-digit widget2-ft" id="apt_request"></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-primary" id="apt_request_progress" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
        <a href="appointment_waiting_list.php">
            <div class="card shadow widget3-border count-card-radius">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Appointment Approved</div>
                        <div class="stat-digit widget3-ft" id="apt_approved"></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" id="apt_approved_progress" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
        <a href="meeting_reviews.php">
            <div class="card shadow widget4-border count-card-radius">
                <div class="stat-widget-two card-body">
                    <div class="stat-content">
                        <div class="stat-text">Appointment Closed</div>
                        <div class="stat-digit widget4-ft" id="apt_closed"></div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" id="apt_closed_progress" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- /# column -->
</div>



<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: 5px solid #cdffe8">
            <div class="card-header d-card-head">
                <h4 class="card-title d-card-title">Appointment Overview</h4>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <div class="default-tab">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-pills w-50 apt-overview-tab">
                            <a class="nav-link active apt_main_tab text-center" data-action="my-apt" data-toggle="tab" href="#myapp" style="border-radius: 10px;">My Appointment</a>
                        </li>
                        <li class="nav-item w-50 apt-overview-tab">
                            <a class="nav-link apt_main_tab text-center text-dark" data-action="all-apt" data-toggle="tab" href="#allapp" style="border-radius: 10px;">All</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="myapp" role="tabpanel">
                            <div class="pt-4">
                                <div class="d-flex justify-content-end">

                                    <div class="col-md-2 p-0" id="my_range_filter_div" style="display:none;">
                                        <label class="text-dark">Range Filter</label>
                                        <div class="my_range_filter" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;height:30px">
                                            <span id="my_date_range_data" style="color: black;"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-1" style="margin-top: 28px;" id="my_clear_div" style="display:none;">
                                        <button class="btn btn-sm btn-danger my_clear_filter">Clear</button>
                                    </div>

                                    <div class="ml-auto">
                                        <button class="btn btn-sm btn-secondary my_apt_range my_active_apt_range" data-action="today">Today</button>
                                        <button class="btn btn-sm btn-secondary my_apt_range ml-2" data-action="upcoming">Upcoming</button>
                                        <button class="btn btn-sm btn-secondary my_apt_range ml-2" data-action="history">History</button>
                                    </div>

                                </div>
                                <table id="datatable2" class="table student-data-table mt-2">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold text-dark text-center">Sno</th>
                                            <th class="font-weight-bold text-dark text-center">Department</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting person</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting Date</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting Time From</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting Time To</th>
                                            <th class="font-weight-bold text-dark text-center">Status</th>
                                            <th class="font-weight-bold text-dark text-center">Detail Info</th>
                                        </tr>
                                    </thead>
                                    <tbody id="my_apt_tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="allapp">
                            <div class="pt-4">
                                <div class="d-flex">
                                    <div class="col-md-2">
                                        <label class="text-dark">Filter Options</label>                 
                                        <select class="form-control select2" name="filter_type" id="filter_type" required>
                                            <option value="all" selected>All</option>
                                            <option value="department">Department</option>
                                            <option value="dept_and_emp">Department With Employee</option>
                                            <option value="employee">Employee</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="department_div" style="display: none;">
                                        <label class="text-dark">Department</label>
                                        <select class="form-control select2" name="department" id="department" required>
                                            <option selected>Choose</option>
                                            <option value="department">Department</option>
                                            <option value="dept_and_emp">Department With Employee</option>
                                            <option value="employee">Employee</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2" id="employee_div" style="display: none;">
                                        <label class="text-dark">Employee</label>                                                    
                                        <select class="form-control select2" name="employee_code" id="employee_code" required>
                                            <option selected>Choose</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 p-0" id="range_filter_div" style="display: none;">
                                        <label class="text-dark">Range Filter</label>
                                        <div class="all_range_filter" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;height:30px">
                                            <span id="all_date_range_data" style="color: black;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="margin-top: 28px;">
                                        <button class="btn btn-sm btn-danger all_clear_filter">Clear</button>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-sm btn-secondary all_apt_range active_apt_range" data-action="today">Today</button>
                                        <button class="btn btn-sm btn-secondary all_apt_range ml-2" data-action="upcoming">Upcoming</button>
                                        <button class="btn btn-sm btn-secondary all_apt_range ml-2" data-action="history">History</button>

                                    </div>

                                </div>
                                <table id="datatable1" class="table mt-2">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold text-dark text-center">Sno</th>
                                            <th class="font-weight-bold text-dark text-center">Department</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting person</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting Date</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting Time From</th>
                                            <th class="font-weight-bold text-dark text-center">Meeting Time To</th>
                                            <th class="font-weight-bold text-dark text-center">Status</th>
                                            <th class="font-weight-bold text-dark text-center">Detail Info</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_apt_tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: 5px solid #cdffe8">
            <div class="card-header d-card-head">
                <h4 class="card-title d-card-title">Appointment calendar</h4>
            </div>
            <div class="card-body">
                <div id="calendar">
                </div>
            </div>
        </div>
    </div>
</div>

</div>
        <!--**********************************
            Content body end
            ***********************************-->


        <!--**********************************
            Footer start
            ***********************************-->
            <?php include('footer.php'); ?>

        <!--**********************************
            Footer end
            ***********************************-->

        <!--**********************************
           Support ticket button start
           ***********************************-->

        <!--**********************************
           Support ticket button end
           ***********************************-->


       </div>
    <!--**********************************
        Main wrapper end
        ***********************************-->

    <!--**********************************
        Scripts
        ***********************************-->
        <!-- Required vendors -->
        <?php include('bottom_script.php'); ?>
        <script type="text/javascript">
            function datatable_call()
            {
               $('#datatable1').DataTable({
                 "ordering": false,
                 "searching": false,
                 "info": false,
                 "lengthChange": false,
                 "pageLength": 5
             });
               $('#datatable2').DataTable({
                 "ordering": false,
                 "searching": false,
                 "info": false,
                 "lengthChange": false,
                 "pageLength": 5
             });  
           }


           function all_daterange_init()
           {
            var start = moment().subtract(29, 'days');
            var end   = moment();
            $('.all_range_filter').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                 'This Week': [moment().startOf('isoweek').add(1,'days'), moment().endOf('week')],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
             }
         },all_daterange_callback);

            $('.daterangepicker:last .ranges ul li').eq(2).hide();
        }

        function all_daterange_callback(start, end) {
            var from_date = start.format('DD-MM-YYYY');
            var to_date   = end.format('DD-MM-YYYY');
            $('.all_range_filter span').html(from_date + ' to ' + to_date);
            var from = $('.active_apt_range').data('action');
            var department = $('#department').val();
            var emp_code   = $('#employee_code').val();
            date_wise_appointment(from,'all-apt',from_date,to_date,department,emp_code);
        }

        function my_daterange_init()
        {
            var start = moment().subtract(29, 'days');
            var end   = moment();
            $('.my_range_filter').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                 'This Week': [moment().startOf('isoweek').add(1,'days'), moment().endOf('week')],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             }
         },my_daterange_callback);

            $('.daterangepicker:last .ranges ul li').eq(3).hide();
        }

        function my_daterange_callback(start, end) {
            var from_date = start.format('DD-MM-YYYY');
            var to_date   = end.format('DD-MM-YYYY');
            $('.my_range_filter span').html(from_date + ' to ' + to_date);
            var from = $('.my_apt_range').data('action'); 
            date_wise_appointment(from,'my-apt',from_date,to_date);

        }


        function get_department()
        {
            $.ajax({
                type: "GET",
                url: "ajax/common_ajax.php",
                data: {
                    "Action": "get_deparment_list",
                },
                dataType:"json",
                success: function(result) {
                    var option = '<option value="">Choose Department</option>';
                    if(result.length > 0) {
                        for(i in result) {
                            option += `<option value="${ result[i].department }">${ result[i].department }</option>`; 
                        }
                    }
                    $('#department').html(option);
                }
            });
        }

        function get_employee_details()
        {
            $.ajax({
                type: "GET",
                url: "ajax/common_ajax.php",
                data: {
                    "Action": "get_employee_detail",
                },
                dataType:"json",
                success: function(result) {
                    var option = '<option value="">Choose Employee</option>';
                    if(result.length > 0) {
                        for(i in result) {
                            option += `<option value="${ result[i].Employee_Code }">${ result[i].Employee_Name }-${ result[i].Employee_Code }-${ result[i].department }</option>`; 
                        }
                    }
                    $('#employee_code').html(option);
                }
            });
        } 

        function get_myappointment() 
        {
            $.ajax({
                type: "GET",
                url: "ajax/common_ajax.php",
                data: {
                    "Action": "get_calendar_data"
                },
                dataType:"json",
                success: function(result) {
                    var data = [];
                    var redirect_url  = 'appointment_waiting_list.php'; 
                    for(i in result) {
                        var obj =  {
                            title : result[i].appointment_no,
                            start : result[i].meeting_date,
                            url : redirect_url
                        }

                        data.push(obj);
                    }
                    calendar(data);
                }
            });
        }

        function calendar(data)
        {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    start: '', 
                    center: 'title',
                },
                editable: false,
                events: data
            });
            calendar.render();
        }

        $(document).ready(function(){
            get_myappointment();
            $('.select2').select2();
            all_daterange_init();

            datatable_call();
            date_wise_appointment('today','my-apt');

            get_department();
            get_employee_details();
            $.ajax({
                type: "GET",
                url: "ajax/common_ajax.php",
                data: {
                    "Action": "get_dashboard_data",
                },
                dataType:"json",
                success: function(result) {
                    var req_percentage      = (result.appointment_request_count > 0) ? (result.appointment_request_count/result.appointment_total_count) * 100 : 0; 
                    var approved_percentage = (result.appointment_approved_count > 0) ? (result.appointment_approved_count/result.appointment_total_count) * 100 : 0; 
                    var closed_percentage   = (result.appointment_closed_count > 0) ? (result.appointment_closed_count/result.appointment_total_count) * 100 : 0; 

                    $('#apt_total').text(result.appointment_total_count);
                    $('#apt_request').text(result.appointment_request_count);
                    $('#apt_approved').text(result.appointment_approved_count);
                    $('#apt_closed').text(result.appointment_closed_count);
                    $('#apt_request_progress').css('width',req_percentage+'%');
                    $('#apt_approved_progress').css('width',approved_percentage+'%');
                    $('#apt_closed_progress').css('width',closed_percentage+'%');

                }   
            });
        });


        function date_wise_appointment(from,main_action,from_date = '',to_date = '',department = '',emp_code = '')
        {
            $.ajax({
                type: "GET",
                url: "ajax/common_ajax.php",
                data: {
                    "Action": "get_date_wise_appointment",
                    from : from,
                    main_action:main_action,
                    from_date : from_date,
                    to_date :to_date,
                    department : department,
                    emp_code : emp_code 
                },
                dataType:"json",
                success: function(result) {
                    var html = '';
                    var badge_class = (from == 'upcoming') ? 'badge-warning' : ((from == 'history') ? 'badge-success' : 'badge-danger');   
                    if(result.length > 0) {
                        for(i in result) {
                            html += `<tr>
                            <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                            <td class="text-dark text-center">${ result[i].department }</td>
                            <td class="text-dark text-center">${ result[i].meeting_person_details.split(',')[0] }</td>
                            <td class="text-dark text-center">${ result[i].meeting_date }</td>
                            <td class="text-dark text-center">${ result[i].meeting_time_from }</td>
                            <td class="text-dark text-center">${ result[i].meeting_time_to }</td>
                            <td class="text-dark text-center"><span class="badge badge-rounded ${ badge_class }">${ result[i].status }</span></td>
                            <td class="text-center">
                            <a><button class="btn btn-sm btn-primary text-white visitor_info_btn" data-aptno="${ result[i].appointment_no }"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                            </td>
                            </tr>`;
                        }
                    }

                    if(main_action == 'all-apt') {
                        $('#datatable1').DataTable().destroy();
                        $('#all_apt_tbody').html(html);
                        $('#datatable1').DataTable({
                           "ordering": false,
                           "searching": false,
                           "info": false,
                           "lengthChange": false,
                           "pageLength": 5
                       });
                    } else if(main_action == 'my-apt') {
                        $('#datatable2').DataTable().destroy();
                        $('#my_apt_tbody').html(html);
                        $('#datatable2').DataTable({
                           "ordering": false,
                           "searching": false,
                           "info": false,
                           "lengthChange": false,
                           "pageLength": 5
                       });
                    }
                }   
            });
        }

        $(document).on('click','.all_apt_range',function(){
            var from = $(this).data('action');
            $('.all_apt_range').removeClass('active_apt_range');
            $(this).addClass('active_apt_range');
            $('#range_filter_div').hide();
            if(from == 'upcoming' || from == 'history') {
                $('#range_filter_div').show();
            }

            $('.daterangepicker:last .ranges ul li').eq(2).hide();
            if(from == 'history') {
                $('.daterangepicker:last .ranges ul li').eq(2).show();
            }
            var department = $('#department').val();
            var emp_code   = $('#employee_code').val();
            date_wise_appointment(from,'all-apt','','',department,emp_code);
        });

        $(document).on('click','.apt_main_tab',function(){
            var from        = 'today';
            var main_action = $(this).data('action');
            if(main_action == 'all-apt') {
                $('.all_apt_range').removeClass('active_apt_range');
                $('.all_apt_range').eq(0).addClass('active_apt_range');
                $('#range_filter_div').hide();
                all_daterange_init();
            } else if(main_action == 'my-apt') {
                $('.my_apt_range').removeClass('my_active_apt_range');
                $('.my_apt_range').eq(0).addClass('my_active_apt_range');
                $('#my_range_filter_div').hide();
                $('#my_clear_div').hide();
                my_daterange_init();
            }
            date_wise_appointment(from,main_action);

            $('.apt_main_tab').removeClass('text-white');
            $('.apt_main_tab').addClass('text-dark');
            if($(this).hasClass('active')) {
                $(this).removeClass('text-dark');
                $(this).addClass('text-white');
            }
        });

        $(document).on('click','.my_apt_range',function(){
            var from = $(this).data('action');
            $('.my_apt_range').removeClass('my_active_apt_range');
            $(this).addClass('my_active_apt_range');
            $('#my_range_filter_div').hide();
            $('#my_clear_div').hide();
            if(from == 'upcoming' || from == 'history') {
                $('#my_range_filter_div').show();
                $('#my_clear_div').show();
            }
            $('.daterangepicker:last .ranges ul li').eq(3).hide();
            if(from == 'history') {
                $('.daterangepicker:last .ranges ul li').eq(3).show();
            } 
            date_wise_appointment(from,'my-apt');
        });

        $(document).on('change','#filter_type',function(){
            var filter_type = $(this).val();
            if(filter_type == 'department') {
                $('#employee_div').hide();
                $('#department_div').show();
            } else if(filter_type == 'dept_and_emp') {
                $('#department_div').show();
                $('#employee_div').show();
            } else if(filter_type == 'employee') {
                $('#department_div').hide();
                $('#employee_div').show();
            } else if(filter_type == 'all') {
                var from       = $('.active_apt_range').data('action');
                date_wise_appointment(from,'all-apt');
            }
        });

        $(document).on('click','.all_clear_filter',function(){
            $('#all_date_range_data').text('');
            $('#department_div').hide();
            $('#employee_div').hide();
            $('#department').val('');
            $('#employee_code').val('');
            $('#filter_type').val('all');
            // $('.select2').select2('destroy');
            $('.select2').select2();
            var from       = $('.active_apt_range').data('action');
            date_wise_appointment(from,'all-apt');
        });


        $(document).on('click','.my_clear_filter',function(){
            $('#my_date_range_data').text('');
            var from       = $('.my_active_apt_range').data('action');
            date_wise_appointment(from,'my-apt');
        });


        $(document).on('change','#department',function(){
            var department = $(this).val();
            var emp_code   = $('#employee_code').val();
            var from       = $('.active_apt_range').data('action');
            var dates      = $('#all_date_range_data').text();
            var start_date = '';
            var to_date    = '';
            if(dates != '') {
                start_date = dates.split('to')[0];
                to_date    = dates.split('to')[1];  
            }
            date_wise_appointment(from,'all-apt',start_date,to_date,department,emp_code);
        });


        $(document).on('change','#employee_code',function(){
            var emp_code   = $(this).val();
            var from       = $('.active_apt_range').data('action');
            var department = $('#department').val();
            var dates      = $('#all_date_range_data').text();
            var start_date = '';
            var to_date    = '';
            if(dates != '') {
                start_date = dates.split('to')[0];
                to_date    = dates.split('to')[1];  
            }
            date_wise_appointment(from,'all-apt',start_date,to_date,department,emp_code);
        });


        $(document).on('click','.visitor_info_btn',function(){
            var appointment_no = $(this).data('aptno'); 
            $.ajax({
                type: "GET",
                url: "ajax/common_ajax.php",
                data: {
                    "Action": "get_appointment_request_list",
                    "for" : 'visitors_info',
                    "appointment_no" : appointment_no,
                    'from' : 'dashboard'
                },
                beforeSend:function(){
                    $('.preloader').show();
                },
                dataType:"json",
                success: function(result) {
                    var html = '';
                    var person = '';
                    for(i in result['request']) {
                        html += `<tr>
                        <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                        <td class="text-dark text-center">${ result['request'][i].visitor_name }</td>
                        <td class="text-dark text-center">${ result['request'][i].visitor_designation }</td>
                        <td class="text-dark text-center">${ result['request'][i].visitor_company_details }</td>
                        <td class="text-dark text-center">${ result['request'][i].visitor_mail_id }</td>
                        </tr>`;
                    }

                    for(n in result['meeting_person_names']) {
                        person += `<h4 class="ml-1"><span class="badge badge-secondary">${ result['meeting_person_names'][n] }</span></h4>`;
                    }


                    $('#visitors_info_tbody').html(html);
                    $('#visitor_info').modal('show')
                    $('.meeting_person_section').html(person);
                }
            });
        });


    </script>


</body>

</html>