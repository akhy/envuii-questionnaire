<?php 

require_once(APPPATH.'core/MY_AlumniController.php');

class Bio extends MY_AlumniController {

	protected function view($template)
	{
		return parent::view($template)
			->set('active', 'bio');
	}

	public function get_index()
	{
		if(User::current()->has_bio())
			redirect('bio/view');

		redirect('bio/edit');
	}

	public function get_edit()
	{
		$bio = User::current()->get_bio();

		$this->view('bio/form')
			->prepend('Edit data diri')
			->set('bio', $bio)
			->display()
			;
	}

	public function post_edit()
	{
		$post = $this->input->post();
		$user = User::current();

		$attempt = $user->save_bio($post);

		if($attempt === false)
		{
			Alert::push('error', 'Lengkapi semua data diri, dan kirim ulang.');
			$this->session->set_flashdata('old', $post);
			$this->session->set_flashdata('errors', $user->bio_validation['errors']);

			redirect('bio/edit');
		}

		Alert::push('success', 'Data berhasil disimpan!');

		redirect('bio/view');
	}

	public function get_view()
	{
		$bio = User::current()->get_bio(true);

		$this->view('bio/view')
			->prepend(User::current()->name)
			->set('bio', $bio)
			->display()
			;
	}
}