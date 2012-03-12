<?php

class Default_Model_checkUser extends Zend_Db_Table_Abstract
{
	protected $_name = 'mt_user';
    protected $_primary = 'email';
	
	public function check_user($email)
	{
		$select = $this->select();
		$select->where('email = ?', $email);
		$row = $this->fetchrow($select);
		if($row)
		{
			return true;	
		}else 
		{
			return false;
		}
		
	}
	
	
	public function search_friend($data)
	{
		array_pop($data);	
	}
	
}

