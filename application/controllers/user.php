<?php 
//error_reporting(0);
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
	}
	
	public function index()
	{		
		chk_access('users',2,true);
		
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
			$user['UserId'] = $this->input->post('userId');							
			$user['name'] = $this->input->post('name');										
			$user['email'] = $this->input->post('email');										
			$user['mobile'] = $this->input->post('mobile');																
			$user['circle_id'] = $this->input->post('circle_id');	
			$user['ssa_id'] = $this->input->post('ssa_id');													
			$user['other_details'] = $this->input->post('other_note_details');					
			
			try {
				$this->db->trans_begin();  // Transaction Start
				
				if($id != ''){
					$user['updated_by'] = $admin_id;
					$user['updated_at'] = date('Y-m-d H:i:s');	
					$user['updated_from'] = 'FORM';	
					
					$this->db->where('id',$id);
					if($this->db->update(TBL_USERS, $user)){
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
					
					if($this->db->insert(TBL_USERS, $user)){
						$inserted_id = $this->db->insert_id();
						
						if($this->db->trans_status() === FALSE) {								
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						} else {
							$this->db->trans_commit(); // Transaction Commit
						
							$response['status'] = true;
							$response['message'] = 'User registered successfully';
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
				chk_access('users',3,true);
				
				$data['record'] = $this->admin_model->get_record_md5(TBL_USERS,$id);
				if(isset($_SERVER['HTTP_REFERER'])){			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_access('users',2,true);
			}	
					
			$data['pageTitle'] = 'Manage Users';
			$data['content'] = 'register_user';
			$this->load->view('layout',$data);
		}
	}
	
	public function upload_users(){
		$response = array();
		
		if($this->input->post('upload') == 'true'){
			
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
						$users = array(); $count = 0; $errors = array(); $row = 1;
						foreach($uploaded_users as $k=>$rcrd){
							if($k <= 1){
								
								if($rcrd['A'] != 'User Id' || $rcrd['B'] != 'Name' || $rcrd['C'] != 'Email' || $rcrd['D'] != 'Mobile' || count($rcrd) > 16){
									$response['status'] = false;
									$response['message'] = 'Wrong File Format.<br/>Please check your file.';
									echo json_encode($response); die;
								}
								continue;
							}
																				
							$user = array(); $row = $k;
							$user['UserId'] = $rcrd['A'];
							
							if(!empty($rcrd['B'])){
								$user['name'] = $rcrd['B'];							
							} else {
								$errors[] = "Name Not Available. Row[$row]";
							}
							
							if(!empty($rcrd['C'])){
								$user['email'] = $rcrd['C'];
								
								$_GET['email'] = $user['email'];
								$exist = $this->check_userEmail(true);	
								if(!$exist){
									$errors[] = "Email already exist. Row[$row]";
								}
							} else {
								$errors[] = "Email Not Available. Row[$row]";
							}
							
							if(!empty($rcrd['D'])){
								$user['mobile'] = $rcrd['D'];
								
								$_GET['mobile'] = $user['mobile'];
								$exist = $this->check_userMobile(true);	
								if(!$exist){
									$errors[] = "Mobile already exist. Row[$row]";
								}
							} else {
								$errors[] = "Mobile Not Available. Row[$row]";
							}
							
							if(!empty($rcrd['E'])){
								$circle = $rcrd['E'];
								$circle = $this->db->get_where(TBL_CIRCLES, array('circle_name' => $circle, 'status' => 0))->row_array();
								if(!empty($circle)){
									$user['circle_id'] = $circle['id'];
								} else {
									$errors[] = "Circle is Not valid. Row[$row]";
								}
							} else {
								$errors[] = "Circle Not Available. Row[$row]";
							}
							
							if(!empty($rcrd['F']) && !empty($user['circle_id'])){
								$ssa = $rcrd['F'];
								$ssa = $this->db->get_where(TBL_SSA, array('ssa_name' => $ssa, 'status' => 0, 'circle_id' => $$user['circle_id']))->row_array();
								if(!empty($ssa)){
									$user['ssa_id'] = $ssa['id'];
								} else {
									$errors[] = "SSA is Not valid. Row[$row]";
								}
							} else {
								$errors[] = "SSA Not Available. Row[$row]";
							}
							
							$_GET['userId'] = $user['UserId'];
							$already_exist = $this->check_userId(true);								
							try {
								$this->db->trans_begin();  // Transaction Start
							
								if(!empty($already_exist)){
									$user['updated_by'] = $admin_id;
									$user['updated_at'] = date('Y-m-d H:i:s');
									$user['updated_from'] = 'CSV';		
									
									$this->db->where('id', $already_exist['id']);
									if(!$this->db->update(TBL_USERS, $user)){
										$errors[] = "Unable to save. Row[$row]";
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
									
									if($this->db->insert(TBL_USERS, $user)){		
										$inserted_id = $this->db->insert_id();
										
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
								$errors[] = "$error. Row[$row]";								
							}							
						}
						
						if(count($errors) == 0){
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
	
	public function check_userId($return=false){		
		$userId = $this->input->get('userId');
		$id = $this->input->get('id');
		if(trim($id) == ''){
			$id = 999999999999;
		}
		
		$already = $this->db->get_where(TBL_USERS,array('UserId' => $userId,'id != ' => $id))->row_array();
		if(!empty($already)) {
			$status = false;
		} else {
			$status = true;
		}
		
		if($return){
			return $status;
		}
		echo $status;
	}
	
	public function check_userEmail($return=false){		
		$email = $this->input->get('email');
		$id = $this->input->get('id');
		if(trim($id) == ''){
			$id = 999999999999;
		}
		
		$already = $this->db->get_where(TBL_USERS,array('email' => $email,'id != ' => $id))->row_array();
		if(!empty($already)) {
			$status = false;
		} else {
			$status = true;
		}
		
		if($return){
			return $status;
		}
		echo $status;
	}
	
	public function check_userMobile($return=false){		
		$mobile = $this->input->get('mobile');
		$id = $this->input->get('id');
		if(trim($id) == ''){
			$id = 999999999999;
		}
		
		$already = $this->db->get_where(TBL_USERS,array('mobile' => $mobile,'id != ' => $id))->row_array();
		if(!empty($already)) {
			$status = false;
		} else {
			$status = true;
		}
		
		if($return){
			return $status;
		}
		echo $status;
	}
	
	public function user_view($UserId=NULL)
	{
		chk_access('users',1,true);
		
		$data['user'] = $this->admin_model->get_record_md5('ts_users', $UserId);
		$UserId = $data['user']['id'];
		$data['user_devices'] = $this->admin_model->get_user_devices($UserId);
		$data['device_surrender_logs'] = $this->admin_model->device_surrender_logs($UserId);
		$data['surrender_type'] = $this->surrender_type;
		$data['pageTitle'] = 'Employee Details';
		$data['content'] = 'user-details';
		$this->load->view('layout',$data);
	}
	
	public function change_users_password()
	{
		chk_access('users',3,true);
		
		$user_id = @$_POST['user_id'];
		$password = @$_POST['password'];
		$cpassword = @$_POST['cpassword'];
				
		$response = array();
		if(trim($user_id) != '' && trim($password) != '' && trim($cpassword) != '')
		{
			if(trim($password) == trim($cpassword))
			{
				$user = $this->admin_model->get_record('ts_users', $user_id, 'name,email');
				
				$password = md5($password);
				$UpdateData = array('password' => $password);
				$this->db->where('id',$user_id);
				if($this->db->update('ts_users',$UpdateData))
				{
					$response['status'] = true;
					$response['message'] = 'Password Changed Successfully';
					
					$emailTemplate = $this->admin_model->get_record('ts_email_config',38);
					$template = @$emailTemplate['description'];						
					$template = str_replace('{{name}}',$user['name'],$template);
					
					$mail = array(); $email = $user['email'];
					$mail['subject'] = @$emailTemplate['subject'];
					$mail['message'] = $template;
					$mail['purpose'] = @$emailTemplate['purpose'];
					$sent = send_mail($email,$mail,$attachment);
				}
				else
				{
					$response['status'] = false;
					$response['message'] = 'Unable to change password';
				}
			}
			else
			{
				$response['status'] = false;
				$response['message'] = 'Both password must be same';
			}
		}
		else
		{
			$response['status'] = false;
			$response['message'] = 'Unable to change password';
		}
		
		echo json_encode($response);die;
	}
	
	public function change_user_status()
	{
		chk_access('users',4,true);
				
		$status = @$_GET['status'];
		$UserId = @$_GET['user_id'];
		$field = @$_GET['field'];
		$data = array();
		if(trim($status) != '' && trim($UserId) != '' && trim($field) != '')
		{			
			$UpdateData = array($field => $status);
			$this->db->where('id',$UserId);
			if($this->db->update('ts_users',$UpdateData))
			{
				$data['status'] = true;
				$data['data'] = $UpdateData;
				$data['message'] = 'Changed Success';
			}
			else
			{
				$data['status'] = false;
				$data['message'] = 'Unable to change';
			}
		}
		else
		{
			$data['status'] = false;
			$data['message'] = 'Unable to change';
		}
		if(isset($_GET['action']))
			redirect($_SERVER['HTTP_REFERER']);
		else
			echo json_encode($data);die;
	}
	
	public function users()
	{		
		chk_access('users',1,true);
		
		$per_page = 20; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_all_users($per_page,$page);
			
		if(@$_GET['verified'] != '' || @$_GET['name'] != '')
			$base_url = BASE_URL.'employees/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'employees/list?page=true';
			
		$total_rows = $result['count'];	
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		
		$data['users'] = $result['result'];
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/user-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['roles'] = $this->db->get_where('ts_user_roles',array('status' => 1))->result_array();
		
		$data['pageTitle'] = 'Employees';
		$data['content'] = 'users';
		$this->load->view('layout',$data);
	}
}
