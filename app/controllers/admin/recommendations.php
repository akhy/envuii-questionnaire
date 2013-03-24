<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Recommendations extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Rekomendasi')
			->set('active', 'recommendations')
			;
	} 

	public function get_index()
	{
		$recommendations = Recommendation::init()->get();

		$this->breadcrumbs[] = 'Rekomendasi';
		
		$this->view('recommendations/index')
			->set('recommendations', $recommendations)
			->display()
			;
	}

}