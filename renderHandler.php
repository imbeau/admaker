<?php

include_once("database.class.php");
include_once("dbfunctions.class.php");


class renderHandler
{

	private $link;

	function __construct()
	{
		$this->link = new dbfunctions();
		$this->link->connect();	
	}

	function fetchAds($date)
	{
		$tmp = $this->link->fetchByColumn("date",$date,"ads_patrick");
		if(empty($tmp))
			die("No results!");
		return $tmp;
	}	

	function fetchImageUrl($image_name)
	{
		$tmp = $this->link->fetchByColumn("image_name",$image_name,"images");
		return $tmp[0]['image_path'];
	}


	function getHeadlineSizeHtml($size)
	{
			if($size == "1")
			{
				return "style=\"font-size:15px;\">";
			}
			else
			{
				//echo just the end bracket
				return ">";
			}		
	}

}


?>