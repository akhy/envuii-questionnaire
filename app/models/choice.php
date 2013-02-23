<?php 

class Choice extends DataMapper {

	public $table = 'choices';

	public static function init()
	{
		return new Choice;
	}

	public static function one($id)
	{
		return Choice::init()->where('id', $id)->get();
	}

	public static function by_meta($id)
	{
		return Choice::init()->where('meta_id', $id)->get();
	}
}