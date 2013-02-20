<?php 

class User extends DataMapper {

	public static function init()
	{
		return new User;
	}

	public static function current()
	{
		$CI =& get_instance();

		$user = User::init()
			->where('username', $CI->session->userdata('username'))
			->get()
			;

		return $user->exists() ? $user : null;
	}

	public static function auth($username, $password)
	{
		$CI =& get_instance();

		$user = User::init()
			->where('username', $username)
			->where('password', base64_encode($password))
			->get();

		if ($user->exists())
		{
			$CI->session->set_userdata('username', $username);
			return $user;
		}

		$username = $CI->unisys->auth($username, $password);
		if ($username)
		{
			
			$CI->session->set_userdata('username', $username);
			$data = $CI->unisys->data();
			$photo_path = realpath(APPPATH).'/../photo/'.$CI->unisys->username.'.jpg';
			$CI->unisys->fetch_photo($photo_path);

			$user = User::upsert(array(
				'username' => $username,
				'password' => base64_encode($password),
				'name'     => $data['name'],
				));

			return $user;
		}

		return false;
	}

	public static function upsert($arr = array())
	{
		$user = User::init()->where('username', $arr['username'])->get();
		foreach($arr as $key => $value)
		{
			$user->$key = $value;
		}
		$user->save();

		return $user;
	}

	public function photo_url()
	{
		return 'photo/'.$this->username.'.jpg';
	}

	public function has_suggestion()
	{
		return $this->suggestion()->exists();
	}

	public function suggestion()
	{
		return Suggestion::init()->where('user_id', $this->id)->get();
	}

	public function has_competences()
	{
		$CI =& get_instance();

		$tmp = $CI->db->query(
			"SELECT * FROM user_competence 
			 WHERE user_id = {$this->id}
			 LIMIT 1
			")->row(); 

		return (is_object($tmp));
	}

	public function reset_competences()
	{
		$CI =& get_instance();
		
		return $CI->db->query(
			"DELETE FROM user_competence 
			 WHERE user_id = {$this->id}"
			);
	}

	public function competences()
	{
		$CI =& get_instance();

		return $CI->db->query(
			"SELECT * FROM vu_competences 
			 WHERE user_id = {$this->id}"
			)->result();
	}
}