        <?php include('header.php'); ?>

        <?php include('sidebar.php'); ?>

        <div class="content-body">
            <!-- row -->
            <div class="modal fade" id="arrival_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Visitor Reporting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="form_vist_arrival">
                  <div class="modal-body">
                    <input type="hidden" id="apt_no">
                    <div class="form-group ml-4">
                        <label class="text-primary font-weight-bold">Visitors Arrival Status</label>

                        <table class="table table-striped table-bordered table-hover">
                          <thead class="text-center text-dark">
                            <tr>
                              <th scope="col">Sno</th>
                              <th scope="col">Visitors Name</th>
                              <th scope="col">Arrival Status</th>                              
                            </tr>
                          </thead>
                          <tbody id="arrival_tbody">
                            
                          </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit_report">Submit Report</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


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


            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="welcome-text">
                                <h4>Visitor Reporting</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table-responsive-sm">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Meeting person</th>
                                                <th>Meeting Date</th>
                                                <th>Meeting Time From</th>
                                                <th>Meeting Time To</th>
                                                <th>Meeting Room</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="appointment_tbody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /# card -->
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
        <?php include('footer.php') ?>

        <!--**********************************
        Scripts
        ***********************************-->
        <?php include('bottom_script.php') ?>

        <script type="text/javascript">
            function Alert_Msg(Msg,text,Type){
                swal({
                    title: Msg,
                    icon: Type,
                    text: text,
                });
            }

            $(document).ready(function(){
                // $('#datatable').DataTable();
                 $.ajax({
                    type: "GET",
                    url: "ajax/common_ajax.php",
                    data: {
                        "Action": "get_appointment_approval_list",
                    },
                    dataType:"json",
                    success: function(result) {
                        var html = '';
                        for(i in result['request']) {
                            html += `<tr data-apt-no="${result['request'][i].appointment_no}">
                            <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_person_details.split(',')[0] }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_date }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_time_from }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_time_to }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_room }</td>
                            <td class="text-dark text-center"><span class="badge badge-rounded badge-success text-white">${ result['request'][i].status }</span></td>
                            <td class="text-center">
                                <a><button class="btn btn-sm btn-info text-white visitor_info_btn" title="Visitors Info" data-aptno="${ result['request'][i].appointment_no }"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                                <a><button class="btn btn-sm btn-success text-white arrival_status_btn" title="Approve"><i class="fa fa-check" aria-hidden="true"></i></button></a>
                            </td>
                            </tr>`;
                        }

                        $('#example').DataTable().destroy();
                        $('#appointment_tbody').html(html);
                        $('#example').DataTable();
                    }
                });
            });


            $(document).on('click','.visitor_info_btn',function(){
                var appointment_no = $(this).data('aptno'); 
                $.ajax({
                    type: "GET",
                    url: "ajax/common_ajax.php",
                    data: {
                        "Action": "get_appointment_approval_list",
                        "for" : 'visitors_info',
                        "appointment_no" : appointment_no
                    },
                    beforeSend:function(){
                        $('#preloader').show();
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

                        $('#preloader').hide();
                        $('#visitors_info_tbody').html(html);
                        $('#visitor_info').modal('show');
                        $('.meeting_person_section').html(person);
                    }
                });
            });


            $(document).on('click','.arrival_status_btn',function(){
                var current_select = $(this); 
                var appointment_no = current_select.closest('tr').data('apt-no');
                $('#apt_no').val(appointment_no);
                $.ajax({
                    type: "GET",
                    url: "ajax/common_ajax.php",
                    data: {
                        "Action": "get_appointment_approval_list",
                        "for" : 'visitors_info',
                        "appointment_no" : appointment_no
                    },
                    beforeSend:function(){
                        $('#preloader').show();
                    },
                    dataType:"json",
                    success: function(result) {
                        var html = '';
                        var person = '';
                        for(i in result['request']) {
                            html += `<tr>
                            <input type="hidden" name="visitor_id[]" value="${result['request'][i].id}"> 
                            <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                            <td class="text-dark text-center">${ result['request'][i].visitor_name }</td>
                            <td class="text-dark text-center">
                                <select class="form-control vist_arrival_status" id="visitor${result['request'][i].id}" name="vist_arrival_status[]" data-vname="${ result['request'][i].visitor_name }" required>
                                <option selected value="">Choose...</option>
                                <option value="Arrived">Arrived</option>
                                <option value="Not Arrived">Not Arrived</option>
                                </select>
                            </td>
                            </tr>`;
                        }
                        $('#arrival_tbody').html(html)
                        $('#arrival_status_modal').modal('show');
                    }
                });
            });


            $(document).on('click','#submit_report',function(e){
                e.preventDefault();
                var form_data = $('#form_vist_arrival').serialize();
                var appointment_no      = $('#apt_no').val();
                $('#arrival_status_modal').modal('hide');
                var meeting_status      = 'Not Arrived';
                var arrival_status_valid = true;
                var invalid_visitor_name = [];
                $('.vist_arrival_status').each(function(){
                    if($(this).val() == 'Arrived') {
                        meeting_status      = 'Arrived';
                    }

                    if($(this).val() == '') {
                        arrival_status_valid = false;
                        invalid_visitor_name.push($(this).data('vname'));
                    }

                });

                if(arrival_status_valid) {
                     $.ajax({
                        type: "POST",
                        url: "ajax/common_ajax.php",
                        data: {
                            "Action": "visitors_arrival_report",
                            appointment_no : appointment_no,
                            form_data : form_data,
                            meeting_status : meeting_status
                        },
                        beforeSend:function(){
                            $('#preloader').show();
                        },
                        dataType:"json",
                        success: function(result) {
                            $('#preloader').hide();
                            if(result.status == 200) {
                                swal({
                                    title: "Sucess",
                                    text: result.msg,
                                    icon: "success",
                                }).then(function(isconfirm){
                                    if(isconfirm) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });

                } else {
                    var msg = 'Visitor '+invalid_visitor_name[0]+' arrival status required.';
                    Alert_Msg('warning',msg,'warning');
                }
            });




        </script>

    </body>


    </html>