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
			$like = array_merge($like,array('bs_admin_roles.admin_role_id' => $_GET['role']));
		}			
					
		$this->db->where($where);
		$this->db->like($like); 
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
		
		$admin = array();						
		$role_id = $this->input->post('role_id');										
		$admin_role_id = $this->input->post('admin_role_id');										
		$admin['admin_name'] = $this->input->post('name');										
		$admin['admin_username'] = $this->input->post('username');										
		$admin['admin_email'] = $this->input->post('email');										
		$admin['admin_mobile'] = $this->input->post('mobile');											
										
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
			$CallInsertData['call_user_id'] = $logged_admin_id;
			$CallInsertData['call_admin_id'] = $admin_id;
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
		
		$user = array();
		$user['afe_name'] = $this->input->post('name');							
		$user['afe_email'] = $this->input->post('email');										
		$user['afe_mobile'] = $this->input->post('mobile');										
		$user['afe_pan_card'] = $this->input->post('pan_card');										
		$user['afe_address '] = $this->input->post('address');											
		$user['afe_bank_name'] = $this->input->post('bank_name');									
		$user['afe_bank_account_no'] = $this->input->post('bank_account_no');									
		$user['afe_bank_ifsc_code'] = $this->input->post('bank_ifsc_code');										
		$user['afe_bank_branch_address'] = $this->input->post('bank_branch_address');										
										
		$result = array('status' => false);
		if(empty($afe_id)){			
			
			$user['afe_added_on'] = date('Y-m-d H:i:s');		
			$user['afe_unique_referral_code'] = $this->generateReferralCode($user['afe_name']);		
						
			if($this->db->insert('bs_afe_users', $user)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
			
		} else {
			
			$user['afe_updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('afe_id', $afe_id);
			if($this->db->update('bs_afe_users', $user)){
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
}	
