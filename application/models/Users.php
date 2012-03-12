<?php

class Default_Model_Users extends Zend_Db_Table_Abstract
{
	protected $_name = 'mt_user';
    protected $_primary = 'id';
	
	public function check_user($email)
	{
		$select = $this->select();
		$select->where('email = ?', $email);
		$row = $this->fetchrow($select);
		if($row){
			return true;	
		}else {
			return false;
		}
		
	}

	public function get_user_byid($id)
	{
		$select = $this->select();
		$select->where('id = ?', $id);
		$row = $this->fetchrow($select);
		if($row){
			return $row["email"];	
		}else {
			return false;
		}
		
	}
	public function get_user_byemail($email)
	{
		$select = $this->select();
		$select->where('email = ?', $email);
		$row = $this->fetchrow($select);
		if($row){
			return $row;	
		}else {
			return false;
		}
	}
	
	public function search($data)
	{

		$type = isset($data['type']) ?  $data['type'] : '';
		$ff = isset($data['friend']) ?  $data['friend'] : '';
		if($type == "name"){
				$select = $this->select()->where("fullname LIKE '%$ff%'", 'NEW');
				$row = $this->fetchAll($select)->toArray();	
				if(sizeof($row) > 1){
				$info = array();
				foreach($row as $key => $value){
					similar_text($value["fullname"], $ff, $percent);
					$info[$percent] = $value["fullname"];
				}
				ksort($info);
				return $info;
			}
			return $row;
		}else if($type == "fullname"){
			$select = $this->select()->where("fullname LIKE '%$ff%'", 'NEW');
			$row = $this->fetchAll($select)->toArray();
			if(sizeof($row) > 1){
				$info = array();
				foreach($row as $key => $value){
					similar_text($value["fullname"], $ff, $percent);
					$info[$percent] = $value["fullname"]."hidden_b".$value["id"];
				}
			krsort($info);
			return $info;
		}
		return $row;
		}
	}
	
}

