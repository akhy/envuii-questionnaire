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

	public static function create($arr)
	{
		$meta = MetaFill::init();
		foreach ($arr as $key => $value) {
			$meta->$key = $value;
		}
		$meta->save();

		return $meta;
	}
}