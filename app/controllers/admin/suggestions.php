<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Suggestions extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Kritik dan Saran')
			->set('active', 'suggestions')
			;
	} 

	public function get_index()
	{
		$suggestions = Suggestion::init()->get();

		$this->breadcrumbs[] = 'Kritik dan Saran';
		
		$this->view('suggestions/index')
			->set('suggestions', $suggestions)
			->display()
			;
	}

}