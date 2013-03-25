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

	public function users()
	{
		return User::init()->where('group_id', $this->id);
	}

	public function questions()
	{
		return Question::by_group($this->id);
	}

	public function last_order()
	{
		$max = $this->db->query(
			"SELECT MAX(`order`) `max` 
			 FROM questions 
			 WHERE group_id = {$this->id}")->row();
		
		return (int) $max->max;
	}

	public function first()
	{
		return Question::init()
			->where('group_id', $this->id)
			->order_by('order')
			->limit(1)
			->get();
	}

	public function url()
	{
		return 'questions/group/'.$this->slug;
	}

	public function admin_url()
	{
		return 'admin/questions?group_id='.$this->id;
	}
}