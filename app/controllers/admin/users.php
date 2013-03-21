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
		$users = User::init()->order_by('verified', 'asc')->get();

		$this->view('users/index')
			->set('users', $users)
			->display()
			;
	}

	public function get_approve($id)
	{
		$user = User::init()->where('id', $id)->get();
		$user->verified = 1;
		$user->save();

		Alert::push('success', 'User approved.');
		redirect_back();
	}

	public function get_delete($id)
	{
		$user = User::init()->where('id', $id)->get();

		$user->purge();

		Alert::push('success', 'The user has been deleted from system.');
		redirect_back();
	}
}