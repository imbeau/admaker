<?php

	include_once "CreateAdClass.php";
	include_once "AdvertisementClass.php";
	include_once "packageClass.php";

?>


<html>
<head>
	<title>AdMaker 2 - Create an Ad</title>
</head>
<body>

<?php


$editing = false;

$form = new AdFormHandler();

if(isset($_GET['action']))
{
	if(($_GET['action'] == "edit") && isset($_GET['id']))
	{
		//flip form to editing mode
		$editing == true;

		//retrieve data to be edited

	}
		
}

?>



<form name="create_ad" action="save.php" method="post">
<strong>Date:</strong><br> <input type="text" name="date" value="<?php echo date("mdy"); ?>" maxlength="6" size="6"><br>
<strong>Zincfin:</strong><br> <input type="text" name="zincfin" value="<?php if(isset($_GET['zincfin'])) echo $_GET['zincfin']; ?>" maxlength="12" size="12">(last HP ended at <?php echo $form->highestZincfin(); ?>)<br>
<strong>Target:</strong><br>
<select name="target">
<?php
$form->populate("targets","target_id","target_name");
?>
</select>
<br>
<strong>Layout:</strong><br>
<select name="layout">
<?php
$form->populate("layouts","layout_name","layout_name");
?>
</select>

<br>
<strong>Product 1:</strong><br>
<select name="product1">
<?php
$form->populate("products","product_id","product_name");
?>

</select>
<br>
<strong>Hero 1:</strong><br> 
<select name="hero1">
<?php
$form->populate("images","image_id","image_name");
?>
</select>
<br>
<strong>Headline 1:</strong><br> <input type="text" name="headline1">
<input type="text" size="8" name="shortheadline1"><input type="checkbox" name="h1_size" value="1">Small text<br>
<strong>Product 2:</strong><br>
<select name="product2">
<?php
$form->populate("products","product_id","product_name");
?>
</select>
<br>
<strong>Hero 2:</strong><br>
<select name="hero2">
<?php
$form->populate("images","image_id","image_name");
?>
</select>
<br>
<strong>Headline 2:</strong><br> <input type="text" name="headline2">
<input type="text" size="8" name="shortheadline2"><input type="checkbox" name="h2_size" value="1">Small text<br>
<br>
<input type="submit" value="Submit">
</form>

</body>
</html>