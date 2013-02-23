<?php 

class MetaFill extends DataMapper {

	public $table = 'meta_fill';

	public static function init()
	{
		return new MetaFill;
	}

	public static function one($id)
	{
		return MetaFill::init()->where('id', $id)->get();
	}
}