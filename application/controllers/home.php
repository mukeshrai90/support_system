<?php 
error_reporting(0);
class Home extends CI_Controller {

	var $surrender_type = array(0 => 'Single Device', 1 => 'Full & Final', 2=> 'Surrended');
	
	public function __construct() {
		parent::__construct();		
		$this->load->database();		
	}
	
	public function index() {
		chk_admin_access();
			
		$data['pageTitle'] = 'Dashboard';
		$data['content'] = 'index';
		$this->load->view('layout',$data);
	}
			
	public function login()
	{
		if(!empty($_POST))
		{	
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			
			$where = "(emp_code = '$username' OR email = '$username') AND password = '$password'";
			$this->db->where($where);						
			$is_valid = $this->db->get('ts_users')->row_array();
			
			if(!empty($is_valid))
			{
				if($is_valid['status'] == 0)
				{
					echo 'deactivated';die;
				}
				
				if($is_valid['status'] == 2)
				{
					echo 'disabled';die;
				}
				$updateData = array('last_login' => date('Y-m-d H:i:s'));
				$this->db->where('id',$is_valid['id']);
				$this->db->update('ts_users',$updateData);
				
				$data = array(
					'admin_id' => $is_valid['id'],
					'role_id' => $is_valid['role_id'],					
					'email' => $is_valid['email'],
					'status' => $is_valid['status'],
					'name' => $is_valid['name'],
					'emp_code' => $is_valid['emp_code'],
				);
				$this->session->set_userdata($data);
				
				$allowed_actions = get_all_allowed_actions($is_valid['role_id'],false, $is_valid['id'], $is_valid['have_admin_access']);
				
				$actions = array();
				if(!empty($allowed_actions)){					
					foreach($allowed_actions as $alw){
						$actions[$alw['action']] = explode(',', $alw['access']);
					}										
				}
				$this->session->set_userdata('access', $actions);
				
				if($this->input->post('remember') == 'on')
				{					
					$cookie = array(
						'name'   => 'rememberlogin',
						'value'  => $email.'::'.$this->input->post('password'),
						'expire' => '86500',
						'path'   => '/'				
					);
					$this->input->set_cookie($cookie); 	
				}
				else
				{
					delete_cookie('rememberlogin'); 	
				}
				
				$redirect_url = BASE_URL.'tickets/list/';
				if($is_valid['role_id'] == 2){
					$redirect_url = BASE_URL.'tickets/list/assigned';
				}
				echo "success**$redirect_url";die;
			}
			else
			{
				echo 'error';die;	
			}
		}
		else
		{						
			$data['pageTitle'] = 'Login';
			$this->load->view('login',$data);
		}
	}
	
	public function logout()
	{
		$this->session->unset_userdata('id');
		$this->session->sess_destroy();
		redirect('login');
	}	
	
	public function admin_profile()
	{
		chk_admin_access();
		
		$AdminId = $this->session->userdata('admin_id');
		$data['user'] = $this->admin_model->get_admin($AdminId);
		$data['pageTitle'] = 'Profile';
		$data['content'] = 'admin-details';
		$this->load->view('layout',$data);
	}
	
	public function change_password()
	{
		chk_admin_access();
		
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
		chk_admin_access('cms',1,true);		
		
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
			chk_admin_access('cms',3,true);
		
			$data['email'] = $this->db->get_where('ts_email_config',array('id' => $Id))->row_array();
			$data['pageTitle'] = 'Edit Details';
			$data['content'] = 'edit_email_template';
			$this->load->view('layout',$data);
		}
	}
	
	public function delete_machine_parts($id)
	{
		chk_admin_access('cms',5,true);
		
		if($this->db->delete('ts_parts', array('id' => $id)))
		{
			$this->session->set_flashdata('success','Deleted successfully.');
		}
		else
		{
			$this->session->set_flashdata('error','Unable to delete');
		}
		redirect($_SERVER['HTTP_REFERER']);
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
			chk_admin_access('site_infos',3,true);
			
			$data['info'] = $this->admin_model->get_record('site_infos',1);
			$data['pageTitle'] = 'Setting';
			$data['content'] = 'site_settings';
			$this->load->view('layout',$data);
		}
	}
	
	public function categories()
	{
		chk_admin_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_categories($per_page, $page);		
		$data['categories'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'categories/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'categories/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/categories-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Categories';
		$data['content'] = 'categories';
		$this->load->view('layout',$data);
	}
	
	public function manage_categories($id=0)
	{				
		if($this->input->post('name') != '')
		{
			$this->admin_model->save_categories();
			
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('success','Updated successfully.');
				$redirect_to = str_replace(BASE_URL,'',$this->input->post('referer'));
				redirect(str_replace('index.php/','',$redirect_to));
			}
			else
			{
				$this->session->set_flashdata('success','Added successfully.');
				redirect(BASE_URL.'categories/list');
			}						
		}
		else
		{									
			if(trim($id) != '' && trim($id) > 0)
			{
				chk_admin_access('cms',3,true);
				
				$data['category'] = $this->admin_model->get_record('ts_category_types',$id);
				if(isset($_SERVER['HTTP_REFERER']))
				{			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('cms',2,true);
			}	
				
			$data['pageTitle'] = 'Manage Categories';
			$data['content'] = 'manage-categories';
			$this->load->view('layout',$data);
		}
	}
	
	public function request_types()
	{
		chk_admin_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_request_types($per_page, $page);		
		$data['records'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'request-types/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'request-types/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/request-types-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Request Types';
		$data['content'] = 'request-types';
		$this->load->view('layout',$data);
	}
	
	public function manage_request_types($id=0)
	{				
		if($this->input->post('name') != '')
		{
			$this->admin_model->save_request_types();
			
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('success','Updated successfully.');
				$redirect_to = str_replace(BASE_URL,'',$this->input->post('referer'));
				redirect(str_replace('index.php/','',$redirect_to));
			}
			else
			{
				$this->session->set_flashdata('success','Added successfully.');
				redirect(BASE_URL.'request-types/list');
			}						
		}
		else
		{									
			if(trim($id) != '' && trim($id) > 0){
				chk_admin_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('ts_request_types',$id);
				if(isset($_SERVER['HTTP_REFERER']))
				{			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('cms',2,true);
			}	
				
			$data['pageTitle'] = 'Manage Request Types List';
			$data['content'] = 'manage-request-types';
			$this->load->view('layout',$data);
		}
	}
	
	public function machine_types()
	{
		chk_admin_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_machine_types($per_page, $page);		
		$data['records'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'machine-types/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'machine-types/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/machine-types-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Machine Types List';
		$data['content'] = 'machine-types';
		$this->load->view('layout',$data);
	}
	
	public function manage_machine_types($id=0)
	{				
		if($this->input->post('name') != '')
		{
			$this->admin_model->save_machine_types();
			
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('success','Updated successfully.');
				$redirect_to = str_replace(BASE_URL,'',$this->input->post('referer'));
				redirect(str_replace('index.php/','',$redirect_to));
			}
			else
			{
				$this->session->set_flashdata('success','Added successfully.');
				redirect(BASE_URL.'machine-types/list');
			}						
		}
		else
		{									
			if(trim($id) != '' && trim($id) > 0)
			{
				chk_admin_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('ts_machine_types',$id);
				if(isset($_SERVER['HTTP_REFERER']))
				{			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('cms',2,true);
			}	
				
			$data['pageTitle'] = 'Manage Machine List';
			$data['content'] = 'manage-machine-types';
			$this->load->view('layout',$data);
		}
	}
	
	public function machine_parts()
	{
		chk_admin_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_machine_parts($per_page, $page);		
		$data['records'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'machine-parts/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'machine-parts/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/machine-parts-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Machine Parts List';
		$data['content'] = 'machine-parts';
		$this->load->view('layout',$data);
	}
	
	public function manage_machine_parts($id=0)
	{				
		if($this->input->post('name') != '')
		{
			$this->admin_model->save_machine_parts();
			
			$id = $this->input->post('id');
			if($id)
			{
				$this->session->set_flashdata('success','Updated successfully.');
				$redirect_to = str_replace(BASE_URL,'',$this->input->post('referer'));
				redirect(str_replace('index.php/','',$redirect_to));
			}
			else
			{
				$this->session->set_flashdata('success','Added successfully.');
				redirect(BASE_URL.'machine-parts/list');
			}						
		}
		else
		{									
			if(trim($id) != '' && trim($id) > 0)
			{
				chk_admin_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('ts_parts',$id);
				if(isset($_SERVER['HTTP_REFERER']))
				{			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('cms',2,true);
			}	
			
			$data['machine_types'] = $this->db->get_where('ts_machine_types',array('status' => 1))->result_array();
			$data['pageTitle'] = 'Manage Parts List';
			$data['content'] = 'manage-machine-parts';
			$this->load->view('layout',$data);
		}
	}
	
	public function send_test_email($id=NULL)
	{
		if(trim($id) != '')
		{
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
	
	public function users()
	{		
		chk_admin_access('users',1,true);
		
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
	
	public function change_status()
	{
		chk_admin_access('users',4,true);
				
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
	
	public function change_status_common()
	{
		chk_admin_access();		
				
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
	
	public function user_view($UserId=NULL)
	{
		chk_admin_access('users',1,true);
		
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
		chk_admin_access('users',3,true);
		
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
	
	public function delete_users($user_id=NULL)
	{
		chk_admin_access('users',5,true);
		
		if(trim($user_id) != '')
		{
			if($this->db->delete('ts_users',array('id' => $user_id)))
			{
				$this->session->set_flashdata('success','Deleted Successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Unable to delete');
			}
		}
		else
		{
			$this->session->set_flashdata('error','Unable to delete');
		}
		
		
		$redirect_to = str_replace(base_url(),'',$_SERVER['HTTP_REFERER']);
		redirect(str_replace('index.php/','',$redirect_to));
	}
	
	public function tickets($assigned_tickets=false)
	{
		chk_admin_access('tickets',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $user_id = $this->session->userdata('admin_id');
		$result = $this->admin_model->get_tickets($per_page, $page, $user_id,$assigned_tickets);		
		$data['tickets'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'tickets/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'tickets/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/tickets-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageUrl'] = BASE_URL.'tickets/list';
		if($assigned_tickets){
			$data['pageUrl'] = BASE_URL.'tickets/list/assigned';
			$data['assigned_tickets'] = $assigned_tickets;
		}
		$data['user'] = $this->admin_model->get_user($user_id, 'id,role_id,emp_code');
				
		$data['pageTitle'] = 'Tickets';
		$data['content'] = 'tickets';
		$this->load->view('layout',$data);
	}		
	
	public function manage_tickets($id=NULL)
	{				
		$response = array();
		
		$user_id = $this->session->userdata('admin_id');
		$user =  $this->admin_model->get_user($user_id,'id,role_id,emp_code,desktop_id,laptop_id');
		$user_id = $user['id'];
		
		if($this->input->post('machine_type') != '')
		{
			$id = $this->input->post('id');			
			
			$machine_type = $this->input->post('machine_type');
			$request_type = $this->input->post('request_type');
			$category_type = $this->input->post('category_type');
			$part_id = $this->input->post('parts');
			$sw_name = $this->input->post('sw_name');
			$description = $this->input->post('description');
			
			$data = array('machine_type_id' => $machine_type, 'request_type_id' => $request_type, 'category_type_id' => $category_type, 'part_id' => $part_id, 'sw_name' => $sw_name, 'description' => $description);
						
			if(trim($id) == '')
			{						
				$return = $this->assignment_logic($category_type, $user_id, $user['role_id'], $request_type);
				$assigned_user_array = $return[0];
				$log_assigned_description = $return[1];
				$manager_emp_code = $return[2];
				$sw_hw = $return[3];
											
				$status = 1;			
				$temp_id = $this->admin_model->get_todays_tickets();
				$ticket_id = 'TS'. date('Ymd'). str_pad(($temp_id + 1), 5, '0', STR_PAD_LEFT);
				
				$system_id = '';
				if($machine_type == 1){
					$system_id = $user['desktop_id'];
				} else if($machine_type == 2) {
					$system_id = $user['laptop_id'];
				}
				
				$part_details = $this->admin_model->get_record('ts_parts',$part_id);
				$part_name = $part_details['part_name'];
				
				$device_id = '';
				$device_id = $this->admin_model->get_device_details($user_id, $part_name);
								
				if(empty($device_id) && $part_details['associated_with_system_id'] == 1){
					$device_id = $system_id;
				}					
				
				$rndm_identifier = 1;
				if(empty($device_id)){
					$rndm_identifier = mt_rand(10000000,99999999);	
				}
				
				$insert_data = array('user_id' => $user_id, 'device_id' => $device_id, 'rndm_identifier' => $rndm_identifier, 'user_emp_code' => $user['emp_code'], 'ticket_id' => $ticket_id, 'status' => $status, 'date_added' => date('Y-m-d H:i:s'));
				$data = array_merge($data, $assigned_user_array);
				$data = array_merge($data, $insert_data);
				
				try{
					$this->db->trans_begin();  // Transaction Start
					
					if($this->db->insert('ts_tickets', $data)){
						$insert_id = $this->db->insert_id();
						
						$log = array();
						$log['ticket_id'] = $insert_id;
						$log['status_id'] = 0;
						$log['description'] = 'New Ticket Created';
						$log1 = $this->db->insert('ts_ticket_logs', $log);
												
						$log['status_id'] = $status;
						$log['description'] = $log_assigned_description;
						$log2 = $this->db->insert('ts_ticket_logs', $log);
						
						if($log1 && $log2){
							if($this->db->trans_status() === FALSE) {
								throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');								
							} else {
								$this->db->trans_commit(); // Transaction Commit
								$response['status'] = true;
								$response['message'] = "Ticket request saved successfully.<br/> Your Ticket Id is: $ticket_id";
								$response['path'] = BASE_URL.'tickets/list/';
								
								$this->send_ticket_create_email($insert_id,$user_id,$manager_emp_code,$ticket_id,$sw_hw);  //send mails
								$this->send_ticket_create_message($insert_id,$user_id,$manager_emp_code,$ticket_id,$sw_hw);  //send messages
							}
						} else {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						}												
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
					}
					
				} catch(Exception $e){
					$this->db->trans_rollback(); // Transaction Rollback
					$response['status'] = false;	
					$response['message'] = $e->getMessage();
				}						
			}
			else
			{	
				try{				
					$this->db->trans_begin(); 
					
					$ticket = $this->admin_model->get_record('ts_tickets',$id);
					$status = $ticket['status'];
					$sts_rcrd = $this->admin_model->get_record('ts_tickets_status', $status);
					
					$ticket_id = $ticket['ticket_id'];
					
					$logs = array();
					
					$log = array();
					$log['ticket_id'] = $id;
					$log['status_id'] = $status;
					$log['user_id'] = $user_id;
					$log['description'] = 'Ticket Details Updated';
					
					$logs[] = $log;
					
					$ticket_recreated = false;
					if($sts_rcrd['ticket_recreate_allowed'] && $this->input->post('ticket_recreate_status') == 'on'){
						
						$ticket_recreated = true;
						$status = 11;
						
						$return = $this->assignment_logic($category_type, $user_id, $user['role_id'], $request_type);
						$assigned_user_array = $return[0];
						$log_assigned_description = $return[1];
						$manager_emp_code = $return[2];
						$sw_hw = $return[3];
												
						$data = array_merge($data, $assigned_user_array);
						$data = array_merge($data, array('status' => $status));
																		
						$log['status_id'] = $status;						
						$log['description'] = 'Ticket Recreated By User';
						$logs[] = $log;	
						
						$log['user_id'] = 0;
						$log['description'] = $log_assigned_description;
						$logs[] = $log;																	
					}
					
					$this->db->where('id',$id);
					if($this->db->update('ts_tickets', $data)){
						
						$log['ticket_id'] = $id;
						$log['status_id'] = $status;
						$log['user_id'] = $user_id;
						$log['description'] = $description;					
						if($this->db->insert_batch('ts_ticket_logs', $logs)){
							$this->db->trans_commit();
							
							$response['status'] = true;
							$response['message'] = "Ticket details Updated Successfully";
							$response['path'] = BASE_URL.'tickets/view/'.md5($id);
							
							if($ticket_recreated){
								$response['message'] = "Ticket Recreated Successfully";
								$this->send_ticket_recreate_notification($insert_id,$user_id,$manager_emp_code,$ticket_id,$sw_hw);
							}							
														
						} else {
							throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
						}
					} else {
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
					} 
				
				} catch(Exception $e){
					$this->db->trans_rollback();
					$response['status'] = false;	
					$response['message'] = $e->getMessage();
				}
			}
			echo json_encode($response);die;
		}
		else
		{									
			if(trim($id) != '')
			{
				chk_admin_access('tickets',3,true);
				
				$data['record'] = $this->admin_model->get_record_md5('ts_tickets',$id);
				$data['parts'] = $this->db->get_where('ts_parts',array('status' => 1,'machine_type_id' => $data['record']['machine_type_id']))->result_array();				
				$status = $data['record']['status'];
				$data['sts_rcrd'] = $this->admin_model->get_record('ts_tickets_status', $status);
				
				
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_admin_access('tickets',2,true);
			}	
			
			$data['request_types'] = $this->db->get_where('ts_request_types',array('status' => 1))->result_array();
			$data['machine_types'] = $this->db->get_where('ts_machine_types',array('status' => 1))->result_array();
			$data['category_types'] = $this->db->get_where('ts_category_types',array('status' => 1))->result_array();			
			$data['user'] = $user;
			
			$data['pageTitle'] = 'Manage Tickets';
			$data['content'] = 'manage-tickets';
			$this->load->view('layout',$data);
		}
	}
	
	public function assignment_logic($category_type, $user_id, $user_role_id, $request_type){
		
		$log_assigned_description = ''; $sw_hw = ''; $manager_emp_code = '';
		if($category_type == 2 || $user_role_id != 5) {
			$admin = $this->admin_model->get_it_admin($user_id);
			$assigned_user_array = array('assigned_user_emp_code' => $admin[0], 'assigned_user_id' => $admin[1], 'assigned_user_role_id' => 1);
			$log_assigned_description = 'Assigned to Admin ('.$admin[0].')';
			
			$sw_hw = 'sw';			
			
		} else if($request_type == 3) {
			$admin = $this->admin_model->get_it_admin($user_id);
			$assigned_user_array = array('assigned_user_emp_code' => $admin[0], 'assigned_user_id' => $admin[1], 'assigned_user_role_id' => 1);
			$log_assigned_description = 'Assigned to Admin ('.$admin[0].')';
			
			$sw_hw = 'sw';			
			
		} else if($category_type == 1 || 1){
			$manager = $this->admin_model->get_user_manager_one($user_id);
			$assigned_user_array = array('assigned_user_emp_code' => $manager[0], 'assigned_user_id' => $manager[1], 'assigned_user_role_id' => 2);
			$log_assigned_description = 'Assigned to Manager ('.$manager[0].')';
			
			$manager_emp_code = $manager[0];
			
			$sw_hw = 'hw';
			
		}
		
		return array($assigned_user_array, $log_assigned_description, $manager_emp_code, $sw_hw);
	}
	
	public function get_machine_parts(){
		
		$response = array();
		$response['status'] = false;		
		if(isset($_POST['machine_type_id']) && $_POST['machine_type_id'] != ''){
			$parts = $this->db->get_where('ts_parts',array('status' => 1,'machine_type_id' => $_POST['machine_type_id']))->result_array();
			
			$html = "<option value=''>Select</option>";;
			if(!empty($parts)){
				foreach($parts as $part){
					$value = $part['id'];
					$text = $part['title'];
					$html .=  "<option value='$value'>$text</option>";
				}
				$response['status'] = true;	
				$response['data'] = $html;	
			}
		}
		
		echo json_encode($response);die;
	}
	
	public function send_ticket_create_email($ticket_id,$user_id,$manager_emp_code,$TicketId,$sw_hw,$attachment=NULL){									
		$user =  $this->admin_model->get_record('ts_users',$user_id);
		$admin =  $this->admin_model->get_record('ts_users',1);
		$manager =  $this->admin_model->get_user_by_emp_code($manager_emp_code);			
		
		$user_detail = $user['name'].' ('.$user['emp_code'].')';
		
		$ticket_view_link = BASE_URL.'tickets/view/'.md5($ticket_id);
		
		$emailTemplate = $this->admin_model->get_record('ts_email_config',1);
		$template = @$emailTemplate['description'];						
		$template = str_replace('{{name}}',$user['name'],$template);
		$template = str_replace('{{ticket_id}}',$TicketId,$template);	
		
		$emailTemplate['subject'] = str_replace('{{ticket_id}}',$TicketId,$emailTemplate['subject']);
				
		$mail = array(); $email = $user['email'];
		$mail['subject'] = @$emailTemplate['subject'];
		$mail['message'] = $template;
		$mail['purpose'] = @$emailTemplate['purpose'];
		$sent = send_mail($email,$mail,$attachment);
		/*** mail to user end ***/
		
		if($sw_hw == 'hw'){
			/*** mail to manager ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',2);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$manager['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);
			$template = str_replace('{{link_to_approve}}',$ticket_view_link,$template);
			$template = str_replace('{{ticket_id}}',$TicketId,$template);	
			
			$emailTemplate['subject'] = str_replace('{{ticket_id}}',$TicketId,$emailTemplate['subject']);
			
			$mail = array(); $email = $manager['email'];
			$mail['subject'] = @$emailTemplate['subject'];
			$mail['message'] = $template;
			$mail['purpose'] = @$emailTemplate['purpose'];
			$sent = send_mail($email,$mail,$attachment);
			/*** mail to manager end ***/
			
			/*** mail to admin ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',3);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$admin['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);
			$template = str_replace('{{ticket_id}}',$TicketId,$template);	
			
			$emailTemplate['subject'] = str_replace('{{ticket_id}}',$TicketId,$emailTemplate['subject']);
			
			$mail = array(); $email = $admin['email'];
			$mail['subject'] = @$emailTemplate['subject'];
			$mail['message'] = $template;
			$mail['purpose'] = @$emailTemplate['purpose'];
			$sent = send_mail($email,$mail,$attachment);
			/*** mail to admin end ***/	
			
		} else {
			
			/*** mail to admin ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',2);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$admin['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);
			$template = str_replace('{{link_to_approve}}',$ticket_view_link,$template);
			$template = str_replace('{{ticket_id}}',$TicketId,$template);	
			
			$emailTemplate['subject'] = str_replace('{{ticket_id}}',$TicketId,$emailTemplate['subject']);
			
			$mail = array(); $email = $admin['email'];
			$mail['subject'] = @$emailTemplate['subject'];
			$mail['message'] = $template;
			$mail['purpose'] = @$emailTemplate['purpose'];
			$sent = send_mail($email,$mail,$attachment);
			/*** mail to admin end ***/	
		}
	}
	
	public function send_ticket_create_message($ticket_id,$user_id,$manager_emp_code,$TicketId,$sw_hw,$attachment=NULL){
		$user =  $this->admin_model->get_record('ts_users',$user_id);
		$admin =  $this->admin_model->get_record('ts_users',1);
		$manager =  $this->admin_model->get_user_by_emp_code($manager_emp_code);			
		
		$user_detail = $user['name'].' ('.$user['emp_code'].')';
		
		$ticket_view_link = BASE_URL.'tickets/view/'.md5($ticket_id);
		$short_url = get_short_url($ticket_view_link);
		
		$emailTemplate = $this->admin_model->get_record('ts_email_config',12);
		$template = @$emailTemplate['description'];						
		$template = str_replace('{{name}}',$user['name'],$template);
		$template = str_replace('{{ticket_id}}',$TicketId,$template);			
		
		$mobile = $user['mobile'];
		$body = array();
		$body['message'] = $template;
		$body['purpose'] = $emailTemplate['purpose'];
		if(!empty($mobile)) {
			$status = send_sms($mobile,$body);
		}
		/*** message to user end ***/
		
		if($sw_hw == 'hw'){
			/*** message to manager ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',13);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$manager['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);			
			$template = str_replace('{{ticket_id}}',$TicketId,$template);
			$template = str_replace('{{link_to_approve}}',$short_url,$template);				
			
			$mobile = $manager['mobile'];
			$body = array();
			$body['message'] = $template;
			$body['purpose'] = $emailTemplate['purpose'];
			if(!empty($mobile)) {
				$status = send_sms($mobile,$body);
			}
			/*** message to manager end ***/
			
			/*** message to admin ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',16);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$admin['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);
			$template = str_replace('{{ticket_id}}',$TicketId,$template);	
			
			$mobile = $admin['mobile'];
			$body = array();
			$body['message'] = $template;
			$body['purpose'] = $emailTemplate['purpose'];
			if(!empty($mobile)) {
				$status = send_sms($mobile,$body);
			}
			/*** message to admin end ***/	
			
		} else {
			
			/*** message to admin ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',13);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$admin['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);			
			$template = str_replace('{{ticket_id}}',$TicketId,$template);
			$template = str_replace('{{link_to_approve}}',$short_url,$template);	
			
			$mobile = $admin['mobile'];
			$body = array();
			$body['message'] = $template;
			$body['purpose'] = $emailTemplate['purpose'];
			if(!empty($mobile)) {
				$status = send_sms($mobile,$body);
			}
			/*** message to admin end ***/	
		}
	}
	
	public function genetare_ticket_pdf($ticket_id_md5=NULL)
	{
		$data['ticket'] = $this->admin_model->get_ticket_details($ticket_id_md5);
		$TicketId = $ticket['ticket_id'];
		
		$filename = 'ticket-'.$ticket['id'].'-'.$TicketId;
		$pdfFilePath = "assets/pdf_tickets/$filename.pdf";				 				
		$pdf_html = $this->load->view('ticket_print_pdf',$data,true);			 
		create_pdf($pdfFilePath,$pdf_html);				
	}
	
	public function send_ticket_recreate_notification($ticket_id,$user_id,$manager_emp_code,$TicketId,$sw_hw,$attachment=NULL){
		$user =  $this->admin_model->get_record('ts_users',$user_id);
		$admin =  $this->admin_model->get_record('ts_users',1);
		$manager =  $this->admin_model->get_user_by_emp_code($manager_emp_code);			
		
		$user_detail = $user['name'].' ('.$user['emp_code'].')';
		
		$ticket_view_link = BASE_URL.'tickets/view/'.md5($ticket_id);
		$short_url = get_short_url($ticket_view_link);
		
		if($sw_hw == 'hw' || 1){
			/*** mail to manager ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',18);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$manager['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);
			$template = str_replace('{{link_to_approve}}',$ticket_view_link,$template);
			$template = str_replace('{{ticket_id}}',$TicketId,$template);	
			
			$emailTemplate['subject'] = str_replace('{{ticket_id}}',$TicketId,$emailTemplate['subject']);
			
			$mail = array(); $email = $manager['email'];
			$mail['subject'] = @$emailTemplate['subject'];
			$mail['message'] = $template;
			$mail['purpose'] = @$emailTemplate['purpose'];
			$sent = send_mail($email,$mail,$attachment);
			/*** mail to manager end ***/
			
			/*** message to manager ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',17);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$manager['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);			
			$template = str_replace('{{ticket_id}}',$TicketId,$template);
			$template = str_replace('{{link_to_approve}}',$short_url,$template);				
			
			$mobile = $manager['mobile'];
			$body = array();
			$body['message'] = $template;
			$body['purpose'] = $emailTemplate['purpose'];
			if(!empty($mobile)) {
				$status = send_sms($mobile,$body);
			}
			/*** message to manager end ***/
						
		} else {
			
			/*** mail to admin ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',18);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$admin['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);
			$template = str_replace('{{link_to_approve}}',$ticket_view_link,$template);
			$template = str_replace('{{ticket_id}}',$TicketId,$template);	
			
			$emailTemplate['subject'] = str_replace('{{ticket_id}}',$TicketId,$emailTemplate['subject']);
			
			$mail = array(); $email = $admin['email'];
			$mail['subject'] = @$emailTemplate['subject'];
			$mail['message'] = $template;
			$mail['purpose'] = @$emailTemplate['purpose'];
			$sent = send_mail($email,$mail,$attachment);
			/*** mail to admin end ***/	
			
			/*** message to admin ***/
			$emailTemplate = $this->admin_model->get_record('ts_email_config',17);
			$template = @$emailTemplate['description'];						
			$template = str_replace('{{name}}',$admin['name'],$template);
			$template = str_replace('{{user}}',$user_detail,$template);			
			$template = str_replace('{{ticket_id}}',$TicketId,$template);
			$template = str_replace('{{link_to_approve}}',$short_url,$template);	
			
			$mobile = $admin['mobile'];
			$body = array();
			$body['message'] = $template;
			$body['purpose'] = $emailTemplate['purpose'];
			if(!empty($mobile)) {
				$status = send_sms($mobile,$body);
			}
			/*** message to admin end ***/	
		}
	}		
	
	public function surrender_devices(){
		chk_admin_access();
		
		if($this->input->post('device_id') != ''){
			$user_id = $this->session->userdata('admin_id');
			$device_id = $this->input->post('device_id');
			$device_name = $this->input->post('device_name');
			$description = $this->input->post('description');
			$surrender_date = date('Y-m-d H:i:s');
			
			$this->db->trans_begin();  // Transaction Start
			
			$data = array('user_id' => $user_id, 'device_id' => $device_id, 'device_name' => $device_name, 'description' => $description, 'surrender_date' => $surrender_date);			
			if($this->db->insert('ts_surrender_logs', $data)){				
				
				$UpdateData = array('assigned_status' => 2);
				$this->db->where('user_id', $user_id);
				$this->db->where('device_id', $device_id);
				if($this->db->update('ts_user_assigned_devices', $UpdateData)){
					if($this->db->trans_status() === FALSE) {								
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
					} else {					
						$this->db->trans_commit(); // Transaction Commit
					
						$response['status'] = true;
						$response['message'] = 'Request processed successfully';
					
						$this->send_device_surrender_notification($user_id, $device_id, $device_name, $description);	
					}
				} else {
					$this->db->trans_rollback(); // Transaction Rollback
					$response['status'] = false;
					$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
				}				
			} else {				
				$this->db->trans_rollback(); // Transaction Rollback
				$response['status'] = false;
				$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
			}
			echo json_encode($response); die;
			
		} else {
			$user_id = $this->session->userdata('admin_id');
			$data['user'] = $this->admin_model->get_user($user_id);
			$data['user_devices'] = $this->admin_model->get_user_devices($user_id);
			
			$data['pageTitle'] = 'Surrender Devices';
			$data['content'] = 'surrender_devices';
			$this->load->view('layout',$data);			
		}
	}
	
	public function surrender_fnf(){
		chk_admin_access();
		
		if(!empty($_POST)){			
			$user_id = $this->session->userdata('admin_id');
			$device_ids = $this->input->post('device_id');			
			$other_devices = $this->input->post('other_devices');			
			$description = $this->input->post('description');
			$surrender_date = date('Y-m-d H:i:s');
			
			if($other_devices != ''){
				$other_devices = explode(',', $other_devices);
				if(!empty($other_devices)){
					$device_ids = array_merge($device_ids, $other_devices);
				}
			}
			
			$this->db->trans_begin();  // Transaction Start
			
			$InsertData = array(); $count = 0;
			foreach($device_ids as $device){
				$data = array('user_id' => $user_id, 'device_id' => $device, 'description' => $description, 'surrender_date' => $surrender_date, 'surrender_type' => 1);
				
				$InsertData[$count] = $data;
				$count++;
			}
			
						
			if($this->db->insert_batch('ts_surrender_logs', $InsertData)){				
				
				$UpdateData = array('assigned_status' => 2);
				$this->db->where('user_id', $user_id);
				$this->db->where_in('device_id', $device_ids);				
				if($this->db->update('ts_user_assigned_devices', $UpdateData)){
					if($this->db->trans_status() === FALSE) {								
						throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
					} else {					
						$this->db->trans_commit(); // Transaction Commit
					
						$response['status'] = true;
						$response['message'] = 'Request processed successfully';
					
						//$this->send_device_surrender_notification($user_id, $device_id, $device_name, $description);	
					}
				} else {
					$this->db->trans_rollback(); // Transaction Rollback
					$response['status'] = false;
					$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
				}				
			} else {				
				$this->db->trans_rollback(); // Transaction Rollback
				$response['status'] = false;
				$response['message'] = 'Unable to proocess your request right now.<br/> Please try again or some time later';
			}
			echo json_encode($response); die;
		} else {
			$user_id = $this->session->userdata('admin_id');
			$data['user'] = $this->admin_model->get_user($user_id);
			$data['user_devices'] = $this->admin_model->get_user_devices($user_id);
			
			$data['pageTitle'] = 'Surrender Full & Final';
			$data['content'] = 'surrender_devices_fnf';
			$this->load->view('layout',$data);	
		}
	}
	
	public function send_device_surrender_notification($user_id, $device_id, $device_name, $description){
		$user =  $this->admin_model->get_record('ts_users',$user_id);
		$admin =  $this->admin_model->get_record('ts_users',1);
		
		$device_id = $device_id ? $device_id : 'Not Available';
		
		$user_detail = $user['name'].' ('.$user['emp_code'].')';
		
		$emailTemplate = $this->admin_model->get_record('ts_email_config',33);
		$template = @$emailTemplate['description'];						
		$template = str_replace('{{name}}',$user['name'],$template);
		$template = str_replace('{{user}}',$user_detail,$template);							
		$template = str_replace('{{device_id}}',$device_id,$template);							
		$template = str_replace('{{device_name}}',$device_name,$template);							
		$template = str_replace('{{description}}',$description,$template);							
		
		$emailTemplate['subject'] = str_replace('{{user}}',$user_detail,$emailTemplate['subject']);
		
		$mail = array(); $email = $admin['email'];
		$mail['subject'] = @$emailTemplate['subject'];
		$mail['message'] = $template;
		$mail['purpose'] = @$emailTemplate['purpose'];
		$sent = send_mail($email,$mail,$attachment);
		
		
		$emailTemplate = $this->admin_model->get_record('ts_email_config',34);
		$template = @$emailTemplate['description'];								
		$template = str_replace('{{user}}',$user_detail,$template);						
		
		$mobile = $admin['mobile'];
		$body = array();
		$body['message'] = $template;
		$body['purpose'] = $emailTemplate['purpose'];
		if(!empty($mobile)) {
			$status = send_sms($mobile,$body);
		}
	}
	
	public function surrender_device_logs(){
		chk_admin_access('cms',1,true);		
		
		$per_page = 20; 
		$page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$result = $this->admin_model->get_surrender_device_logs($per_page, $page);
		
		$base_url = BASE_URL.'surrender-devices-logs/list?page=true';
		$total_rows = $result['count'];
		
		$data['links'] = create_links($per_page,$total_rows,$base_url);
		$data['device_surrender_logs'] = $result['result'];
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/surrender-devices-logs-list',$data,true);
			echo json_encode($data);die;
		}
		
		$this->db->order_by('name', 'asc');
		$data['users'] = $this->db->get_where('ts_users', array('id > ' => 2))->result_array();
		
		$data['surrender_type'] = $this->surrender_type;
		
		$data['pageTitle'] = 'Surrender Devices Logs';
		$data['content'] = 'surrender-devices-logs';
		$this->load->view('layout',$data);
	}
}
?>
