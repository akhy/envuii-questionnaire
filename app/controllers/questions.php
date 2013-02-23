<?php 

require_once(APPPATH.'core/MY_AlumniController.php');

class Questions extends MY_AlumniController {

	protected function view($template)
	{
		return parent::view($template)
			->set('active', 'questions')
			;
	}

	public function get_index()
	{
		$groups = Group::init()->get();

		$this->view('questions/groups')
			->prepend('Tracer Study')
			->set('groups', $groups)
			->display();
	}

	public function get_group($slug)
	{
		$group = Group::by_slug($slug);

		$this->view('questions/index')
			->set('group', $group)
			->display();
	}

	public function get_view($id)
	{
		$question = Question::one($id);

		$this->view('questions/form')
			->set('question', $question)
			->display();
	}

	public function post_fill($id)
	{
		$post = $this->input->post();
		Answer::fill($id, $post['fill']);
	}

	public function post_choose($id)
	{
		$post = $this->input->post();
		var_dump($post);
		Answer::choose($id, $post['choice_id'], $post['fill']);
	}

	// public function get_show($id)
	// {
	// 	$question = Question::one($id);

	// 	$this->view('questions/show')
	// 		->set('question', $question)
	// 		->display();
	// }
}