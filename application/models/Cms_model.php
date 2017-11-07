<?php

class Cms_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->model('admin_model');	
	}
	
	public function check_commission_exist($date, $type, $circle_id=NULL, $id=NULL) {  
		if(empty($id)){
			$id = 9999;
		}
		$already = $this->db->get_where('bs_commission_master',array('start_date' => $date, 'type' => $type, 'circle_id' => $circle_id, 'id != ' => $id))->row_array();
		if(empty($already)) {
			return false;
		}
		return true;
	}
	
	public function get_next_month_date(){
		$next_month = date('m', strtotime('+ 29 days'));
		$next_year = date('Y', strtotime('+ 29 days'));
		
		$next_month_date = date('Y-m-d', strtotime($next_year.'-'.$next_month.'-1'));
		return $next_month_date;
	}

	public function get_all_commission_list($limit, $start, $month=NULL, $year=NULL) {        
		
		$data = array(); $where = array('id > ' => 2, 'type' => 1); $like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_commission_master.status' => $_GET['status']));			
		}
		
		if(!empty($_GET['t'])) {	
			$where = array_merge($where,array('type' => 2));			
		}
		
		if(isset($_GET['title']) && !empty($_GET['title'])){
			$like = array_merge($like,array('bs_commission_master.title' => $_GET['title']));
		}	

		if(!empty($month) && !empty($year)){
			$where = array_merge($where, array('MONTH(bs_commission_master.start_date)' => $month, 'YEAR(bs_commission_master.start_date)' => $year));	
		}		
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_commission_master');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_commission_master.*, bs_circles.circle_name');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_commission_master.circle_id', 'INNER'); 
		$this->db->order_by('bs_commission_master.id','desc'); 
		$query = $this->db->get("bs_commission_master");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	/*******************commission*************************************/
	public function manage_commission() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$id = $this->input->post('id');
		$id = DeCrypt($id);
		
		$data = array();
		$data['title'] = $this->input->post('title');																							
		$data['rate'] = $this->input->post('rate');										
		$data['type'] = $this->input->post('type');
		$data['circle_id'] = $this->input->post('circle_id');
		$data['active'] = 1; //$this->input->post('active');										
		
		$result = array('status' => false);
		if(empty($id)){			
			
			$data['added_on'] = date('Y-m-d H:i:s');
			
			$next_month_date = $this->get_next_month_date();
			$sts = $this->check_commission_exist($next_month_date, $data['type'], $data['circle_id']);
			if($sts){
				$response['status'] = false;	
				$response['message'] = 'Commission Already Exist for next Month';
				echo json_encode($response);die;	
			}
			
			$data['start_date'] = $next_month_date;
			
			if($this->db->insert('bs_commission_master', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
		
		} else {
			
			$rslt = $this->admin_model->get_record('bs_commission_master', 'id', $id);
			if(empty($rslt) || !is_cmsn_inctv_updatable($rslt)){
				$response['status'] = false;	
				$response['message'] = 'You can\'t not update this record.';
				echo json_encode($response);die;	
			}
			
			$data['updated_on'] = date('Y-m-d H:i:s');	
			
			$this->db->where('id', $id);
			if($this->db->update('bs_commission_master', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	/*******************incentive*************************************/
	public function manage_incentive() {
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
		
		$id = $this->input->post('id');
		$id = DeCrypt($id);
		
		$data = array();
		$data['title'] = $this->input->post('title');							
		$data['rate'] = $this->input->post('rate');										
		$data['type'] = $this->input->post('type');										
		$data['circle_id'] = $this->input->post('circle_id');										
		$data['active'] = 1; //$this->input->post('active');										
		
		$result = array('status' => false);
		if(empty($id)){			
			
			$data['added_on'] = date('Y-m-d H:i:s');

			$next_month_date = $this->get_next_month_date();
			$sts = $this->check_inctv_exist($next_month_date, $data['type']);
			if($sts){
				$response['status'] = false;	
				$response['message'] = 'Incentive Already Exist for next Month';
				echo json_encode($response);die;	
			}
			
			$data['start_date'] = $next_month_date;
	
			if($this->db->insert('bs_incentive_master', $data)){
				$result['status'] = true;
				$result['insert_id'] = $this->db->insert_id();
			} 
		
		} else {
			$rslt = $this->admin_model->get_record('bs_incentive_master', 'id', $id);
			if(empty($rslt) || !is_cmsn_inctv_updatable($rslt)){
				$response['status'] = false;	
				$response['message'] = 'You can\'t not update this record.';
				echo json_encode($response);die;	
			}
			
			$data['updated_on'] = date('Y-m-d H:i:s');	
		
			$this->db->where('id', $id);
			if($this->db->update('bs_incentive_master', $data)){
				$result['status'] = true;
			}
		}
		
		return $result;
	}
	
	public function check_inctv_exist($date, $type, $id=NULL) {  
		if(empty($id)){
			$id = 9999;
		}
		$already = $this->db->get_where('bs_incentive_master',array('start_date' => $date, 'type' => $type, 'id != ' => $id))->row_array();
		if(empty($already)) {
			return false;
		}
		return true;
	}
	
	
	public function get_all_incentive_list($limit, $start, $month=NULL, $year=NULL) {        
		
		$data = array(); $where = array('id > ' => 1); $like = array(); 
		
		if(isset($_GET['status'])) {	
			$_GET['status'] = $_GET['status'] == 2 ? 0 : $_GET['status'];
			$where = array_merge($where,array('bs_incentive_master.status' => $_GET['status']));			
		}
		
		if(isset($_GET['title']) && !empty($_GET['title'])){
			$like = array_merge($like,array('bs_incentive_master.title' => $_GET['title']));
		}		
		
		if(isset($_GET['type']) && !empty($_GET['type'])){
			$like = array_merge($like,array('bs_incentive_master.type' => $_GET['type']));
		}	
		
		if(!empty($month) && !empty($year)){
			$where = array_merge($where, array('MONTH(bs_incentive_master.start_date)' => $month, 'YEAR(bs_incentive_master.start_date)' => $year));	
		}
					
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->from('bs_incentive_master');
		$data['count'] = $this->db->count_all_results();
		
		$this->db->select('bs_incentive_master.*, bs_circles.circle_name');
		$this->db->where($where);
		$this->db->like($like); 
		$this->db->limit($limit, $start);
		$this->db->order_by('bs_incentive_master.id','desc');
		$this->db->join('bs_circles', 'bs_circles.circle_id=bs_incentive_master.circle_id', 'LEFT'); 
		$query = $this->db->get("bs_incentive_master");		
		$data['results'] = $query->result_array();
		
		return $data;
    }
	
	
	/*******************incentive*************************************/
}	
