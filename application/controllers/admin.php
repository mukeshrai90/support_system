<?php 
error_reporting(0);
class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
		$this->load->model('admin_model');			
	}
	
	public function index()
	{		
		chk_access('admins', 1, true);
		
		$per_page = 10; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_all_admins($per_page, $page);
				
		if(!empty($_GET['status']) != '' || !empty($_GET['name'])){
			$base_url = BASE_URL.'admins/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'admins/list?page=true';
		}
			
		$total_rows = $result['count'];	
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		
		$data['admins'] = $result['result'];
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/admin-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['roles'] = $this->admin_model->get_all_roles();
		
		$data['pageTitle'] = 'Admins';
		$data['content'] = 'admin/admins';
		$this->load->view('layout',$data);
	}
			
	public function manage_admin($admin_id=NULL)
	{				
		if(!empty($_POST)) {					
			$result = $this->admin_model->manage_admin();			
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Added Successfully.';
					$response['redirectTo'] = BASE_URL.'admins/list';
					
					/*$name = $this->input->post('name');
					$username = $this->input->post('emp_code');
					$email = $this->input->post('email');
					
					$emailTemplate = $this->admin_model->get_record('ts_email_config',37);
					$template = $emailTemplate['description'];	
					
					$template = str_replace('{{name}}', $name, $template);				
					$template = str_replace('{{email}}', $email, $template);				
					$template = str_replace('{{username}}', $username, $template);				
					$template = str_replace('{{password}}', $emailed_code, $template);							
					$template = str_replace('{{url}}', BASE_URL, $template);							

					$mail = array();
					$mail['subject'] = @$emailTemplate['subject'];
					$mail['message'] = $template;
					$mail['purpose'] = @$emailTemplate['purpose'];
					$sent = send_mail($email,$mail); 
					
					$this->session->set_flashdata('success','Added successfully.');
					redirect(BASE_URL.'admin/access/manage/'.md5($insert_id)); */
					
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.';
			}
			
			echo json_encode($response);die;	
								
		} else {												
			
			if(!empty($admin_id)) {
				chk_access('admins' ,3, true);
				
				$admin_id = DeCrypt($admin_id);
				
				$data['record'] = $this->admin_model->get_record('bs_admins', 'admin_id', $admin_id);
				$data['admin_roles'] = $this->admin_model->get_admin_roles($admin_id);
				
				$data['ssa'] = $this->admin_model->get_SSA($data['record']['user_circle_id']);
				
				if(isset($_SERVER['HTTP_REFERER'])){			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
				
			} else {
				chk_access('admins', 2, true);
			}	

			$data['circles'] = $this->admin_model->get_Circles();
			
			$data['roles'] = $this->admin_model->get_all_roles();
			
			$data['pageTitle'] = 'Manage Admin';
			$data['content'] = 'admin/manage-admin';
			$this->load->view('layout',$data);
		}
	}		
	
	public function admin_view($admin_id=NULL)
	{
		chk_access('admins',1, true);
		
		$admin_id = DeCrypt($admin_id);
		
		$data['user'] = $this->admin_model->get_record('bs_admins', 'admin_id', $admin_id);
		$data['pageTitle'] = 'Admin Details';
		$data['content'] = 'admin/admin-details';
		$this->load->view('layout',$data);
	}		
	
	public function manage_access($admin_id=NULL,$return=false)
	{
		chk_access('admins',3,true);
				
		$admin = $this->admin_model->get_record_md5('ts_users', $admin_id, 'id,have_admin_access');
		$this->session->set_userdata('access_admin_id',$admin['id']);
		
		$data['actions'] = $this->admin_model->get_all_actions($admin['id']);
		$data['have_admin_access'] = $admin['have_admin_access'];
		
		if($return){
			return $data['actions'];
		}
		
		$data['pageTitle'] = 'Manage Access';
		$data['content'] = 'admin/manage-access';
		$this->load->view('layout',$data);
	}
	
	public function access_update()
	{
		chk_access('admins',4, true);
		
		if(!empty($_POST)) {
			$admin_id = $this->session->userdata('access_admin_id');
			
			$type = $this->input->post('type');
			$action = $this->input->post('action');
			$access = $this->input->post('access');
			$created = date('Y-m-d H:i:s');
			
			if($action ==  'all_access'){
				$data = array('have_admin_access' => $access);
				$this->db->where('id',$admin_id);
				$this->db->update('ts_users',$data);
					
				$response['status'] = true;
				$response['message'] = "success";
					
			} else {
				if(trim($admin_id) != '' || trim($type) != '' || trim($access) != '' || trim($action) != '') {
					$already = $this->db->get_where('ts_subadmin_access',array('admin_id' => $admin_id,'type' => $type,'action' => $action))->row_array();
					if(!empty($already)) {
						$data = array('admin_id' => $admin_id,'action' => $action,'type' => $type,'access' => $access);
						$this->db->where('id',$already['id']);
						$this->db->update('ts_subadmin_access',$data);
						
					} else {
						$data = array('admin_id' => $admin_id,'action' => $action,'type' => $type,'access' => $access,'created' => $created);
						$this->db->insert('ts_subadmin_access',$data);
					}
					$response['status'] = true;
					$response['message'] = "success";
					
				} else {
					$response['status'] = false;
					$response['message'] = "Unable to process your request.<br/>Please try again or some time later";
				}	
			} 	
		} else {
			$response['status'] = false;
			$response['message'] = "Unable to process your request.<br/>Please try again or some time later";
		}
		echo json_encode($response);die;
	}
	
	public function delete_admin($admin_id=NULL)
	{
		if($this->session->userdata('admin_id') == 1) {
		
			if(trim($admin_id) != '')
			{
				$UpdateData = array('deleted' => 1);
				
				$this->db->where('id',$admin_id);			
				if($this->db->update('admins', $UpdateData)) {			
					$this->session->set_flashdata('success','Deleted successfully');
				} else{
					$this->session->set_flashdata('error','Unable to delete');
				}
			}
			else
			{
				$this->session->set_flashdata('error','Unable to delete');
			}
		}
		
		$redirect_to = str_replace(base_url(),'',$_SERVER['HTTP_REFERER']);
		redirect(str_replace('index.php/','',$redirect_to));
	}
	
	public function change_admin_password()
	{
		chk_access('admins', 3, true);
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$admin_id = @$_POST['admin_id'];
		$admin_id = DeCrypt($admin_id);
		$password = @$_POST['password'];
		$cpassword = @$_POST['cpassword'];
				
		$response = array();
		if(!empty($admin_id) && !empty($password) && !empty($cpassword)) {
			if(trim($password) == trim($cpassword)) {
				$password = md5($password);
				
				try{
					$this->db->trans_begin();  // Transaction Start
				
					$UpdateData = array('admin_password' => $password);
					$this->db->where('admin_id', $admin_id);
					if($this->db->update('bs_admins', $UpdateData)) {
						
						$CallInsertData = array();
						$CallInsertData['call_user_id'] = $admin_id;
						$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
						$CallInsertData['call_desc'] = 'Password has been changed';
						$CallInsertData['call_type'] = 4;
						$CallInsertData['call_time'] = date('Y-m-d H:i:s');
						
						if($this->db->insert('bs_admin_call_logs', $CallInsertData)) {
							if($this->db->trans_status() === FALSE) {
								throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');								
							} else {
								$this->db->trans_commit(); // Transaction Commit
								$response['status'] = true;
								$response['message'] = 'Password Changed Successfully';
							}
						} else {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						}				
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
					}
					
				}  catch(Exception $e){
					$this->db->trans_rollback(); // Transaction Rollback
					$response['status'] = false;	
					$response['message'] = $e->getMessage();
				}	
			} else {
				$response['status'] = false;
				$response['message'] = 'Unable to process your request. <br/> Please try again or some later';
			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Unable to process your request. <br/> Please try again or some later';
		}
		
		echo json_encode($response);die;
	}
	
	public function change_admin_status()
	{
		chk_access('admins', 4, true);
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
				
		$status = $this->input->post('status');
		$admin_id = $this->input->post('admin_id');
		$admin_id = DeCrypt($admin_id);
		
		$response = array();
		if(!empty($status) && !empty($admin_id)) {			
			
			try{
				$this->db->trans_begin();  // Transaction Start
			
				$UpdateData = array('admin_status' => $status);
				$this->db->where('admin_id' ,$admin_id);
				if($this->db->update('bs_admins', $UpdateData)) {
					
					$sts_array = array(0 => 'Inactive', 1 => 'Active', 2 => 'Desabled');
					$sts_txt = $sts_array[$status];
					
					$CallInsertData = array();
					$CallInsertData['call_user_id'] = $admin_id;
					$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
					$CallInsertData['call_desc'] = 'Status has been changed to "'.$sts_txt.'"';
					$CallInsertData['call_type'] = 3;
					$CallInsertData['call_time'] = date('Y-m-d H:i:s');
					
					if($this->db->insert('bs_admin_call_logs', $CallInsertData)) {
						if($this->db->trans_status() === FALSE) {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');								
						} else {
							$this->db->trans_commit(); // Transaction Commit
							$response['status'] = true;
							$response['message'] = 'Status Changed Successfully';
						}
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
					}				
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
				}
				
			}  catch(Exception $e){
				$this->db->trans_rollback(); // Transaction Rollback
				$response['status'] = false;	
				$response['message'] = $e->getMessage();
			}	
		} else {
			$response['status'] = false;
			$response['message'] = 'Unable to process your request. <br/> Please try again or some later';
		}
		
		echo json_encode($response);die;
	}
	
	public function afe_users()
	{		
		chk_access('afe_users', 1, true);
		
		$per_page = 20; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_afe_users($per_page, $page);
				
		if(!empty($_GET['status']) || !empty($_GET['name'])){
			$base_url = BASE_URL.'afe-users/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'afe-users/list?page=true';
		}
			
		$total_rows = $result['count'];	
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		
		$data['users'] = $result['result'];
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-users-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'AFE Users';
		$data['content'] = 'admin/afe-users';
		$this->load->view('layout',$data);
	}
	
	public function afe_users_details($afe_id=NULL)
	{
		chk_access('afe_users', 1, true);
		
		$afe_id = DeCrypt($afe_id);
		$data['record'] = $this->admin_model->get_afe_details($afe_id);
		
		$data['pageTitle'] = 'AFE Details';
		$data['content'] = 'admin/afe_user_details';
		$this->load->view('layout',$data);
	}
	
	public function manage_afe($admin_id=NULL)
	{				
		if(!empty($_POST)) {					
			$result = $this->admin_model->manage_afe();			
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Added Successfully.';
				} else {
					$response['message'] = 'Updated Successfully.';
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.';
			}
			
			echo json_encode($response);die;
								
		} else {												
			
			if(!empty($admin_id)) {
				chk_access('afe_users', 3, true);
				
				$admin_id = DeCrypt($admin_id);				
				$data['record'] = $this->admin_model->get_record('bs_afe_users', 'afe_id', $admin_id);
				
				$data['ssa'] = $this->admin_model->get_SSA($data['record']['user_circle_id']);
				
			} else {
				chk_access('afe_users', 2, true);
			}	

			$data['circles'] = $this->admin_model->get_Circles();
						
			$data['pageTitle'] = 'Manage AFE Users';
			$data['content'] = 'admin/manage-afe-users';
			$this->load->view('layout',$data);
		}
	}	
	
	public function check_admin_username($return=false){		
		$username = $this->input->get('username');
		$admin_id = $this->input->get('id');
		$admin_id = DeCrypt($admin_id);
		
		$sts = $this->admin_model->check_admin_username($username, $admin_id);
		echo $sts;
	}
	
	public function check_admin_email($return=false){		
		$email = $this->input->get('email');
		$admin_id = $this->input->get('id');
		$admin_id = DeCrypt($admin_id);
		
		$sts = $this->admin_model->check_admin_email($email, $admin_id);
		echo $sts;
	}
	
	public function check_afe_user_email($return=false){		
		$username = $this->input->get('email');
		$user_id = $this->input->get('id');
		$user_id = DeCrypt($user_id);
		
		$sts = $this->admin_model->check_afe_user_email($username, $user_id);
		echo $sts;
	}
	
	public function check_afe_user_mobile($return=false){		
		$email = $this->input->get('mobile');
		$user_id = $this->input->get('id');
		$user_id = DeCrypt($user_id);
		
		$sts = $this->admin_model->check_afe_user_mobile($email, $user_id);
		echo $sts;
	}
}
