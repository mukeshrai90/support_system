<?php 
error_reporting(0);
class Incentive extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');	
		$this->months_arr_gl = json_decode(MONTHS_ARR_GL, TRUE);
	}
	
	public function fe_incentives()
	{
		$loggedIn_data = chk_access('fe_incentives', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = date('m', strtotime('-27 days'));
		$last_month_year = date('Y', strtotime('-27 days'));
		
		$month = $last_month;
		if(!empty($_GET['month'])) {	
			$month = $_GET['month'];
		}
		
		$year = $last_month_year;
		if(!empty($_GET['year'])) {	
			$year = $_GET['year'];
		}
		
		$and_whre = get_loggedINCondtn('incentive', $loggedIn_data);		
		
		$data["pageUrl"] = BASE_URL.'incentives/fe/list';
		if(!empty($_GET['m']) && $_GET['m'] == 'current'){
			$month = $current_month; $year = $current_year;
			$result = $this->admin_model->get_fe_incentives_list_monthly($per_page, $page, $month, $year, 3, false, $and_whre);
			$data["pageUrl"] = $data["pageUrl"].'?m=current';
			
		} else {
			$current_month = $last_month;
			$result = $this->admin_model->get_incentives_list($per_page, $page, $month, $year, 3, $and_whre);
		}
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'incentives/fe/list?'.$_SERVER['QUERY_STRING'];
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
        $data["current_month"] = $current_month;
        $data["current_year"] = $current_year;
        $data["last_month"] = $last_month;
        $data["last_month_year"] = $last_month_year;
        $data["month"] = $month;
        $data["year"] = $year;
        $data["logged_in_role_id"] = $loggedIn_data['current_role_id'];
		
		$data['subPageTitle'] = ' | '.$this->months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $this->months_arr_gl;
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/fe-incentives-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data["admins"] = $this->admin_model->get_all_admins_byRole(3);
		
		$this->session->unset_userdata('inctvcbh_htprfr');
		
		$data['pageTitle'] = 'FE Incentives';
		$data['content'] = 'incentive/fe-incentives';
		$this->load->view('layout',$data);
	}
	
	public function cbh_incentives()
	{
		$loggedIn_data = chk_access('cbh_incentives', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$current_month = date('m');
		$current_year = date('Y');
		$last_month = date('m', strtotime('-27 days'));
		$last_month_year = date('Y', strtotime('-27 days'));
		
		$month = $last_month;
		if(!empty($_GET['month'])) {	
			$month = $_GET['month'];
		}
		
		$year = $last_month_year;
		if(!empty($_GET['year'])) {	
			$year = $_GET['year'];
		}
		
		$and_whre = get_loggedINCondtn('incentive', $loggedIn_data);
		
		$data["pageUrl"] = BASE_URL.'incentives/cbh/list';
		if(!empty($_GET['m']) && $_GET['m'] == 'current'){
			$month = $current_month; $year = $current_year;
			$result = $this->admin_model->get_cbh_incentives_list_monthly($per_page, $page, $month, $year, 2, false, $and_whre);
			$data["pageUrl"] = $data["pageUrl"].'?m=current';
			
		} else {
			$current_month = $last_month;
			$result = $this->admin_model->get_incentives_list($per_page, $page, $month, $year, 2, $and_whre);
		}
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'incentives/cbh/list?'.$_SERVER['QUERY_STRING'];
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
        $data["current_month"] = $current_month;
        $data["current_year"] = $current_year;
        $data["last_month"] = $last_month;
        $data["last_month_year"] = $last_month_year;
        $data["month"] = $month;
        $data["year"] = $year;
        $data["logged_in_role_id"] = $loggedIn_data['current_role_id'];
		
		$data['subPageTitle'] = ' | '.$this->months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $this->months_arr_gl;
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/cbh-incentives-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data["admins"] = $this->admin_model->get_all_admins_byRole(2);
		
		$this->session->unset_userdata('inctvcbh_htprfr');
		
		$data['pageTitle'] = 'CBH Incentives';
		$data['content'] = 'incentive/cbh-incentives';
		$this->load->view('layout',$data);
	}
	
	public function get_cbh_incentive_leads(){
		chk_access('incentives', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$admin_id = DeCrypt($_GET['admin']);
		$month = $_GET['month'];
		$year = $_GET['year'];
		
        $result = $this->admin_model->get_cbh_incentive_leads($per_page, $page, $admin_id, $month, $year);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'incentives/cbh/view/leads?'.$_SERVER['QUERY_STRING'];
		
		$admin = $result['admin'];
		$data["month"] = $month;
		$data["year"] = $year;
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		$data['subPageTitle'] = " <i>({$admin['admin_name']} [{$admin['admin_username']}]) &nbsp;&nbsp;&nbsp; |  &nbsp;&nbsp;&nbsp;".$this->months_arr_gl[$month]." - $year </i>";
		$data['pageTitle'] = 'FE Lead Details for';
		$data['fromPage'] = 'cbh_incentives';
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/fe-incentive-list',$data,true);
			
			if(!empty($_GET['inner'])){
				$data['pageTitleNew'] = $data['pageTitle'].' '.$data['subPageTitle'];
				$data['result'] = $this->load->view('ajax_modal_list_layout', $data, true);
			}
			echo json_encode($data);die;
		}
		
		$data['content'] = 'incentive/fe-incentives';
		$this->load->view('layout',$data);
	}
	
	public function get_incentive_leads(){
		chk_access('incentives', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$admin_id = DeCrypt($_GET['admin']);
		$month = $_GET['month'];
		$year = $_GET['year'];
		
        $result = $this->admin_model->get_incentives_leads($per_page, $page, $admin_id, $month, $year);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'incentives/view/leads?'.$_SERVER['QUERY_STRING'];
		
		$admin = $result['admin'];
		$data["month"] = $month;
		$data["year"] = $year;
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		$data['subPageTitle'] = " <i>({$admin['admin_name']} [{$admin['admin_username']}]) &nbsp;&nbsp;&nbsp; |  &nbsp;&nbsp;&nbsp;".$this->months_arr_gl[$month]." - $year </i>";
		$data['pageTitle'] = 'AFE Lead Details for';
		$data['fromPage'] = 'incentives';
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-commission-list',$data,true);
			
			if(!empty($_GET['inner'])){
				$data['pageTitleNew'] = $data['pageTitle'].' '.$data['subPageTitle'];
				$data['result'] = $this->load->view('ajax_modal_list_layout', $data, true);
			}
			echo json_encode($data);die;
		}
		
		$data['content'] = 'commission/afe_commissions';
		$this->load->view('layout',$data);
	}
}
