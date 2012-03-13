<?php

class Default_Model_Initiialize 
{
	
	public function set_table($name)
	{
		$this->_name = md5($name);
	}
	

	public function initialize($index)
	{
		$sql = "DROP TABLE IF EXISTS `$this->_name`; CREATE TABLE IF NOT EXISTS `$this->_name` (
			  `int` int(255) NOT NULL,
  			  `friend` varchar(255) NOT NULL,
  			  `timestamp` int(255) NOT NULL
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12;";	
		$db = Zend_Registry::get($index);
		$db->query($sql);		
	}
	
	public function init_inbox($index)
	{
		$sql = "DROP TABLE IF EXISTS `$this->_name`;
				CREATE TABLE IF NOT EXISTS `$this->_name` (
			   `id` int(255) NOT NULL,
  			   `sent_user` varchar(255) NOT NULL,
  			   `message` varchar(255) NOT NULL,
  			   `timestamp` int(255) NOT NULL,
  			   	PRIMARY KEY (`id`)
			    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12;";
		$db = Zend_Registry::get($index);
		$db->query($sql);		
	}
	
	
	public function init_confirm($index)
	{
		$sql = "DROP TABLE IF EXISTS `$this->_name`;
				CREATE TABLE IF NOT EXISTS `$this->_name` (
  				`id` int(255) NOT NULL AUTO_INCREMENT,
  				`code` varchar(255) NOT NULL,
  				`front_user_id` int(11) NOT NULL,
  				`end_user_id` int(11) NOT NULL,
 				 PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;";
		$db = Zend_Registry::get($index);
		$db->query($sql);	
	}
	
	
	protected $_name ;
	
}
