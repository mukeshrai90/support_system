<?php 
error_reporting(0);
class Cms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');	
		$this->load->model('cms_model');	
		
		$this->months_arr_gl = json_decode(MONTHS_ARR_GL, TRUE);
	}
	
	public function circles_list()
	{
		chk_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_all_circles_list($per_page, $page);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'cms/circles/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'cms/circles/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/circles-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Circles';
		$data['content'] = 'cms/circles';
		$this->load->view('layout',$data);
	}
	
	public function manage_circles($circle_id=0)
	{				
		if($this->input->post('circle_name') != '') {
			
			$result = $this->admin_model->manage_circles();
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Saved Successfully.';
					$response['redirectTo'] = BASE_URL.'cms/circles/list';
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later..';
			}
			
			echo json_encode($response);die;							
		}
		else
		{									
			if(!empty($circle_id)){
				chk_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('bs_circles', 'circle_id', DeCrypt($circle_id));
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_access('cms',2,true);
			}	
				
			$data['pageTitle'] = 'Manage Circles';
			$data['content'] = 'cms/manage-circles';
			$this->load->view('layout',$data);
		}
	}
	
	public function ssa_list()
	{
		chk_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_all_ssa_list($per_page, $page);		
		$data['records'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'cms/ssa/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'cms/ssa/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/ssa-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['circles'] = $this->admin_model->get_Circles();
		
		$data['pageTitle'] = 'SSA';
		$data['content'] = 'cms/ssa';
		$this->load->view('layout',$data);
	}
	
	public function manage_ssa($ssa_id=0)
	{				
		if($this->input->post('ssa_name') != '') {
			
			$result = $this->admin_model->manage_ssa();
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Saved Successfully.';
					$response['redirectTo'] = BASE_URL.'cms/ssa/list';
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.';
			}
			
			echo json_encode($response);die;							
		}
		else
		{									
			if(!empty($ssa_id)){
				chk_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('bs_ssa', 'ssa_id', DeCrypt($ssa_id));
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_access('cms',2,true);
			}	
			
			$data['circles'] = $this->admin_model->get_Circles();
				
			$data['pageTitle'] = 'Manage SSA';
			$data['content'] = 'cms/manage-ssa';
			$this->load->view('layout',$data);
		}
	}
	
	public function all_plans()
	{
		chk_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
						
        $result = $this->admin_model->get_all_plans($per_page, $page);		
		$data['records'] = @$result['results'];
	
		$total_rows = $result['count'];
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'cms/plans/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'cms/plans/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request())
		{
			$data['result'] = $this->load->view('elements/plans-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['circles'] = $this->admin_model->get_Circles();
		
		$data['pageTitle'] = 'Plans';
		$data['content'] = 'cms/plans';
		$this->load->view('layout',$data);
	}
	
	public function manage_plans($plan_id=0)
	{				
		if($this->input->post('plan_name') != '') {
			
			$result =$this->admin_model->manage_plans();
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Saved Successfully.';
					$response['redirectTo'] = BASE_URL.'cms/plans/list';
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
			if(!empty($plan_id)){
				chk_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('bs_plans', 'plan_id', DeCrypt($plan_id));
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_access('cms',2,true);
			}	
			
			$data['circles'] = $this->admin_model->get_Circles();
				
			$data['pageTitle'] = 'Manage Plans';
			$data['content'] = 'cms/manage-plans';
			$this->load->view('layout',$data);
		}
	}
	
	public function change_plans_status(){
		chk_access('admins', 4, true);
		
		$logged_admin = $this->session->userdata('admin');
		$logged_admin_id = $logged_admin['admin_id'];
				
		$status = $this->input->post('status');
		$plan_id = $this->input->post('plan_id');
		$plan_id = DeCrypt($plan_id);
		
		$response = array();
		if($status != '' && !empty($plan_id)) {			
			
			$UpdateData = array('plan_status' => $status);
			$this->db->where('plan_id' ,$plan_id);
			if($this->db->update('bs_plans', $UpdateData)) {
				$response['status'] = true;
				$response['message'] = 'Status Changed Successfully';	
			} else {
				$response['status'] = false;
				$response['message'] = 'Unable to process your request. <br/> Please try again or some later.';
			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Unable to process your request. <br/> Please try again or some later..';
		}
		
		echo json_encode($response);die;
	}
	
	public function check_circle_name(){
		$circle_name = $this->input->get('circle_name');
		$circle_id = $this->input->get('circle_id');
		
		$sts = $this->admin_model->check_circle_name($circle_name, $circle_id);
		echo $sts;
	}
	
	public function check_ssa_name(){
		$ssa_name = $this->input->get('ssa_name');
		$ssa_id = $this->input->get('ssa_id');
		
		$sts = $this->admin_model->check_ssa_name($ssa_name, $ssa_id);
		echo $sts;
	}
	
	public function check_plan_name(){
		$plan_name = $this->input->get('plan_name');
		$plan_id = $this->input->get('plan_id');
		
		$sts = $this->admin_model->check_plan_name($plan_name, $plan_id);
		echo $sts;
	}
	
	public function check_plan_rental(){
		$plan_rental = $this->input->get('plan_rental');
		$plan_id = $this->input->get('plan_id');
		
		$sts = $this->admin_model->check_plan_rental($plan_rental, $plan_id);
		echo $sts;
	}
	/**********************admin commission ************************************/
	public function commission_list()
	{
		chk_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$month = '';
		if(!empty($_GET['month'])) {	
			$month = $_GET['month'];
		}
		
		$year = '';
		if(!empty($_GET['year'])) {	
			$year = $_GET['year'];
		}
						
        $result = $this->cms_model->get_all_commission_list($per_page, $page, $month, $year);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$current_month = date('m');
		$current_year = date('Y');
		$data["month"] = $month;
        $data["year"] = $year;
		$data["current_year"] = $current_year;
		$data['subPageTitle'] = ' | '.$this->months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $this->months_arr_gl;
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'cms/commission/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'cms/commission/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/commission-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Sales Partner Commission';
		$data['content'] = 'cms/commission';
		$this->load->view('layout',$data);
	}
	
	public function manage_commission($id=0)
	{				
		if($this->input->post('title') != '') {
			
			$result = $this->cms_model->manage_commission();
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Saved Successfully.';
					$response['redirectTo'] = BASE_URL.'cms/commission/list';
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later..';
			}
			
			echo json_encode($response);die;							
		}
		else
		{									
			if(!empty($id)){
				chk_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('bs_commission_master', 'id', DeCrypt($id));
				
				$data['is_rcd_updatable'] = false;
				if(is_cmsn_inctv_updatable($data['record'])){
					$data['is_rcd_updatable'] = true;
				}
				
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_access('cms',2,true);
			}	
			
			$data['pageTitle'] = 'Manage Commission';
			$data['circles'] = $this->admin_model->get_Circles();
			$data['content'] = 'cms/manage-commission';
			$this->load->view('layout',$data);
		}
	}
	public function check_commission_title(){
		$title = $this->input->get('title');
		$id = $this->input->get('id');
		
		$sts = $this->cms_model->check_commission_title($title, $id);
		echo $sts;
	}
	
	/**********************admin commission ************************************/
	
	/**********************admin incentive ************************************/
	public function incentive_list()
	{
		chk_access('cms',1,true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$month = '';
		if(!empty($_GET['month'])) {	
			$month = $_GET['month'];
		}
		
		$year = '';
		if(!empty($_GET['year'])) {	
			$year = $_GET['year'];
		}
						
        $result = $this->cms_model->get_all_incentive_list($per_page, $page, $month, $year);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$current_month = date('m');
		$current_year = date('Y');
		$data["month"] = $month;
        $data["year"] = $year;
		$data["current_year"] = $current_year;
		$data['subPageTitle'] = ' | '.$this->months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $this->months_arr_gl;
		
		if(@$_GET['name'] != '')
			$base_url = BASE_URL.'cms/incentive/list?'.$_SERVER['QUERY_STRING'];
		else
			$base_url = BASE_URL.'cms/incentive/list?page=true';
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/incentive-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'CBH/FE Incentive';
		$data['content'] = 'cms/incentive';
		$this->load->view('layout',$data);
	}
	
	public function manage_incentive($id=0)
	{				
		if($this->input->post('title') != '') {
			
			$result = $this->cms_model->manage_incentive();
			
			$response = array();
			if($result['status']) {
				$response['status'] = true;
				if(isset($result['insert_id'])) {
					$response['message'] = 'Saved Successfully.';
					$response['redirectTo'] = BASE_URL.'cms/incentive/list';
				} else {
					$response['message'] = 'Updated Successfully.';
					$response['redirectTo'] = $this->session->userdata('referer');
				}	
			} else {
				$response['status'] = false;	
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later..';
			}
			
			echo json_encode($response);die;							
		}
		else
		{									
			if(!empty($id)){
				chk_access('cms',3,true);
				
				$data['record'] = $this->admin_model->get_record('bs_incentive_master', 'id', DeCrypt($id));
				if(isset($_SERVER['HTTP_REFERER'])) {			
					$referer = array('referer' => $_SERVER['HTTP_REFERER']);
					$this->session->set_userdata($referer);			
				}
			} else {
				chk_access('cms',2,true);
			}	
				
			$data['pageTitle'] = 'Manage Incentive';
			$data['circles'] = $this->admin_model->get_Circles();
			$data['content'] = 'cms/manage-incentive';
			$this->load->view('layout',$data);
		}
	}
	public function check_incentive_title(){
		$title = $this->input->get('title');
		$id = $this->input->get('id');
		
		$sts = $this->Cms_model->check_incentive_title($title, $id);
		echo $sts;
	}
	
	/**********************admin incentive ************************************/
	
}
