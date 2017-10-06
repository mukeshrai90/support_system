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
		$loggedIn_data = chk_access('afe_commissions', 1, true);
		
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
		
		$current_role_id = $loggedIn_data['current_role_id'];
		
		$and_whre = array();
		if($current_role_id == 2){
			$cbh_circle_id = $loggedIn_data['roles'][$current_role_id]['admin_role_circle_id'];
			$and_whre = array("bs_afe_users.afe_circle_id" => $cbh_circle_id);
		} else if($current_role_id == 3){
			$fe_ssa_id = $loggedIn_data['roles'][$current_role_id]['admin_role_ssa_id'];
			$and_whre = array("bs_afe_users.afe_ssa_id" => $fe_ssa_id);
		}
		
		$data["pageUrl"] = BASE_URL.'commissions/afe/list';
		if(!empty($_GET['m']) && $_GET['m'] == 'current'){
			$month = $current_month; $year = $current_year;
			$result = $this->admin_model->get_afe_commissions_monthly($per_page, $page, $month, $year, $and_whre);
			$data["pageUrl"] = $data["pageUrl"].'?m=current';
			
		} else {
			$current_month = $last_month;
			$result = $this->admin_model->get_afe_commissions($per_page, $page, $month, $year, $and_whre);
		}
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'commissions/afe/list?'.$_SERVER['QUERY_STRING'];
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
        $data["current_month"] = $current_month;
        $data["current_year"] = $current_year;
        $data["last_month"] = $last_month;
        $data["last_month_year"] = $last_month_year;
        $data["month"] = $month;
        $data["year"] = $year;
        $data["logged_in_role_id"] = $current_role_id;
		//prx($data);
		$months_arr_gl = json_decode(MONTHS_ARR_GL, TRUE);
		$data['subPageTitle'] = ' | '.$months_arr_gl[$month]." - $year";
		$data['months_arr_gl'] = $months_arr_gl;
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-commission-list',$data,true);
			echo json_encode($data);die;
		}
		
		$data["afe_users"] = $this->admin_model->get_all_afes();
		
		$data['pageTitle'] = 'Commissions';
		$data['content'] = 'commission/afe_commissions';
		$this->load->view('layout',$data);
	}
	
	public function get_afe_leads(){
		chk_access('afe_commissions', 1, true);
		
		$per_page = 20; 
        $page = @$_GET['per_page']? $_GET['per_page'] : 0;
		
		$afe_id = DeCrypt($_GET['afe']);
		$month = $_GET['month'];
		$year = $_GET['year'];
		
        $result = $this->admin_model->get_afe_leads($afe_id, $month, $year);		
		$data['records'] = @$result['results'];
		
		$total_rows = $result['count'];
		
		$base_url = BASE_URL.'commissions/afe/view/leads?'.$_SERVER['QUERY_STRING'];
		
		$data["month"] = $month;
		
        $data["links"] = create_links($per_page,$total_rows,$base_url);
		
		if($this->input->is_ajax_request()) {
			$data['result'] = $this->load->view('elements/afe-leads-list',$data,true);
			echo json_encode($data);die;
		}
		
		$afe = $this->admin_model->get_afe_details($afe_id);
		
		$data['subPageTitle'] = " ({$afe['afe_name']} [{$afe['afe_mobile']}])";
		$data['pageTitle'] = 'AFE Leads';
		$data['content'] = 'commission/afe_leads';
		$this->load->view('layout',$data);
	}
	
	public function get_commissions_allowed_sts(){
		$commission_id = $this->input->post('c');
		$commission_id = DeCrypt($commission_id);
		
		$record = $this->admin_model->get_record('bs_afe_commissions', 'commission_id', $commission_id, 'commission_id,commission_status_id');
		
		$response = array('status' => false);
		if(!empty($record)){
			$allwd_sts_arr = $this->admin_model->get_commissions_allowed_sts($record['commission_status_id']);
			if(!empty($allwd_sts_arr)){
				$html = '<select class="chnge_sts_slct" data-c="'.EnCrypt($record['commission_id']).'">
							<option value="">Select</option>';
				foreach($allwd_sts_arr as $rcd){
					$html .= '<option value="'.EnCrypt($rcd['status_id']).'">'.$rcd['status_name'].'</option>';
				}
				$html .= '</select>';
				
				$response['status'] = true;
				$response['html'] = $html;
			}
		}
		
		echo json_encode($response); die;
	}
	
	public function changet_commissions_sts(){
		chk_access('afe_commissions', 4, true);
		
		$commission_id = $this->input->post('c');
		$sts_id = $this->input->post('s');
		$commission_id = DeCrypt($commission_id);
		$sts_id = DeCrypt($sts_id);
		
		$record = $this->admin_model->get_record('bs_afe_commissions', 'commission_id', $commission_id, 'commission_id,commission_status_id');
		
		if(!empty($record)){
			$UpdateData = array();
			$UpdateData['commission_status_id'] = $sts_id;
			
			$this->db->where('commission_id', $commission_id);
			if($this->db->update('bs_afe_commissions', $UpdateData)){
				$response['status'] = true;
				$response['message'] = 'Status Changed Successfully.';
				
			} else {
				$response['status'] = true;
				$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.';
			}
		} else {
			$response['status'] = true;
			$response['message'] = 'Unable to process your request right now. <br/> Please try again or some time later.';
		}
		
		echo json_encode($response); die;
	}
}
