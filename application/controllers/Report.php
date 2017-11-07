<?php 
error_reporting(0);
class Report extends CI_Controller {
	
	var $lead_sources = array(1 => 'Self/Direct Sales', 2 => 'Sales Partner');
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');	
	}
	
	public function get_leads_reports()
	{
		$loggedIn_data = chk_access('reports', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		if(!empty($_GET['month'])) {	
			$month = $_GET['month'];
		}
		
		if(!empty($_GET['year'])) {	
			$year = $_GET['year'];
		}
		
		$data["logged_in_role_id"] = $loggedIn_data['current_role_id'];
		
		if($data["logged_in_role_id"] == 2){
			$circle_id = $loggedIn_data['roles'][$data["logged_in_role_id"]]['admin_role_circle_id'];
			$_GET['circle'] = $circle_id;
		} else if($data["logged_in_role_id"] == 3){
			$ssa_id = $loggedIn_data['roles'][$data["logged_in_role_id"]]['admin_role_ssa_id'];
			$_GET['ssa'] = $ssa_id;
		}
		
		if(!empty($_GET['report_type']) && $_GET['report_type'] == 'o_l'){
			$result = $this->admin_model->get_leads($per_page, $page);
			$element_name = 'elements/leads-report-list';
		} else if(!empty($_GET['report_type']) && $_GET['report_type'] == 'l_c'){
			$result = $this->admin_model->get_leads_cnt($per_page, $page);
			$element_name = 'elements/leads-report-cnt-list';
		}
		
		$data['count'] = @$result['count'];
		$data['records'] = @$result['results'];
		
        $data["month"] = $month;
        $data["year"] = $year;
		
		$months_arr_gl = json_decode(MONTHS_ARR_GL, TRUE);
		$data['subPageTitle'] = ' | '.$months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $months_arr_gl;
		
		$data['pageTitle'] = 'Leads Report';
		$data['element_name'] = $element_name;
		$data['lead_sources'] = $this->lead_sources;
		
		if(!empty($_GET['print']) && $_GET['print'] == 'YES'){
			$data['called_for_print'] = true;
			$data['content'] = $element_name;
			
			$print_html = $this->load->view('print_layout', $data, true);
			echo ($print_html);die;
		}
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view($element_name ,$data, true);
			echo json_encode($data);die;
		}
		
		$and_whre = get_loggedINCondtn('commission', $loggedIn_data);
		$data["afe_users"] = $this->admin_model->get_all_afes($and_whre);
		
		$data['circles'] = $this->admin_model->get_Circles();
		if($data["logged_in_role_id"] == 2){
			$circle_id = $loggedIn_data['roles'][$data["logged_in_role_id"]]['admin_role_circle_id'];
			$data['ssa'] = $this->admin_model->get_SSA($circle_id);
		}
		
		$data['content'] = 'report/leads_reports';
		$this->load->view('layout',$data);
	}
}
