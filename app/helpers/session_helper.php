<?php 

if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		Alert::save();

		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = site_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}

if ( ! function_exists('redirect_back'))
{
	function redirect_back($method = 'location', $http_response_code = 302)
	{
		redirect($_SERVER['HTTP_REFERER'], $method, $http_response_code);
	}
}