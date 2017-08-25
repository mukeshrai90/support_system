<?php 
//error_reporting(0);
class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
	}
	
	public function index()
	{		
		chk_admin_access('users',2,true);
		
		$data['pageTitle'] = 'Bulk User Registration';
		$data['content'] = 'csv_user_upload';
		$this->load->view('layout',$data);
	}
	
	public function register_user($id=NULL){
		
		$response = array();
		if($this->input->post('role_id') != ''){
			
			$admin_id = $this->session->userdata('admin_id');
			
			$id = $this->input->post('id');
			
			$user = array();
			$user['sequence_no'] = $this->input->post('sequence_no');
			$user['emp_code'] = $this->input->post('emp_code');							
			$user['name'] = $this->input->post('name');										
			$user['email'] = $this->input->post('email');										
			$user['mobile'] = $this->input->post('mobile');										
			$user['role_id'] = $this->input->post('role_id');										
			$user['designation'] = $this->input->post('designation');									
			$user['department'] = $this->input->post('department');										
			$user['location'] = $this->input->post('location');										
			$user['city'] = $this->input->post('city');										
			$user['manager_emp_code'] = $this->input->post('manager_emp_code');										
			$user['desktop_id'] = $this->input->post('desktop_id');	
			$user['laptop_id'] = $this->input->post('laptop_id');	
			$user['other_device_ids'] = $this->input->post('other_device_ids');	
			$user['machine_specification'] = $this->input->post('machine_specification');												
			$user['other_details'] = $this->input->post('other_note_details');					
			
			try {
				$this->db->trans_begin();  // Transaction Start
				
				if($id != ''){
					$user['updated_by'] = $admin_id;
					$user['updated_at'] = date('Y-m-d H:i:s');	
					$user['updated_from'] = 'FORM';	
					
					$this->db->where('id',$id);
					if($this->db->update('ts_users',$user)){
						
						if(!empty($user['desktop_id'])){
							$user['other_device_ids'] = $user['other_device_ids'].','.$user['desktop_id']; 
						}
						if(!empty($user['laptop_id'])){
							$user['other_device_ids'] = $user['other_device_ids'].','.$user['laptop_id']; 
						}
						
						if($user['other_device_ids'] != ''){
							$device_ids = $user['other_device_ids'];
							$device_array = explode(',', $device_ids);
							
							$data = array('assigned_status' => 0);
							$this->db->where('user_id', $id);
							$this->db->where('assigned_status', 1);
							if(!$this->db->update('ts_user_assigned_devices', $data)){
								throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');				
							}
							
							foreach($device_array as $device_id){
								if($device_id != ''){
									$already_exist = $this->db->get_where('ts_user_assigned_devices', array('user_id' => $id, 'device_id' => $device_id, 'assigned_status' => 0))->row_array();								
									if(!empty($already_exist)){
										$data = array('assigned_status' => 1);
										$this->db->where('id', $already_exist['id']);
										if(!$this->db->update('ts_user_assigned_devices', $data)){
											throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
											break;
										} 
									} else {
										$data = array('user_id' => $id, 'device_id' => $device_id, 'assigned_status' => 1,'assigned_date' => date('Y-m-d H:i:s'));
										if(!$this->db->insert('ts_user_assigned_devices', $data)){
											throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
											break;
										}
									}
								}
							}
						}
						
						if($this->db->trans_status() === FALSE) {								
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						} else {
							$this->db->trans_commit(); // Transaction Commit
						
							$response['status'] = true;
							$response['message'] = 'User updated successfully';
						}
					} else {
						$response['status'] = false;
						$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
					}
				} else {
					$user['added_from'] = 'FORM';					
					$code = $user['mobile'];
					if(empty($code)){
						$code = mt_rand(100000,999999);	
					}					
					$password = md5($code);
					
					$user['password'] = $password;		
					$user['emailed_code'] = $code;		
					$user['date_added'] = date('Y-m-d H:i:s');		
					$user['registered_by'] = $admin_id;
					
					if($this->db->insert('ts_users', $user)){
						$inserted_id = $this->db->insert_id();
						
						if(!empty($user['desktop_id'])){
							$user['other_device_ids'] = $user['other_device_ids'].','.$user['desktop_id']; 
						}
						if(!empty($user['laptop_id'])){
							$user['other_device_ids'] = $user['other_device_ids'].','.$user['laptop_id']; 
						}
						
						if($user['other_device_ids'] != ''){
							$device_ids = $user['other_device_ids'];
							$device_array = explode(',', $device_ids);
							
							$insertBatch = array(); $arr_cnt = 0;
							foreach($device_array as $device_id){
								if($device_id != ''){
									$data = array('user_id' => $inserted_id, 'device_id' => $device_id, 'assigned_status' => 1,'assigned_date' => date('Y-m-d H:i:s'));
									$insertBatch[$arr_cnt] = $data;
									$arr_cnt++;
								}
							}
							
							if(count($insertBatch > 0)){								
								if(!$this->db->insert_batch('ts_user_assigned_devices', $insertBatch)){
									throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
								}
							}
						}
						
						if($this->db->trans_status() === FALSE) {								
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						} else {
							$this->db->trans_commit(); // Transaction Commit
						
							$response['status'] = true;
							$response['message'] = 'User registered successfully';
							
							$rslt_arr = $this->send_registeration_notifications($user);
							
							$update_arr = array();
							if($rslt_arr[0]){
								$update_arr['email_sent'] = 1;
							}
							if($rslt_arr[1]){
								$update_arr['sms_sent'] = 1;
							}
							
							if(!empty($update_arr)){
								$this->db->where('id',$inserted_id);
								$this->db->update('ts_users',$update_arr);			
							}
						}
						
					} else {
						$response['status'] = false;
						$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
					}
				}
			} catch(Exception $e) {
				$this->db->trans_rollback(); // Transaction Rollback
				
				$response['status'] = false;
				$response['message'] = $e->getMessage();
			}			
			echo json_encode($response); die;
			
		} else {
				
			if(trim($id) != '') {
				chk_admin_access('users',3,true);
				
				$data['record'] = $this->admin_model->get_record_md5('ts_users',$id);
				if(isset($_SERVER['HTTP_REFERER'])){			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('users',2,true);
			}	
			$data['roles'] = $this->db->get_where('ts_user_roles',array('status' => 1))->result_array();
			$this->db->where_in('role_id', array(2,6));
			$data['managers'] = $this->db->get_where('ts_users',array('id > ' => '1'))->result_array();			
			$data['pageTitle'] = 'Manage Users';
			$data['content'] = 'register_user';
			$this->load->view('layout',$data);
		}
	}
	
	public function upload_users(){
		$response = array();
		
		if($this->input->post('upload') == 'true'){
			$user_type = $this->input->post('user_type');
			
			$admin_id = $this->session->userdata('admin_id');
			
			if(isset($_FILES['csv_file']) && $_FILES['csv_file']['name'] != ''){
				if($_FILES['csv_file']['size'] > 0){
					$tmp_file = $_FILES['csv_file']['tmp_name'];
					
					$this->load->library('upload'); 
					$config['upload_path'] = './assets/uploads/excels/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = '100000';					
					$this->upload->initialize($config);
					
					$file_name = str_replace(' ','',$_FILES['csv_file']['name']);
					$temp = explode('.',$file_name);					
					$temp[0] = $temp[0].'-'.date('Ymd_His');
					$file_name = $temp[0].'.'.end($temp);
					$_FILES['csv_file']['name'] = $file_name;				
					
					$this->upload->do_upload('csv_file');
										
					$file = $tmp_file;
					ini_set('memory_limit', '-1');
					ini_set('max_execution_time','3600');
				
					$this->load->library('excel');
					PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					$objPHPExcel = PHPExcel_IOFactory::load($file);
					$sheetCount = $objPHPExcel->getSheetCount();			
					$objPHPExcel->setActiveSheetIndex(0);
					$sheetName = $objPHPExcel->getActiveSheet()->getTitle();
					$uploaded_users = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);	
						
					if(!empty($uploaded_users)){						
						$users = array(); $count = 0; $error = '';
						foreach($uploaded_users as $k=>$rcrd){
							if($k <= 1){
								
								if($rcrd['B'] != 'Emp Code' || $rcrd['C'] != 'Name' || $rcrd['D'] != 'Email' || $rcrd['F'] != 'Role' || count($rcrd) != 16){
									$response['status'] = false;
									$response['message'] = 'Wrong File Format.<br/>Please check your file.';
									echo json_encode($response); die;
								}
								
								continue;
							}
							
							$roles = array('Employee' => 5, 'Manager' => 2);
							$role_id = $roles[$rcrd['F']];
							
							if(isset($rcrd['B']) && $rcrd['B'] != '' && in_array($role_id, array(2,5))){							
								
								$user = array();
								$user['sequence_no'] = $rcrd['A'];
								
								if(!empty($rcrd['B'])){
									$user['emp_code'] = $rcrd['B'];
								}
									
								if(!empty($rcrd['C'])){
									$user['name'] = $rcrd['C'];							
								}
								
								if(!empty($rcrd['D'])){
									$user['email'] = $rcrd['D'];		
								}
								
								if(!empty($rcrd['E'])){
									$user['mobile'] = $rcrd['E'];
								}
								$user['role_id'] = $role_id;		

								if(!empty($rcrd['G'])){
									$user['designation'] = $rcrd['G'];
								}

								if(!empty($rcrd['H'])){
									$user['department'] = $rcrd['H'];
								}

								if(!empty($rcrd['I'])){
									$user['location'] = $rcrd['I'];	
								}

								if(!empty($rcrd['J'])){
									$user['city'] = $rcrd['J'];	
								}
								
								if(!empty($rcrd['K'])){
									$user['manager_emp_code'] = $rcrd['K'];
								}
								
								if(!empty($rcrd['L'])){
									$user['desktop_id'] = $rcrd['L'];	
								}
								
								if(!empty($rcrd['M'])){
									$user['laptop_id'] = $rcrd['M'];		
								}
								
								if(!empty($rcrd['N'])){
									$user['other_device_ids'] = $rcrd['N'];		
								}
								
								if(!empty($rcrd['O'])){
									$user['machine_specification'] = $rcrd['O'];	
								}
								
								if(!empty($rcrd['P'])){
									$user['other_details'] = $rcrd['P'];
								}
																
								$already_exist = $this->admin_model->get_user_by_emp_code($user['emp_code'],'id');								
								try {
									$this->db->trans_begin();  // Transaction Start
								
									if(!empty($already_exist)){
										$user['updated_by'] = $admin_id;
										$user['updated_at'] = date('Y-m-d H:i:s');
										$user['updated_from'] = 'CSV';		
										
										$this->db->where('id',$already_exist['id']);
										if(!$this->db->update('ts_users',$user)){
											$error = $error == '' ? 'Yes' : $error;
											
											if(!empty($user['desktop_id'])){
												$user['other_device_ids'] = $user['other_device_ids'].','.$user['desktop_id']; 
											}
											if(!empty($user['laptop_id'])){
												$user['other_device_ids'] = $user['other_device_ids'].','.$user['laptop_id']; 
											}
											
											if($user['other_device_ids'] != ''){
												$device_ids = $user['other_device_ids'];												
												$device_array = explode(',', $device_ids);
												
												$data = array('assigned_status' => 0);
												$this->db->where('user_id', $already_exist['id']);
												$this->db->where('assigned_status', 1);
												if(!$this->db->update('ts_user_assigned_devices', $data)){
													throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');												
												}
												
												foreach($device_array as $device_id){
													if($device_id != ''){
														$device_already_exist = $this->db->get_where('ts_user_assigned_devices', array('user_id' => $id, 'device_id' => $device_id, 'assigned_status' => 0))->row_array();								
														if(!empty($device_already_exist)){
															$data = array('assigned_status' => 1);
															$this->db->where('id', $device_already_exist['id']);
															if(!$this->db->update('ts_user_assigned_devices', $data)){
																throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
																break;
															}
														} else {
															$data = array('user_id' => $id, 'device_id' => $device_id, 'assigned_status' => 1,'assigned_date' => date('Y-m-d H:i:s'));
															if(!$this->db->insert('ts_user_assigned_devices', $data)){
																throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');														
															}
														}
													}
												}
											}
										}
									} else {
										$user['added_from'] = 'CSV';	
										$code = $user['mobile'];	
										if(empty($code)){
											$code = mt_rand(100000,999999);	
										}
										$password = md5($code);
										
										$user['password'] = $password;		
										$user['emailed_code'] = $code;		
										$user['date_added'] = date('Y-m-d H:i:s');		
										$user['registered_by'] = $admin_id;		
										
										if($this->db->insert('ts_users', $user)){		
											$inserted_id = $this->db->insert_id();
											
											if(!empty($user['desktop_id'])){
												$user['other_device_ids'] = $user['other_device_ids'].','.$user['desktop_id']; 
											}
											if(!empty($user['laptop_id'])){
												$user['other_device_ids'] = $user['other_device_ids'].','.$user['laptop_id']; 
											}
											
											if($user['other_device_ids'] != ''){
												$device_ids = $user['other_device_ids'];												
												$device_array = explode(',', $device_ids);
												
												$insertBatch = array(); $arr_cnt = 0;
												foreach($device_array as $device_id){
													if($device_id != ''){
														$data = array('user_id' => $inserted_id, 'device_id' => $device_id, 'assigned_status' => 1,'assigned_date' => date('Y-m-d H:i:s'));
														$insertBatch[$arr_cnt] = $data;
														$arr_cnt++;
													}
												}
												
												if(count($insertBatch > 0)){								
													if(!$this->db->insert_batch('ts_user_assigned_devices', $insertBatch)){
														throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
													} 
												}
											}
										} else {
											throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
										}
									}
									
									if($this->db->trans_status() === FALSE) {								
										throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
									} else {
										$this->db->trans_commit(); 
									}
									
								} catch(Exception $e) {
									$this->db->trans_rollback(); // Transaction Rollback
									$error = $error == '' ? 'Yes' : $error;									
								}	
							}							
						}
						
						if(!$error){
							$response['status'] = true;
							$response['message'] = 'All users have been registered successfully.';
						} else {
							$response['status'] = false;
							$response['message'] = 'There are error occured for inserting/updating some users ';
						}	
					} else {
						$response['status'] = false;
						$response['message'] = 'Please upload a valid CSV file';
					}					
				} else {
					$response['status'] = false;
					$response['message'] = 'Please upload a valid CSV file';
				}
			} else {
				$response['status'] = false;
				$response['message'] = 'Please upload a valid CSV file';
			}																			
		} else {
			$response['status'] = false;
			$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
		}
		echo json_encode($response); die;
	}
	
	public function check_emp_code(){		
		$emp_code = $this->input->get('emp_code');
		$id = $this->input->get('id');
		if(trim($id) == ''){
			$id = 9999;
		}
		
		$already = $this->db->get_where('ts_users',array('emp_code' => $emp_code,'id != ' => $id))->row_array();
		if(!empty($already)) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
	
	public function check_user_email(){		
		$email = $this->input->get('email');
		$id = $this->input->get('id');
		if(trim($id) == ''){
			$id = 9999;
		}
		
		$already = $this->db->get_where('ts_users',array('email' => $email,'id != ' => $id))->row_array();
		if(!empty($already)) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
	
	public function send_registeration_notifications($user){
		
		$username = $user['emp_code'];
		$password = $user['emailed_code'];				
		
		/*** mail to user ***/	
		$emailTemplate = $this->admin_model->get_record('ts_email_config',8);
		$template = @$emailTemplate['description'];						
		$template = str_replace('{{name}}',$user['name'],$template);
		$template = str_replace('{{username}}',$username,$template);	
		$template = str_replace('{{password}}',$password,$template);
		$template = str_replace('{{url}}', BASE_URL, $template);	
							
		$mail = array(); $email = $user['email'];
		$mail['subject'] = @$emailTemplate['subject'];
		$mail['message'] = $template;
		$mail['purpose'] = @$emailTemplate['purpose'];
		$email_sent = send_mail($email,$mail);
		/*** mail to user end ***/	
		
		/*** message to user ***/	
		$username = $user['emp_code'];
		$emailTemplate = $this->admin_model->get_record('ts_email_config',9);
		$template = @$emailTemplate['description'];						
		$template = str_replace('{{name}}',$user['name'],$template);
		$template = str_replace('{{username}}',$username,$template);	
		$template = str_replace('{{password}}',$password,$template);
		
		$login_link = BASE_URL;
		$short_url = get_short_url($login_link);
		
		$template = str_replace('{{url}}',$short_url,$template);	

		$mobile = $user['mobile'];
		$body = array();
		$body['message'] = $template;
		$body['purpose'] = $emailTemplate['purpose'];
		if(!empty($mobile)) {
			$sms_sent = send_sms($mobile,$body);
		}
		/*** message to user end ***/	
		
		return array($email_sent, $sms_sent);
	}			
	
	public function ticket_reports(){
		chk_admin_access('ticket_reports',1,true);			
		
		$per_page = 10; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_ticket_reports($per_page,$page);			
		$total_rows = $result['count'];
		
		if(@$_GET['device_id'] != ''){
			$base_url = BASE_URL.'ticket-reports/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'ticket-reports/list?page=true';
		}
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		$data['tickets'] = $result['result'];
		
		if($this->input->is_ajax_request()){
			$data['result'] = $this->load->view('elements/ticket-reports-list',$data,true);
			echo json_encode($data);die;
		}
					
		$data['pageTitle'] = 'Ticket Reports';
		$data['content'] = 'ticket-reports';
		$this->load->view('layout',$data);				
	}
	
	public function expense_reports(){
		
		chk_admin_access('expense_reports',1,true);		
		
		$per_page = 10; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_expense_reports($per_page,$page);
		$total_rows = $result['count'];
		
		if(@$_GET['device_id'] != ''){
			$base_url = BASE_URL.'expense-reports/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'expense-reports/list?page=true';
		}		
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		$data['tickets'] = $result['result'];
		
		if($this->input->is_ajax_request()){
			$data['result'] = $this->load->view('elements/expense-reports-list',$data,true);
			echo json_encode($data);die;
		}
					
		$data['pageTitle'] = 'Expense Reports';
		$data['content'] = 'expense-reports';
		$this->load->view('layout',$data);	
	}
	
	public function expense_report_details($ticket_id){
		
		chk_admin_access('expense_reports',1,true);		
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						        
		$result = $this->admin_model->get_expense_report_tickets($ticket_id, $per_page, $page);		
		$data['tickets'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		$ticket_id = md5($ticket_id);	
		$base_url = BASE_URL.'expense-reports/view/'.$ticket_id.'?'.$_SERVER['QUERY_STRING'];
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
				
		$data['pageTitle'] = 'Expense Reports';
		$data['content'] = 'expense-report-details';
		$this->load->view('layout',$data);	
	}
	
	public function upload_devices(){
		$response = array();
		
		if($this->input->post('upload') == 'true'){
			
			$admin_id = $this->session->userdata('admin_id');
			
			if(isset($_FILES['devices_csv_file']) && $_FILES['devices_csv_file']['name'] != ''){
				if($_FILES['devices_csv_file']['size'] > 0){
					$tmp_file = $_FILES['devices_csv_file']['tmp_name'];
					
					$this->load->library('upload'); 
					$config['upload_path'] = './assets/uploads/excels/';
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size'] = '100000';					
					$this->upload->initialize($config);
					
					$file_name = str_replace(' ','',$_FILES['devices_csv_file']['name']);
					$temp = explode('.',$file_name);					
					$temp[0] = $temp[0].'-'.date('Ymd_His');
					$file_name = $temp[0].'.'.end($temp);
					$_FILES['devices_csv_file']['name'] = $file_name;				
					
					$this->upload->do_upload('devices_csv_file');
										
					$file = $tmp_file;
					ini_set('memory_limit', '-1');
					ini_set('max_execution_time','3600');
				
					$this->load->library('excel');
					PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					$objPHPExcel = PHPExcel_IOFactory::load($file);
					$sheetCount = $objPHPExcel->getSheetCount();			
					$objPHPExcel->setActiveSheetIndex(0);
					$sheetName = $objPHPExcel->getActiveSheet()->getTitle();
					$uploaded_devices = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);	
				
					if(!empty($uploaded_devices)){						
						$users = array(); $count = 0; $error = '';
						
						$this->db->trans_begin();  // Transaction Start
						foreach($uploaded_devices as $k=>$rcrd){
							if($k <= 1){
								if($rcrd['A'] != 'Device Id' || $rcrd['B'] != 'Device Name' || count($rcrd) != 10){
									
									$this->db->trans_complete();
									
									$response['status'] = false;
									$response['message'] = 'Wrong File Format.<br/>Please check your file.';
									echo json_encode($response); die;
								}
								continue;
							}
							
							if(isset($rcrd['B']) && $rcrd['B'] != ''){
							
								$device = array();
								
								$device_id = $rcrd['A'];
								$device_type = $rcrd['C'];
								
								$device_type_for_map = str_replace(' ', '-', $device_type);
								$device_type_for_map = strtolower($device_type_for_map);
								
								$device['device_id'] = $device_id;
								$device['device_name'] = $rcrd['B'];									
								$device['device_type'] = $device_type;								
								$device['device_type_for_map'] = $device_type_for_map;								
								$device['device_brand'] = $rcrd['D'];														
								$device['device_serial_no'] = $rcrd['E'];							
								$device['device_specification'] = $rcrd['F'];															
								$device['device_ram'] = $rcrd['G'];
								$device['device_warranty_time'] = $rcrd['I'];
								
								$date_of_purchase = $rcrd['H'];
								$date_of_purchase = str_replace("/","-",$date_of_purchase);
								$date_of_purchase = date('Y-m-d',strtotime($date_of_purchase));
								$device['device_purchase_date'] = $date_of_purchase;
																
								$already_exist = $this->db->get_where('ts_devices_inventory', array('device_id' => $device_id))->row_array();
								try {
									
								if(!empty($already_exist)){
										$device['device_updated_by'] = $admin_id;
										$device['device_updated_date'] = date('Y-m-d H:i:s');	
										$device['device_updated_from'] = 'CSV';	
										
										$this->db->where('id',$already_exist['id']);
										if(!$this->db->update('ts_devices_inventory',$device)){
											$error = $error == '' ? 'Yes' : $error;
											throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
										}
									} else {
										
										$device['device_status'] = 1;	
										$device['device_added_date'] = date('Y-m-d H:i:s');		
										$device['device_added_by'] = $admin_id;		
										$device['device_added_from'] = 'CSV';		
										
										if($this->db->insert('ts_devices_inventory', $device)){		
											$inserted_id = $this->db->insert_id();
										} else {
											throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
										}
									}
								} catch(Exception $e) {
									$this->db->trans_rollback(); // Transaction Rollback
									$error = $error == '' ? 'Yes' : $error;	
									break;									
								}	
							}
						}
						
						if(!$error){
							if($this->db->trans_status() === FALSE) {								
								$response['status'] = false;
								$response['message'] = 'There are error occured for inserting/updating some devices.';
							} else {
								$this->db->trans_commit(); // Transaction Commit
							}
							
							$response['status'] = true;
							$response['message'] = 'All devices have been added successfully.';
						} else {
							
							if($this->db->trans_status() === FALSE) {								
								$this->db->trans_rollback(); // Transaction Rollback
							}
							
							$response['status'] = false;
							$response['message'] = 'There are error occured for inserting/updating some devices.';
						}	
					} else {
						$response['status'] = false;
						$response['message'] = 'Please upload a valid CSV file';
					}					
				} else {
					$response['status'] = false;
					$response['message'] = 'Please upload a valid CSV file';
				}
			} else {
				$response['status'] = false;
				$response['message'] = 'Please upload a valid CSV file';
			}																			
			echo json_encode($response); die;
		} else {
			chk_admin_access('devices',2,true);
		
			$data['pageTitle'] = 'Bulk Devices Upload';
			$data['content'] = 'csv_devices_upload';
			$this->load->view('layout',$data);
		}		
	}
	
	public function register_devices($id){
		if($this->input->post('device_id') != ''){
			
			$admin_id = $this->session->userdata('admin_id');
			
			$id = $this->input->post('id');
			
			$device = array();
			$device_id = $this->input->post('device_id');			
			$device_type = $this->input->post('device_type');
								
			$device_type_for_map = str_replace(' ', '-', $device_type);
			$device_type_for_map = strtolower($device_type_for_map);
																				
			$device['device_id'] = $device_id;
			$device['device_name'] = $this->input->post('device_name');							
			$device['device_type'] = $device_type;								
			$device['device_type_for_map'] = $device_type_for_map;										
			$device['device_brand'] = $this->input->post('device_brand');										
			$device['device_serial_no'] = $this->input->post('device_serial_no');										
			$device['device_specification'] = $this->input->post('device_specification');										
			$device['device_ram'] = $this->input->post('device_ram');										
			$device['device_warranty_time'] = $this->input->post('device_warranty_time');				

			$device_purchase_date = $this->input->post('device_purchase_date');
			$device['device_purchase_date'] = date('Y-m-d', strtotime($device_purchase_date));									
			
			try {
				//$this->db->trans_begin();  // Transaction Start
				
				if($id != ''){
					
					$device_exist = $this->db->get_where('ts_devices_inventory', array('device_id' => $device_id, 'id != ' => $id))->row_array();
					if(!empty($device_exist)){
						$response['status'] = false;
						$response['message'] = 'This device Id id already axist in the system';
						
						echo json_encode($response); die;
					}
					
					$device['device_updated_by'] = $admin_id;
					$device['device_updated_date'] = date('Y-m-d H:i:s');
					$device['device_updated_from'] = 'FORM';	
					
					$this->db->where('id',$id);
					if($this->db->update('ts_devices_inventory',$device)){
						
						if(0 && $this->db->trans_status() === FALSE) {								
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						} else {
							//$this->db->trans_commit(); // Transaction Commit
						
							$response['status'] = true;
							$response['message'] = 'Device updated successfully';
						}
					} else {
						$response['status'] = false;
						$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
					}
				} else {									
					
					$device_exist = $this->db->get_where('ts_devices_inventory', array('device_id' => $device_id))->row_array();
					if(!empty($device_exist)){
						$response['status'] = false;
						$response['message'] = 'This device Id id already axist in the system';
						
						echo json_encode($response); die;
					}
					
					$device['device_status'] = 1;	
					$device['device_added_date'] = date('Y-m-d H:i:s');		
					$device['device_added_by'] = $admin_id;
					$device['device_added_from'] = 'FORM';	
					
					if($this->db->insert('ts_devices_inventory', $device)){
						$inserted_id = $this->db->insert_id();
						
						if(0 && $this->db->trans_status() === FALSE) {								
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						} else {
							//$this->db->trans_commit(); // Transaction Commit
						
							$response['status'] = true;
							$response['message'] = 'Device registered successfully';
						}
						
					} else {
						$response['status'] = false;
						$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
					}
				}
			} catch(Exception $e) {
				//$this->db->trans_rollback(); // Transaction Rollback
				
				$response['status'] = false;
				$response['message'] = $e->getMessage();
			}			
			echo json_encode($response); die;
			
		} else {
				
			if(trim($id) != '') {
				chk_admin_access('devices',3,true);
				
				$data['record'] = $this->admin_model->get_record_md5('ts_devices_inventory',$id);
				
				if(isset($_SERVER['HTTP_REFERER'])){			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('devices',2,true);
			}				
			$data['pageTitle'] = 'Manage Devices';
			$data['content'] = 'register_devices';
			$this->load->view('layout',$data);
		}
	}
	
	public function get_devices_by_device_id($device_id, $id){						
		if(trim($id) == ''){
			$id = 9999;
		}
		
		$already = $this->db->get_where('ts_devices_inventory',array('device_id' => $device_id,'id != ' => $id))->row_array();
		if(!empty($already)){
			echo 'false';
		} else {
			echo 'true';
		}
	}
	
	public function devices()
	{		
		chk_admin_access('devices',1,true);
		
		$per_page = 20; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_all_devices($per_page,$page);
		$total_rows = $result['count'];	
				
		if(isset($_GET['device_id']) && $_GET['device_id'] != ''){
			$base_url = BASE_URL.'devices-inventory/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'devices-inventory/list?page=true';
		}
			
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		
		$data['devices'] = $result['results'];
		
		if($this->input->is_ajax_request()){
			$data['result'] = $this->load->view('elements/devices-list',$data,true);
			echo json_encode($data);die;
		}
				
		$data['pageTitle'] = 'Devices Inventory';
		$data['content'] = 'devices-inventoy';
		$this->load->view('layout',$data);
	}
	
	public function device_details($device_id=NULL)
	{
		chk_admin_access('devices',1,true);
		
		$data['device'] = $this->admin_model->get_device($device_id);	
		
		$data['records'] = $this->admin_model->get_devices_assignment_history($data['device']['device_id']);	
		
		$data['pageTitle'] = 'Device Details';
		$data['content'] = 'device-details';
		$this->load->view('layout',$data);
	}
	
	public function assign_devices_to_user(){
		
		if($this->input->post('assign') != ''){
			
			$admin_id = $this->session->userdata('admin_id');
			
			$device_type = $this->input->post('device_type');
			$device_id = $this->input->post('device_id');
			$user_id = $this->input->post('user_id');
			
			$device_exist = $this->db->get_where('ts_devices_inventory', array('device_id' => $device_id))->row_array();			
			if(count($device_exist) > 0){
				
				$result = $this->admin_model->get_device_assigned_status($device_type, $device_id, $user_id);
				
				if(count($result) > 0){
					$response = array();
					if($device_type == 1 || $device_type == 2){
						
						$field = '';
						if($device_type == 1){
							$field = 'desktop_id';
						} else if($device_type == 2){
							$field = 'laptop_id';
						}
						
						if($field != ''){
							$UpdateData = array($field => $device_id);
							
							$this->db->where('id', $user_id);
							if($this->db->update('ts_users', $UpdateData)){
								$response['status'] = true;
								$response['status'] = 'Device Assigned successfully.';
							} else {
								$response['status'] = false;
								$response['status'] = 'Unable to process your request. Please try gain later';
							}
						}
						
					} else {
						$InsertData = array('user_id' => $user_id, 'device_id' => $device_id, 'assigned_status' => 1, 'assigned_date' => date('Y-m-d H:i:s'), 'assigned_by' => $admin_id);
						if($this->insert('ts_user_assigned_devices', $InsertData)){
							$response['status'] = true;
							$response['status'] = 'Device Assigned successfully.';
						} else {
							$response['status'] = false;
							$response['status'] = 'Unable to process your request. Please try gain later';
						}
					}
				} else {
					$response['status'] = false;
					$response['status'] = 'This device is already assigned to '.$result[0]['name'].' ('.$result[0]['emp_code'].')';
				}
			} else {
				$response['status'] = false;
				$response['status'] = 'This device is not exist in the inventory.<br/> Please add this device in the inventory and then proceed.';
			}
			echo json_encode($response); die;
			
		} else {
			
			$user_id = $this->session->userdata('admin_id');
			$role_id = $this->session->userdata('role_id');
			$data['users'] = $this->admin_model->get_team_users($user_id, $role_id);
			
			$data['pageTitle'] = 'Assign Devices';
			$data['content'] = 'assign-devices';
			$this->load->view('layout',$data);
		}
	}
}
