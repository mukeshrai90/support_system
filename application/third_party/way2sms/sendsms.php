<?php 

require_once(APPPATH.'third_party/way2sms/way2sms-api.php');

function sendsms($phone=NULL,$msg=NULL)
{
	$uid = '9023155109'; $pwd = 'ashok2002';
	$res =  sendWay2SMS($uid, $pwd, $phone, $msg);
	return $res;
}
?>