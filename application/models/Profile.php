<?php
class Default_Model_Profile extends Zend_Db_Table_Abstract
{
	protected $_name = 'profile';
    protected $_primary = 'id';
	public function _construct()
	{
		
	}
	
	public function get_profile_byEmail($email)
	{
		$row = $this->fetchRow(
   		 		$this->select()
        		->where('user = ?', $email));
		return $row;
	}	
	
	
	public function updating($data)
	{
		$where = $this->getAdapter()->quoteInto('user = ?', 'test@sfsu.edu');
		$this->update($data, $where);
		return TRUE;
	}
	
	public function inserting($email)
	{
		$data["user"] = $email;
		$this->insert($data);
	}
 
}
