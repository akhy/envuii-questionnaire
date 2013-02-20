<?php 

function alerts()
{
	$CI =& get_instance();

	return array(
		'error'   => $CI->session->flashdata('status-error'),
		'success' => $CI->session->flashdata('status-success'),
		'warning' => $CI->session->flashdata('status-warning'),
		);
}