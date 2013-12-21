<?php

Class Advertisement
{
	private $link; // db

	private $date;
	private $target_id;
	private $target_code;
	private $zincfin; //code for zincfin
	private $layout;
	private $product1;
	private $product2;
	private $affId;
	private $backupaffId;
	private $adName;
	private $backupLinkPath;

	/*
	 * fields:
	 * target_id = ID of the targeting for this ad
	 * date = date the ad is being run
	 * tracking_code = four digit unique code for the ad - this gets rolled into the zincfin number immediately
	 * product - a class containing all the information for each product to be rendered
	 */
	function __construct($target_id, $layout, $date, $tracking_code, $product1, $product2)
	{
		$this->link = new dbfunctions();
		$this->link->connect();	

		$this->date = $date;
		$this->layout = $layout;

		//301990001829
		//[target-gender] [age-range] [filler] [tracking code]

		$this->product1 = $product1;
		$this->product2 = $product2;
		
		$this->target_id = $target_id;

		//finds the proper targeting information
		$this->fetchTargetingInfo($tracking_code);

		$this->buildAdName();
		$this->buildAffId();
		$this->buildBackupAffId();

	}

	function save_patrick()
	{

		$query = $this->link->buildSingleQuery("ads_patrick", [
									"date" => $this->date,
									"target" => $this->target_code,
									"ad_name" => $this->affId,
									"tracker" => $this->zincfin,
									"brand_1" => $this->product1->getDisplayUrl(),
									"image_1" => $this->product1->getImageName(),
									"head_1_size" => $this->product1->getHeadlineSize(),
									"head_1" => $this->product1->getHeadline(),
									"link_1" => $this->product1->getClickUrl() . $this->affId,
									"brand_2" => $this->product2->getDisplayUrl(),
									"image_2" => $this->product2->getImageName(),
									"head_2_size" => $this->product2->getHeadlineSize(),
									"head_2" => $this->product2->getHeadline(),
									"link_2" => $this->product2->getClickUrl() . $this->affId,		
									"link_backup" => $this->backupLinkPath . $this->backupaffId	
								]);
		echo $query;
		$this->link->write($query);
	}

	function saveAd()
	{
		$package1_id = $product1->save();
		$package2_id = $product2->save();

		$query = $this->link->buildSingleQuery("ads", [
													"target_id" => $this->target_id,
													"layout" => $this->layout,
													"date" => $this->date,
													"tracking_code" => $this->tracking_code
														]);

		$this->link->write($query);
		$ad_id = $this->link->getLastInsertId();

	}

	function saveAdPackageRelationship($ad_id, $packages)
	{
		foreach($packages as $package_id)
		{
				//MULTI INSERT BELONGS IN dbfunctions
		}
	}


	function fetchTargetingInfo($tracking_code)
	{
		$tmp = $this->link->fetch($this->target_id,"targets");
		$this->target_code = $tmp[0]['target_code'];
		$this->backupLinkPath = $tmp[0]['backup_link_path'];
		$this->zincfin = $tmp[0]['zincfin_start'] . "000" . $tracking_code;
	}

	
	function getAffId()
	{
		return $this->affId;
	}
	
	function getBackupAffId()
	{
		return $this->backup_url;
	}

	
	function buildAffId()
	{
		$this->affId = $this->adName .
				  $this->product1->getProductId() . "x" .
				  $this->product2->getProductId() . "_" .
				  $this->zincfin;	
	}

	function buildAdName()
	{
		$this->affId = $this->target_code . "_" .
				  $this->product1->getProductAbbreviation() . "_" .
				  $this->product1->getImageName()  . "_" .
				  $this->product1->getHeadlineAbbreviation() . "_" .
				  
				  $this->product2->getProductAbbreviation() . "_" .
				  $this->product2->getImageName()  . "_" .
				  $this->product2->getHeadlineAbbreviation() . "_" .
				  $this->layout;	
	}
	
	function buildBackupaffId()
	{
		$this->backupaffId = $this->adName .
				  "Backup" . "_" .
				  $this->product1->getProductId() . "x" .
				  $this->product2->getProductId() . "_" .
				  $this->zincfin;
	}

}


?>