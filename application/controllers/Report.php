<?php 
error_reporting(0);
class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');	
	}
	
	public function get_afe_reports()
	{
		$loggedIn_data = chk_access('reports', 1, true);
		
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
		
		$data["pageUrl"] = BASE_URL.'incentives/fe/list';
		if(!empty($_GET['m']) && $_GET['m'] == 'current'){
			$month = $current_month; $year = $current_year;
			$result = $this->admin_model->get_incentives_list_monthly($per_page, $page, $month, $year, 3, false, $and_whre);
			$data["pageUrl"] = $data["pageUrl"].'?m=current';
			
		} else {
			$current_month = $last_month;
			$result = $this->admin_model->get_incentives_list($per_page, $page, $month, $year, 3, $and_whre);
		}
		$data['records'] = @$result['results'];
		
        $data["current_month"] = $current_month;
        $data["current_year"] = $current_year;
        $data["last_month"] = $last_month;
        $data["last_month_year"] = $last_month_year;
        $data["month"] = $month;
        $data["year"] = $year;
        $data["logged_in_role_id"] = $loggedIn_data['current_role_id'];
		
		$months_arr_gl = json_decode(MONTHS_ARR_GL, TRUE);
		$data['subPageTitle'] = ' | '.$months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $months_arr_gl;
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-reports-list',$data,true);
			echo json_encode($data);die;
		}
		
		$and_whre = get_loggedINCondtn($loggedIn_data);
		$data["afe_users"] = $this->admin_model->get_all_afes($and_whre);
		
		$data['pageTitle'] = 'AFE Leads Report';
		$data['content'] = 'report/afe_reports';
		$this->load->view('layout',$data);
	}
}
