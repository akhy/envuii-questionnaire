<?php 

require_once(APPPATH.'core/MY_AlumniController.php');

class Competences extends MY_AlumniController
{
	public function __construct()
	{
		parent::__construct();

		if(User::current()->group_id == null)
		{
			Alert::push('warning', 'Anda harus mengisi tracer study terlebih dahulu');
			redirect('questions');
		}
	}

	protected function view($template)
	{
		return parent::view($template)
			->prepend('Form Kompetensi Alumni')
			->set('active', 'competences')
			;
	}

	public function get_index()
	{
		if( User::current()->has_competences() )
			redirect('competences/answers');
		else
			redirect('competences/form');
	}

	public function get_answers()
	{
		$competences = User::current()->competences();

		$this->view('competences/answers')
			->set('competences', $competences)
			->display();
	}

	public function get_reset()
	{
		User::current()->reset_competences();

		Alert::push('warning', 'Jawaban anda sebelumnya telah dihapus, 
			silakan isi kembali form kompetensi alumni di bawah.');

		redirect('competences/form');
	}

	public function get_form()
	{
		$competences = Competence::all();

		$this->view('competences/form')
			->set('competences', $competences)
			->display();
	}

	public function post_form()
	{
		$answers = $this->input->post('answer');
		Competence::bulk_insert(User::current()->id, $answers);

		redirect('competences');
	}
}