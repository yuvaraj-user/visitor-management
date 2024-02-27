        <?php include('header.php'); ?>
        <style type="text/css">
            .dropdown-toggle,.box-border {
                border: 2px solid #b552da !important;
            }
        </style>
        <?php include('sidebar.php'); ?>

        <div class="content-body">
            <!-- row -->
            <div class="modal fade" id="close_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Appointment Close </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body pl-5 pr-5">
                    <input type="hidden" id="apt_no">
                    <input type="hidden" id="apt_req_id">
                    <div class="form-group">
                        <label for="meeting_points" class="text-primary font-weight-bold">Particulars</label>
                        <textarea class="form-control box-border" id="meeting_particulars" rows="2" name="meeting_particulars"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="meeting_points" class="text-primary font-weight-bold">Meeting Points</label>
                        <textarea class="form-control box-border" id="meeting_points" rows="6" name="meeting_points"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="text-primary font-weight-bold">Meeting Person Detail</label>
                        <select id="meeting_person" class="form-control multi-select" name="meeting_person_code[]" required multiple="multiple">
                        </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="submit_close">Close Appointment</button>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal fade" id="visitor_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Participators Information</h5>
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
                              <th scope="col">Arrival Status</th>                                                         
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
                                <h4>Meeting Reviews</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table-responsive-sm">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Sno</th>
                                                <th>Appointment No</th>
                                                <th>Meeting Particulars</th>
                                                <th>Meeting Points</th>
                                                <th>Meeting person</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reviews_tbody">

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
                 $.ajax({
                    type: "GET",
                    url: "ajax/common_ajax.php",
                    data: {
                        "Action": "get_meeting_reviews_list",
                    },
                    dataType:"json",
                    success: function(result) {
                        var html = '';
                        for(i in result['reviews_data']) {
                            html += `<tr data-apt-no="${result['reviews_data'][i].appointment_no}">
                            <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].appointment_no }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].meeting_particulars }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].meeting_points }</td>
                            <td class="text-dark text-center">${ result['meeting_person_names'][i].split(',')[0] }</td>
                            <td class="text-center">
                                <a><button class="btn btn-sm btn-info text-white visitor_info_btn" title="Visitors Info" data-aptno="${ result['reviews_data'][i].appointment_no }"><i class="fa fa-info-circle" aria-hidden="true"></i></button></a>
                            </td>
                            </tr>`;
                        }

                        $('#example').DataTable().destroy();
                        $('#reviews_tbody').html(html);
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
                        "Action": "get_meeting_reviews_list",
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
                        for(i in result['reviews_data']) {
                            html += `<tr>
                            <td class="text-dark text-center">${ parseInt(i) + parseInt(1) }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].visitor_name }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].visitor_designation }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].visitor_company_details }</td>
                            <td class="text-dark text-center">${ result['reviews_data'][i].visitor_mail_id }</td>
                            <td class="text-dark text-center">${ (result['reviews_data'][i].arrival_status != null) ? result['reviews_data'][i].arrival_status : ''}</td>
                            </tr>`;
                        }

                        for(n in result['single_meeting_person_names']) {
                            person += `<h4 class="ml-1"><span class="badge badge-secondary">${ result['single_meeting_person_names'][n] }</span></h4>`;
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