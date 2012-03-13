<?php
class Default_Model_Profile extends Zend_Db_Table_Abstract
{
	protected $_schema = 'chichio1_inbox';
	protected $_name;
    protected $_primary = 'id';
	public function _construct()
	{
		
	}	
	
	public function set_table($table)
	{
		$this->_name = $table;
		echo $this->_name;
	}
	
	
	public function updating($data)
	{
		$where = $this->getAdapter()->quoteInto('user = ?', 'test@sfsu.edu');
		$this->update($data, $where);
		return TRUE;
	}
	
}
