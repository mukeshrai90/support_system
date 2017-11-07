<?php 
error_reporting(0);
class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->database();	
		$this->load->model('admin_model');		
		
		ini_set('memory_limit', '-1');
		set_time_limit(0);
		//ini_set('max_execution_time', 600);
	}
	
	public function generate_afe_commissions(){
		
		$last_month = date('m', strtotime('-27 days'));
		$last_month_year = date('Y', strtotime('-27 days'));
		
		$CronLog = array();
		$CronLog['cron_name'] = 'generate_afe_commissions';
		$CronLog['cron_start_time'] = date('Y-m-d H:i:s');
		
		$response = '';
		
		$result = $this->admin_model->get_afe_commissions_monthly('', '', $last_month, $last_month_year, '', true);
		$records = $result['results'];
		
		$InsertData = array(); $afe_ids = array();
		if(!empty($records)) {
			foreach($records as $rcd){
				$tmp = array();
				
				$total_plans_amt = $rcd['total_plans_amt'];
				if($total_plans_amt > 0){
					//$total_plans_amt = number_format($total_plans_amt, 2);
					
					$commission_rate = $rcd['commission_rate'];
					$commission_amount = $total_plans_amt*($commission_rate/100);
					
					$afe_ids[] = $rcd['afe_id'];
					
					$tmp['applied_commission_id'] = $rcd['applied_commission_id'];
					$tmp['commission_afe_id'] = $rcd['afe_id'];
					$tmp['commission_month'] = $last_month;
					$tmp['commission_year'] = $last_month_year;
					$tmp['commission_amount'] = $commission_amount;
					$tmp['total_plans_amt'] = $total_plans_amt;
					$tmp['commission_status_id'] = 1;
					$tmp['commission_generated_on'] = date('Y-m-d H:i:s');
					$tmp['commission_total_leads'] = $this->admin_model->get_afe_leads_count($rcd['afe_id'], $last_month, $last_month_year);
					
					$InsertData[] = $tmp;
				}
			}
			
			if(count($InsertData) > 0){
				
				$UpdateData = array();
				$UpdateData['commission_status_id'] = 0;
				
				$this->db->where_in('commission_afe_id', $afe_ids);
				$this->db->where('commission_month', $last_month);
				$this->db->where('commission_year', $last_month_year);
				if($this->db->update('bs_afe_commissions', $UpdateData)){
					if($this->db->insert_batch('bs_afe_commissions', $InsertData)){
						$response = 'Commission Generated Successfully';
					} else {
						$response = 'Error in Insert';
					}
				} else {
					$response = 'Unable to Process Right Now.';
				}
			} else {
				$response = 'No Records to Insert';
			}
		} else {
			$response = 'No AFE Records Found';
		}
		
		$CronLog['cron_response'] = $response;
		$CronLog['cron_end_time'] = date('Y-m-d H:i:s');
		
		$this->db->insert('bs_cron_logs', $CronLog);
		echo $response;
	}
	
	public function generate_fe_incentive(){
		
		$last_month = date('m', strtotime('-27 days'));
		$last_month_year = date('Y', strtotime('-27 days'));
		
		$CronLog = array();
		$CronLog['cron_name'] = 'generate_fe_incentive';
		$CronLog['cron_start_time'] = date('Y-m-d H:i:s');
		
		$cr_rt = $this->admin_model->get_current_incentive_rate(3, $last_month, $last_month_year);
		
		$response = '';
		if(!empty($cr_rt)) {
			$result = $this->admin_model->get_fe_incentives_list_monthly('', '', $last_month, $last_month_year, 3, true);
			$records = $result['results'];
			
			$InsertData = array(); $afe_ids = array();
			if(!empty($records)) {
				foreach($records as $rcd){
					$tmp = array();
				
					if($total_plans_amt > 0){
						
						$admin_ids[] = $rcd['admin_id'];
						
						$tmp['incentive_role_id'] = 3;
						$tmp['applied_incentive_id'] = $cr_rt['id'];
						$tmp['incentive_admin_id'] = $rcd['admin_id'];
						$tmp['incentive_month'] = $last_month;
						$tmp['incentive_year'] = $last_month_year;
						$tmp['incentive_amount'] = $rcd['incentive_amount'];
						$tmp['total_plans_amt'] = $rcd['total_plans_amt'];
						$tmp['incentive_status_id'] = 1;
						$tmp['incentive_generated_on'] = date('Y-m-d :i:s');
						$tmp['incentive_total_leads'] = $rcd['incentive_total_leads'];
						
						$InsertData[] = $tmp;
					}
				}
				
				if(count($InsertData) > 0){
					
					$UpdateData = array();
					$UpdateData['incentive_status_id'] = 0;
					
					$this->db->where('incentive_role_id', 3);
					$this->db->where_in('incentive_admin_id', $admin_ids);
					$this->db->where('incentive_month', $last_month);
					$this->db->where('incentive_year', $last_month_year);
					if($this->db->update('bs_incentives', $UpdateData)){
						if($this->db->insert_batch('bs_incentives', $InsertData)){
							$response = 'Incentives Generated Successfully';
						} else {
							$response = 'Error in Insert';
						}
					} else {
						$response = 'Unable to Process Right Now.';
					}
				} else {
					$response = 'No Records to Insert';
				}
			} else {
				$response = 'No Admin Records Found';
			}
		} else {
			$response = 'No Suitable Incentive Rate Found';
		}
		
		$CronLog['cron_response'] = $response;
		$CronLog['cron_end_time'] = date('Y-m-d H:i:s');
		
		$this->db->insert('bs_cron_logs', $CronLog);
		echo $response;
	}
	
	public function generate_cbh_incentive(){
		
		$last_month = date('m', strtotime('-27 days'));
		$last_month_year = date('Y', strtotime('-27 days'));
		
		$CronLog = array();
		$CronLog['cron_name'] = 'generate_cbh_incentive';
		$CronLog['cron_start_time'] = date('Y-m-d H:i:s');
		
		$cr_rt = $this->admin_model->get_current_incentive_rate(2, $last_month, $last_month_year);
		
		$response = '';
		if(!empty($cr_rt)) {
			$result = $this->admin_model->get_cbh_incentives_list_monthly('', '', $last_month, $last_month_year, 2, true);
			$records = $result['results'];
			
			$InsertData = array(); $afe_ids = array();
			if(!empty($records)) {
				foreach($records as $rcd){
					$tmp = array();
					
					if($total_plans_amt > 0){
						
						$admin_ids[] = $rcd['admin_id'];
						
						$tmp['incentive_role_id'] = 2;
						$tmp['applied_incentive_id'] = $cr_rt['id'];
						$tmp['incentive_admin_id'] = $rcd['admin_id'];
						$tmp['incentive_month'] = $last_month;
						$tmp['incentive_year'] = $last_month_year;
						$tmp['incentive_amount'] = $rcd['incentive_amount'];
						$tmp['total_plans_amt'] = $rcd['total_plans_amt'];
						$tmp['incentive_status_id'] = 1;
						$tmp['incentive_generated_on'] = date('Y-m-d H:i:s');
						$tmp['incentive_total_leads'] = $rcd['incentive_total_leads'];
						
						$InsertData[] = $tmp;
					}
				}
				
				if(count($InsertData) > 0){
					
					$UpdateData = array();
					$UpdateData['incentive_status_id'] = 0;
					
					$this->db->where('incentive_role_id', 2);
					$this->db->where_in('incentive_admin_id', $admin_ids);
					$this->db->where('incentive_month', $last_month);
					$this->db->where('incentive_year', $last_month_year);
					if($this->db->update('bs_incentives', $UpdateData)){
						if($this->db->insert_batch('bs_incentives', $InsertData)){
							$response = 'Incentives Generated Successfully';
						} else {
							$response = 'Error in Insert';
						}
					} else {
						$response = 'Unable to Process Right Now.';
					}
				} else {
					$response = 'No Records to Insert';
				}
			} else {
				$response = 'No Admin Records Found';
			}
		} else {
			$response = 'No Suitable Incentive Rate Found';
		}
		
		$CronLog['cron_response'] = $response;
		$CronLog['cron_end_time'] = date('Y-m-d H:i:s');
		
		$this->db->insert('bs_cron_logs', $CronLog);
		echo $response;
	}
	
	public function generate_bsnl_monthly_commission(){
		$last_month = date('m', strtotime('-27 days'));
		$last_month_year = date('Y', strtotime('-27 days'));
		
		$CronLog = array();
		$CronLog['cron_name'] = 'generate_bsnl_commissions';
		$CronLog['cron_start_time'] = date('Y-m-d H:i:s');
		
		$response = '';
		
		$cr_rt = $this->admin_model->get_current_bsnl_commission_rate($last_month, $last_month_year);
		$commission_rate = $cr_rt['rate'];
		
		$all_circles = $this->admin_model->get_Circles();
		
		$tmpData = array();
		$tmpData['comm_month'] = $last_month;
		$tmpData['comm_year'] = $last_month_year;
		$tmpData['comm_status_id'] = 1;
		$tmpData['comm_generated_on'] = date('Y-m-d H:i:s');
		
		$InsertData = array();
		foreach($all_circles as $rcd){
			
			$circle_id = $rcd['circle_id'];
			$all_ssa = $this->admin_model->get_SSA($circle_id);
			
			$total_circle_rentals = 0;
			foreach($all_ssa as $rcd){
				
				$ssa_id = $rcd['ssa_id'];
				
				$results = $this->admin_model->get_all_commision_leads($last_month, $last_month_year, $circle_id, $ssa_id);	
			   
				$total_ssa_rentals = 0;
				if(!empty($results)){
					foreach($results as $rcd){
						$lead_installation_date = $rcd['installation_date'];
						$lead_plan_id = $rcd['plan_id'];
						$lead_plan_rental = $rcd['plan_rental'];
						$lead_id = $rcd['user_id'];
						
						$lead_installation_date = date('d', strtotime($lead_installation_date));
						$lead_installation_month = date('m', strtotime($lead_installation_date));
						$lead_installation_year = date('Y', strtotime($lead_installation_date));
						
						if($lead_installation_month == $last_month && $lead_installation_year == $last_month_year){
							$remain_days = 30 - $lead_installation_date;
							if($remain_days > 0){
								$applicable_retal = ($lead_plan_rental/30)*$remain_days;
								$total_ssa_rentals = $total_ssa_rentals + $applicable_retal;
							}
						} else {
							$total_ssa_rentals = $total_ssa_rentals + $lead_plan_rental;
						}
					}
				}
				
				$total_circle_rentals = $total_circle_rentals + $total_ssa_rentals;
				
				$comm_amount = $total_ssa_rentals*($commission_rate/100);

				$tmpData['comm_circle_id'] = $circle_id;
				$tmpData['comm_ssa_id'] = $ssa_id;
				$tmpData['comm_type'] = 2;
				$tmpData['comm_total_amount'] = $total_ssa_rentals;
				$tmpData['comm_applied_commision_id'] = $cr_rt['id'];
				$tmpData['comm_amount'] = $comm_amount;
				
				$InsertData[] = $tmpData;
			}
			
			$comm_amount = $total_circle_rentals*($commission_rate/100);
				
			$tmpData['comm_circle_id'] = $circle_id;
			$tmpData['comm_ssa_id'] = $ssa_id;
			$tmpData['comm_type'] = 1;
			$tmpData['comm_total_amount'] = $total_circle_rentals;
			$tmpData['comm_applied_commision_id'] = $cr_rt['id'];
			$tmpData['comm_amount'] = $comm_amount;
			
			$InsertData[] = $tmpData;
		}
		
		if(count($InsertData) > 0){
				
			$UpdateData = array();
			$UpdateData['comm_status_id'] = 0;
			
			$this->db->where('comm_month', $last_month);
			$this->db->where('comm_year', $last_month_year);
			if($this->db->update('bs_bsnl_commissions', $UpdateData)){
				if($this->db->insert_batch('bs_bsnl_commissions', $InsertData)){
					$response = 'Commission Generated Successfully';
				} else {
					$response = 'Error in Insert';
				}
			} else {
				$response = 'Unable to Process Right Now.';
			}
		} else {
			$response = 'No Records to Insert';
		}
		
		$CronLog['cron_response'] = $response;
		$CronLog['cron_end_time'] = date('Y-m-d H:i:s');
		
		$this->db->insert('bs_cron_logs', $CronLog);
		echo $response;
	}
}
