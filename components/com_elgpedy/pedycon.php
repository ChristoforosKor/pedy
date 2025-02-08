<?php
Class PedyCon 
{
    public static function getDB()
    {
		$db =  new PDO("mysql:host=192.168.10.172;dbname=pedy;",'root','zaQ1@#$%');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
    }
}
