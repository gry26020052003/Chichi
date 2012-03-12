<?php
class IndexController extends Zend_Controller_Action
{
	private $profile;
	private $session;
	private $friends;
	private $email;
	private $check;
	private $comments;
	private $personal;
	private $newUser;
	private $parse;
	
	public function init()
	{
		$this->check = new Default_Model_Users();
		$this->profile= new Default_Model_Tweets();
		$this->session = new  Default_Model_Session();	
		$this->email = new Default_Model_emailConfirm();
		$this->friends = new Default_Model_userfriends();	
		$this->comments = new Default_Model_Comments();
		$this->personal = new Default_Model_Profile();
		$this->newUser = new Default_Model_Signup();
		$this->parse = new Default_Model_Parse();
	}
	
	public function indexAction()
	{
		echo "testing";
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();

		}
	}
	
	

	
	public function confirmcodeAction()
	{
		if($this->getRequest()->isGET()){
			$code = isset($_GET['code']) ?  $_GET['code'] : '';
			$front_u = isset($_GET['front_user']) ?  $_GET['front_user'] : '';
			$back_u = isset($_GET['enduser']) ?  $_GET['enduser'] : '';
			$f_email = $this->check->get_user_byid($front_u);
			$b_email = $this->check->get_user_byid($back_u);		
			$bool = $this->email->check_code($code);
			if($bool == true){
				$row = $this->email->delete_by_code($code);
				$this->friends->set_end_user($b_email);	
				$this->friends->setTable(md5($b_email));	
				$this->friends->inserting();			
			}			
		}
	}
	
	public function emailconfirmAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$email = $postdata["email"];
			$id = explode("_", $email);
			$id = $id[1];
			$email = $this->check->get_user_byid($id);
			$confirm_code=md5(uniqid(rand()));
			$defaultNamespace = new Zend_Session_Namespace('Default');
			$mail = new Zend_Mail();
			$mail->setBodyHtml('click here to confirm a friend  <a href="http://chichionline.net/chichi/public/index/confirmcode?code='.$confirm_code.'&enduser='.$id.'&front_user='.$defaultNamespace ->user_id.'" > Click Here</a>');
			$mail->setFrom('gry2600@gmail.com', 'Some Sender');
			$mail->addTo('gry2600@gmail.com', 'Some Recipient');
			$mail->setSubject('Confirm Your Friend');
			$mail->send();
			$data= array("code" => $confirm_code, "front_user_id" => $defaultNamespace ->user_id, "end_user_id" =>$id );
			$this->email->inserting($data);
		}
	}
	
	
	public function checkuserAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$email = $postdata["user_name"];
			$is_reg = $this->check->check_user($email);
			if($is_reg == true){
				echo "exist";
			}
		}
	}
	
	
	public function imageAction()
	{
		if($this->getRequest()->isGet()){
			//$id = $_GET["id"];
			//$image = $this->friends->get_user_image_by_id($id);
			//$this->view->image = $image;
		}
	}
	
	public function profileAction()
	{
		$ns = $this->session->get_session("Default");
		$user = $ns->userName;
		if($user){
			$this->view->current_user = $user;
			$rows = $this->profile->get_data($user);		
			$this->view->data = $rows;
			$row = $this->profile->get_last_message($user);
			$this->view->latest = $row;
			$data = $this->personal-> get_profile_byEmail($user);
			$this->view->personal = $data;
		}
		//$friends_data = $this->friends->get_data();
		//$this->view->friends = $friends_data;
	}
	
	public function submitAction()
	{
		
	}
	
	public function inboxAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$id = $this->parse->parse_byID("inbox", $postdata);
			echo $id;			
		}
	}
	
	public function messageAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$data = $this->profile->inserting($postdata);			
			$this->view->data = $data;
		}
	}
	
	
	public function oopAction()
	{
		
		
	}
	
	
	public function updateAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$bool = $this->personal->updating($postdata);
			if($bool == TRUE){
				$this->_redirect($_SERVER['HTTP_REFERER']);
			}				
		}
	}
	
	
	
	public function testAction()
	{
		//if($this->getRequest()->isPOST()){
		//	$scrapper = new Default_Model_Scrapper();
		//	$postdata = $this->_request->getPost();     
		//	$product = isset($postdata['product']) ?  $postdata['product'] : '';
		//	$image = $scrapper->getall($product);
		//	echo "<img src='".$image."' />";
		//}
		
		
		if($this->getRequest()->isPost()) {
				$postdata = $this->_request->getPost();
				$check = new Default_Model_Users();
				$rows = $check->search($postdata);
				$this->view->rows = $rows;
				$this->render("results");
				//var_dump($rows);
		}
		
		//	if($this->getRequest()->isPost()){
		//		$postdata = $this->_request->getPost();
		//		$message_id = isset($postdata['message_id']) ?  $postdata['message_id'] : '';
		//		$message_id = explode("tweet_", $message_id);
			//	$postdata["message_id"] = $message_id[1];
		//		$this->comments->inserting($postdata);
		//	}
		
		 
	}
	
	public function loginAction()
	{
 		if($this->getRequest()->isPost()) { 
    		$postdata = $this->_request->getPost();       	
			$filters = array(
				'*' => 'StringTrim',
				'*' => 'StripTags',
				'email'=>'StringToLower',
			);								
			$validators = array(
				'email'=>array(new Zend_Validate_EmailAddress(), 'NotEmpty'),
				'password'=>array('allowEmpty'=>true),
			);     
			$input = new Zend_Filter_Input($filters, $validators, $postdata);
			
			if($input->isValid()){
				$email = isset($postdata['email']) ?  $postdata['email'] : '';
				$password = isset($postdata['password']) ?  $postdata['password'] : '';
			    $user = new Default_Model_Login();
				$user-> set_all($email, $password);
				$this->is_log_in= $user->check_user();
				if($this->is_log_in == FALSE){
					$this->view->error = "Login Fail, Please Contact tian@globalmojo.com";
				}else if($this->is_log_in == TRUE){
					$row = $this->check->get_user_byemail($user->get_email());
					if($row["id"]){
							$this->session->set_id($row["id"]);
							$this->session->set_session($user->get_email());
					}
				
					$this->_redirect("/index/profile");
				}	
			}
			else {
				$this->view->error = "Login Fail, Your Email Address and Password is not Valid";				
			}
		 }
	}

	public function signupAction(){
			
		if($this->getRequest()->isPost())
		{
			$data = array();
			$postdata = $this->_request->getPost(); 
			$email = $postdata["email_address"];
			foreach ($postdata as $key => $value) {
				if($key == 'email_address')
					$key = 'email';
				$data[$key] = $value;
			}
			$data["user_image"] = is_uploaded_file($_FILES["user_image"]['tmp_name'])?  file_get_contents($_FILES["user_image"]['tmp_name']) : '';
			$this->newUser->storeData($data);
			$this->session->set_session($email);
			$ns = $this->session->get_session();
			$this->personal->inserting($ns->userName);			 
		}
	}



public function pdemoAction(){}

public function test1Action(){
		/*
			$data = new Default_Model_checkUserName();
			$rows = $data->showData();
			echo "mike test";
			$this->view->rows = $rows;	
	*/
	$data = array(
		  '1','2','3','4','5',
		  '6','7','8','9','10',
		  '11','12','13','14','15',
		  '16','17','18','19','20',
		  '21','22','23','24','25',

		);// initialize pager with data set
	
	$paginator =  $paginator = Zend_Paginator::factory($data);	
	$paginator->setCurrentPageNumber( $this->_getParam('page',1));
	$paginator->setItemCountPerPage($this->_getParam('count',2));
	$this->view->paginator = $paginator;
	

	
	}
	private $is_log_in;		
}
