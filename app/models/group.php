<?php 

class Group extends DataMapper {
	
	public static function init()
	{
		return new Group;
	}

	public static function one($id)
	{
		return Group::init()->where('id', $id)->limit(1)->get();
	}

	public static function by_slug($slug)
	{
		return Group::init()->where('slug', $slug)->limit(1)->get();
	}

	public function questions()
	{
		return Question::by_group($this->id);
	}

	public function url()
	{
		return 'questions/group/'.$this->slug;
	}
}