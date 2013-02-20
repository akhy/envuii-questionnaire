<?php 

class Suggestion extends DataMapper{

	public static function init()
	{
		return new Suggestion;
	}

	public static function add($user_id, $content)
	{
		$suggestion = Suggestion::init();
		$suggestion->user_id = $user_id;
		$suggestion->content = $content;
		
		return $suggestion->save();
	}
}