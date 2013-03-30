<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Reports extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Report')
			->set('active', 'reports')
			;
	} 

	public function get_index()
	{
		$this->view('reports/index')
			->set('reports', Report::init()->get())
			->set('groups', Group::init()->get())
			->set('users', User::init()->get())
			->display();
	}

}