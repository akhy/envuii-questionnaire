<?php 

require_once(APPPATH.'core/MY_AlumniController.php');

class Suggestions extends MY_AlumniController {

	public function __construct()
	{
		parent::__construct();

		if(! User::current()->has_competences())
		{
			Alert::push('warning', 'Anda harus mengisi form kompetensi terlebih dahulu');
			redirect('competences/form');
		}
	}

	protected function view($template)
	{
		return parent::view($template)
			->set('active', 'suggestions')
			->prepend('Kritik dan Saran')
			;
	}

	public function get_index()
	{
		if(! User::current()->has_suggestion())
			redirect('suggestions/form');

		$this->view('suggestions/view')
			->set('suggestion', User::current()->suggestion())
			->display();
	}

	public function get_form()
	{
		if(User::current()->has_suggestion())
			redirect('suggestions');

		$this->view('suggestions/form')
			->set('styles', array('lib/redactor/css/redactor.css'))
			->set('scripts', array('lib/redactor/redactor.min.js'))
			->display();
	}

	public function post_form()
	{
		$content = $this->input->post('content');

		if($content === '')
		{
			Alert::push('error', 'Harap isi kritik dan saran, lalu klik Kirim');
			redirect('suggestions/form');
		}

		Suggestion::add(User::current()->id, $content);
		Alert::push('success', 'Terima kasih sudah mengisi kritik dan saran.');

		redirect('suggestions');
	}
}