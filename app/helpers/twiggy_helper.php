<?php 

function yesno($bool)
{
	return $bool 
		? '&check;'
		: '&cross;'
		;
}