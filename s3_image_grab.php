<?php

include("C:\wamp\www\admaker2\database.class.php");
include("C:\wamp\www\admaker2\dbfunctions.class.php");

		$link = new dbfunctions();
		$link->connect();	

		$xml = simplexml_load_file("http://imgs.zincfin.com.s3.amazonaws.com/") or die("feed not loading");
		$image_query = $link->importImages($xml);
		if( $image_query == 0)
			echo "No new images found on S3!";
		else
			$link->doQuery($image_query);

		//$link->fixImages();
		//$link->fixHeadSize();
?>