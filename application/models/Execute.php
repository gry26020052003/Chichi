<?php
class Default_Model_Execute
{	
	public static function get_data($user, $profile, $share)
	{
		$db = Zend_Registry::get('db');
		$select = $db->select()
             ->from(array('p' => 'activity'));
		$stmt = $db->query($select);
		$result = $stmt->fetchAll();
		$temp = array();
		foreach($result as $key => $value){
			if($value["table"] == "status_msg"){
				$data = $profile->get_dataByID($value["table_id"]);
				$value["user"] = $data->user;
				$value["message"] = $data->message;
				$value["timestamp"] = $data->date;
				$temp[] = $value;
			}else if($value["table"] == "purchases"){
				$data = $share->getData_ById($value["table_id"]);
				$value["user"] = $data->user;
				$value["product_title"] = $data->product_title;
				$value["product_description"] = $data->product_description;
				$value["product_price"] = $data->product_price;
				$value["product_image"] = $data->product_image;
				//$tempp[] = $value;
			}
		}	
		return $temp;
	}		
}
	