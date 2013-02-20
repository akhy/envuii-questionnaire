<?php 

class Competence extends DataMapper {
	

	public static function init()
	{
		return new Competence;
	}

	public static function all()
	{
		return Competence::init()->order_by('id');
	}

	public static function bulk_insert($user_id, $answers)
	{
		$CI =& get_instance();

		foreach($answers as $competence_id => $answer)
		{
			$CI->db->insert('user_competence', array_merge(array(
				'user_id' => $user_id, 
				'competence_id' => $competence_id, 
				),
				$answer
				));
		}
	}
}
