<?php 

class Question extends DataMapper {
	
	var $has_many = array('choice');

	public static function init()
	{
		return new Question;
	}

	public static function one($id)
	{
		return Question::init()->where('id', $id);
	}


	public function choices()
	{
		return Choice::init()->where('question_id', $this->id)->order_by('order', 'asc')->get();
	}


	public function url()
	{
		return 'questions/show/'.$this->id;
	}

	public function type()
	{
		$map = array(
			'choose' => '<i class="icon-list"></i> Pilihan',
			'fill' => 'Isian',
			);
		return $map[$this->type];
	}
}