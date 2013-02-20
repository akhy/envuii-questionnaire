<?php 

class Questions extends MY_Controller {

	public function get_index()
	{
		$questions = Question::init();

		$this->view('questions/index')
			->set('questions', $questions)
			->display();
	}

	public function get_show($id)
	{
		$question = Question::one($id);

		$this->view('questions/show')
			->set('question', $question)
			->display();
	}
}