<?php

include_once("database.class.php");
include_once("dbfunctions.class.php");

Class AdFormHandler
{
	private $link;

	function __construct()
	{
		$this->link = new dbfunctions();
		$this->link->connect();	
	}
	
	public function fetchDetails($id, $table)
	{
		return $this->link->fetch($id, $table);
	}
	
	public function fetchLinkPath($product_id, $target)
	{
		return $this->link->fetchLinkPath($product_id, $target);
	}
	
	public function escape($string)
	{
		return mysqli::escape_string($string);
	}
	
	public function highestZincfin()
	{
		$trackers = $this->link->getZincfinNumbers();
		$highest_tracker = 0;

		foreach($trackers as $tracker)
		{
			$tmp = substr($tracker['tracker'],-4);
			if($tmp > $highest_tracker)
				$highest_tracker = $tmp;
		}
		return $highest_tracker;

	}
	
	public function populate($tableName, $value, $name, $selected_element = "")
	{
		$items = $this->link->fetchAll($tableName);
		foreach($items as $item)
		{
			if($item[$name] == $selected_element)
					echo "<option value = '" . $item[$value] . "' selected>" . $item[$name] . "</option>";
				else
					echo "<option value = '" . $item[$value] . "'>" . $item[$name] . "</option>";
		}		
	}
	
}

?>