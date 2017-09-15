<?php

class Admin_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_user($user_id=NULL, $select=NULL)
	{		
		$user = array();
		if($select){
			$this->db->select($select);
		}
		$user = $this->db->get_where('bs_users', array('user_id' => $user_id))->row_array();		
		return $user;		
	}
	
	public function get_admin($admin_id=NULL, $select=NULL)
	{		
		$admin = array();
		if($select){
			$this->db->select($select);
		}
		$admin = $this->db->get_where('bs_admins', array('admin_id' => $admin_id))->row_array();		
		return $admin;		
	}
	
	public function get_user_by_userId($userId=NULL, $select=NULL)
	{		
		$user = array();
		if($select){
			$this->db->select($select);
		}
		$user = $this->db->get_where(TBL_USERS, array('UserId' => $userId))->row_array();
		
		return $user;		
	}
	
	public function get_all_users($limit=0,$start=0,$csv=NULL) 
	{        
		$data = array();
		$admin_id = $this->session->userdata('admin_id');
		$where = array('ts_users.id >' => 1, 'ts_users.id !=' => $admin_id, 'ts_users.role_id > ' => '1', 'ts_users.role_id != ' => '6');
		$like = array(); 
		
		$current_loggen_in_role = $this->session->userdata('role_id');				
		if($role_id == 2){			
			$user = $this->get_user($admin_id, 'emp_code');
			$where = array_merge($where, array('ts_users.manager_emp_code' => $user['emp_code']));
		}
		
		if(isset($_GET['verified']) && $_GET['verified'] >= 1)
		{			
			$_GET['verified'] = $_GET['verified'] == 2 ? 0 : $_GET['verified'];
			$where = array_merge($where,array('ts_users.status' => $_GET['verified']));
			if($_GET['verified'] > 1)
			{
				$where = array_merge($where, array('ts_users.id > ' => 1));
			}
		}
		if(isset($_GET['emp_code']) && !empty($_GET['emp_code']))
		{
			$where = array_merge($where,array('emp_code' => $_GET['emp_code']));
		}
		if(isset($_GET['name']) && !empty($_GET['name']))
		{
			$like = array_merge($like,array('LOWER(name)' => strtolower($_GET['name'])));
		}
		if(isset($_GET['role']) && !empty($_GET['role']))
		{
			$where = array_merge($where,array('role_id' => $_GET['role']));
		}
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('ts_users');
		$data['count'] = $this->db->count_all_results();
		
		if(trim($csv) == 'csv') {			
			$this->db->select("fname as FirstName,lname as LastName,email as Email,mobile as Mobile,created as Registered,city as City,state as State,zip as Zipcode");
		}
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->order_by('ts_users.id','desc'); 
		if(trim($csv) == ''){
			$this->db->limit($limit, $start);
		}
		$this->db->select('ts_users.*,ts_user_roles.role_name');
		$this->db->join('ts_user_roles','ts_users.role_id=ts_user_roles.id','INNER');
		$query = $this->db->get("ts_users");		
		$data['result'] = $query->result_array();
		
		if(trim($csv) == '' || trim($csv) == 'pdf')	
			return $data;
		else if(trim($csv) == 'csv')
			return $query;
    }
   
    public function get_email_templates($limit, $start) 
	{        
		$data = array();
					
		$this->db->from('ts_email_config');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->order_by('id','desc'); 
		$this->db->limit($limit, $start);
		$data['result'] = $this->db->get("ts_email_config")->result_array();
		return $data;
    }
	
	public function get_record($table, $prim_key=NULL, $id, $select=NULL)
	{	
		if($select){
			$this->db->select($select);
		}
		$query = $this->db->get_where($table, array($prim_key => $id));
		return $query->row_array();
	}
	
	public function get_record_md5($table, $prim_key=NULL, $id, $select=NULL)
	{	
		if($select){
			$this->db->select($select);
		}
		$query = $this->db->get_where($table, array("MD5($prim_key)" => $id));
		return $query->row_array();
	}
	
	public function get_all_records($table, $order=NULL, $select=NULL)
	{
		if($select){
			$this->db->select($select);
		}
		
		if($order) {
			$this->db->order_by($order,'asc');
		}		
		$query = $this->db->get($table);
		return $query->result_array();
	}		
	
	public function get_all_actions($admin_id=NULL)
	{		
		$this->db->order_by('ts_access_actions.id','asc');						
		$this->db->where('ts_access_actions.parent_id',0); 
		$this->db->where('ts_access_actions.status',1); 
		$actions = $this->db->get("ts_access_actions")->result_array();
		
		foreach($actions as $j=>$row)
		{
			$ParentId = $row['id'];
			$this->db->order_by('ts_access_actions.id','asc');						
			$this->db->where('ts_access_actions.parent_id',$ParentId);
			$this->db->where('ts_access_actions.status',1); 
			$rslts = $this->db->get("ts_access_actions")->result_array();
			
			if(trim($admin_id) != '')
			{
				if(!empty($rslts))
				{
					foreach($rslts as $k=>$rslt)
					{									
						$where = array('admin_id' => $admin_id,'action' => strtolower($row['name']),'type' => $rslt['type']);
						$this->db->select('access');
						$this->db->where($where); 				
						$temp = $this->db->get("ts_subadmin_access")->row_array();
						
						$rslts[$k]['access'] = @$temp['access'];
					}
				}
			}
			
			$actions[$j]['childs'] = $rslts;
		}
		
		return $actions;
	}
	
	public function get_all_admins($limit, $start) 
	{        
		$data = array(); $where = array('bs_admins.admin_id >' => 0); $like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_admins.admin_status' => $_GET['status']));			
		}
		
		if(isset($_GET['name']) && !empty($_GET['name'])) {
			$like = array_merge($like,array('bs_admins.admin_name' => $_GET['name']));
		}	

		if(isset($_GET['role']) && !empty($_GET['role'])) {
			$where = array_merge($where,array('bs_admin_roles.admin_role_id' => $_GET['role']));
		}			
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER');
		$this->db->join('bs_roles', 'bs_roles.role_id=bs_admin_roles.admin_role_id', 'INNER');
		$this->db->from('bs_admins');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_admins.*, group_concat(bs_roles.role_name) as roles');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->order_by('bs_admins.admin_id','desc'); 
		$this->db->join('bs_admin_roles', 'bs_admin_roles.admin_id=bs_admins.admin_id', 'INNER');
		$this->db->join('bs_roles', 'bs_roles.role_id=bs_admin_roles.admin_role_id', 'INNER');
		$this->db->group_by('admin_role_id');
		$query = $this->db->get("bs_admins");	
		$data['result'] = $query->result_array();

		return $data;
    }
	
	public function manage_admin()
	{
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$admin_id = $this->input->post('admin_id');
		$admin_id = DeCrypt($admin_id);
							
		$role_id = $this->input->post('role_id');										
		$admin_role_id = $this->input->post('admin_role_id');										
		$circle_id = $this->input->post('circle_id');										
		$ssa_id = $this->input->post('ssa_id');	
		
		$admin = array();	
		$admin['admin_name'] = $this->input->post('name');										
		$admin['admin_username'] = $this->input->post('username');										
		$admin['admin_email'] = $this->input->post('email');										
		$admin['admin_mobile'] = $this->input->post('mobile');	

		$sts = $this->check_admin_email($admin['admin_email'], $admin_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_admin_username($admin['admin_username'], $admin_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Username Already Exist.<br/>Please enter a valid username';
			echo json_encode($response);die;	
		}
										
		$result = array('status' => false);
		try{
			$this->db->trans_begin();  // Transaction Start
			
			if(empty($admin_id)){			
				$admin['admin_added_on'] = date('Y-m-d H:i:s');		
				
				$code = $admin['admin_mobile'];
				if(empty($code)){
					$code = mt_rand(100000,999999);	
				}					
				$password = md5($code);
				
				$admin['admin_password'] = $password;		
				$admin['admin_emailed_pass'] = $code;										
				if($this->db->insert('bs_admins', $admin)){
					$result['status'] = true;
					$result['insert_id'] = $this->db->insert_id();
					$admin_id = $result['insert_id'];
				} else {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
				}
				
				$call_description = 'New Admin Added Successfully';
				$call_type = 1;
				
			} else {
				$admin['admin_updated_on'] = date('Y-m-d H:i:s');	
			
				$this->db->where('admin_id', $admin_id);
				if(!$this->db->update('bs_admins', $admin)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
				}
				
				$call_description = 'Admin Details Updated Successfully';
				$call_type = 2;
			}
			
			$RoleData = array();
			$RoleData['admin_id'] = $admin_id;
			$RoleData['admin_role_id'] = $role_id;
			$RoleData['admin_role_status'] = 1;
			$RoleData['admin_role_ssa_id'] = 0;
			$RoleData['admin_role_circle_id'] = 0;
			
			if($role_id == 2) {
				$RoleData['admin_role_circle_id'] = $circle_id;
			} else if($role_id == 3) {
				$RoleData['admin_role_ssa_id'] = $ssa_id;
			}
			
			if(empty($admin_role_id)){
				$RoleData['admin_role_added_on'] = date('Y-m-d H:i:s');		
				if(!$this->db->insert('bs_admin_roles', $RoleData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');	
				}
			} else {
				$this->db->where('id', $admin_role_id);
				if(!$this->db->update('bs_admin_roles', $RoleData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
				}
				
				if($admin_role_id != $role_id) {
					$role = $this->get_record('bs_roles', 'role_id', $role_id, 'role_name');
					$call_description .= ' Role has been changed to '.$role['role_name'];
				}
			}
			
			$CallInsertData = array();
			$CallInsertData['call_user_id'] = $admin_id;
			$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
			$CallInsertData['call_desc'] = $call_description;
			$CallInsertData['call_type'] = $call_type;
			$CallInsertData['call_time'] = date('Y-m-d H:i:s');
			
			if($this->db->insert('bs_admin_call_logs', $CallInsertData)) {
				if($this->db->trans_status() === FALSE) {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');								
				} else {
					$this->db->trans_commit(); // Transaction Commit
					$result['status'] = true;
				}
			}
		
		}  catch(Exception $e){
			$this->db->trans_rollback(); // Transaction Rollback
			$result['status'] = false;	
		}
		
		return $result;
	}
	
	public function get_afe_users($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_afe_users.afe_status' => $_GET['status']));			
		}
		
		if(isset($_GET['name']) && !empty($_GET['name'])){
			$like = array_merge($like,array('bs_afe_users.afe_name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_afe_users');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_afe_users.afe_id','desc'); 
		$query = $this->db->get("bs_afe_users");		
		$data['result'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_afe() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$afe_id = $this->input->post('afe_id');
		$afe_id = DeCrypt($afe_id);
		
		$data = array();
		$data['afe_name'] = $this->input->post('name');							
		$data['afe_email'] = $this->input->post('email');										
		$data['afe_mobile'] = $this->input->post('mobile');										
		$data['afe_pan_card'] = $this->input->post('pan_card');										
		$data['afe_address '] = $this->input->post('address');											
		$data['afe_bank_name'] = $this->input->post('bank_name');									
		$data['afe_bank_account_no'] = $this->input->post('bank_account_no');									
		$data['afe_bank_ifsc_code'] = $this->input->post('bank_ifsc_code');										
		$data['afe_bank_branch_address'] = $this->input->post('bank_branch_address');

		$sts = $this->check_afe_user_email($data['afe_email'], $afe_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_afe_user_mobile($data['afe_mobile'], $afe_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Mobile Already Exist.<br/>Please enter another no';
			echo json_encode($response);die;	
		}
										
		$result = array('status' => false);
		if(empty($afe_id)){			
			
			$data['afe_added_on'] = date('Y-m-d H:i:s');		
			$data['afe_unique_referral_code'] = $this->generateReferralCode($data['afe_name']);		
						
			if($this->db->insert('bs_afe_users', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
			
		} else {
			
			$data['afe_updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('afe_id', $afe_id);
			if($this->db->update('bs_afe_users', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	function generateReferralCode($name){
		
		$fname = substr($name, 1);
		
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 9; $i++) {
			$res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		
		$referral_code = $fname.$res;
		return $referral_code;
	}
	
	public function get_admin_roles($admin_id, $md5=false){
		if($md5){
			$this->db->where('MD5(admin_id)', $admin_id);
		} else {
			$this->db->where('admin_id', $admin_id);
		}
		$this->db->where(array('admin_role_status' => 1));
		$this->db->join('bs_roles', 'bs_roles.role_id=bs_admin_roles.admin_role_id', 'INNER');
		$query = $this->db->get("bs_admin_roles");		
		$roles = $query->result_array();
		
		return $roles;
	}
	
	public function get_all_roles(){
		$this->db->where(array('role_status' => 1));
		$query = $this->db->get("bs_roles");		
		$roles = $query->result_array();
		
		return $roles;
	}
	
	public function manage_leads() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$user_id = $this->input->post('lead_id');
		$user_id = DeCrypt($user_id);
		
		$user = $this->get_record('bs_users', 'user_id', $user_id);
		if(!empty($user_id) && empty($user)){
			$response['status'] = false;	
			$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.';
			echo json_encode($response);die;	
		}
		
		$data = array();
		$user_id = $user['user_id'];
		$data['user_full_name'] = $this->input->post('name');							
		$data['user_email'] = $this->input->post('email');										
		$data['user_mobile'] = $this->input->post('mobile');										
		$data['user_address'] = $this->input->post('address');										
		$data['user_circle_id'] = $this->input->post('circle_id');											
		$data['user_ssa_id'] = $this->input->post('ssa_id');
		$data['user_afe_referer_id'] = $this->input->post('afe_id');
		
		$sts = $this->check_user_email($data['user_email'], $user_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Email Already Exist.<br/>Please enter a valid email';
			echo json_encode($response);die;	
		}
		
		$user_plan_id = $this->input->post('user_plan_id');										
		$plan_id = $this->input->post('plan_id');										
		$payment_status = $this->input->post('payment_status');										
		
		$result = array('status' => false);
		try{
			$this->db->trans_begin();  // Transaction Start
			
			if(empty($user)){			
				
				$user_status_id = 1;
				$data['user_added_on'] = date('Y-m-d H:i:s');		
				$data['user_status_id'] = $user_status_id;		
				$data['user_active'] = 1;		
							
				if($this->db->insert('bs_users', $data)){
					$result['status'] = true;
					$user_id = $this->db->insert_id();
					$result['insert_id'] = $user_id;
				} 
				
				$call_description = 'New Lead Created Successfully';
				$call_type = 1;
				
			} else {
				
				$user_status_id = $user['user_status_id'];
				$data['user_updated_on'] = date('Y-m-d H:i:s');	
			
				$this->db->where('user_id', $user_id);
				if($this->db->update('bs_users', $data)){
					$result['status'] = true;
				}
				
				$call_description = 'Lead Updated Successfully';
			}
			
			$PlanData = array();
			$PlanData['user_id'] = $user_id;
			$PlanData['user_plan_id'] = $plan_id;
			$PlanData['user_plan_status'] = 1;
			
			if(empty($user)){
				$PlanData['user_plan_started_on'] = date('Y-m-d H:i:s');		
				if(!$this->db->insert('bs_user_plans', $PlanData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');	
				}
			} else {
				
				$PlanData['user_plan_ended_on'] = date('Y-m-d H:i:s');
				
				$this->db->where('user_id', $user_id);
				if(!$this->db->update('bs_user_plans', $PlanData)){
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');
				}
				
				if($user_plan_id != $plan_id) {
					$pln = $this->get_record('bs_roles', 'plan_id', $plan_id, 'plan_name');
					$call_description .= ' Plan has been changed to '.$pln['plan_name'];
				}
			}
			
			$CallInsertData = array();
			$CallInsertData['call_user_id'] = $user_id;
			$CallInsertData['call_logged_admin_id'] = $logged_admin_id;
			$CallInsertData['call_desc'] = $call_description;
			$CallInsertData['call_status_id'] = $user_status_id;
			$CallInsertData['call_time'] = date('Y-m-d H:i:s');
			
			if($this->db->insert('bs_user_call_logs', $CallInsertData)) {
				if($this->db->trans_status() === FALSE) {
					throw new Exception('Unable to proocess your request right now.<br/> Please try again or some time later');								
				} else {
					$this->db->trans_commit(); // Transaction Commit
					$result['status'] = true;
				}
			}
		} catch(Exception $e){
			$this->db->trans_rollback(); // Transaction Rollback
			$result['status'] = false;	
		}
		
		return $result;
	}
	
	public function get_all_leads($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		if(!empty($_GET['status'])) {	
			$where = array_merge($where,array('bs_lead_status.status_id' => $_GET['status']));			
		}
		
		if(!empty($_GET['circle'])) {	
			$where = array_merge($where,array('bs_users.user_circle_id' => $_GET['circle']));			
		}
		
		if(!empty($_GET['name'])){
			$like = array_merge($like,array('bs_users.user_full_name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_users');
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_status_id', 'INNER'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_users.*, bs_lead_status.status_name as current_status, bs_plans.plan_name');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->join('bs_lead_status', 'bs_lead_status.status_id=bs_users.user_status_id', 'INNER'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$this->db->join('bs_plans', 'bs_plans.plan_id=bs_user_plans.user_plan_id', 'INNER'); 
		$query = $this->db->get("bs_users");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function check_user_email($email, $user_id=NULL) {  
		if(empty($user_id)){
			$user_id = 9999;
		}
		$already = $this->db->get_where('bs_users',array('user_email' => $email, 'user_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_admin_email($email, $admin_id=NULL){		
		if(trim($admin_id) == ''){
			$admin_id = 9999;
		}
		
		$already = $this->db->get_where('bs_admins',array('admin_email' => $email, 'admin_id != ' => $admin_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_admin_username($username, $admin_id=NULL){	
		if(trim($admin_id) == ''){
			$admin_id = 9999;
		}
		
		$already = $this->db->get_where('bs_admins',array('admin_username' => $username, 'admin_id != ' => $admin_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_afe_user_email($email, $user_id=NULL){		
		if(trim($user_id) == ''){
			$user_id = 9999;
		}
		
		$already = $this->db->get_where('bs_afe_users',array('afe_email' => $email, 'afe_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_afe_user_mobile($mobile, $user_id=NULL){	
		if(trim($user_id) == ''){
			$user_id = 9999;
		}
		
		$already = $this->db->get_where('bs_afe_users',array('afe_mobile' => $mobile, 'admin_id != ' => $user_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function get_all_leadsStatus(){
		$statss_arr = $this->db->get_where('bs_lead_status',array('status_active' => 1))->result_array();
		
		return $statss_arr;
	}
	
	public function check_circle_name($circle_name, $circle_id=NULL){	
		if(trim($circle_id) == ''){
			$circle_id = 9999;
		}
		
		$already = $this->db->get_where('bs_circles',array('circle_name' => $circle_name, 'circle_id != ' => $circle_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_ssa_name($ssa_name, $ssa_id=NULL){	
		if(trim($ssa_id) == ''){
			$ssa_id = 9999;
		}
		
		$already = $this->db->get_where('bs_ssa',array('ssa_name' => $ssa_name, 'ssa_id != ' => $ssa_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_plan_name($plan_name, $plan_id=NULL, $circle_id=NULL){	
		if(trim($plan_id) == ''){
			$plan_id = 9999;
		}
		
		$already = $this->db->get_where('bs_plans',array('plan_name' => $plan_name, 'plan_id != ' => $plan_id, 'circle_id != ' => $circle_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function check_plan_rental($plan_rental, $plan_id=NULL, $circle_id=NULL){	
		if(trim($plan_id) == ''){
			$plan_id = 9999;
		}
		
		$already = $this->db->get_where('bs_plans',array('plan_rental' => $plan_rental, 'plan_id != ' => $plan_id, 'circle_id != ' => $circle_id))->row_array();
		if(!empty($already)) {
			$sts = 'false';
		} else {
			$sts = 'true';
		}
		
		return $sts;
	}
	
	public function get_all_circles_list($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_circles.circle_status' => $_GET['status']));			
		}
		
		if(isset($_GET['name']) && !empty($_GET['name'])){
			$like = array_merge($like,array('bs_circles.circle_name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_circles');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_circles.*');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_circles.circle_id','desc'); 
		$query = $this->db->get("bs_circles");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_circles() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$circle_id = $this->input->post('circle_id');
		$circle_id = DeCrypt($circle_id);
		
		$data = array();
		$data['circle_name'] = $this->input->post('circle_name');							
		$data['circle_code'] = $this->input->post('circle_code');										
		$data['circle_status'] = $this->input->post('circle_status');										
		
		$sts = $this->check_circle_name($data['circle_name'], $circle_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Circle Name Already Exist.';
			echo json_encode($response);die;	
		}
		
		$result = array('status' => false);
		if(empty($circle_id)){			
			
			$data['circle_added_on'] = date('Y-m-d H:i:s');				
	
			if($this->db->insert('bs_circles', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
		
		} else {
			
			$data['circle_updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('circle_id', $circle_id);
			if($this->db->update('bs_circles', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	public function get_all_ssa_list($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		if(!empty($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_ssa.ssa_status' => $_GET['status']));			
		}
		
		if(!empty($_GET['circle'])) {	
			$where = array_merge($where,array('bs_ssa.circle_id' => $_GET['circle']));			
		}
		
		if(!empty($_GET['name'])){
			$like = array_merge($like,array('bs_ssa.ssa_name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_ssa');
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_ssa.circle_id', 'INNER'); 
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_ssa.*, bs_circles.circle_name');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_ssa.ssa_id','desc'); 
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_ssa.circle_id', 'INNER'); 
		$query = $this->db->get("bs_ssa");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_ssa() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$ssa_id = $this->input->post('ssa_id');
		$ssa_id = DeCrypt($ssa_id);
		
		$data = array();
		$data['circle_id'] = $this->input->post('circle_id');
		$data['ssa_name'] = $this->input->post('ssa_name');							
		$data['ssa_code'] = $this->input->post('ssa_code');										
		$data['ssa_status'] = $this->input->post('ssa_status');										
		
		$sts = $this->check_ssa_name($data['ssa_name'], $ssa_id);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'SSA Name Already Exist.';
			echo json_encode($response);die;	
		}
		
		$result = array('status' => false);
		if(empty($ssa_id)){			
			
			$data['ssa_added_on'] = date('Y-m-d H:i:s');				
	
			if($this->db->insert('bs_ssa', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
		
		} else {
			
			$data['ssa_updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('ssa_id', $ssa_id);
			if($this->db->update('bs_ssa', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	public function get_all_plans($limit, $start) {        
		
		$data = array(); $where = array(); $like = array(); 
		
		if(!empty($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_plans.plan_status' => $_GET['status']));			
		}
		
		if(!empty($_GET['circle'])) {	
			$where = array_merge($where,array('bs_plans.circle_id' => $_GET['circle']));			
		}
		
		if(!empty($_GET['name'])){
			$like = array_merge($like,array('bs_plans.plan_name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_plans');
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_plans.circle_id', 'INNER'); 
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_plans.*, bs_circles.circle_name');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_plans.plan_id','desc'); 
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_plans.circle_id', 'INNER'); 
		$query = $this->db->get("bs_plans");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_plans() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$plan_id = $this->input->post('plan_id');
		$plan_id = DeCrypt($plan_id);
		
		$data = array();
		$data['circle_id'] = $this->input->post('circle_id');
		$data['plan_name'] = $this->input->post('plan_name');							
		$data['plan_code'] = $this->input->post('plan_code');										
		$data['plan_rental'] = $this->input->post('plan_rental');										
		$data['plan_status'] = 1;																			
		$data['plan_features'] = $this->input->post('plan_features');										
		
		$sts = $this->check_plan_name($data['plan_name'], $plan_id, $data['circle_id']);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Plan Name Already Exist in this Circle.';
			echo json_encode($response);die;	
		}
		
		$sts = $this->check_plan_rental($data['plan_rental'], $plan_id, $data['circle_id']);
		if($sts == 'false'){
			$response['status'] = false;	
			$response['message'] = 'Plan Rental Already Exist in this Circle.';
			echo json_encode($response);die;	
		}
		
		$result = array('status' => false);
		if(empty($plan_id)){			
			
			$data['plan_added_on'] = date('Y-m-d H:i:s');				
	
			if($this->db->insert('bs_plans', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
		
		} else {
			
			$data['plan_updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('plan_id', $plan_id);
			if($this->db->update('bs_plans', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	public function get_Circles($circle_id=NULL){
		if(!empty($circle_id)) {
			$this->db->where('circle_id', $circle_id);
		}
		$circles = $this->db->get_where('bs_circles', array('circle_status' => 1))->result_array();
		return $circles;
	}
	
	public function get_SSA($circle_id=NULL, $ssa_id=NULL){
		if(!empty($circle_id)) {
			$this->db->where('circle_id', $circle_id);
		}
		if(!empty($ssa_id)) {
			$this->db->where('ssa_id', $ssa_id);
		}
		$ssa = $this->db->get_where('bs_ssa', array('ssa_status' => 1))->result_array();
		return $ssa;
	}
	
	public function get_Plans($plan_id=NULL){
		if(!empty($plan_id)) {
			$this->db->where('plan_id', $plan_id);
		}
		$plans = $this->db->get_where('bs_plans', array('plan_status' => 1))->result_array();
		return $plans;
	}
	
	public function get_allAFEs($only_Active=NULL){
		
		if(!empty($only_Active)) {
			$this->db->where('afe_status', 1);
		}
		$this->db->select('afe_id, afe_name, afe_name, afe_mobile');
		$results = $this->db->get("bs_afe_users")->result_array();
		
		return $results;
	}
	
	public function get_LeadDetails($lead_id){
		$this->db->select('bs_users.*, bs_user_plans.user_plan_id');
		$this->db->where('bs_users.user_id', $lead_id);
		$this->db->order_by('bs_users.user_id','desc'); 
		$this->db->join('bs_user_plans', 'bs_user_plans.user_id=bs_users.user_id', 'INNER'); 
		$query = $this->db->get("bs_users");	

		return $query->row_array();	
	}
}	
