<?php 

class Choice extends DataMapper {
	public $has_many = array('question');

	public static function init()
	{
		return new Choice;
	}
}