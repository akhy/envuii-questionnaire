<?php 

class Auth extends MY_Controller {

	public function get_login()
	{
		$this->session->unset_userdata('is_admin');

		$this->view('admin/auth/login')
			->display();
	}

	public function post_login()
	{
		$post = $this->input->post();

		if(strtolower($post['username']) == 'admin' 
			AND md5($post['password']) == Config::get('passhash'))
		{
			$this->session->set_userdata('is_admin', true);

			Alert::push('success', 'Anda telah login sebagai admin sistem.');
			redirect('admin/users');
		}
		else
		{
			Alert::push('error', 'Username/Password tidak valid.');
			redirect_back();
		}
	}

	public function get_logout()
	{
		$this->session->sess_destroy();

		Alert::push('info', 'Anda telah keluar dari sistem.');
		redirect('admin/auth/login');
	}
}