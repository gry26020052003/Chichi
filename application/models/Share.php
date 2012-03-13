<?php

class Default_Model_Share extends Zend_Db_Table_Abstract
{
	protected $_name = 'purchases';
    protected $_primary = 'id';
	
	
	public function inserting($data)
	{
		$id = $this->insert($data);
		return $id;
	}
	
	
	public function getData_ById($id)
	{
		$select = $this->select();
		$select->from($this)
			   ->where('id = ?', $id);
		$row = $this->fetchRow($select);
		return $row;
	}
		
		
}
	