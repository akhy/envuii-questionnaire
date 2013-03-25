<?php 

class Alert {

	public static $alerts = array(); 

	public static function push($type, $content)
	{
		Alert::$alerts[$type] = $content;
	}

	public static function all()
	{
		return get_instance()->session->flashdata('alerts');
	}

	public static function save()
	{
		$CI =& get_instance();
		$CI->session->set_flashdata('alerts', Alert::$alerts);
	}
}