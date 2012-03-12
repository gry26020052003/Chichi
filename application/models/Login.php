<?php

class Default_Model_Login 
{
	
	public function set_all($email, $password)
	{
		$this->email = $email;
		$this->password = $password;
	}
	
	public function set_email($email)
	{
		$this->email = $email;
	}
	
	public function set_password($password)
	{
		$this->password = $password;
	}
	
	public function get_email()
	{
		return $this->email;
	}
	
	public function get_password()
	{
		return $this->password;
	}
	
	public function check_user()
	{
		$auth = Zend_Auth::getInstance();
		$db = Zend_Registry::get('db');
		$authAdapter = new Zend_Auth_Adapter_DbTable($db);
		$authAdapter->setTableName('mt_user')  
          		    ->setIdentityColumn('email')  
                    ->setCredentialColumn('password');
					
		$authAdapter->setIdentity($this->email)  
                    ->setCredential($this->password); 
					
		$result = $auth->authenticate($authAdapter);  		 
        if($result->isValid()){
               $storage = new Zend_Auth_Storage_Session();
               $userInfo = $authAdapter->getResultRowObject(null, 'password');
               $storage->write($userInfo);
           	   return true;
        }
        else {
               return false;
        }    
	}
	
	private $email;
	private $password;
	
}
