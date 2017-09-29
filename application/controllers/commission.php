<?php 
error_reporting(0);
class Commission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');	
	}
	
	public function afe_commissions()
	{
		chk_access('commissions', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$month = date('m');
		if(!empty($_GET['month'])) {	
			$month = $_GET['month'];
		}
		
        $result = $this->admin_model->get_afe_commissions($per_page, $page, $month);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		if(!empty($_GET['name'])){
			$base_url = BASE_URL.'commissions/afe/list?'.$_SERVER['QUERY_STRING'];
		} else {
			$base_url = BASE_URL.'commissions/afe/list?page=true';
		}
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
        $data["month"] = $month;
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-commission-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'Commissions';
		$data['content'] = 'commission/afe_commissions';
		$this->load->view('layout',$data);
	}
	
	public function get_afe_leads(){
		chk_access('commissions', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$afe_id = DeCrypt($_GET['afe']);
		$month = $_GET['month'];
		
        $result = $this->admin_model->get_afe_leads($afe_id, $month);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'commissions/afe/view/leads?'.$_SERVER['QUERY_STRING'];
		
		$data["month"] = $month;
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-leads-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data['pageTitle'] = 'AFE Leads';
		$data['content'] = 'commission/afe_leads';
		$this->load->view('layout',$data);
	}
}
