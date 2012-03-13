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
		$id = $this->insert($data);
		return $id;
	}
	
	
	
	
	public function get_data($user)
	{
		$db = Zend_Registry::get('db');
		$select = $db->select()
             		 ->from(array('m' => 'status_msg'),array("m.id as M_id", "m.user", "m.message", "c.id", "c.message_id", "c.comment", "c.sent_user", "c.timestamp"))
					 ->joinleft(array('c' => 'comments'),' m.id = c.message_id',array())
					 ->where('m.user = ?', $user);
					 
					 
		$row = $db->fetchAll($select);
		$temp = array();
		$message = array();
		$M_ID = array();
		foreach($row as $key => $value){
			if(isset($value["id"])){
				$tweet = array_slice($value, 0, 3);
				$comments = array_slice($value, 3, 5);
				if(in_array($tweet["M_id"], $M_ID)){
					$temp[$tweet["M_id"]]["comments"][] = $comments;
				}
				else {
					$M_ID[] = $tweet["M_id"];	
					$temp[$tweet["M_id"]] = $tweet;
					$temp[$tweet["M_id"]]["comments"][] = $comments;
				}
			}
			else {
					$temp[$value["M_id"]] = $value;
			}//
		}		
		//print_r($temp);		
		return $temp;
	}
	
	
	public function get_dataa($id)
	{
		$db = Zend_Registry::get('db');
		$select = $db->select()
             		 ->from(array('m' => 'status_msg'),array("m.id as M_id", "m.user", "m.message", "c.id", "c.message_id", "c.comment", "c.sent_user", "c.timestamp"))
					 ->joinleft(array('c' => 'comments'),' m.id = c.message_id',array())
					 ->where('m.id = ?', $id);
					 
					 
		$row = $db->fetchAll($select);
		$temp = array();
		$message = array();
		$M_ID = array();
		foreach($row as $key => $value){
			if(isset($value["id"])){
				$tweet = array_slice($value, 0, 3);
				$comments = array_slice($value, 3, 5);
				if(in_array($tweet["M_id"], $M_ID)){
					$temp[$tweet["M_id"]]["comments"][] = $comments;
				}
				else {
					$M_ID[] = $tweet["M_id"];	
					$temp[$tweet["M_id"]] = $tweet;
					$temp[$tweet["M_id"]]["comments"][] = $comments;
				}
			}
			else {
					$temp[$value["M_id"]] = $value;
			}//
		}		
		//print_r($temp);		
		return $temp;
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
	
	public function get_dataByID($id)
	{
		$select = $this->select();
		$select->from($this)
			   ->where('id = ?', $id);
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
