<?php 

class User extends DataMapper {

	static $current = false;

	public static function init()
	{
		return new User;
	}

	public static function current()
	{
		$CI =& get_instance();

		if (User::$current !== false)
			return User::$current;

		$user = User::init()
			->where('username', $CI->session->userdata('username'))
			->get()
			;

		User::$current = $user;

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

		return false;
	}

	public static function auth_unisys($username, $password)
	{
		$CI =& get_instance();

		$username = $CI->unisys->auth($username, $password);
		if ($username)
		{
			$data = $CI->unisys->data();
			$photo_path = realpath(APPPATH).'/../photo/'.$CI->unisys->username.'.jpg';
			$CI->unisys->fetch_photo($photo_path);

			$user = array(
				'username' => $username,
				'password' => base64_encode($password),
				'name'     => $data['name'],
				'verified' => true,
				);

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

	public function profile_url()
	{
		
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

	public function has_bio()
	{
		return sizeof($this->get_bio()) > 0;
	}

	public function get_bio($nice = false)
	{
		$CI =& get_instance();

		$user_id = $this->id;

		$raw = $CI->db->query(
			"SELECT `key`, `value`, `nicename` FROM user_bio WHERE user_id = $user_id"
			)->result(); 

		$index = $nice ? 'nicename' : 'key';
		$result = array();
		foreach ($raw as $record)
			$result[$record->$index] = $record->value;

		return $result;
	}
	public function set_bio($array)
	{
		$this->bio = $array;
	}

	public function save_bio($array)
	{
		$CI =& get_instance();

		$this->set_bio($array);

		if($this->invalid_bio())
			return false;

		foreach($this->bio_validation['sanitized'] as $key => $value)
		{
			$user_id = User::current()->id;

			$check = $CI->db
				->where('user_id', $user_id)
				->where('key', $key)
				->from('user_bio')
				->get()->row();

			if(is_object($check))
			{
				$CI->db
					->where('user_id', $user_id)
					->where('key', $key)
					->update('user_bio', array(
						'value'   => $value,
						)
					);
				continue;
			}

			$CI->db->insert('user_bio', 
				array(
					'user_id' => $user_id,
					'key'     => $key,
					'nicename'=> User::nicename($key),
					'value'   => $value,
					)
				);
		}
	}

	public function invalid_bio()
	{
		$validation = $this->validate_bio();

		return sizeof($validation['errors']) > 0; 
	}

	public function validate_bio()
	{
		$CI =& get_instance();
		$CI->load->library('validation');

		// Validate 
		$val = new validation;
		$val->addSource($this->bio);

		$val->addRule('gender', 'string', true, 1, 20)
			->addRule('email', 'email', true)
			->addRule('year_entry', 'numeric', true, 1990, date('Y'))
			->addRule('year_graduate', 'numeric', true, 1990, date('Y'))
			->addRule('priority', 'numeric', true, 1, 3)
			->addRule('current_address', 'string', true, 5, 500)
			->addRule('contact_number', 'string', true, 5, 15)
			->addRule('socmed_facebook', 'url', false)
			->addRule('socmed_twitter', 'string', false, 4, 30)
			;

		$val->run();


		return $this->bio_validation = array(
			'errors' => $val->errors,
			'sanitized' => $val->sanitized,
			);
	}

	public static function nicename($key)
	{
		$hashmap = array(
			'gender'          => 'Jenis Kelamin',
			'email'           => 'E-mail',
			'year_entry'      => 'Tahun Masuk',
			'year_graduate'   => 'Tahun Lulus',
			'priority'        => 'Prioritas Masuk JTL',
			'current_address' => 'Alamat Sekarang',
			'contact_number'  => 'Nomor Telepon/HP',
			'socmed_facebook' => 'Facebook',
			'socmed_twitter'  => 'Twitter',
			);

		return $hashmap[$key];
	}

	public function group()
	{
		return Group::init()->where('id', $this->group_id)->get();
	}

}