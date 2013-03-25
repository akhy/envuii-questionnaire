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

	public static function create($arr)
	{
		// Separate metadata with choices
		$choices = array();
		if(array_key_exists('choices', $arr))
		{
			$choices = $arr['choices'];
			unset($arr['choices']);
		}

		// Create the meta
		$meta = MetaChoose::init();
		foreach ($arr as $key => $value) {
			$meta->$key = $value;
		}
		$meta->save();

		// Create the choices
		foreach($choices as $text)
		{
			if(trim($text) !== '')
			{
				$choice = Choice::init();
				$choice->meta_id = $meta->id;
				$choice->text = $text;
				$choice->save();
			}
		}

		return $meta;
	}

	public function delete()
	{
		$choices = Choice::init()->where('meta_id', $this->id)->get();
		foreach($choices as $choice)
		{
			$choice->delete();
		}

		return parent::delete();
	}
}