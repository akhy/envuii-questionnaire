<?php 

class Users extends CI_Controller {

	private function view($template)
	{
		return $this->twiggy
			->layout('public')
			->template($template)
			->set('alerts', alerts())
			// ->set('current', User::current())
			;
	}

	public function get_login()
	{
		$this->view('users/login')
			->display();
	}

	public function get_logout()
	{
		$this->session->sess_destroy();

		redirect('users/login');
	}

	public function post_login()
	{
		$username = $this->input->post('user_id');
		$password = $this->input->post('password');

		$user = User::auth($username, $password);

		if($user === false)
		{
			$this->session->set_flashdata('status-error', 'Login tidak berhasil.');
			redirect('users/login');	
		}
			
		redirect('questions');

	}

	public function post_test()
	{
		echo 'haha';
	}
}