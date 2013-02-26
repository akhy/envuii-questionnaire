<?php 

class Answer extends DataMapper {

	public static function init()
	{
		return new Answer;
	}

	public static function choose($question_id, $choice_id = null, $fill = null)
	{
		if(is_array($choice_id))
		{
			foreach($choice_id as $cid)
			{
				if($cid == 0)
					Answer::choose($question_id, $cid, $fill);
				else	
					Answer::choose($question_id, $cid);
			}

			return;
		}

		$CI =& get_instance();

		$CI->db->insert('answers', array(
			'user_id'     => User::current()->id,
			'question_id' => $question_id,
			'choice_id'   => $choice_id,
			'fill'        => $fill == '' ? null : $fill, 
			));
	}

	public static function fill($question_id, $fill)
	{
		$CI =& get_instance();

		$CI->db->insert('answers', array(
			'user_id'     => User::current()->id,
			'question_id' => $question_id,
			'choice_id'   => null,
			'fill'        => $fill == '' ? null : $fill, 
			));
	}

}