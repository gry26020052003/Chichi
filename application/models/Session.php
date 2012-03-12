<?php
class Default_Model_Session
{
	public function set_session($email)
	{
		$this->ns = new Zend_Session_Namespace('Default');
		$this->ns->userName = $email;	
	}
	
	public function set_id($id)
	{
		$this->ns = new Zend_Session_Namespace('Default');
		$this->ns->user_id = $id;		
	}
	
	public function get_session()
	{
		return new Zend_Session_Namespace('Default');
				
	}
	
	
	
	private $ns;
	private $session;
}