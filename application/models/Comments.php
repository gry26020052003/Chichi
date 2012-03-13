<?php
class Default_Model_Comments extends Zend_Db_Table_Abstract
{
	protected $_name = 'comments';
    protected $_primary = 'id';
    private $user;
	private $time_stamp;
	private $message_id;
	
	public function inserting($data)
	{
		$this->insert($data);
	}
	
	

	
	
	
}