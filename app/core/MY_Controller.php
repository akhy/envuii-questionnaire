<?php 

class MY_Controller extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->spark('Twiggy/0.8.5');
	}

	protected function view($template)
	{
		return $this->twiggy
			->layout('public')
			->template($template)
			->append('Environmental Engineering')
			->set('current', User::current())
			;
	}
}