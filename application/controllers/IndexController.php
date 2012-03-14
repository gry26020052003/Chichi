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
	private $init;
	private $scrapper;
	private $peginator;
	private $example;
	private $share;
	private $activity;
		
	public function init()
	{
		$this->check = new Default_Model_Users();
		$this->profile= new Default_Model_Tweets();
		$this->session = new  Default_Model_Session();	
		$this->email = new Default_Model_emailConfirm();
		$this->friends = new Default_Model_userfriends();	
		$this->comments = new Default_Model_Comments();
		$this->personal = new Default_Model_Profile();
		$this->init = new Default_Model_Initiialize();
		$this->inbox = new Default_Model_Inbox();
		$this->scrapper = new Default_Model_Scrapper();
		$this->example = new Default_Model_Example();
		$this->share = new  Default_Model_Share(); 
		$this->activity = new Default_Model_Activity();
		
	}
	
	public function indexAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
		}
	}
	
	public function kkkAction()
	{
	}
	
	public function commentsAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$ids = explode("_", $postdata["message_id"]);
			$id = $ids[1];
			$postdata["message_id"] = $id;
			$postdata["sent_user"] = $this->session->get_user_email();
			$postdata["timestamp"] = strtotime("now");
			$this->comments->inserting($postdata);
		}
	}
	
	public function inboxAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();		
			$data = array("sent_user" => $this->session->get_user_email(), "message" => $postdata["message"], "timestamp" => strtotime("now"));	
			$id = explode("_", $postdata["email"]);
			$receive_id = $id[1];
			$receive_email = $this->check->get_user_byid($receive_id);
			$this->inbox->set_table(md5($receive_email));
			$this->inbox->inserting($data);
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
		if(isset($user)){
			$this->view->current_user = $user;
			$rows = $this->profile->get_data($user);		
			$this->view->data = $rows;
			$row = $this->profile->get_last_message($user);
			$this->view->latest = $row;
			$current_user = $this->session->get_user_email();
		//	$this->view->current_user = $current_user;
		}
		if(isset($user)){
			//$rows = Default_Model_Execute::get_data($user, $this->profile, $this->share);
			//$this->view->data = $rows;
		}
		//$friends_data = $this->friends->get_data();
		//$this->view->friends = $friends_data;
	}
	
	public function submitAction()
	{
		
	}
	
	public function messageAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$postdata["date"] = strtotime("now");			
			$data = $this->profile->inserting($postdata);	
			$this->view->data = $data;
			$this->activity->inserting("status_msg", $data);
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
				//$this->_redirect($_SERVER['HTTP_REFERER']);
			}				
		}
	}
	
	
	public function scrapperAction()
	{
		if($this->getRequest()->isPost()){
		   $postdata = $this->_request->getPost();
		   $scrapper = isset($postdata['scrap']) ?  $postdata['scrap'] : '';
	 	   $data = $this->example->getInfo($scrapper);
		   $query = $query. "product=".$data[0];
		   $query = $query ."<br />description=".$data[2];
		   $query = $query ."<br />price=".$data[1];
		   foreach($data[3] as $value){
		   		$query = $query."<br />image=".$value;
		   }	
		   
			echo $query;
		}
	}
	
	public function productAction()
	{
		if($this->getRequest()->isPost()){
			$postdata = $this->_request->getPost();
			$scrapper = isset($postdata['scrapper']) ?  $postdata['scrapper'] : '';
			$data = $this->example->getInfo($scrapper);
			$this->view->data = $data;
		}
	}
	
	
	
	public function testAction()
	{
		$this->paginator = new Zend_Session_Namespace('Default');			
		if($this->getRequest()->isPost()) {		
				$postdata = $this->_request->getPost();
				$check = new Default_Model_Users();
				$rows = $check->search($postdata);	
				$this->paginator->searchInput = $rows;
	
				$peginator  =  Zend_Paginator::factory($this->paginator->searchInput);
				$peginator ->setCurrentPageNumber( $this->_getParam('page',1))
				->setItemCountPerPage(1)
				->setPageRange(5);
	
				$this->view->paginator = $peginator;
				$this->render("results");	
		}
		
		else if(isset($this->paginator->searchInput) && $this->_getParam('page')){
			$peginator  =  Zend_Paginator::factory($this->paginator->searchInput);	
			$peginator ->setCurrentPageNumber( $this->_getParam('page',1))
					   ->setItemCountPerPage(1)
					   ->setPageRange(5);	
			$this->view->paginator = $peginator;
			$this->render("results");
		}
		
		
		
		 $info = $this->example->getInfo("http://www.walmart.com/ip/RCA-26-26LA30RQD/15907766");
		//echo print_r($info);
		 
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

	public function shareAction()
	{
			if($this->getRequest()->isPost()){				
				$postdata = $this->_request->getPost();
				$data = $this->share->inserting($postdata);
				$this->activity->inserting("purchases", $data);
				
			}		
	}

	public function signupAction(){
			
		if($this->getRequest()->isPost())
		{
			$newUser = new Default_Model_Signup();
			$data = array();
			$postdata = $this->_request->getPost(); 
			foreach ($postdata as $key => $value){
				if($key == 'email_address')
					$key = 'email';
					$data[$key] = $value;
			}
			$data["user_image"] = is_uploaded_file($_FILES["user_image"]['tmp_name'])?  file_get_contents($_FILES["user_image"]['tmp_name']) : '';
			$newUser->storeData($data);
			$this->init->set_table($data["email"]);
			$this->init->initialize("dbb");
			$this->init->init_inbox("inbox");
			$this->init-> init_confirm("confirm");
		}
	}

	private $is_log_in;		
}
