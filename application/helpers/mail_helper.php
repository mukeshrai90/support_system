<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('send_mail'))
{
	function send_mail($to_email=NULL,$body=array(),$attachment=NULL)
	{		
		$CI = & get_instance();
		$CI->load->database();
		
		$to_email = 'mukeshrai90@gmail.com';
		
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		
		$config['smtp_host'] = 'mail.parinyastechnologies.com';		
		$config['smtp_user'] = 'info@parinyastechnologies.com';		
		$config['smtp_pass'] = 'info@123';
		
		$config['smtp_host'] = 'mail.sanix.in';		
		$config['smtp_user'] = 'development@sanix.in';		
		$config['smtp_pass'] = 'development';		
		
		$config['smtp_port'] = '25';		
		$config['smtp_keepalive'] = TRUE;		
		$config['validate'] = false;		
		$config['charset'] = 'iso-8859-1';		
		$config['wordwrap'] = TRUE;	
		$config['charset'] = 'utf-8';
		$config['newline'] = '\r\n';
		$CI->load->library('email',$config);       		
		
		$noreply = $CI->db->get_where('ts_site_infos',array('id' => 1))->row_array(); 		
		
		$CI->email->from(@$noreply['noreply_email'],@$noreply['noreply_name']);
		$CI->email->to(trim($to_email));
		$CI->email->subject(@$body['subject']);
		$CI->email->message(@$body['message']);		
		if(trim($attachment) != '') {
			$CI->email->attach($attachment);	
		}
								
		$status = 0;
		if($CI->email->send()){
			$status = 1;
		}
		
		//echo $CI->email->print_debugger(); die;
		
		$log = array('sender' => $noreply['noreply_email'], 'sendto' => $to_email, 'subject' => $body['subject'], 'message' => $body['message'], 'status' => $status, 'purpose' => $body['purpose']);
		$inserted = $CI->db->insert('ts_email_log', $log);	
		
		return $status;
	}
}
