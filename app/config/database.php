<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



$dbpath = APPPATH.'config/db/'.ENVIRONMENT.'.php';

if( ! is_file($dbpath) )
	exit("Database configuration is not exist. Please check file <strong>`$dbpath`</strong>");
else
	$conn = include ($dbpath);


$active_group = 'env_alumni';
$active_record = TRUE;

$db = $conn;



/* End of file database.php */
/* Location: ./application/config/database.php */