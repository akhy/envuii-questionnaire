<?php 

class Question extends DataMapper {

	public static function init()
	{
		return new Question;
	}

	public static function by_group($group_id)
	{
		return Question::init()->where('group_id', $group_id)->order_by('order');
	}
	
	public static function one($id)
	{
		return Question::init()->where('id', $id)->get();
	}


	public function choices()
	{
		return Choice::init()->where('question_id', $this->id)->order_by('order', 'asc')->get();
	}

	public function group()
	{
		return Group::one($this->group_id)->get();
	}

	public function answers()
	{
		return Answer::init()
			->where('user_id', User::current()->id)
			->where('question_id', $this->id)
			->get()
			;
	}

	public function answer_by_choice($choice_id)
	{
		return Answer::init()
			->where('user_id', User::current()->id)
			->where('question_id', $this->id)
			->where('choice_id', $choice_id)
			->get();
	}

	public function choice_ids()
	{
		$answers = $this->answers();

		$ids = array();
		foreach($answers as $answer)
		{
			array_push($ids, $answer->choice_id);
		}

		return $ids;

	}

	public function siblings()
	{
		return Question::init()
			->where('group_id', $this->group_id)
			->get()
			;
	}

	public function prev()
	{
		return Question::init()
			->where('group_id', $this->group_id)
			->where('order <= '.$this->order)
			->where('id != ', $this->id)
			->order_by('order', 'desc')
			->limit(1)
			->get();
	}

	public function next()
	{
		return Question::init()
			->where('group_id', $this->group_id)
			->where('order >= '.$this->order)
			->where('id != ', $this->id)
			->order_by('order', 'asc')
			->limit(1)
			->get();
	}

	public function meta()
	{
		$class_name = 'Meta'.ucfirst($this->meta_table);

		return call_user_func($class_name . '::one', $this->meta_id);
	}

	public function url()
	{
		return 'questions/view/'.$this->id;
	}

}