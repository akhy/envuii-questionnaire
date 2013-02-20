<?php 

class MY_Router extends CI_Router {
	function fetch_method()
	{
		$request = strtolower($_SERVER['REQUEST_METHOD']);

		if ($this->method == $this->fetch_class()) 
		{
			$method = $request.'_index';
		} 
		else 
		{
			$method = $request.'_'.$this->method;
		}

		return $method;
	}
}