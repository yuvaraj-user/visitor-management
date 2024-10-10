<?php
include '../auto_load.php';  

$appointment_no = $_POST['appointment_no'];

// $appointment_no = 'APT-000003';


$sql = "SELECT request_tbl.meeting_person_details,request_tbl.meeting_time_from,request_tbl.meeting_time_to,request_tbl.purpose_of_meeting,FORMAT(request_tbl.meeting_date,'dd-MM-yyyy') as meeting_date,request_tbl.appointment_no,COUNT(visitors_tbl.visitor_name) AS visitor_total_count,MIN(visitors_tbl.visitor_name) AS visitor_name from VM_Appointment_Request as request_tbl 
inner join VM_Appointment_visitors as visitors_tbl on request_tbl.id = visitors_tbl.appointment_request_id 
where request_tbl.status = 'Approved' and request_tbl.appointment_no = '".$appointment_no."'
group by request_tbl.meeting_person_details,request_tbl.meeting_time_from,request_tbl.meeting_time_to,request_tbl.purpose_of_meeting,request_tbl.meeting_date,request_tbl.appointment_no";

// echo $sql;exit;
$sql_exec = sqlsrv_query($conn,$sql);
$sql_result = sqlsrv_fetch_array($sql_exec,SQLSRV_FETCH_ASSOC); 
// echo "<pre>";print_r($sql_result);exit;

$meeting_persons     = explode(',',$sql_result['meeting_person_details']);
$meeting_person_name = $meeting_persons[0];
$meeting_toal_count  = COUNT($meeting_persons);


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        /* General styles for the page */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .f-12 {
            font-size: 12px !important;
        }

        .f-20 {
            font-size: 20px !important;
        }

        .text-bold {
            font-weight: bold;
        }

        .hr_div {
            width: 60%;
        }

        .memo_head {
            text-decoration: underline;
            text-underline-offset: 4px !important;
        }

        .side_head_span1 {
            margin-left: 100px;
        }

        .side_head_span2 {
            margin-left: 79px;
        }

        .side_head_span3 {
            margin-left: 89px;
        }

        .side_head_span4 {
            margin-left: 86px;
        }

        .side_head_span5 {
            margin-left: 72px;
        }

        .side_head_span6 {
            margin-left: 25px;
        }

        .side_head_span7 {
            margin-left: 75px;
        }

        .signature_text {
            margin-left: 20px;
        }

        .text-center {
            text-align: center;
        }

        /* Print styles */
      /*  @media print {
            @page {
                size: 4in 6in; /* Memo paper size */
                margin: 0; /* Remove default margins */
            }

            body {
                margin: 0; /* Remove body margin for print */
                padding: 10px; /* Adjust padding for print */
                font-size: 12pt; /* Adjust font size for print */
            }

            /* Hide elements that are not needed in print */
            nav, footer {
                display: none;
            }
        }*/


    </style>
</head>
<body>

        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td>
                        <p class="text-bold f-20">Rasi Seeds (P) Ltd.</p>
                        <p class="f-12 text-bold">Registered & Corporate Office</p>
                        <p class="f-12">Rasi Enclave,Green Fields,</p>
                        <p class="f-12">737 C,Puliyankulam Road,</p>
                        <p class="f-12">Coimbatore - 641 045,Tamil Nadu, India.</p>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <div style="margin-right: -30px;">
                            <img src="images/company_logo.png">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan="2">
                        <div style="display: flex;">
                            <p class="text-bold">Appointment No :</p>
                            <p style="margin-left: 10px;"><?php echo $sql_result['appointment_no']; ?></p>
                        </div>
                    </td>
                    <td colspan="2">
                        <div style="display: flex;">
                            <p class="text-bold">Date : </p>
                            <p style="margin-left: 10px;"><?php echo $sql_result['meeting_date']; ?></p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                    </td>
                    <td>
                        <p class="text-center text-bold memo_head">VISITOR PASS</p>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td> 
                </tr>

                <tr>
                    <td>
                        <p class="text-bold">Name <span class="side_head_span1">:</span></p>
                    </td>
                    <td>
                        <p><?php echo $sql_result['visitor_name']; ?>
                            <?php 
                            if($sql_result['visitor_total_count'] - 1 > 0) { ?>
                                <span class="text-bold">+<?php echo ($sql_result['visitor_total_count'] - 1); ?></span>
                            <?php } ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-bold">Address <span class="side_head_span2">:</span></p>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-bold">Laptop <span class="side_head_span3">:</span></p>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-bold">In Time <span class="side_head_span4">:</span></p>
                    </td>
                    <td>
                        <p><?php echo $sql_result['meeting_time_from']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-bold">Out Time <span class="side_head_span5">:</span></p>
                    </td>
                    <td>
                        <p><?php echo $sql_result['meeting_time_to']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-bold">Person to Meet <span class="side_head_span6">:</span></p>
                    </td>
                    <td>
                        <p><?php echo $meeting_person_name ?>
                        <?php 
                        if($meeting_toal_count - 1 > 0) { ?> 
                            <span class="text-bold">+<?php echo ($meeting_toal_count - 1); ?></span>
                        <?php } ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="text-bold">Purpose <span class="side_head_span7">:</span></p>
                    </td>
                    <td>
                        <p><?php echo $sql_result['purpose_of_meeting']; ?></p>
                    </td>
                </tr>
               <!--  <tr>
                    <td>
                        <div class="hr_div">
                            <hr>
                        </div>
                        <p class="signature_text">Signature - Met Person</p>
                    </td>
                    <td>
                    </td>
                    <td colspan="2">
                        <div class="hr_div">
                            <hr>
                        </div>
                        <p class="signature_text">Signature - Security</p>
                    </td>
                </tr> -->
            </tbody>
        </table>

        <br>
        <br>
        <br>

        <table style="width:100%">
            <tbody>
                <tr>
                    <td colspan="2">
                        <div class="hr_div">
                            <hr>
                        </div>
                        <p class="signature_text">Signature - Met Person</p>
                    </td>
                    <td>
                    </td>
                    <td colspan="2">
                        <div class="hr_div" style="margin-left: 72px;">
                            <hr>
                        </div>
                        <p class="signature_text text-center">Signature - Security</p>
                    </td>
                </tr>
            </tbody>
        </table>

<!--     <script>
        // Optional: Automatically trigger print dialog
        window.onload = function() {
            window.print();
        };
    </script> -->
</body>
</html>
