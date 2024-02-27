<?php include('header.php'); ?>

<?php include('sidebar.php'); ?>

<div class="content-body">
    <!-- row -->
    <!-- <div class="card-header">
        <h4 class="card-title">Table Hover</h4>
    </div> -->
    <div class="container-fluid">


        <form id="appointment_request_form" method="POST">
            <div class="row">
              
                <div class="col-lg-12">

                    <div class="card">
                        <div class="welcome-text">
                            <h4>Add Appointment Request</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label class="text-dark font-weight-bold">Appointment No</label>
                                        <input type="text" class="form-control grey-textbox" id="apt_no" name="appoint_no" readonly required>
                                    </div>

                                    <div class="form-group col-md-2 ml-4">
                                        <label class="text-dark font-weight-bold">Department</label>
                                        <select class="form-control select2" name="department" id="department">
                                            <option>Choose Department</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 ml-4">
                                        <label class="text-dark font-weight-bold">Meeting Person Detail</label>
                                        <select id="meeting_person" class="form-control multi-select" name="meeting_person_code[]" required multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 ml-4">
                                        <label class="text-dark font-weight-bold">Purpose Of Meeting</label>
                                        <input type="text" name="meeting_purpose" class="form-control" placeholder="Enter Purpose Of Meeting" required>
                                    </div>
                                    <div class="form-group col-md-2 ml-4">
                                        <label class="text-dark font-weight-bold">Meeting Location</label>
                                        <input type="text" name="meeting_location" class="form-control" placeholder="Enter Meeting Location" required>
                                    </div>

                                    <div class="form-group col-md-2 col-xl-2 col-xxl-2">
                                        <label class="text-dark font-weight-bold">Meeting Date</label>
                                        <input name="meeting_date" class="datepicker-default form-control" id="datepicker" required>
                                    </div>

                                    <div class="form-group col-md-2 col-xl-2 col-xxl-2 ml-4">
                                        <label class="text-dark font-weight-bold">Meeting From</label>
                                        <input type="text" name="meeting_time_from" class="form-control timepicker_from" required>
                                    </div>

                                    <div class="form-group col-md-2 col-xl-2 col-xxl-2 ml-4">
                                        <label class="text-dark font-weight-bold">Meeting To</label>
                                        <input type="text" name="meeting_time_to" class="form-control timepicker_to" required>
                                    </div>

                                    <div class="form-group col-md-2 ml-4">
                                        <label class="text-dark font-weight-bold">Parking Required</label>
                                        <select class="form-control select2" name="parking_required" required>
                                            <option selected>Choose...</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2 ml-4">
                                        <label class="text-dark font-weight-bold">Wifi Required</label>
                                        <select id="inputState" class="form-control select2" name="wifi_required" required>
                                            <option selected>Choose...</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3 my-auto">
                                        <button class="btn btn-sm btn-primary text-white" type="submit"><i class="fa fa-save"></i> Create Request</button>
                                        <button class="btn btn-sm btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" id="existing_row_count" value="1">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <!-- <th class="font-weight-bold">Appointment No</th> -->
                                        <th class="font-weight-bold text-dark">SNO</th>
                                        <th class="font-weight-bold text-dark">Visitor Name</th>
                                        <th class="font-weight-bold text-dark">Designation</th>
                                        <th class="font-weight-bold text-dark">Company Details</th>
                                        <th class="font-weight-bold text-dark">Mail id</th>
                                        <th class="font-weight-bold text-dark">Action</th>
                                    </thead>
                                    <tbody class="apt_req_tbl_tbody">
                                        <tr data-row="1">
                                            <td class="srn_no" style="width:5%;">1</td>
                                            <td style="width:20%;">
                                                <input type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="visitor_name[]" placeholder="Enter visitor Name" autocomplete="off" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="designation[]" placeholder="Enter Visitor designation" autocomplete="off" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" name="comapany_details[]" placeholder="Enter Comapany Details" autocomplete="off" required>
                                            </td>
                                            <td>
                                                <input type="email" class="form-control" name="email_id[]" placeholder="Enter Email Id" autocomplete="off" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success add_row"><i class="fa fa-plus text-white" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </form>
</div>
</div>

</div>
<?php include('footer.php') ?>


<?php include('bottom_script.php') ?>

<script>
    function Alert_Msg(Msg,text,Type){
        swal({
            title: Msg,
            icon: Type,
            text: text,
        });
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
                var option = '<option>Choose Department</option>';
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
                // var option = '<option>Choose Meeting Person</option>';
                var option = '';
                if(result.length > 0) {
                    for(i in result) {
                        option += `<option value="${ result[i].Employee_Code }">${ result[i].Employee_Name }-${ result[i].Employee_Code }-${ result[i].department }</option>`; 
                    }
                }
                $('.multi-select').multiselect('destroy');
                $('#meeting_person').html(option);
                $('.multi-select').multiselect({
            // maxHeight: 450,
            // selectAllText:' Select all',
                    includeSelectAllOption:true,
                    dropdownPosition: 'below',
                    maxHeight:200,
                    buttonWidth: '100%',
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering:true 
                });
            }
        });
    }

    function get_appointment_no()
    {
        $.ajax({
            type: "GET",
            url: "ajax/common_ajax.php",
            data: {
                "Action": "get_appointment_no",
            },
            dataType:"json",
            success: function(result) {
                result = (result == 0) ? 0 : result.split('-')[1];
                var apt_no = parseInt(result) + parseInt(1);
                final_apt_no = apt_no.toString().padStart(6,'0'); 
                $('#apt_no').val('APT-'+final_apt_no);
            }
        });
    }
     
    $(document).on('change', '.timepicker_from', function() {
        var from = $(this).val();
        var step = 10;
        // if(from >= $(this).val()) {
        //     swal({
        //         title: "Error",
        //         icon: "error",
        //         text: "Meeting end time should be greater than meeting start time",
        //     }).then(function(isconfirm){
        //         $('.timepicker_to').val('');
        //     });;
        // }

        const from_time = moment(from,"hh:mm A");
        const to_min_time = from_time.add(step,'minutes').format("hh:mm A")

        $('.timepicker_to').val(to_min_time);
        $('.timepicker_to').timepicker({
            timeFormat: 'h:i A',
            step: step,
            minTime: to_min_time,
            maxTime: '7:00pm',
        // defaultTime: '9',
        // startTime: '9:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

    });    

    function timepicker_init()
    {
        var step = 10;
        $('.timepicker_from').timepicker({
            timeFormat: 'h:i A',
            step: step,
            minTime: '09',
            maxTime: '7:00pm',
            // defaultTime: '09',
            // startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('.timepicker_to').timepicker({
        timeFormat: 'h:i A',
        step: step,
        minTime: '09',
        maxTime: '7:00pm',
        // defaultTime: '9',
        // startTime: '9:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        });
    }

    $(document).ready(function(){
        $('.select2').select2();
        // $('.multi-select').select2({
        //     multiple:true
        // });
        $('.multi-select').multiselect({
            // maxHeight: 450,
            // selectAllText:' Select all',
            includeSelectAllOption:true,
            dropdownPosition: 'below',
            enableFiltering: true,
            enableCaseInsensitiveFiltering:true 
        });
        timepicker_init();
        get_employee_details();
        get_appointment_no();
        get_department();
    });

    $(document).on('click', '.add_row', function() {
        var exist_row_count = $('#existing_row_count').val();
        var next_row_count = parseInt(exist_row_count) + parseInt(1);
        var table_row = `<tr data-row="${ next_row_count }">
        <td class="srn_no" style="width:5%;">${ next_row_count }</td>
        <td style="width:20%;">
        <input type="text" class="form-control text-upper" name="visitor_name[]" placeholder="Enter visitor Name" autocomplete="off" required>
        </td>
        <td>
        <input type="text" class="form-control text-upper" name="designation[]" placeholder="Enter Visitor designation" autocomplete="off" required>
        </td>
        <td>
        <input type="text" class="form-control text-upper" name="comapany_details[]" placeholder="Enter Comapany Details" autocomplete="off" required>
        </td>
        <td>
        <input type="email" class="form-control" name="email_id[]" placeholder="Enter Email Id" autocomplete="off" required>
        </td>
        <td>
        <button type="button" class="btn btn-sm btn-success add_row"><i class="fa fa-plus text-white" aria-hidden="true"></i></button>
        <button class='btn btn-sm btn-danger delete_row'><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
        </tr>`;
        $('.apt_req_tbl_tbody').append(table_row);
        $('#existing_row_count').val(next_row_count);
    });

    $(document).on('click', '.delete_row', function() {
        var decresed_row_count = parseInt($('#existing_row_count').val()) - parseInt(1);
        $('#existing_row_count').val(decresed_row_count);
        $(this).closest('tr').remove();
        s_no();
    });

    function s_no() {
        var sno = 1;
        $(".srn_no").each(function(key, index) {
            $(this).html(sno);
            sno++;
        });
    }

    $(document).on('submit','#appointment_request_form',function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "ajax/common_ajax.php",
            data: { "Action": "create_appointment_request","data" : $('#appointment_request_form').serialize()},
            dataType:"json",
            beforeSend:function(){
                $('#preloader').show();
            },
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
                } else {
                    Alert_Msg("Failed",result.msg,"error");   
                }
            }
        });
    });
</script>

</body>

</html>