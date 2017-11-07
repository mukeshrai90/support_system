<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_short_url')) {
	
	function get_short_url($long_url) {	
		$key = BITLY_API_KEY;
		
		$api_url = 'https://api-ssl.bitly.com/v3/shorten?access_token='.$key.'&longUrl='.urlencode($long_url);		
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
		curl_setopt( $ch, CURLOPT_URL, $api_url);		
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt( $ch, CURLOPT_ENCODING, "");
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $ch, CURLOPT_AUTOREFERER, true);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT,200);
		curl_setopt( $ch, CURLOPT_TIMEOUT,200);
		curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
		
		$short_url = $long_url;
		if($result = curl_exec($ch)) {			
			$result = json_decode($result);		
			$short_url = $result->data->url;						
		}		
		curl_close($ch);	
		return $short_url;
	}
	
}

if(!function_exists('get_loggedINCondtn')) {
	
	function get_loggedINCondtn($type='commission', $loggedIn_data=array()) {		
		$CI = & get_instance();
		
		$current_role_id = $loggedIn_data['current_role_id'];
		$admin_id = $loggedIn_data['admin_id'];
		
		$and_whre = array();
		if($type == 'commission'){
			if($current_role_id == 2){
				$cbh_circle_id = $loggedIn_data['roles'][$current_role_id]['admin_role_circle_id'];
				$and_whre = array("bs_afe_users.afe_circle_id" => $cbh_circle_id);
			} else if($current_role_id == 3){
				$fe_ssa_id = $loggedIn_data['roles'][$current_role_id]['admin_role_ssa_id'];
				$and_whre = array("bs_afe_users.afe_ssa_id" => $fe_ssa_id);
			}
		} else if($type == 'incentive'){
			if($current_role_id == 3){
				$and_whre = array('bs_admins.admin_id' => $admin_id);
			} else if($current_role_id == 2){
				$admin_role_circle_id = $loggedIn_data['roles'][$current_role_id]['admin_role_circle_id'];
				$and_whre = array('bs_admin_roles.admin_role_circle_id' => $admin_role_circle_id);
			}	
		}
		
		return $and_whre;
	}
}
		
if(!function_exists('get_record')) {
	
	function get_record($table, $prim_key, $id, $select=NULL) {		
		$CI = & get_instance();
		
		if($select){
			$this->db->select($select);
		}
		$info = $CI->db->get_where($table, array($prim_key => $id))->row_array(); 
		return $info;
	}
}

if(!function_exists('get_all_allowed_actions')) {
	
	function get_all_allowed_actions($role_id, $all=false) {		
		$CI = & get_instance();
		
		$CI->db->select('action, access');
		$CI->db->group_by('action');
		$actions = $CI->db->get_where('bs_admin_access', array('role_id' => $role_id, 'status' => 0))->result_array(); 
		
		return $actions;
	}
}

if(!function_exists('is_cmsn_inctv_updatable')) {
	
	function is_cmsn_inctv_updatable($arr, $type=NULL){
		$start_date = $arr['start_date'];
		$start_date_y = date('Y', strtotime($start_date));
		$start_date_m = date('m', strtotime($start_date));
		
		$current_date_y = date('Y');
		$current_date_m = date('m');
		
		if(($start_date_m >= $current_date_m && ($start_date_y >= $current_date_y))){
			return true;
		}
		return false;
	}
}

