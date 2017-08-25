<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_short_url'))
{
	
	function get_short_url($long_url)
	{		
		/*$key = GOOGLE_API_KEY;
		
		require_once(APPPATH.'third_party/url_shortener.php');
		$googer = new GoogleURLAPI($key);
		
		$shortDWName = $googer->shorten($long_url);
		return $shortDWName;*/
		
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

if(!function_exists('get_record'))
{
	
	function get_record($table,$id)
	{		
		$CI = & get_instance();
		 			
		$info = $CI->db->get_where($table,array('id' => $id))->row_array(); 
		return $info;
	}
}

if(!function_exists('get_all_allowed_actions'))
{
	
	function get_all_allowed_actions($role_id, $all=false, $admin_id=0, $have_admin_access=0)
	{		
		$CI = & get_instance();
		
		if($role_id == 1 && $admin_id > 1 && $have_admin_access <= 0){
			$CI->db->select('action, GROUP_CONCAT(type) as access');
			$CI->db->group_by('action');
			$info = $CI->db->get_where('ts_subadmin_access',array('admin_id' => $admin_id))->result_array(); 
		} else {		 						
			$CI->db->select('action,access');
			$CI->db->group_by('action');
			$info = $CI->db->get_where('ts_admin_access',array('role_id' => $role_id))->result_array(); 
		}
		
		return $info;
	}
}
