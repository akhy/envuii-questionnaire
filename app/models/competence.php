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

	public static function avg()
	{
		return get_instance()->db->query(
			'SELECT c.*, 
				AVG(level) avg_level, 
				AVG(contribution) avg_contribution,
				COUNT(uc.id) cnt_user
			 FROM `competences` c
			 LEFT JOIN user_competence uc 
			 ON (uc.competence_id = c.id ) 
			 GROUP BY c.id, c.statement'
			 )->result();
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
