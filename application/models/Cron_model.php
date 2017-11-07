<?php

class Cron_model extends CI_Model
{
	var $leadStatsIdToCons = 4;
	
	public function __construct()
	{
		$this->load->database();
	}
	
	
}	
