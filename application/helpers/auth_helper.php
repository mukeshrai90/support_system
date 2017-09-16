<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('chk_access'))
{
	function chk_access($action=NULL, $type=NULL, $role_check=false)
	{		
		$CI = & get_instance();		
		$CI->load->database();
		$CI->load->model('admin_model');	
		
		$admin_data = $CI->session->userdata('admin');
		$admin_id = $admin_data['admin_id'];
		$admin = $CI->admin_model->get_admin($admin_id, 'admin_id');
		
		if(!empty($admin)){
			if($role_check && 0){
				
				$role_id = $user['role_id'];
				$user_id = $user['id'];
				
				if($role_id == 1 && $user_id > 1 && $user['have_admin_access'] <= 0){
					$access = $CI->db->get_where('ts_subadmin_access',array('admin_id' => $user_id,'action' => $action,'type' => $type,'access' => 1))->row_array(); 	
					if(empty($access)) {
						if($CI->input->is_ajax_request()) {
							echo 'access-error';die;
						}
						
						$CI->session->set_flashdata('error','Sorry! You don\'t have permission.');
						redirect('dashboard');			
					}
				} else {
					$records = $CI->db->get_where('ts_admin_access',array('role_id' => $role_id,'action' => $action))->row_array(); 	
					
					if(!empty($records)) {
						$access = $records['access'];
						$access = explode(',',$access);
												
						if(in_array($type, $access)){
							
						} else {
							if($CI->input->is_ajax_request()){
								echo 'access-error';die;
							}
							$CI->session->set_flashdata('error','Sorry! You don\'t have permission.');
							redirect('dashboard');	
						}
					} else {
						if($CI->input->is_ajax_request()){
							echo 'access-error';die;
						}
						$CI->session->set_flashdata('error','Sorry! You don\'t have permission.');
						redirect('dashboard');	
					}
				}
			}
		} else {
			if($CI->input->is_ajax_request()){
				echo 'login-error';die;
			}
			
			$CI->session->set_flashdata('error','Your session has been expired.<br/> Please login again to continue.');
			$current_url = current_url();
			$current_url = $_SERVER['QUERY_STRING'] ? $current_url.'?'.$_SERVER['QUERY_STRING'] : $current_url;
			redirect('login?return_url='.urlencode($current_url));	
		}
	}
}

