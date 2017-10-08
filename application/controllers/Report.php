<?php 
error_reporting(0);
class Report extends CI_Controller {

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
        $data["logged_in_role_id"] = $loggedIn_data['current_role_id'];
		
		$months_arr_gl = json_decode(MONTHS_ARR_GL, TRUE);
		$data['subPageTitle'] = ' | '.$months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $months_arr_gl;
		
		$data['pageTitle'] = 'Leads Report';
		$data['element_name'] = $element_name;
		
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
		
		$and_whre = get_loggedINCondtn($loggedIn_data);
		$data["afe_users"] = $this->admin_model->get_all_afes($and_whre);
		
		$data['circles'] = $this->admin_model->get_Circles();
		
		$data['content'] = 'report/leads_reports';
		$this->load->view('layout',$data);
	}
}
