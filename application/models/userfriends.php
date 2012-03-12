<?php

class Default_Model_userfriends extends Zend_Db_Table_Abstract
{
	protected $_primary = 'id';
	protected $_schema  = 'chichio1_user_friends';
	
	public function setTable($db)
	{
		$this->_name =  $db;
	}
	
	public function inserting()
	{
		$data = array("friend" => $this->end_user, "timestamp" => strtotime("now"));
		$this->insert($data);
	}
	
	
	public function get_end_user($user)
	{
		return $this->end_user;
	}
	
	public function set_end_user($user)
	{
		$this->end_user = $user;
	}
	
	private $end_user;
	
	
	
	
	
}
