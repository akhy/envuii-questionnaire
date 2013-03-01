<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Suggestions extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Kritik dan Saran')
			;
	} 

	public function get_index()
	{
		$suggestions = Suggestion::init()->get();

		$this->view('suggestions/index')
			->set('suggestions', $suggestions)
			->display()
			;
	}

}