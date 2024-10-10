        <?php include('header.php'); ?>

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
                              <th scope="col">Email</th>     
                              <th scope="col">Mobile</th>                                                       
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="welcome-text">
                                <h4>Appointment Request</h4>
                            </div>

                            <div class="text-right mb-3 mr-3">
                                <a href="appointment_request.php">
                                    <button type="button" class="btn btn-rounded btn-primary">
                                        <span class="btn-icon-left" style="background: #343957;">
                                            <i class="fa fa-plus color-info"></i>
                                        </span>Add
                                    </button>
                                </a>
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

            $(document).ready(function(){
                // $('#datatable').DataTable();
                 $.ajax({
                    type: "GET",
                    url: "ajax/common_ajax.php",
                    data: {
                        "Action": "get_appointment_request_list",
                    },
                    dataType:"json",
                    success: function(result) {
                        var html = '';
                        for(i in result['request']) {
                            html += `<tr>
                            <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_person_details.split(',')[0] }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_date }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_time_from }</td>
                            <td class="text-dark text-center">${ result['request'][i].meeting_time_to }</td>
                            <td class="text-dark text-center"><span class="badge badge-rounded badge-danger">${ result['request'][i].status }</span></td>
                            <td class="text-center">
                                <a><button class="btn btn-sm btn-info text-white visitor_info_btn" data-aptno="${ result['request'][i].appointment_no }"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
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
                        "Action": "get_appointment_request_list",
                        "for" : 'visitors_info',
                        "appointment_no" : appointment_no
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
                            <td class="text-dark text-center">${ (result['request'][i].visitor_mobile_no != null) ? result['request'][i].visitor_mobile_no : '' }</td>
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