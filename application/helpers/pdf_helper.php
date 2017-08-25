<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('create_pdf'))
{
	function create_pdf($pdfFilePath=NULL,$html=NULL,$save=NULL)
	{		
		$CI = & get_instance();
		
		$CI->load->library('pdf');		 			
		$pdf = $CI->pdf->load();
		$pdf->SetFooter(' '); 
		$pdf->WriteHTML($html);
		if(trim($save) != '')
		{
			$pdf->Output($pdfFilePath, 'F');
		}
		else
		{
			$pdf->Output($pdfFilePath, 'I');
			exit();
		}		
	}
}
