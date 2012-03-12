<?php

class Default_Model_Signup extends Zend_Db_Table_Abstract
{
	protected $_name = 'mt_user';
	protected $_primary = 'id';

/*	
	private $firstName;
	private $lastName;
	private $email;
	private $password;
	private $sexSelect;
	private $profileImage;
	
	public function initSignup($_firstname,$_lastname,$_email,$_profileImage,$_password,$_sexselect){	
		//echo "model1";
			
			echo $this->firstName = $_firstname;
			echo $this->lastName = $_lastname;
			echo $this->email = $_email;
			$this->profileImage = $_profileImage;
			echo $this->password = $_password;
			echo $this->sexSelect = $_sexselect;
			
			//$imgData =addslashes(file_get_contents($_FILES['file']['tmp_name']));
	}
	
	public function storeData(){
		
		$data = array(
		'email'			=>	 	$this->email,
		'user_image'	=>		$this->profileImage,
		'firstname'		=>		$this->firstName,
		'lastname'		=>		$this->lastName,
		'password'		=>		$this->password,
		'sex-select'	=>		$this->sexSelect
		);
		$this->insert($data);
	}

*/
	public function storeData($data){
		$this->insert($data);
	}
}
