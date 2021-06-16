<?php

class Database2{
	public static function connect(){
		$db = new mysqli('localhost', 'desarrollo', '123456', 'db_variedadesotac');
		$db->query("SET NAMES 'utf8'");
		return $db;
	}
}

