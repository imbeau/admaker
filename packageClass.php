<?php

include_once("dbfunctions.class.php");

Class Package
{
	 private $link; // link to db
	 
	 private $headline;
	 private $headline_abbreviation;
	 private $headline_size;
	 private $click_url;
	 private $display_url;
	 private $hero;
	 private $product_id;
	 private $product_details;
	 private $hero_details;
	 private $target_id;
	 private $target_code;
	 
	
	function __construct($product_id, $headline, $headline_abbreviation, $headline_size, $hero_id, $target_id)
	{
		$this->link = new dbfunctions();
		$this->link->connect();	
		
		$this->headline_size = $headline_size;
		$this->product_id = $product_id;
		$this->product_details = $this->getDetails($this->product_id, "products");
		$this->headline = $headline;
		$this->headline_abbreviation = $headline_abbreviation;
		$this->hero_details = $this->getDetails($hero_id,"images");
		$this->target_id = $target_id;
		$this->click_url = $this->retrieveClickUrl();
		$this->display_url = $this->setDisplayUrl();
		
	}
	
	public function save()
	{
		$query = $this->link->buildSingleQuery("packages",["product_id" => $this->product_id,
														   "headline" => $this->headline,
														   "headline_abbreviation" => $this->headline_abbreviation,
														   "headline_size" => $this->headline_size,
														   "hero_id" => $this->hero_id,
														   "target_id" => $this->target_id
															]);
		$this->link->write($query);
		return $this->link->getLastInsertId();
	}

	public function getDisplayUrl()
	{
		return $this->display_url;
	}

	public function getDetails($id,$table)
	{
		$tmp = $product_details = $this->link->fetch($id,$table);
		return $tmp[0];
	}
	
	function getHeadlineSize()
	{
		return $this->headline_size;
	}

	function getClickUrl()
	{
		return $this->click_url;
	}
	
	function retrieveClickUrl()
	{
		return $this->link->fetchLinkPath($this->product_details['product_id'], $this->target_id);
	}
	
	function getImageName()
	{
		return $this->hero_details['image_name'];
	}
	
	function getImagePath()
	{
		return $this->hero_details['image_path'];
	}
	
	function getHeadline()
	{
		return $this->headline;
	}

	function getHeadlineAbbreviation()
	{
		return $this->headline_abbreviation;
	}
	
	function getProductAbbreviation()
	{
		return $this->product_details['product_abbreviation'];
	}
	
	function getProductId()
	{
		return $this->product_details['product_id'];
	}
	
	function setDisplayUrl()
	{
		return $this->product_details['product_url'];
	}
	
	function getTargetCode()
	{
		return $this->target_code;
	}
	
	function fetchTargetCode()
	{
		$tmp = $this->getDetails($this->target_id,"targets");
		return $tmp['target_code'];
	}

}

?>