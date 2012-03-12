<?php
class Default_Model_Comments extends Zend_Db_Table_Abstract
{
	protected $_name = 'comments';
    protected $_primary = 'id';
    private $user;
	private $time_stamp;
	private $message_id;
	
	public function set_all()
	{
		$this->set_time();
	}
	public function inserting($data)
	{
	    $this->set_time();
		$data["timestamp"] = $this->time_stamp;
		//print_r($data);
		$this->insert($data);
	}
	
	
	public function set_time()
	{
		$this->time_stamp = strtotime("now");
	}
	
	
	public static function get_time()
	{
		return $this->time_stamp;	
	}
	
	
	
}