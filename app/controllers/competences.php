<?php 

require_once(APPPATH.'core/MY_AlumniController.php');

class Competences extends MY_AlumniController
{

	protected function view($template)
	{
		return parent::view($template)
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
			->prepend('Kompetensi Alumni')
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
			->prepend('Form Kompetensi Alumni')
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