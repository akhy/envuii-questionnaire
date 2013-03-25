<?php 

require_once(APPPATH.'core/MY_AdminController.php');

class Questions extends MY_AdminController {
	
	protected function view($template)
	{
		return parent::view($template)
			->prepend('Manajemen Pertanyaan')
			->set('active', 'questions')
			;
	} 

	public function get_index()
	{

		$group_id = $this->input->get('group_id');

		if(! $group_id) exit ('You must specify a question group');

		$group = Group::init()->where('id', $group_id)->get();
		$questions = Question::init()->where('group_id', $group_id)->order_by('order')->get();

		$this->breadcrumbs = array(
			anchor('admin/groups', 'Group Pertanyaan'),
			anchor($group->admin_url(), $group->description),
			);

		$this->view('questions/index')
			->set('group', $group)
			->set('questions', $questions)
			->display()
			;
	}

	public function get_detail($id)
	{
		$question = Question::one($id);

		$this->breadcrumbs = array(
			anchor('admin/groups', 'Group Pertanyaan'),
			anchor($question->group()->admin_url(), $question->group()->description),
			anchor($question->admin_url(), $question->title),
			);
		$this->view('questions/detail')
			->set('question', $question)
			->display()
			;
	}


	public function get_delete($id)
	{
		Question::init()->where('id', $id)->get()->delete();

		Alert::push('success', 'The question has been deleted from system.');
		redirect_back();
	}

	public function get_add()
	{
		$type     = $this->input->get('type');
		$group_id = $this->input->get('group_id');

		if(! $type OR $group_id === false) exit ('Invalid URL');

		$this->view('questions/add')
			->set('group', Group::one($group_id))
			->set('type', $type)
			->display();
	}

	public function post_add()
	{
		// echo '<pre>';
		// var_dump($this->input->post());
		// echo '</pre>';
		$question = Question::create($this->input->post());

		Alert::push('success', 'Berhasil menambahkan pertanyaan baru');
		redirect('admin/questions?group_id='.$question->group_id);
	}
}