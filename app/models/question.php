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