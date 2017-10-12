<?php 
error_reporting(0);
class Home extends CI_Controller {

	var $surrender_type = array(0 => 'Single Device', 1 => 'Full & Final', 2=> 'Surrended');
	
	public function __construct() {
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');	
	}
	
	public function index() {
		
		chk_access();
			
		$data['pageTitle'] = 'Dashboard';
		$data['content'] = 'index';
		$this->load->view('layout',$data);
	}
			
	public function login()
	{
		$redirect_url = BASE_URL.'leads/list';
		if(!empty($_POST)) {	
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			
			$where = "(admin_username = '$username' OR admin_email = '$username') AND admin_password = '$password'";
			$this->db->where($where);						
			$is_valid = $this->db->get('bs_admins')->row_array();
			
			if(!empty($is_valid)) {
				if($is_valid['admin_status'] == 0) {
					$response['status'] = false;
					$response['message'] = 'Your account is deactivated. <br/> Please contact sdministration';
					
					echo json_encode($response); die;
				}
				
				if($is_valid['admin_status'] == 2) {
					$response['status'] = false;
					$response['message'] = 'Your account has been blocked.<br/> Please contact sdministration';
					
					echo json_encode($response); die;
				}
				$updateData = array('admin_last_login' => date('Y-m-d H:i:s'));
				$this->db->where('admin_id', $is_valid['admin_id']);
				$this->db->update('bs_admins', $updateData);
				
				$roles = $this->admin_model->get_admin_roles($is_valid['admin_id']);
				$current_role_id = $roles[0]['admin_role_id'];
				$current_role_name = $roles[0]['role_name'];
				
				$sess_roles = array();
				foreach($roles as $role){
					$sess_roles[$role['admin_role_id']] = $role;
				}
				
				$allowed_actions = get_all_allowed_actions($current_role_id, false, $is_valid['admin_id']);
				
				$actions = array();
				if(!empty($allowed_actions)){					
					foreach($allowed_actions as $alw){
						$actions[$alw['action']] = explode(',', $alw['access']);
					}										
				}
				
				$session_data = array(
					'admin_id' => $is_valid['admin_id'],					
					'email' => $is_valid['admin_email'],
					'name' => $is_valid['admin_name'],
					'current_role_id' => $current_role_id,
					'current_role_name' => $current_role_name,
					'last_login' => date('d-M-Y H:i a', strtotime($is_valid['admin_last_login'])),
					'roles' => $sess_roles,
					'access' => $actions
				);
				$this->session->set_userdata('admin', $session_data);
				
				if($current_role_id == 7){
					$redirect_url = BASE_URL.'commissions/afe/list';
				}
				
				$response['status'] = true;
				$response['message'] = 'Loggen In Successfully.';
				$response['redirectTo'] = $redirect_url;
				
			} else {
				$response['status'] = false;
				$response['message'] = 'Incorrect Username or Password.';
			}
			
			echo json_encode($response); die;
		} else {						
			
			$logged_session = $this->session->userdata('admin');
			if(!empty($logged_session)){
				redirect($redirect_url);
			}
			
			$data['pageTitle'] = 'Login';
			$this->load->view('login',$data);
		}
	}
	
	public function logout() {
		$this->session->unset_userdata('admin_id');
		$this->session->sess_destroy();
		redirect('login');
	}	
	
	public function admin_profile()
	{
		chk_access();
		
		$AdminId = $this->session->userdata('admin_id');
		$data['user'] = $this->admin_model->get_admin($AdminId);
		$data['pageTitle'] = 'Profile';
		$data['content'] = 'admin-details';
		$this->load->view('layout',$data);
	}
	
	public function change_password()
	{
		chk_access();
		
		$OldPassword = $this->input->post('old-password');
		$OldPassword = md5($OldPassword);
		$Password = $this->input->post('password');
		$Password = md5($Password);
		
		$AdminId = $this->session->userdata('admin_id');
		$admin = $this->admin_model->get_admin($AdminId);
		
		if(trim($OldPassword) != trim($admin['password']))
		{
			echo 'old';die;
		}
		
		$UpdateData = array('password' => $Password);
		$this->db->where('id',$admin['id']);
		if($this->db->update('ts_users',$UpdateData))
		{
			echo 'success';die;
		}
		echo 'error';die;
	}		
	
	public function update_profile(){
		if(!empty($_POST['name'])){
			$user_id = $this->session->userdata('admin_id');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$mobile = $this->input->post('mobile');
			
			$UpdateArray = array('name' => $name,'email' => $email,'mobile' => $mobile);
			$this->db->where('id', $user_id);
			if($this->db->update('ts_users', $UpdateArray)){
				$response['status'] = true;
				$response['message'] = "Profile updated successfully.";
			}  else {
				$response['status'] = false;
				$response['message'] = "Unable to process your request.<br/> Please try later";
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = "Unable to process your request.<br/> Please try later";
		}
		
		echo json_encode($response); die;
	}
	
	public function email_templates()
	{		
		chk_access('cms',1,true);		
		
		$per_page = 10; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_email_templates($per_page,$page);
		
		$base_url = BASE_URL.'emails/list?page=true';
		$total_rows = $result['count'];
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		$data['emails'] = $result['result'];
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/email-templates-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['test_email'] = $this->db->get_where('ts_site_infos',array('id' => 1))->row_array();
		
		$data['pageTitle'] = 'Email/Text Templates';
		$data['content'] = 'email_templates';
		$this->load->view('layout',$data);
	}
	
	public function edit_email_templates($Id=NULL)
	{
		if(!empty($_POST))
		{
			$id = $this->input->post('id');
			$purpose = $this->input->post('purpose');
			$subject = $this->input->post('subject');
			$description = $this->input->post('description');
			
			$UpdateData = array('purpose' => $purpose,'subject' => $subject,'description' => $description);
			
			$this->db->where('id',$id);
			if($this->db->update('ts_email_config',$UpdateData))
				$this->session->set_flashdata('success','Updated successfully.');
			else
				$this->session->set_flashdata('error','Unable to update.');
				
			redirect('emails/list');
		}
		else
		{
			chk_access('cms',3,true);
		
			$data['email'] = $this->db->get_where('ts_email_config',array('id' => $Id))->row_array();
			$data['pageTitle'] = 'Edit Details';
			$data['content'] = 'edit_email_template';
			$this->load->view('layout',$data);
		}
	}
	
	public function site_settings()
	{
		if(!empty($_POST))
		{					
			$this->admin_model->save_site_settings();
			$this->session->set_flashdata('success', 'Information updated.');
			redirect('/general-settings');	
		}
		else
		{
			chk_access('site_infos',3,true);
			
			$data['info'] = $this->admin_model->get_record('site_infos',1);
			$data['pageTitle'] = 'Setting';
			$data['content'] = 'site_settings';
			$this->load->view('layout',$data);
		}
	}
	
	public function send_test_email($id=NULL)
	{
		if(trim($id) != '') {
			$record = $this->admin_model->get_record('ts_email_config',$id);
			
			$test = $this->db->get_where('ts_site_infos',array('id' => 1))->row_array(); 
			
			$email = @$test['general_email'];
			
			$mail['subject'] = @$record['subject'];
			$mail['message'] = @$record['description'];
			$sent = send_mail($email,$mail);
			
			if($sent)
			{
				$data['status'] = true;
				$data['message'] = 'Test email sent successfully'; 
			}
			else 
			{
				$data['status'] = false;
				$data['message'] = 'Unable to send'; 
			}
		}
		else 
		{
			$data['status'] = false;
			$data['message'] = 'Unable to send'; 
		}
		echo json_encode($data);die;
	}
	
	public function change_status_common()
	{
		chk_access();		
				
		$status = @$_GET['status'];
		$Id = @$_GET['id'];
		$field = @$_GET['field'];
		$table = @$_GET['table'];
		$data = array();
		if(trim($status) != '' && trim($Id) != '' && trim($field) != '' && trim($table) != '')
		{			
			$UpdateData = array($field => $status);
			$this->db->where('id',$Id);
			if($this->db->update($table,$UpdateData))
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
		echo json_encode($data);die;
	}
}
?>
