<?php
include '../../auto_load.php';	
include '../Appointment_request_details.php';
$Appointment = new Appointment_request_details($conn);

if(isset($_POST) && isset($_POST['Action'])) {
	if ($_POST['Action'] == 'create_appointment_request') {
		$appointment_request = $Appointment->create_appointment_request($_POST);
		echo json_encode($appointment_request);exit;
	} elseif($_POST['Action'] == 'approve_appointment_request') {
		$approve_request = $Appointment->approve_appointment_request($_POST);
		echo json_encode($approve_request);exit;	
	} elseif($_POST['Action'] == 'close_appointment_request') {
		$close_request = $Appointment->close_appointment_request($_POST);
		echo json_encode($close_request);exit;	
	} elseif($_POST['Action'] == 'visitors_arrival_report') {
		$arrival_report = $Appointment->visitors_arrival_report($_POST);
		echo json_encode($arrival_report);exit;	
	} 
	// elseif($_POST['Action'] == 'visitors_pass_print') {
	// 	$arrival_report = $Appointment->visitors_arrival_report($_POST);
	// 	echo json_encode($arrival_report);exit;	
	// }

} elseif (isset($_GET) && isset($_GET['Action'])) {
	if($_GET['Action'] == 'get_employee_detail') {
		$employee_details = $Appointment->get_employee_detail();
		// echo "<pre>";print_r(json_encode($employee_details));exit;
		echo json_encode($employee_details);exit;	
	} elseif($_GET['Action'] == 'get_appointment_no') {
		$apt_no = $Appointment->get_appointment_no();
		echo json_encode($apt_no);exit;	
	} elseif($_GET['Action'] == 'get_appointment_request_list') {
		$request_list = $Appointment->get_appointment_request_list($_GET);
		echo json_encode($request_list);exit;	
	} elseif($_GET['Action'] == 'get_appointment_approval_list') {
		$approval_list = $Appointment->get_appointment_approval_list($_GET);
		echo json_encode($approval_list);exit;	
	} elseif($_GET['Action'] == 'get_dashboard_data') {
		$dashboard_data = $Appointment->get_dashboard_data($_GET);
		echo json_encode($dashboard_data);exit;	
	}  elseif($_GET['Action'] == 'get_deparment_list') {
		$deparment_list = $Appointment->get_deparment_list($_GET);
		echo json_encode($deparment_list);exit;	
	} elseif($_GET['Action'] == 'get_appointment_arrival_list') {
		$arrival_list = $Appointment->get_appointment_arrival_list($_GET);
		echo json_encode($arrival_list);exit;	
	} elseif($_GET['Action'] == 'get_date_wise_appointment') {
		$appointments = $Appointment->get_date_wise_appointment($_GET);
		echo json_encode($appointments);exit;	
	} elseif($_GET['Action'] == 'get_meeting_rooms') {
		$meeting_rooms = $Appointment->get_meeting_rooms($_GET);
		echo json_encode($meeting_rooms);exit;	
	} elseif($_GET['Action'] == 'get_calendar_data') {
		$calendar_data = $Appointment->get_calendar_data($_GET);
		echo json_encode($calendar_data);exit;	
	} elseif($_GET['Action'] == 'get_meeting_reviews_list') {
		$meeting_reviews = $Appointment->get_meeting_reviews_list($_GET);
		echo json_encode($meeting_reviews);exit;	
	} elseif($_GET['Action'] == 'get_meeting_location') {
		$get_meeting_location = $Appointment->get_meeting_location($_GET);
		echo json_encode($get_meeting_location);exit;	
	}  


}
	
?>