<?php 

class MetaChoose extends DataMapper {

	public $table = 'meta_choose';

	public static function init()
	{
		return new MetaChoose;
	}

	public static function one($id)
	{
		return MetaChoose::init()->where('id', $id)->get();
	}

	public function choices()
	{
		return Choice::by_meta($this->id);
	}
}