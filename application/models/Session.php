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
		$this->ns =  new Zend_Session_Namespace('Default');
		return $this->ns;		
	}
	
	public function get_user_email()
	{
		$this->ns =  new Zend_Session_Namespace('Default');
		return $this->ns->userName;
	}
	
	private $ns;
	private $session;
}