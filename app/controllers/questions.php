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
		$user = User::current();
		if($user->group_id !== null)
			redirect($user->group()->url());

		
		$groups = Group::init()->get();

		$this->view('questions/groups')
			->prepend('Tracer Study')
			->set('groups', $groups)
			->display();
	}

	public function get_select($id)
	{
		$group = Group::one($id);

		// TODO: Pindahin ke model 
		$user = User::current();
		$user->group_id = $group->id;
		$user->save();

		redirect($group->first()->url());
	}

	public function get_group($slug)
	{
		
		$group = Group::by_slug($slug);

		$this->view('questions/index')
			->prepend($group->description)
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

	public function post_answer($type, $id)
	{
		$post = $this->input->post();

		// Proses jawaban
		$this->$type($id, $post);

		$next = Question::one($id)->next();
		if($next->exists())
		{
			redirect($next->url());
		}
		else
		{
			Alert::push('success', 'Terima kasih telah mengisi tracer study.');

			redirect(User::current()->group()->url());
		}
	}

	private function fill($id, $post)
	{
		Answer::fill($id, $post['fill']);
	}

	private function choose($id, $post)
	{
		Answer::choose($id, $post['choice_id'], $post['fill']);
	}

	public function reset($id)
	{

	}

	public function get_complete()
	{
		$this->view('questions/complete')
			->display();
	}
}