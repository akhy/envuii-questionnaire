<?php 

class MY_AdminController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Placeholder
	}

	protected function view($template)
	{
		return parent::view('admin/'.$template)
			->layout('admin')
			->prepend('Admin Area')
			;
	}
}