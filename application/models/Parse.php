<?php

class Default_Model_Parse
{

	public function parse_byID($string , $data)
	{
		$id = explode("_", $data[$string]);
		$info = $id[1];
		return $info;
	}
	
	
	
	
}
