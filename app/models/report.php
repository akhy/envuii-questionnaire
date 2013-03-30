<?php 

class Report extends DataMapper {

	public static function init()
	{
		return new Report;
	}

	public function question()
	{
		return Question::init()->where('id', $this->question_id)
			->limit(1)->get();
	}
	
}