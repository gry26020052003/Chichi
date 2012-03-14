<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected function _initDB()
	{		
		$db = Zend_Db::factory('Pdo_Mysql', array(
   		//'host' => 'localhost',
         //       'username' => 'chichio1',
          //      'password' => 'dat8tiantianT@',
           //     'dbname'   => 'chichio1_MT' ));
		'username' => 'tian',
		'password' => 'nx349r0x',
		'dbname'   => 'chichio1_MT' ));
		Zend_Registry::set('db', $db);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		
		$dbb = Zend_Db::factory('Pdo_Mysql', array(
   		'host' => 'localhost',
                'username' => 'chichio1',
                'password' => 'dat8tiantianT@',
                'dbname'   => 'chichio1_user_friends' ));
		Zend_Registry::set('dbb', $dbb);
		
		
		$inbox = Zend_Db::factory('Pdo_Mysql', array(
   		'host' => 'localhost',
                'username' => 'chichio1',
                'password' => 'dat8tiantianT@',
                'dbname'   => 'chichio1_inbox'));
		Zend_Registry::set('inbox', $inbox);		
		
		
				
		$confirm= Zend_Db::factory('Pdo_Mysql', array(
   		'host' => 'localhost',
                'username' => 'chichio1',
                'password' => 'dat8tiantianT@',
                'dbname'   => 'chichio1_confirm'));
		Zend_Registry::set('confirm', $confirm);				
	}
	
	protected function _initAutoload()
    {
		$autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => APPLICATION_PATH,
        ));
			
        return $autoloader;
    }
	
	protected function _initTime()
	{
		
	}
		
	protected function _initView()	
	{		
		//Zend_Layout::startMvc(array('layoutPath' => APPLICATION_PATH.'/layout/','layout' => 'layout'));
		//$ctrl  = Zend_Controller_Front::getInstance();
		//$router = $ctrl->getRouter();
		//		$router->addRoute(
    	//		'user',
   	//			 new Zend_Controller_Router_Route('user/:username',
          //                       			array('controller' => 'user',
            //                               		  'action' => 'info')));
	}
	
	

}

