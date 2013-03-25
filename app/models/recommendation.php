<?php 

class Recommendation extends DataMapper{

	public static function init()
	{
		return new Recommendation;
	}

	public static function add($array)
	{
		$recommendation = Recommendation::init();
		$recommendation->user_id = User::current()->id;

		foreach($array as $key => $value)
			$recommendation->$key = $value;

		return $recommendation->save();
	}

	public function user()
	{
		return User::init()->where('id', $this->user_id)->get();
	} 
}