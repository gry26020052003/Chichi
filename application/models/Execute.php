<?php
class Default_Model_Execute extends Zend_Db_Table_Abstract
{
	protected $_name = 'profile';
    protected $_primary = 'id';
	
	public function _construct()
	{
			
	}
	
	
	public function check_user($email)
	{
		$rows = $this->fetchall();
		print_r($rows);	
	}
	
	
	
} 