<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('send_sms'))
{
	function send_sms($mobile=NULL,$body=array())
	{		
		$CI = & get_instance();
		$CI->load->database();
				
		$message = @$body['message'];
		$purpose = @$body['purpose'];	
		$mobile = '9023155109';
		
		if(SMS_ENV == 'way2sms' && 0){
			require_once(APPPATH.'third_party/way2sms/sendsms.php');
			$sendr_id = 'Test';
			$rslt = sendsms($mobile,$message);
			$result = $rslt;
			if(is_array($rslt)){
				$result = json_encode($rslt);
			}
		} else {
		
			$result = $CI->db->get_where('ts_api_details',array('status' => 1))->result_array();
			$username = $result[0]['username'];
			$password = $result[0]['password'];
			$password = base64_decode($password);
			$sendr_id = $result[0]['senderId'];
			$api_url = $result[0]['api_url'];
					
			$message_encoded = urlencode($message);		
			$mobile = '91'.trim($mobile);
			
			$data = "username=$username&password=$password&sender=$sendr_id&sendto=$mobile&message=$message_encoded";
				 
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
			curl_setopt( $ch, CURLOPT_URL, $api_url);
			curl_setopt( $ch, CURLOPT_POST,1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt( $ch, CURLOPT_ENCODING, "");
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt( $ch, CURLOPT_AUTOREFERER, true);
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT,200);
			curl_setopt( $ch, CURLOPT_TIMEOUT,200);
			curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
			if(!$result = curl_exec($ch)) {
				$result = curl_error($ch);
			}
			curl_close($ch);
		}

		$status = 0;
		if(is_array($rslt) || strpos($result,'LogID') !== false){
			$status = 1;
		}

		$log = array('response' => $result, 'sender' => $sendr_id, 'sendto' => $mobile, 'message' => $message, 'status' => $status, 'purpose' => $purpose);		
		$inserted = $CI->db->insert('ts_sms_log', $log);
		
		return $status;
	}
}
