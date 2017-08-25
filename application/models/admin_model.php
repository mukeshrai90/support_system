<?php

class Admin_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_admin($admin_id=NULL)
	{		
		if(trim($admin_id) != '')
		{
			$admin = array();
			$this->db->select('ts_users.*,role_name');			
			$this->db->join('ts_user_roles','ts_users.role_id=ts_user_roles.id','INNER');
			$admin = $this->db->get_where('ts_users', array('ts_users.id' => $admin_id))->row_array();
			
			return $admin;
		}		
	}
	
	public function get_user($user_id=NULL, $select=NULL)
	{		
		$user = array();
		if($select){
			$this->db->select($select);
		}
		$user = $this->db->get_where('ts_users', array('id' => $user_id))->row_array();		
		return $user;		
	}
	
	public function get_user_devices($user_id=NULL)
	{		
		$devices = array();
		$this->db->select('ts_user_assigned_devices.*,ts_devices_inventory.device_name,ts_devices_inventory.device_type,ts_devices_inventory.device_specification');
		$this->db->join('ts_devices_inventory', 'ts_devices_inventory.device_id=ts_user_assigned_devices.device_id', 'LEFT');
		$devices = $this->db->get_where('ts_user_assigned_devices', array('user_id' => $user_id, 'assigned_status' => 1))->result_array();
				
		//$user_devices = $this->get_user($user_id, 'desktop_id,laptop_id');
		if(isset($user_devices['desktop_id']) && $user_devices['desktop_id'] != ''){
			$device_count = count($devices);
			$devices[$device_count]['device_id'] = $user_devices['desktop_id'];
			$devices[$device_count]['assigned_status'] = 1;
			$devices[$device_count]['device_name'] = 'Desktop';
		}
		
		if(isset($user_devices['laptop_id']) && $user_devices['laptop_id'] != ''){
			$device_count = count($devices);
			$devices[$device_count]['device_id'] = $user_devices['laptop_id'];
			$devices[$device_count]['assigned_status'] = 1;
			$devices[$device_count]['device_name'] = 'Laptop';
		}
		//prx($devices);
		return $devices;		
	}
	
	public function device_surrender_logs($user_id=NULL)
	{		
		$devices = array();	
		$this->db->select('ts_surrender_logs.*,ts_devices_inventory.device_name as inv_device_name,ts_devices_inventory.device_specification');
		$this->db->join('ts_devices_inventory', 'ts_devices_inventory.device_id=ts_surrender_logs.device_id', 'LEFT');
		$devices = $this->db->get_where('ts_surrender_logs', array('user_id' => $user_id))->result_array();
						
		return $devices;		
	}
	
	public function get_user_by_emp_code($emp_code=NULL, $select=NULL)
	{		
		$user = array();
		if($select){
			$this->db->select($select);
		}
		$user = $this->db->get_where('ts_users', array('emp_code' => $emp_code))->row_array();
		
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
	
	public function get_record($table, $id, $select=NULL)
	{	
		if($select){
			$this->db->select($select);
		}
		$query = $this->db->get_where($table, array('id' => $id));
		return $query->row_array();
	}
	
	public function get_record_md5($table, $id, $select=NULL)
	{	
		if($select){
			$this->db->select($select);
		}
		$query = $this->db->get_where($table, array('MD5(id)' => $id));
		return $query->row_array();
	}
	
	public function get_all_records($table,$order=NULL)
	{
		if(trim($order) != '')
		{
			$this->db->order_by($order,'asc');
		}		
		$query = $this->db->get($table);
		return $query->result_array();
	}		

	public function save_site_settings()
	{
		$facebook_url_show = 0;
		if($this->input->post('facebook_url_show') == 'on')
		{
			$facebook_url_show = 1;
		}
				
		$google_url_show = 0;
		if($this->input->post('google_url_show') == 'on')
		{
			$google_url_show = 1;
		}
		
		$twitter_url_show = 0;
		if($this->input->post('twitter_url_show') == 'on')
		{
			$twitter_url_show = 1;
		}	

		$pinterest_url_show = 0;
		if($this->input->post('pinterest_url_show') == 'on')
		{
			$pinterest_url_show = 1;
		}
		
		$linkedin_url_show = 0;
		if($this->input->post('linkedin_url_show') == 'on')
		{
			$linkedin_url_show = 1;
		}
		
		$data = array('general_email' => $this->input->post('general_email'),'contact_email' => $this->input->post('contact_email'),'noreply_email' => $this->input->post('noreply_email'),'noreply_name' => $this->input->post('noreply_name'),'facebook_url' => $this->input->post('facebook_url'),'facebook_url_show' => $facebook_url_show,'google_url' => $this->input->post('google_url'),'google_url_show' => $google_url_show,'pinterest_url' => $this->input->post('pinterest_url'),'pinterest_url_show' => $pinterest_url_show,'twitter_url' => $this->input->post('twitter_url'),'twitter_url_show' => $twitter_url_show,'linkedin_url' => $this->input->post('linkedin_url'),'linkedin_url_show' => $linkedin_url_show);
		
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('site_infos', $data); 
	}
	
	public function get_categories($limit, $start)
	{
		$like = array();$where = array();$data = array();

		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_category_types');
		$data['count'] = $this->db->count_all_results();

		$this->db->order_by('ts_category_types.id','desc');			
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$cats = $this->db->get("ts_category_types")->result_array();
			
		$data['results'] = $cats;
		return $data;
	}

	public function save_categories()
	{
		$id = $this->input->post('id');
		
		$data = array('title' => $this->input->post('name'),'status' => $this->input->post('status'));
		if(trim($id) == '')
		{
			$this->db->insert('ts_category_types', $data); 
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('ts_category_types', $data); 
		}
	}
	
	public function get_request_types($limit, $start)
	{
		$like = array();$where = array();$data = array();

		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_request_types');
		$data['count'] = $this->db->count_all_results();

		$this->db->order_by('ts_request_types.id','desc');			
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$records = $this->db->get("ts_request_types")->result_array();
			
		$data['results'] = $records;
		return $data;
	}

	public function save_request_types()
	{
		$id = $this->input->post('id');
		
		$data = array('title' => $this->input->post('name'),'status' => $this->input->post('status'));
		if(trim($id) == '')
		{
			$this->db->insert('ts_request_types', $data); 
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('ts_request_types', $data); 
		}
	}
	
	public function get_machine_types($limit, $start)
	{
		$like = array();$where = array();$data = array();

		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_machine_types');
		$data['count'] = $this->db->count_all_results();

		$this->db->order_by('ts_machine_types.id','desc');			
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$records = $this->db->get("ts_machine_types")->result_array();
			
		$data['results'] = $records;
		return $data;
	}

	public function save_machine_types()
	{
		$id = $this->input->post('id');
		
		$data = array('title' => $this->input->post('name'),'status' => $this->input->post('status'));
		if(trim($id) == '')
		{
			$this->db->insert('ts_machine_types', $data); 
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('ts_machine_types', $data); 
		}
	}
	
	public function get_machine_parts($limit, $start)
	{
		$like = array();$where = array();$data = array();

		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_parts');
		$data['count'] = $this->db->count_all_results();

		$this->db->select('ts_parts.*,ts_machine_types.title as machine_type');
		$this->db->order_by('ts_parts.id','desc');		
		$this->db->join('ts_machine_types', 'ts_parts.machine_type_id=ts_machine_types.id', 'LEFT');
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$records = $this->db->get("ts_parts")->result_array();
			
		$data['results'] = $records;
		return $data;
	}

	public function save_machine_parts()
	{
		$id = $this->input->post('id');
		
		$title = $this->input->post('name');
		$part_name = str_replace(' ', '-', $title);
		$part_name = strtolower($part_name);
		
		$associate_check = $this->input->post('associate_check');
		
		$data = array('title' => $title, 'part_name' => $part_name,'machine_type_id' => $this->input->post('machine_type_id'),'associated_with_system_id' => $associate_check,'status' => $this->input->post('status'));
		if(trim($id) == '')
		{
			$this->db->insert('ts_parts', $data); 
		}
		else
		{
			$this->db->where('id',$id);
			$this->db->update('ts_parts', $data); 
		}
	}
	
	public function get_tickets($limit, $start,$user_id,$assigned=false)
	{
		$data = array(); 
		
		$like = array();
		
		$user = $this->get_user($user_id,'role_id,emp_code');
		$role_id = $user['role_id'];
		$user_emp_code = $user['emp_code'];
		
		$where = 'ts_tickets.id > 0';
		if(($role_id == 1 || $role_id == 6 || strtolower($user_emp_code) == 'b4s/0001') && !$assigned){
			$status_field = 'ts_tickets_status.title_long_text as status_name';
			
		} else if(!$assigned){
			$status_field = 'ts_tickets_status.title as status_name';
			$where = array('ts_tickets.user_id' => $user_id);
			
		} else if($assigned) {			
			$status_field = 'ts_tickets_status.title_long_text as status_name';
			
			if(strtolower($user_emp_code) == 'b4s/0001'){
				$where = "(assigned_user_id = '$user_id' OR assigned_user_emp_code = '$user_emp_code') AND (assigned_user_role_id = '2' OR assigned_user_role_id = '6')";
			} else {
				$where = "(assigned_user_id = '$user_id' OR assigned_user_emp_code = '$user_emp_code') AND assigned_user_role_id = '$role_id'";
			}						
		}
	
		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_tickets');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select("ts_tickets.*, ts_users.name, ts_users.emp_code,ts_tickets_status.ticket_close_allowed,ts_tickets_status.ticket_close_allowed_role_id, $status_field, ts_category_types.title as category_type, ts_request_types.title as request_type, ts_machine_types.title as machine_type, ts_parts.title as part");			
		$this->db->join('ts_users','ts_tickets.user_id=ts_users.id', 'INNER');
		$this->db->join('ts_tickets_status', 'ts_tickets.status=ts_tickets_status.id', 'INNER');
		$this->db->join('ts_category_types', 'ts_tickets.category_type_id=ts_category_types.id', 'LEFT');
		$this->db->join('ts_request_types', 'ts_tickets.request_type_id=ts_request_types.id', 'LEFT');
		$this->db->join('ts_machine_types', 'ts_tickets.machine_type_id=ts_machine_types.id', 'LEFT');
		$this->db->join('ts_parts', 'ts_tickets.part_id=ts_parts.id', 'LEFT');
		$this->db->order_by('ts_tickets.date_updated', 'desc');	
		$this->db->order_by('ts_tickets.id', 'desc');				
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$tickets = $this->db->get("ts_tickets")->result_array();
	
		$data['results'] = $tickets;
		return $data;
	}
	
	public function save_tickets()
	{
		
	}
	
	public function get_user_manager_one($user_id){
		$user = $this->get_user($user_id);		
		$manager_emp_code = $user['manager_emp_code'];
		
		$manager = $this->get_user_by_emp_code($manager_emp_code);
		$manager_id = $manager['id'];
		
		return array($manager_emp_code,$manager_id);
	}
	
	public function save_ticket_log($log_data=array()){
		if($this->db->insert('ts_ticket_logs', $log_data)){
			return true;
		} else {
			return false;
		}
	}
	
	public function get_todays_tickets(){		
		$today = date('Y-m-d');		
		$where = "DATE(date_added) = DATE(NOW())";		
		$where = "date_added BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()";		
		
		$this->db->select('COUNT(id) as ticket_count');
		$this->db->where($where); 				
		$record = $this->db->get("ts_tickets")->row_array();				
		return $record['ticket_count'];
	}
	
	public function get_it_admin($user_id){
		$user = $this->get_user(1);
		
		$manager_emp_code = $user['emp_code'];		
		$manager_id = $user['id'];
		
		return array($manager_emp_code,$manager_id);
	}
	
	public function get_ticket_details($id){
		
		$this->db->select('ts_tickets.*, ts_users.name, ts_users.emp_code, ts_tickets_status.title, ts_category_types.title as category_type, ts_request_types.title as request_type, ts_machine_types.title as machine_type, ts_parts.title as part');			
		$this->db->join('ts_users','ts_tickets.user_id=ts_users.id','INNER');
		$this->db->join('ts_tickets_status','ts_tickets.status=ts_tickets_status.id','INNER');
		$this->db->join('ts_category_types','ts_tickets.category_type_id=ts_category_types.id','LEFT');
		$this->db->join('ts_request_types','ts_tickets.request_type_id=ts_request_types.id','LEFT');
		$this->db->join('ts_machine_types','ts_tickets.machine_type_id=ts_machine_types.id','LEFT');
		$this->db->join('ts_parts','ts_tickets.part_id=ts_parts.id','LEFT');
		$query = $this->db->get_where('ts_tickets', array('MD5(ts_tickets.id)' => $id));		
		return $query->row_array();
	}
	
	public function get_ticket_logs($ticket_id){
		
		$this->db->select('ts_ticket_logs.*, ts_users.name, ts_users.emp_code,ts_tickets_status.title_long_text');
		$this->db->join('ts_users','ts_ticket_logs.user_id=ts_users.id','LEFT');
		$this->db->join('ts_tickets_status','ts_ticket_logs.status_id=ts_tickets_status.id','LEFT');
		$this->db->order_by('ts_ticket_logs.id','DESC');
		$query = $this->db->get_where('ts_ticket_logs', array('ticket_id' => $ticket_id));
		return $query->result_array();
	}
	
	public function get_ticket_bills($ticket_id, $user_id, $user_role){
		
		if($user_role == 5){
			$where = "user_id = '$user_id' AND ticket_id = '$ticket_id' AND ts_ticket_invoices.status = '1'";
		} else {
			$where = "ticket_id = '$ticket_id'";
		}
		
		$this->db->select('ts_ticket_invoices.*, ts_users.name, ts_users.emp_code');
		$this->db->join('ts_users','ts_ticket_invoices.user_id=ts_users.id','LEFT');		
		$this->db->order_by('ts_ticket_invoices.id','DESC');
		$this->db->where($where);
		$query = $this->db->get('ts_ticket_invoices');
		return $query->result_array();
	}
	
	public function get_allowed_status_array($role_id=NULL, $current_status, $previous_status_id_dependent=NULL, $original_current_status=NULL){
		
		if($role_id != ''){
			if(in_array($current_status, array(4))){
				$role_id = 6;
			}
			$this->db->where('role_id', $role_id);
		}
		
		
		if($previous_status_id_dependent){			
			$status_map_array = array('24' => '14', '16' => '12', '25' => '0', '19' => '12');
			if($status_map_array[$current_status] != ''){
				$current_status = $status_map_array[$current_status];
			}
			$this->db->where('previous_status_id', $current_status);
		}
		
		if(!empty($original_current_status) && in_array($original_current_status, array(19))){
			$this->db->where('id !=', $original_current_status);
		}
		
		$query = $this->db->get_where('ts_tickets_status',array('status' => 1));
		return $query->result_array();
	}
	
	public function get_device_details($user_id, $part_name){
		$device_id = '';
		
		$this->db->select('ts_devices_inventory.device_id');
		$this->db->where('device_type_for_map', $part_name);
		$this->db->where('user_id', $user_id);
		$this->db->where('assigned_status', 1);
		$this->db->join('ts_user_assigned_devices', 'ts_user_assigned_devices.device_id=ts_devices_inventory.device_id', 'INNER');
		
		$device_details = $this->db->get('ts_devices_inventory')->row_array();
		if(!empty($device_details)){
			$device_id = $device_details['device_id'];
		}

		return $device_id;
	}
	
	public function get_ticket_reports($limit=0, $start=0){
		
		$data = array();
		$where = array('ts_tickets.id >' => 0);
		$like = array(); 
		
		if(isset($_GET['device_id'])){			
			$where = array_merge($where,array('ts_tickets.device_id' => $_GET['device_id']));			
		}
					
		$this->db->where($where);
		$this->db->like($like); 	
		$this->db->from('ts_tickets'); 
		$this->db->select('ts_tickets.*');
		$this->db->join('ts_users','ts_tickets.user_id=ts_users.id','INNER');
		$this->db->join('ts_ticket_invoices','ts_tickets.id=ts_ticket_invoices.ticket_id','LEFT');
		$this->db->join('ts_devices_inventory','ts_tickets.device_id=ts_devices_inventory.device_id','LEFT');
		$this->db->group_by('ts_tickets.id');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('ts_tickets.id','desc'); 
		$this->db->select('ts_tickets.*, ts_users.name,ts_users.emp_code,SUM(ts_ticket_invoices.amount) as total_amount,ts_devices_inventory.device_name,ts_devices_inventory.device_type,ts_tickets_status.title as status_name');		
		$this->db->join('ts_tickets_status', 'ts_tickets.status=ts_tickets_status.id', 'INNER');
		$this->db->join('ts_users','ts_tickets.user_id=ts_users.id','INNER');
		$this->db->join('ts_ticket_invoices','ts_tickets.id=ts_ticket_invoices.ticket_id','LEFT');
		$this->db->join('ts_devices_inventory','ts_tickets.device_id=ts_devices_inventory.device_id','LEFT');
		$this->db->group_by('ts_tickets.id');
		$data['result'] = $this->db->get_where('ts_tickets')->result_array();		
					
		return $data;
	}
	
	public function get_expense_reports($limit=0, $start=0){
		
		$data = array();
		$where = array('ts_tickets.id >' => 0);
		$like = array(); 
		
		if(isset($_GET['device_id'])){			
			$where = array_merge($where,array('ts_tickets.device_id' => $_GET['device_id']));			
		}
					
		$this->db->where($where);
		$this->db->like($like); 			
		$this->db->select('ts_tickets.*, SUM(ts_ticket_invoices.amount) as total_amount');				
		$this->db->join('ts_ticket_invoices','ts_tickets.id=ts_ticket_invoices.ticket_id','LEFT');		
		$this->db->group_by('ts_tickets.device_id');
		$this->db->group_by('ts_tickets.rndm_identifier');
		$this->db->having('total_amount > ', 0);
		$data['count'] = count($this->db->get('ts_tickets')->result_array());		
		
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('ts_tickets.id','desc'); 
		$this->db->select('ts_tickets.*, ts_users.name,ts_users.emp_code,SUM(ts_ticket_invoices.amount) as total_amount,ts_devices_inventory.device_name,ts_tickets_status.title as status_name');		
		$this->db->join('ts_tickets_status', 'ts_tickets.status=ts_tickets_status.id', 'INNER');
		$this->db->join('ts_users','ts_tickets.user_id=ts_users.id','INNER');
		$this->db->join('ts_ticket_invoices','ts_tickets.id=ts_ticket_invoices.ticket_id','LEFT');
		$this->db->join('ts_devices_inventory','ts_tickets.device_id=ts_devices_inventory.device_id','LEFT');		
		$this->db->group_by('ts_tickets.device_id');
		$this->db->group_by('ts_tickets.rndm_identifier');
		$this->db->having('total_amount > ', 0);
		$data['result'] = $this->db->get('ts_tickets')->result_array();
		
		return $data;
	}
	
	public function get_expense_report_tickets($ticket_id, $limit, $start){
		
		$like = array();
		$where = array('MD5(ts_tickets.id)' => $ticket_id);
		$data = array();
		
		if(isset($_GET['device_id']) && trim($_GET['device_id']) != ''){
			$device_id = $_GET['device_id'];
			$where = array('ts_tickets.device_id' => $device_id);
		}
		
		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_tickets');		
		$data['count'] = $this->db->count_all_results();
							
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$this->db->select("ts_tickets.*, ts_users.name, ts_users.emp_code,ts_tickets_status.ticket_close_allowed,ts_tickets_status.ticket_close_allowed_role_id, ts_category_types.title as category_type, ts_request_types.title as request_type, ts_machine_types.title as machine_type, ts_parts.title as part,SUM(ts_ticket_invoices.amount) as total_amount,ts_tickets_status.title_long_text as status_name");			
		$this->db->join('ts_users','ts_tickets.user_id=ts_users.id', 'INNER');
		$this->db->join('ts_tickets_status', 'ts_tickets.status=ts_tickets_status.id', 'INNER');
		$this->db->join('ts_category_types', 'ts_tickets.category_type_id=ts_category_types.id', 'LEFT');
		$this->db->join('ts_request_types', 'ts_tickets.request_type_id=ts_request_types.id', 'LEFT');
		$this->db->join('ts_machine_types', 'ts_tickets.machine_type_id=ts_machine_types.id', 'LEFT');
		$this->db->join('ts_parts', 'ts_tickets.part_id=ts_parts.id', 'LEFT');
		$this->db->join('ts_ticket_invoices','ts_tickets.id=ts_ticket_invoices.ticket_id','LEFT');
		$this->db->order_by('ts_tickets.date_updated', 'desc');	
		$this->db->order_by('ts_tickets.id', 'desc');			
		$data['results'] = $this->db->get("ts_tickets")->result_array();
		
		return $data;
	}
	
	public function get_device_assigned_status($device_type, $device_id, $user_id){
		
		$this->db->where(array('laptop_id' => $device_id, 'id' != $user_id, 'status' => 1));
		$this->db->or_where(array('desktop_id' => $device_id));
		$result = $this->db->get('ts_users')->result_array();
		
		if(count($result) > 0){
			return $result;
		} else {
			$this->db->join('ts_users','ts_tickets.user_id=ts_users.id','INNER');
			$this->db->where(array('device_id' => $device_id, 'user_id' != $user_id, 'assigned_status' => 1));		
			$result = $this->db->get('ts_user_assigned_devices')->result_array();
			
			return $result;
		}
	}
	
	public function get_team_users($user_id, $role_id){
		if($role_id == 2){
			$user = $this->get_user($user_id, 'emp_code');
			$this->db->where('manager_emp_code', $user['emp_code']);
		}
		
		$this->db->select('id,name,emp_code');
		$this->db->where('status', 1);
		$this->db->where('id >', 2);
		$users = $this->db->get('ts_users')->result_array();
		
		return $users;
	}
	
	public function get_all_devices($limit, $start){
		
		$like = array();
		$where = array('id >' => 0);
		$data = array();
		
		if(isset($_GET['device_id']) && trim($_GET['device_id']) != ''){
			$device_id = $_GET['device_id'];
			$where = array('ts_devices_inventory.device_id' => $device_id);
		}
		
		$this->db->like($like); 
		$this->db->where($where); 
		$this->db->from('ts_devices_inventory');		
		$data['count'] = $this->db->count_all_results();
							
		$this->db->like($like); 
		$this->db->where($where); 		
		$this->db->limit($limit, $start);
		$this->db->select("ts_devices_inventory.*");					
		$this->db->order_by('ts_devices_inventory.device_updated_date', 'desc');	
		$this->db->order_by('ts_devices_inventory.id', 'desc');			
		$data['results'] = $this->db->get("ts_devices_inventory")->result_array();
		
		return $data;
	}
	
	public function get_device($device_id){
		$this->db->where('MD5(id)', $device_id);
		$device = $this->db->get('ts_devices_inventory')->row_array();
		
		return $device;
	}
	
	public function get_devices_assignment_history($device_id){
		
		$this->db->where('device_id', $device_id);
		$this->db->select('ts_user_assigned_devices.*,ts_users.name,ts_users.emp_code,assignedby.name as assigned_by_name,assignedby.emp_code as assigned_by_emp_code');
		$this->db->join('ts_users','ts_user_assigned_devices.user_id=ts_users.id','INNER');
		$this->db->join('ts_users assignedby','ts_user_assigned_devices.assigned_by=assignedby.id','LEFT');
		$records = $this->db->get('ts_user_assigned_devices')->result_array();
						
		return $records;
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
		$data = array();
		$where = array('ts_users.id >' => 1, 'ts_users.role_id' => 1);$like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('ts_users.status' => $_GET['status']));			
		}
		
		if(isset($_GET['name']) && !empty($_GET['name']))
		{
			$like = array_merge($like,array('ts_users.name' => $_GET['name']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('ts_users');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->order_by('ts_users.id','desc'); 
		$this->db->select('ts_users.*,ts_user_roles.role_name');
		$this->db->join('ts_user_roles','ts_users.role_id=ts_user_roles.id','INNER');
		$query = $this->db->get("ts_users");		
		$data['result'] = $query->result_array();
		
		return $data;
    }
	
	public function manage_admin()
	{
		$admin_id = $this->session->userdata('admin_id');
		$id = $this->input->post('id');
		
		$user = array();
		$user['emp_code'] = $this->input->post('emp_code');							
		$user['name'] = $this->input->post('name');										
		$user['email'] = $this->input->post('email');										
		$user['mobile'] = $this->input->post('mobile');										
		$user['role_id'] = 1;										
		$user['designation'] = $this->input->post('designation');									
		$user['department'] = $this->input->post('department');										
		$user['location'] = $this->input->post('location');										
		$user['city'] = $this->input->post('city');	
		
		$code = '';									
		if(trim($id) == ''){			
			$code = $user['mobile'];
			if(empty($code)){
				$code = mt_rand(100000,999999);	
			}					
			$password = md5($code);
			
			$user['password'] = $password;		
			$user['emailed_code'] = $code;		
			$user['date_added'] = date('Y-m-d H:i:s');		
			$user['registered_by'] = $admin_id;
						
			$this->db->insert('ts_users', $user);
			
		} else {
			$user['updated_by'] = $admin_id;
			$user['updated_at'] = date('Y-m-d H:i:s');	
		
			$this->db->where('id',$id);
			$this->db->update('ts_users', $user); 
		}
		
		return $code;
	}
	
	function get_surrender_device_logs($limit, $start){
		$data = array();
		$where = array();$like = array(); 
		
		if(isset($_GET['user']) && !empty($_GET['user'])) {
			$like = array_merge($like,array('ts_surrender_logs.user_id' => $_GET['user']));
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('ts_surrender_logs');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('ts_surrender_logs.*,ts_devices_inventory.device_name as inv_device_name,ts_devices_inventory.device_specification,ts_users.name,ts_users.emp_code');
		$this->db->join('ts_devices_inventory', 'ts_devices_inventory.device_id=ts_surrender_logs.device_id', 'LEFT');
		$this->db->join('ts_users', 'ts_users.id=ts_surrender_logs.user_id', 'INNER');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('ts_surrender_logs.id','desc'); 
		$query = $this->db->get("ts_surrender_logs");		
		$data['result'] = $query->result_array();
		
		return $data;
	}
}	
