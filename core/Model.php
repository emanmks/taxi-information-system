<?php

class Model
{
	function __construct()
	{
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}

	function cleanXSS($var)
	{
		$newVar = stripslashes(htmlspecialchars($var, ENT_QUOTES));
		return $newVar;
	}
}