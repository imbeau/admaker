<?php

include_once "AdvertisementClass.php";
include_once "packageClass.php";

	$headline1_size = 0;
	$headline2_size = 0;
	if(isset($_POST['h1_size']))
		$headline1_size = $_POST['h1_size'];

	if(isset($_POST['h2_size']))
		$headline1_size = $_POST['h2_size'];
		
	$p1 = new Package($_POST['product1'],$_POST['headline1'],$_POST['shortheadline1'],$headline1_size,$_POST['hero1'],$_POST['target']);
	$p2 = new Package($_POST['product2'],$_POST['headline2'],$_POST['shortheadline2'],$headline2_size,$_POST['hero2'],$_POST['target']);

	$ad = new Advertisement($_POST['target'],$_POST['layout'],$_POST['date'],$_POST['zincfin'],[$p1,$p2]);
	
	$ad->save();
	?>
	<h1>Ad Saved!</h1>
	<ul>
		<li><a href="create.php?action=new&zincfin=<?php echo $_POST['zincfin']+1; ?>">Create Another?<a></li>
		<li><a href="render.php?date=<?php echo $_POST['date']; ?>">See Ad</a></li>
	</ul>
