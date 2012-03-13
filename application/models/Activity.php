<?php
class Default_Model_Activity extends Zend_Db_Table_Abstract
{
	protected $_name = 'activity';
    protected $_primary = 'id';
	public function _construct()
	{
		
	}
	
	
	public function inserting($table, $table_id)
	{
		$data["table"] = $table;
		$data["table_id"] = $table_id;
		$data["timestamp"] = strtotime("now");		
		$this->insert($data);
		
	}
	
	
	public function saving()
	{
		
	}

}
