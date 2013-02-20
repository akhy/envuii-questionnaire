<?php 

class Users extends MY_Controller {

	protected function view($template)
	{
		return parent::view($template);
	}

	public function get_login()
	{
		$this->session->sess_destroy();
		
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