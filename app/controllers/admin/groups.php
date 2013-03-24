<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Groups extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Question Group')
			;
	} 

	public function get_index()
	{
		$groups = Group::init()->get();

		$this->view('groups/index')
			->set('groups', $groups)
			->display()
			;
	}


	public function get_delete($id)
	{
		$group = Group::init()->where('id', $id)->delete();

		Alert::push('success', 'The group has been deleted from system.');
		redirect_back();
	}
}