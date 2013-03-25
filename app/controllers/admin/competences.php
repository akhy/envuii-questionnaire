<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Competences extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Kompetensi Alumni')
			->set('active', 'competences')
			;
	} 

	public function get_index()
	{
		$this->breadcrumbs[] = anchor('admin/competences', 'Kompetensi Alumni');

		$competences = Competence::avg();

		$this->view('competences/index')
			->set('competences', $competences)
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