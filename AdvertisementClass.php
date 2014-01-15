<?php

Class Advertisement
{
	private $link; // db

	private $date;
	private $target_id;
	private $target_code;
	private $zincfin; //code for zincfin
	private $layout;
	private $packages;
	private $affId;
	private $backupaffId;
	private $adName;
	private $backupLinkPath;
	private $tracking_code;

	/*
	 * fields:
	 * target_id = ID of the targeting for this ad
	 * date = date the ad is being run
	 * tracking_code = four digit unique code for the ad - this gets rolled into the zincfin number immediately
	 * product - a class containing all the information for each product to be rendered
	 */
	protected function __construct()
	{
		$this->link = new dbfunctions();
		$this->link->connect();	
	}
	
	public static function withParameters($target_id, $layout, $date, $tracking_code, $packages)
	{
		$instance = new self();
		$instance->build($target_id, $layout, $date, $tracking_code, $packages);
	}
	
	public static function load( $id )
	{
		$instance = new self();
		$ad = $instance->link->fetch($id, "ads");
		$instance->packages = $instance->link->fetchByColumn("ad_id",$id,"ads_packages"); //need to turn this into products
		
		// build the ad and load the assets for each package so we're ready to go.
		$instance->build($ad[0]['target_id'], $ad[0]['layout'], $ad[0]['date'], $ad[0]['tracking_code'], $instance->loadPackages($instance->packages));
		echo "wat";
		echo "<br>instance:";
		print_r($instance);
		echo "<br>packages";
		print_r($instance->packages);
		
		return $instance;
		
	}
	
	private function loadPackages( $packages )
	{
		$builtPackages = array();
		
		foreach( $packages as $package )
		{			
			array_push($builtPackages, Package::load($package['package_id']));
		}
		
		return $builtPackages;
	}
	
	function build($target_id, $layout, $date, $tracking_code, $packages)
	{
		$this->date = $date;
		$this->layout = $layout;

		//301990001829
		//[target-gender] [age-range] [filler] [tracking code]

		$this->packages = $packages;
		
		$this->target_id = $target_id;

		//finds the proper targeting information
		$this->tracking_code = $tracking_code;
		$this->fetchTargetingInfo($tracking_code);

		$this->buildAdName();
		$this->buildAffId();
		$this->buildBackupAffId();	
		return $instance;	
	}
 

/*	function save_patrick()
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
*/
	function save()
	{
		$query = $this->link->buildSingleQuery("ads", [
													"target_id" => $this->target_id,
													"layout" => $this->layout,
													"date" => $this->date,
													"tracking_code" => $this->tracking_code
														]);
		//$this->link->write($query);
		//$ad_id = $this->link->getLastInsertId();
		$ad_id = 11;
		$this->saveAdPackageRelationship($ad_id, $this->packages);

	}
	
	/* This function needs to take each package and save it into the packages table
	   then take the id for each package and insert that, along with the ad's ID into
	   the ad_package table so we can keep track of their relationship.
	 */

	function saveAdPackageRelationship($ad_id, $packages)
	{
		foreach($packages as $package)
		{
			//saves each package and then saves the relationship.
			$query = $this->link->buildSingleQuery("ads_packages",["ad_id" => $ad_id, "package_id" => $package->save()]);
			echo "query: " . $query . "<br>";
			$this->link->write($query);
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
		$this->affId = $this->adName;
				foreach($this->packages as $package)
				{
					$this->affId .= $package->getProductId() . "x";
				}
				//trim off the last 'x';
				$this->affId = substr($this->affId,0,-1); 				
				$this->affId .= "_" . $this->zincfin;
	}

	function buildAdName()
	{
		$this->adName = $this->target_code . "_";
				print_r($this->packages);
				foreach($this->packages as $package)
				{
					$this->adName .= $package->getProductAbbreviation() . "_" .
									$package->getImageName() . "_" .
									$package->getHeadlineAbbreviation() . "_";
				}
		$this->adName .= $this->layout;	
	}
	
	function buildBackupaffId()
	{
		$this->backupaffId = $this->adName .
				  "Backup" . "_";
				foreach($this->packages as $package)
				{
					$this->backupaffId .= $package->getProductId() . "x";
				}
				//trim off the last 'x';
				$this->affId = substr($this->backupaffId,0,-1); 				
				  $this->zincfin;
	}

}


?>