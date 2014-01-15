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
	
	public function fetchAdforEdit($id)
	{
		$tmp = $this->link->fetchAdtoEdit($id,"ads_patrick");
		return $tmp;
	}
	
	public function populate($tableName, $value, $name, $selected_element = "")
	{
		$items = $this->link->fetchAll($tableName);
		foreach($items as $item)
		{
			if($item[$value] == $selected_element)
					echo "<option value = '" . $item[$value] . "' selected>" . $item[$name] . "</option>";
				else
					echo "<option value = '" . $item[$value] . "'>" . $item[$name] . "</option>";
		}		
	}
	
	/* editing */
	public function getTarget($target_code)
	{
		$tmp = $this->link->fetchByColumn("target_code",$target_code,"targets");
		return $tmp[0]['target_id'];	
	}
	
	public function fetchProductsFromTitle($ad_name)
	{
		$tmp = explode("_",$ad_name);
		
		$product1 = $this->link->fetchByColumn("product_abbreviation",$tmp[1],"products");
		$product2 = $this->link->fetchByColumn("product_abbreviation",$tmp[4],"products");
		
		return array("1" => $product1, "2" => $product2);
	}
	
	public function fetchAbbreviationsFromTitle($ad_name)
	{
		$tmp = explode("_",$ad_name);

		return array("1" => $tmp[3], "2" => $tmp[6]);	
	}
	
	public function fetchImageIdByName($image_name)
	{
		$tmp = $this->link->fetchByColumn("image_name",$image_name,"images");
		return $tmp[0]['image_id'];
	}
	
	public function fetchFontSizeBySize($size)
	{
		$tmp = $this->link->fetchByColumn("font_size",$size,"font_sizes");
		return $tmp[0]['font_size'];
	}
	
	
}

?>