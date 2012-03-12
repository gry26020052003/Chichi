<?php
class Default_Model_emailConfirm extends Zend_Db_Table_Abstract 
{
	protected $_name = 'email';
    protected $_primary = 'id';
	
	
	public function inserting($data)
	{
		$this->insert($data);
	}
	
	
	public function check_code($code)
	{
		$select = $this->select();
		$select->where('code = ?', $code);
		$row = $this->fetchrow($select);	
		if($row){
			return true;	
		}else {
			return false;
		}
	}
	
	public function delete_by_code($code)
	{
		$where = $this->getAdapter()->quoteInto('code= ?', $code);
		$this->delete($where);
	}
	
	
}
