<?php 

class MY_AdminController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(! $this->session->userdata('is_admin'))
		{
			Alert::push('error', 'Silakan login ke dalam sistem untuk mengakses halaman admin.');
			redirect('admin/auth');
		}

		$this->load->helper('text');
	}

	protected function view($template)
	{
		return parent::view('admin/'.$template)
			->layout('admin')
			->prepend('Admin Area')
			;
	}
}