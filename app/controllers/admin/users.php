<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Users extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Manajemen User')
			;
	} 

	public function get_index()
	{
		$users = User::init()->get();

		$this->view('users/index')
			->set('users', $users)
			->display()
			;
	}
}