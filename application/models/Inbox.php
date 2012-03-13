<?php
class Default_Model_Inbox extends Zend_Db_Table_Abstract
{
	
	protected $_schema = 'chichio1_inbox';
    protected $_primary = 'id';
	protected $_name;
	
	public function inserting($data)
	{
		$this->insert($data);
	}
	
	public function set_table($table)
	{
		$this->_name = $table;
	}	
	
	
	
	public function get_table()
	{
		return $this->_name;
	}
	
	
	public function updating($data)
	{
	}
	
	
 
}
