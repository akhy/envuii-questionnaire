<?php 

class Config {

	public static function get($key)
	{
		$CI =& get_instance();

		$row = $CI->db->query(
			"SELECT value FROM configs WHERE `key` = '{$key}'")
			->row();

		return is_object($row) ? $row->value : null;
	}
}