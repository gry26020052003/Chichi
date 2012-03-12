<?php
class Default_Model_Tweets extends Zend_Db_Table_Abstract
{
	protected $_name = 'status_msg';
    protected $_primary = 'id';
    private $user;
	private $time_stamp;
	private $message;
	
	
	public function inserting($data)
	{
		$this->set_user();
		$this->set_time();
		$data["date"]= $this->time_stamp;
		$data["user"]= $this->user;
		$this->insert($data);
		return $data;
	}
	public function get_data($user)
	{
		$select = $this->select();
		$select->from($this, array('id','user', 'message', 'date'))
			   ->order('date DESC')
			   ->limit(10, 0)
			   ->where('user = ?', $user);
		$rows = $this->fetchAll($select);
		return $rows;
	}
	
	public function get_last_message($user)
	{
		$select = $this->select();
		$select->from($this, array('message'))
			   ->order('date DESC')
			   ->limit(1, 0)
			   ->where('user = ?', $user);
		$row = $this->fetchRow($select);
		return $row;
	}
	public function set_message($message)
	{
		
	}
	
	public function get_message()
	{
		return $this->message;
	}
	public function set_time()
	{
		$this->time_stamp = strtotime("now");
	}
	
	
	public static function get_time()
	{
		
	}
}
