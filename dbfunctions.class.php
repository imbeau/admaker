<?php

include_once("database.class.php");
include_once("settingClass.php");
include_once("dbfunctions.class.php");

class dbfunctions
{
	function __constructor()
	{
	}
	
	public function connect()
	{
		$dbo = database::getInstance();
		$dbo->connect(Setting::DB_IP, Setting::DB_IP, Setting:DB_PASSWORD, Setting::DB_TABLE);
	}

	function write($sql)
	{
		$dbo = database::getInstance();
		$dbo->doQuery($sql);
		//HOW TO RETURN ERROR?	
	}

	function buildSingleQuery($table_name, $data)
	{
		$columns = "INSERT into " . $table_name . " (";
		$values = " VALUES (";
		foreach($data as $key => $value)
		{
			$columns .= $key . ",";
			$values .= "'" . $value . "',";
		}
		//trim off last character because it's a comma
		$columns = substr($columns,0,-1) . ")";
		$values = substr($values,0,-1) . ");";

		return $columns . $values;
	}
	
	function fetchLinkPath($product_id, $target)
	{
	
		$dbo = database::getInstance();
		$query = "SELECT url FROM link_paths WHERE product_id = " . $product_id . " AND target = " . $target;
		//echo $query;
		$dbo->doQuery($query);
		$result = $dbo->LoadObjectList();
		return $result[0]['url'];		
	}

	function fetchByColumn($column, $value, $table)
	{
		$dbo = database::getInstance();
		$query = "SELECT * FROM " . $table . " WHERE " . $column . " = '" . $value . "'";
		$dbo->doQuery($query);
		$result = $dbo->LoadObjectList();
		return $result;		
	}

	
	function fetch($id,$table)
	{
		$dbo = database::getInstance();
		
		//tables are IMAGES... id column is IMAGE, so trim it up
		$query = "SELECT * FROM " . $table . " WHERE " . substr($table,0,strlen($table)-1) . "_id = " . $id;
		$dbo->doQuery($query);
		$result = $dbo->LoadObjectList();
		return $result;
	}

	function fetchAll($table)
	{
		$dbo = database::getInstance();
		$query = "SELECT * FROM " . $table;
		$dbo->doQuery($query);
		$result = $dbo->LoadObjectList();
		return $result;		
	}

	function getZincfinNumbers()
	{
		$dbo = database::getInstance();
		$query = "SELECT tracker FROM ads_patrick";	
		$dbo->doQuery($query);	
		$result = $dbo->LoadObjectList();
		return $result;			
	}

	function getLastInsertId()
	{
		return $dbo->getLastInsertId();
	}


	//fixes images imported via old cvs
	function fixImages()
	{
		$dbo = database::getInstance();
		$query = "SELECT * from ads_patrick";
		$dbo->doQuery($query);
		$result = $dbo->LoadObjectList();
		
		foreach($result as $ad)
		{
			$pieces = explode(".",$ad['image_2']);
			if(count($pieces) > 0)
			{
				$query = "UPDATE ads_patrick SET image_2 = '" . substr($pieces[0],strrpos($pieces[0],"_",-1)+1) . "' WHERE uid = " . $ad['uid'];
		$dbo->doQuery($query);
			}
		}


	}

	function fixHeadSize()
	{
		$dbo = database::getInstance();
		$query = "SELECT * from ads_patrick";
		$dbo->doQuery($query);
		$result = $dbo->LoadObjectList();

		foreach($result as $ad)
		{
			echo $ad['head_2'] . "<br>";
			if($ad['head_2'] == "<nobr>Surprising Natural</nobr> Testosterone Booster")
			{
				$query = "UPDATE ads_patrick SET head_2_size = 1 WHERE uid = " . $ad['uid'];
				echo $query . "<br>";
				//$dbo->doQuery($query);

			}
		}

	}
	
	
	function importImages($xml)
	{
		$dbo = database::getInstance();
		$current_images = $this->fetchAll("images");

		$query = "INSERT into images (image_id, image_name, image_path) VALUES ";
		$new_images_found = 0;
		foreach($xml->Contents as $image)
		{
				if((count(explode("/",$image->Key)) < 2) && in_array($image->Key,$current_images))
				{
					$new_images_found++;
					$pieces = explode(".",$image->Key);
					$query .= "('','" . substr($pieces[0],strrpos($pieces[0],"_",-1)+1) . "','" . $image->Key . "'), ";
				
				}
				
		}
		if($new_images_found == 0)
			return 0;
		else		
			return $query;
	
	}
	


}

?>