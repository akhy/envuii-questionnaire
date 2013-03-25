<?php 

class MY_AlumniController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		if(User::current() === null)
		{
			Alert::push('warning', 'Anda harus login terlebih dahulu');
				
			redirect('users/login');
		}
	}
}