<?php

class Default_Model_Signup extends Zend_Db_Table_Abstract
{
	protected $_name = 'mt_user';
	protected $_primary = 'id';
	
	public function storeData($data){
		$this->insert($data);
	}
}
