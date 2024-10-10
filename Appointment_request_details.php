<?php
class Appointment_request_details
{
 	public $conn;
	function __construct($conn)
	{
		$this->conn = $conn; 
	}

	public function get_dashboard_data($request)
	{
		$result['appointment_request_count']   = $this->apt_status_wise_count('Created');
		$result['appointment_approved_count']  = $this->apt_status_wise_count('Approved');
		$result['appointment_closed_count']    = $this->apt_status_wise_count('Closed');
		$result['appointment_total_count']     = $this->apt_status_wise_count();

		return $result;
	}

	public function apt_status_wise_count($status = '')
	{
		$result        = array();
		$query         = "SELECT count(*) as total_count from (select appointment_no from VM_Appointment_Request"; 

		if(!empty($status)) {
			$query        .= " where status = '".$status."'";
		}

		$query  .= " group by appointment_no) as total";

		$count_details = sqlsrv_query($this->conn,$query);
		$result        = sqlsrv_fetch_array($count_details,SQLSRV_FETCH_ASSOC)['total_count'];

		return $result;
	}

	public function get_employee_detail() 
	{
		$result = array();

		$query        = "SELECT Employee_Code,Employee_Name,department from HR_Master_table where Employment_Status = 'Active' AND
		Employee_Code LIKE 'RS%' AND department IS NOT NULL group by Employee_Code,Employee_Name,department";
		$emp_details  = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($emp_details)) {
			$result[] = $row;
		}
		return $result;
	}

	public function get_deparment_list()
	{
		$result = array();

		$query        = "SELECT DISTINCT department from HR_Master_table where department IS NOT NULL";
		$emp_details  = sqlsrv_query($this->conn,$query);
		while($row    = sqlsrv_fetch_array($emp_details,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row; 
		}
		return $result;
	}

	public function get_employee_name($ecode) 
	{
		$result		  = array();

		$query        = "SELECT Employee_Name from HR_Master_table where Employee_Code = '".$ecode."' group by employee_name";
		$emp_details  = sqlsrv_query($this->conn,$query);
		$result       = sqlsrv_fetch_array($emp_details,SQLSRV_FETCH_ASSOC);
		return $result['Employee_Name'];
	}

	public function get_appointment_no() 
	{
		$result 	  = array();

		$query        = "SELECT TOP 1 appointment_no from VM_Appointment_Request group by appointment_no order by appointment_no desc";
		$apt_no       = sqlsrv_query($this->conn,$query);
		$result       = sqlsrv_fetch_array($apt_no,SQLSRV_FETCH_ASSOC);
		return ($result['appointment_no'] != null) ? $result['appointment_no'] : 0;
	}

	public function get_meeting_rooms() 
	{
		$result 	  = array();

		$query        = "SELECT location,meeting_room from VM_meeting_room_master";
		$rooms        = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($rooms,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	}


	public function get_meeting_person_names($apt_no) 
	{
		$result 	  = array();

		$query        = "SELECT meeting_person_details from VM_Appointment_Request where appointment_no = '".$apt_no."'";
		$apt_no       = sqlsrv_query($this->conn,$query);
		$result       = sqlsrv_fetch_array($apt_no,SQLSRV_FETCH_ASSOC);
		return explode(',',$result['meeting_person_details']);
	}

	public function get_appointment_request_list($request)
	{
		$result['request']		  = array();
		$result['meeting_person_names'] = array();

		$query        = "SELECT appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,FORMAT(meeting_date,'dd-MM-yyyy') as meeting_date from VM_Appointment_Request where status = 'Created' group by appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,meeting_date";

		if(isset($request['for']) && $request['for'] == 'visitors_info') {
			$query        = "SELECT visitors_tbl.visitor_name,visitors_tbl.visitor_designation,visitors_tbl.visitor_company_details,visitors_tbl.visitor_mail_id,visitors_tbl.visitor_mobile_no 
			from VM_Appointment_Request as request_tbl
			inner join VM_Appointment_visitors as visitors_tbl on request_tbl.id = visitors_tbl.appointment_request_id 
			where request_tbl.status = 'Created' and request_tbl.appointment_no = '".$request['appointment_no']."' 
			group by visitor_name,visitor_designation,visitor_company_details,visitor_mail_id,visitors_tbl.visitor_mobile_no";
			$result['meeting_person_names'] = $this->get_meeting_person_names($request['appointment_no']);

		}

		if(isset($request['from']) && $request['from'] == 'dashboard') {
			$query        = "SELECT visitors_tbl.visitor_name,visitors_tbl.visitor_designation,visitors_tbl.visitor_company_details,visitors_tbl.visitor_mail_id,visitors_tbl.visitor_mobile_no 
			from VM_Appointment_Request as request_tbl
			inner join VM_Appointment_visitors as visitors_tbl on request_tbl.id = visitors_tbl.appointment_request_id 
			where request_tbl.appointment_no = '".$request['appointment_no']."' 
			group by visitor_name,visitor_designation,visitor_company_details,visitor_mail_id,visitors_tbl.visitor_mobile_no";
			$result['meeting_person_names'] = $this->get_meeting_person_names($request['appointment_no']);

		}

		$request_list = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($request_list,SQLSRV_FETCH_ASSOC)) {
			// $result['request'] = $row; 
			array_push($result['request'],$row);
		}
		return $result;
	}

	public function create_appointment_request($request) 
	{
		parse_str($request['data'],$data);
		// echo "<pre>";print_r($data);exit;
		$appoint_no      	= $data['appoint_no'];
 		$meeting_purpose 	= $data['meeting_purpose'];
 		$meeting_location 	= $data['meeting_location'];
 		$meeting_date 	    = $data['meeting_date_submit'];
 		$meeting_time_from 	= $data['meeting_time_from'];
 		$meeting_time_to 	= $data['meeting_time_to'];
 		$parking_required 	= $data['parking_required'];
 		$wifi_required 	    = $data['wifi_required'];
 		$department         = $data['department'];
 		$is_approval_request = $data['approval_request_type'];
 		$request_status      = ($is_approval_request == 'yes') ? 'Created' : 'Closed';  
 		$created_by           = $_SESSION['EmpID'];
 		$approved_by          = ($is_approval_request == 'yes') ? '' : $_SESSION['EmpID'];
 		$arrival_reported_by  = ($is_approval_request == 'yes') ? '' : $_SESSION['EmpID'];
 		$closed_by            = ($is_approval_request == 'yes') ? '' : $_SESSION['EmpID'];

		$meeting_person_code = array();
		$meeting_person_name = array();

 		$query  = "INSERT INTO VM_Appointment_Request (appointment_no,meeting_person_code,meeting_person_details,department,purpose_of_meeting,meeting_location,meeting_date,meeting_time_from,meeting_time_to,parking_required,wifi_required,status,created_by,approved_by,arrival_reported_by,closed_by) VALUES"; 


 		 for($i = 0;$i< count($data['meeting_person_code']);$i++) {
 		 	$meeting_person_code[] = $data['meeting_person_code'][$i];
 		 	$meeting_person_name[] = $this->get_employee_name($data['meeting_person_code'][$i]);
 		 } 

 		 $meeting_person_codes = (COUNT($meeting_person_code) > 0) ? implode(',', $meeting_person_code) : '';
 		 $meeting_person_names = (COUNT($meeting_person_name) > 0) ? implode(',', $meeting_person_name) : '';

		$query .= "('".$appoint_no."','".$meeting_person_codes."','".$meeting_person_names."','".$department."','".$meeting_purpose."','".$meeting_location."','".$meeting_date."','".$meeting_time_from."','".$meeting_time_to."','".$parking_required."','".$wifi_required."','".$request_status."','".$created_by."','".$approved_by."','".$arrival_reported_by."','".$closed_by."'); SELECT SCOPE_IDENTITY()";
		// echo $query;exit;

 		$appointment_request = sqlsrv_query($this->conn,$query);

 		if($appointment_request) {
 			$retrive_request_id = sqlsrv_next_result($appointment_request);
 			$apt_request_id     = sqlsrv_fetch_array($appointment_request);

 			$v_query  = "INSERT INTO VM_Appointment_visitors (appointment_request_id,appointment_no,visitor_name,visitor_designation,visitor_company_details,visitor_mail_id,visitor_mobile_no,arrival_status) VALUES"; 
	 		 foreach($data['visitor_name'] as $key => $value) {
	 		 	$visitor_name           	= $data['visitor_name'][$key];
	 		 	$visitor_designation   		= $data['designation'][$key];
	 		 	$visitor_comapany_details   = $data['comapany_details'][$key];
	 		 	$visitor_email_id 			= $data['email_id'][$key];
	 		 	$visitor_mobile_no 			= $data['mobile_no'][$key];
	 		 	$arrival_status            = ($is_approval_request == 'yes') ? '' : 'Arrived';

	 		 	$v_query .= "('".$apt_request_id[0]."','".$appoint_no."','".$visitor_name."','".$visitor_designation."','".$visitor_comapany_details."','".$visitor_email_id."','".$visitor_mobile_no."','".$arrival_status."')";
	 		 	if(isset($data['visitor_name'][$key + 1])) {
	 		 		$v_query .= ",";
	 		 	}
	 		 }

	 		$appointment_visitors_creation = sqlsrv_query($this->conn,$v_query);
	 		if($appointment_visitors_creation === false) {
	 			$response['status'] = 500;
	 			$response['msg'] = "Server error.";
	 			print_r(sqlsrv_errors());exit;
	 		} else {
	 			$response['status'] = 200;
	 			$response['msg'] = "Appointment request created successfully.";
	 			$response['record_id'] = $apt_request_id;
	 		}
 		} else {
 			$response['status'] = 500;
	 		$response['msg'] = "Server error.";
	 		print_r(sqlsrv_errors());exit;
 		}


 		return $response; 
	}


	public function approve_appointment_request($request)
	{
		if($request['appointment_no']) {
			$query  = "UPDATE VM_Appointment_Request SET status = 'Approved',meeting_room = '".$request['meeting_room']."',approved_by = '".$_SESSION['EmpID']."' where appointment_no = '".$request['appointment_no']."'";
			$appointment_approval = sqlsrv_query($this->conn,$query);
			if($appointment_approval === false) {
				$response['status'] = 500;
				$response['msg'] = "Server error.";
			} else {
				$response['status'] = 200;
				$response['msg'] = "Appointment request approved successfully.";
			}
		} else {
			$response['status'] = 422;
 			$response['msg']    = "Unproccesable Entry.";
		}
 		return $response; 
	}

	public function get_appointment_approval_list($request)
	{
		$result['request']		  = array();
		$result['meeting_person_names'] = array();

		$query        = "SELECT appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,FORMAT(meeting_date,'dd-MM-yyyy') as meeting_date,meeting_room from VM_Appointment_Request where status = 'Approved' group by appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,meeting_date,meeting_room";

		if(isset($request['for']) && $request['for'] == 'visitors_info') {
			$query        = "SELECT visitors_tbl.id,visitors_tbl.visitor_name,visitors_tbl.visitor_designation,visitors_tbl.visitor_company_details,visitors_tbl.visitor_mail_id,visitors_tbl.visitor_mobile_no 
			from VM_Appointment_Request as request_tbl
			inner join VM_Appointment_visitors as visitors_tbl on request_tbl.id = visitors_tbl.appointment_request_id 
			where request_tbl.status = 'Approved' and request_tbl.appointment_no = '".$request['appointment_no']."' 
			group by visitor_name,visitor_designation,visitor_company_details,visitor_mail_id,visitors_tbl.id,visitors_tbl.visitor_mobile_no";
			$result['meeting_person_names'] = $this->get_meeting_person_names($request['appointment_no']);

		}

		$request_list = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($request_list,SQLSRV_FETCH_ASSOC)) {
			// $result[] = $row; 
			array_push($result['request'],$row);
		}
		return $result;
	}

	public function close_appointment_request($request)
	{
		if($request['appointment_no']) {
			$query  = "UPDATE VM_Appointment_Request SET status = 'Closed',closed_by = '".$_SESSION['EmpID']."' where appointment_no = '".$request['appointment_no']."'";
			$appointment_close = sqlsrv_query($this->conn,$query);
			if($appointment_close === false) {
				$response['status'] = 500;
				$response['msg'] = "Server error.";
			} else {
				$meeting_person_code = (COUNT($request['meeting_person_code']) > 0) ? implode(',',$request['meeting_person_code']) : '';
 				$v_query  = "INSERT INTO VM_Meeting_reviews (appointment_request_id,appointment_no,meeting_particulars,meeting_points,meeting_person_code) VALUES ('".$request['apt_req_id']."','".$request['appointment_no']."','".$request['meeting_particulars']."','".$request['meeting_points']."','".$meeting_person_code."')";
				$review_save = sqlsrv_query($this->conn,$v_query);
				$response['status'] = 200;
				$response['msg'] = "Appointment request closed successfully.";
			}
		} else {
			$response['status'] = 422;
 			$response['msg']    = "Unproccesable Entry.";
		}
 		return $response; 
	}

	public function visitors_arrival_report($request)
	{
		parse_str($request['form_data'],$data);
		if($request['appointment_no']) {
			$query  = "UPDATE VM_Appointment_Request SET status = '".$request['meeting_status']."',arrival_reported_by = '".$_SESSION['EmpID']."' where appointment_no = '".$request['appointment_no']."'";
			$appointment_close = sqlsrv_query($this->conn,$query);
			if($appointment_close === false) {
				$response['status'] = 500;
				$response['msg'] = "Server error.";
			} else {
				$v_query = '';
				foreach ($data['visitor_id'] as $k => $value) {
					$v_query  .= "UPDATE VM_Appointment_visitors SET arrival_status = '".$data['vist_arrival_status'][$k]."' where id = '".$value."';";
				}
				$arrival_save = sqlsrv_query($this->conn,$v_query);
				if($arrival_save) {
					$response['status'] = 200;
					$response['msg'] = "Visitors arrival status updated successfully.";
				} else {
					$response['status'] = 500;
					$response['msg'] = "Server error.";
				}
			}
		} else {
			$response['status'] = 422;
 			$response['msg']    = "Unproccesable Entry.";
		}
 		return $response; 
	}

	public function get_appointment_arrival_list($request)
	{
		$result['request']		  = array();
		$result['meeting_person_names'] = array();

		$query        = "SELECT id,appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,FORMAT(meeting_date,'dd-MM-yyyy') as meeting_date,meeting_room from VM_Appointment_Request where status = 'Arrived' group by appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,meeting_date,meeting_room,id";

		if(isset($request['for']) && $request['for'] == 'visitors_info') {
			$query        = "SELECT visitors_tbl.visitor_name,visitors_tbl.visitor_designation,visitors_tbl.visitor_company_details,visitors_tbl.visitor_mail_id 
			from VM_Appointment_Request as request_tbl
			inner join VM_Appointment_visitors as visitors_tbl on request_tbl.id = visitors_tbl.appointment_request_id 
			where request_tbl.status = 'Arrived' and request_tbl.appointment_no = '".$request['appointment_no']."' 
			group by visitor_name,visitor_designation,visitor_company_details,visitor_mail_id";
			
			$result['meeting_person_names'] = $this->get_meeting_person_names($request['appointment_no']);
		}

		$request_list = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($request_list,SQLSRV_FETCH_ASSOC)) {
			// $result[] = $row; 
			array_push($result['request'],$row);
		}
		return $result;
	}

	public function get_date_wise_appointment($request)
	{
		$result		  = array();

		$query        = "SELECT appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,department,meeting_location,status,FORMAT(meeting_date,'dd-MM-yyyy') as meeting_date from VM_Appointment_Request";

		if($request['main_action'] == "all-apt") {
			if($request['from'] == "today") {
				$query        .= " where meeting_date = '".date('Y-m-d')."' and status != 'Closed'";
				if(!empty($request['department'])) {
					$query        .= " and department = '".$request['department']."'";
				}

				if(!empty($request['emp_code'])) {
					$query        .= " and meeting_person_code LIKE '%".$request['emp_code']."%'";
				}
			} else if($request['from'] == "upcoming") {
				if(!empty($request['from_date']) && !empty($request['to_date'])) {
					$query        .= " where meeting_date BETWEEN '".date('Y-m-d',strtotime($request['from_date']))."' and '".date('Y-m-d',strtotime($request['to_date']))."' and status != 'Closed'";
				} else {
					$query        .= " where meeting_date > '".date('Y-m-d')."' and status != 'Closed'";
				}

				if(!empty($request['department'])) {
					$query        .= " and department = '".$request['department']."'";
				}

				if(!empty($request['emp_code'])) {
					$query        .= " and meeting_person_code LIKE '%".$request['emp_code']."%'";
				}
			} else if($request['from'] == "history") {
				if(!empty($request['from_date']) && !empty($request['to_date'])) {
					$query        .= " where meeting_date BETWEEN '".date('Y-m-d',strtotime($request['from_date']))."' and '".date('Y-m-d',strtotime($request['to_date']))."' and status = 'Closed'";
				} else {
					$query        .= " where status = 'Closed'";
				}

				if(!empty($request['department'])) {
					$query        .= " and department = '".$request['department']."'";
				}

				if(!empty($request['emp_code'])) {
					$query        .= " and meeting_person_code LIKE '%".$request['emp_code']."%'";
				}
			} 
		} else if($request['main_action'] == "my-apt") {
			$query        .= " where meeting_person_code LIKE '%RS3015%'";
			if($request['from'] == "today") {
				$query        .= " and meeting_date = '".date('Y-m-d')."' and status != 'Closed'";
			} else if($request['from'] == "upcoming") {
				if(!empty($request['from_date']) && !empty($request['to_date'])) {
					$query        .= " and meeting_date BETWEEN '".date('Y-m-d',strtotime($request['from_date']))."' and '".date('Y-m-d',strtotime($request['to_date']))."' and status != 'Closed'";
				} else {
					$query        .= " and meeting_date > '".date('Y-m-d')."' and status != 'Closed'";
				}

			} else if($request['from'] == "history") {
				if(!empty($request['from_date']) && !empty($request['to_date'])) {
					$query        .= " and meeting_date BETWEEN '".date('Y-m-d',strtotime($request['from_date']))."' and '".date('Y-m-d',strtotime($request['to_date']))."' status = 'Closed'";
				} else {
					$query        .= " and status = 'Closed'";
				}
			}
		}
		
		$query        .= " group by appointment_no,meeting_time_from,meeting_time_to,meeting_person_details,meeting_location,status,meeting_date,department";
		// echo $query;exit;
		$request_list = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($request_list,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row; 
		}
		return $result;
	}

	public function get_calendar_data($request)
	{	
		$result 	  = array();

		$query        = "SELECT appointment_no,FORMAT(meeting_date,'yyyy-MM-dd') as meeting_date from VM_Appointment_Request where status != 'Closed'";
		$data        = sqlsrv_query($this->conn,$query);
		while($row    = sqlsrv_fetch_array($data,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	}

	public function get_meeting_reviews_list($request)
	{
		$result['reviews_data']		  = array();
		$result['meeting_person_names'] = array();
		$result['single_meeting_person_names'] = array();

		$query        = "SELECT VM_Appointment_Request.appointment_no,VM_Meeting_reviews.meeting_particulars,VM_Meeting_reviews.meeting_points,VM_Meeting_reviews.meeting_person_code from VM_Appointment_Request inner join VM_Meeting_reviews on VM_Appointment_Request.id = VM_Meeting_reviews.appointment_request_id where VM_Appointment_Request.status = 'Closed'";
		
		if(isset($request['for']) && $request['for'] == 'visitors_info') {
			$query        = "SELECT VM_Appointment_Request.appointment_no,VM_Meeting_reviews.meeting_particulars,VM_Meeting_reviews.meeting_points,VM_Meeting_reviews.meeting_person_code,VM_Appointment_visitors.visitor_name,VM_Appointment_visitors.visitor_designation,VM_Appointment_visitors.visitor_mail_id,VM_Appointment_visitors.visitor_company_details,VM_Appointment_visitors.arrival_status,VM_Appointment_visitors.visitor_mobile_no from VM_Appointment_Request 
			inner join VM_Meeting_reviews on VM_Appointment_Request.id = VM_Meeting_reviews.appointment_request_id 
			inner join VM_Appointment_visitors on VM_Appointment_Request.id = VM_Appointment_visitors.appointment_request_id where VM_Appointment_Request.status = 'Closed' and VM_Appointment_Request.appointment_no = '".$request['appointment_no']."'";
		}

		// echo $query;exit;

		$request_list = sqlsrv_query($this->conn,$query);
		// print_r( sqlsrv_errors());exit;
		while($row = sqlsrv_fetch_array($request_list,SQLSRV_FETCH_ASSOC)) {
			// $result[] = $row; 
			array_push($result['reviews_data'],$row);
			$code_arr = explode(',',$row['meeting_person_code']);
			$meeting_person_name = array();
			for($i = 0;$i< count($code_arr);$i++) {
				$meeting_person_name[] = $this->get_employee_name($code_arr[$i]);
				$result['single_meeting_person_names'] = $meeting_person_name;

			} 

 		 	$meeting_person_names = (COUNT($meeting_person_name) > 0) ? implode(',', $meeting_person_name) : '';

				array_push($result['meeting_person_names'],$meeting_person_names);
 		 	// echo "<pre>";print_r($meeting_person_name);exit;
 		 	// if(isset($request['for']) && $request['for'] == 'visitors_info') {
			// 	array_push($result['meeting_person_names'],$meeting_person_name);
 		 	// } else {
 		 	// }
		}
		return $result;
	}

	public function get_meeting_location($request)
	{	
		$result 	  = array();

		$query        = "SELECT DISTINCT Plant_Code,Plant_Name from Plant_Master_PO";
		$location     = sqlsrv_query($this->conn,$query);
		while($row = sqlsrv_fetch_array($location,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;	
	}

}

?>