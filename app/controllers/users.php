<?php 

class Users extends MY_Controller {

	protected function view($template)
	{
		return parent::view($template);
	}

	public function get_register()
	{
		$this->session->sess_destroy();
		
		$this->view('users/register')
			->prepend('Register with Unisys')
			->display();
	}

	public function get_register_manual()
	{
		$this->session->sess_destroy();
		
		$this->view('users/register_manual')
			->prepend('Manual Registration')
			->set('intended_username', $this->session->flashdata('intended_username'))
			->display();
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
			
		Alert::push('info', 'Anda telah logout dari sistem.');
		redirect('users/login');
	}

	public function post_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = User::auth($username, $password);

		if($user === false)
		{
			Alert::push('error', 'Login tidak berhasil.');

			redirect('users/login');	
		}
			
		redirect('bio');
	}

	public function post_register()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = User::auth_unisys($username, $password);

		if($user === false)
		{
			Alert::push('error', 
				'Username/Password Unisys yang anda masukkan tidak valid
				 atau website Unisys sedang mengalami gangguan/down.
				 Jika anda masih tidak dapat login,
				 silakan gunakan form registrasi manual di bawah.');

			$this->session->set_flashdata('intended_username', $username);

			redirect('users/register_manual');	
		}

		User::upsert($user);
		Alert::push('success',
			'Akun Unisys anda berhasil divalidasi, silakan login 
			 dengan username dan password Unisys anda.'
			);

		redirect('users/login');
	}

	public function post_register_manual()
	{
		extract($this->input->post());

		if($username == '' OR $name == '')
		{
			Alert::push('error', 'NIM dan nama tidak boleh kosong');
			redirect_back();
		}
		if($confirm != $password)
		{
			Alert::push('error', 'Anda harus mengkonfirmasi password');
			redirect_back();
		}
		if($agree !== 'agree')
		{
			Alert::push('error', 'Anda harus menyetujui persyaratan registrasi');
			redirect_back();
		}

		User::upsert(array(
			'username' => $username,
			'name' => $name,
			'password' => base64_encode($password),
			'verified' => 0,
			'created_at' => date('Y-m-d H:i:s'),
			));

		User::login($username);
		Alert::push('success', 'Registrasi berhasil.');

		redirect('bio/edit');
	}

	public function post_test()
	{
		echo 'haha';
	}
}