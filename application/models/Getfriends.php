<?php
class Default_Model_Getfriends extends Zend_Db_Table_Abstract
{
	protected $_schema = 'user_friends';
	protected $_name = '6984ed7a9acf718c933d4242f8c3882c504add19';
	protected $_id = "id";
    	
	public function set_dbApter()
	{
	
		
	}
	
	
	public function get_data()
	{
		$rows = $this->fetchAll();
		return $rows;
	}
	
	
	public function get_user_image_by_id($id)
	{
		$row = $this->find($id);
		return $row[0]->image;
	}
	
	
	public function get_tweets()
	{
		
	}
		
	public function get_lion()
	{
		
	}
}
