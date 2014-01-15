<?php
	include_once "CreateAdClass.php";
	include_once "AdvertisementClass.php";
	include_once "packageClass.php";

?>


<html>
<head>
	<title>AdMaker 2 - Create an Ad</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  
</head>
<body>

<?php


$editing = false;

$form = new AdFormHandler();

$ad;
$products;
$abbreviations;
if(isset($_GET['action']))
{
	if(($_GET['action'] == "edit") && isset($_GET['id']))
	{
		//flip form to editing mode
		$editing = true;

		//retrieve data to be edited
		$tmp = $form->fetchAdforEdit($_GET['id']);
		
		$ad = $tmp[0];
		$products = $form->fetchProductsFromTitle($ad['ad_name']);
		$abbreviations = $form->fetchAbbreviationsFromTitle($ad['ad_name']);
		print_r($ad);

	}

		
}

?>


<form name="create_ad" action="save.php" method="post" onsubmit="return validate(this);">

<strong>Date:</strong><br> <input type="text" id="date" name="date" value="<?php echo date("mdy"); ?>" maxlength="6" size="6"><br>
<strong>Zincfin:</strong><br> <input type="text" id="zincfin" name="zincfin" value="<?php if($editing){ echo substr($ad['tracker'],-4); }else{ echo $form->highestZincfin() + 1; }  ?>" maxlength="12" size="12">(highest current ad number is <?php echo $form->highestZincfin(); ?>)<br>
<strong>Target:</strong><br>
<select name="target">
<?php
if($editing)
	$form->populate("targets","target_id","target_name",$form->getTarget($ad['target']));
else
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
if($editing)
	$form->populate("products","product_id","product_name",$products[1][0]['product_id']);
else
	$form->populate("products","product_id","product_name");
?>

</select>
<br>
<strong>Hero 1:</strong><br> 
<select name="hero1">
<?php
if($editing)
	$form->populate("images","image_id","image_name",$form->fetchImageIdByName($ad['image_1']));
else
	$form->populate("images","image_id","image_name");
?>
</select>
<br>
<strong>Headline 1:</strong><br> <input type="text" id="headline1" name="headline1" value="<?php if($editing){ echo stripslashes($ad['head_1']); } ?>">
<input type="text" size="8" name="shortheadline1" id="shortheadline1" value="<?php if($editing){ echo $abbreviations[1]; } ?>">
<select name="h1_size">
<?php
if($editing)
	$form->populate("font_sizes","font_size","font_size",$form->fetchFontSizeBySize($ad['head_1_size']));
else
	$form->populate("font_sizes","font_size","font_size");
?>
</select>
<Br><strong>Product 2:</strong><br>
<select name="product2">
<?php
if($editing)
	$form->populate("products","product_id","product_name",$products[2][0]['product_id']);
else
	$form->populate("products","product_id","product_name");
?>
</select>
<br>
<strong>Hero 2:</strong><br>
<select name="hero2">
<?php
if($editing)
	$form->populate("images","image_id","image_name",$form->fetchImageIdByName($ad['image_2']));
else
	$form->populate("images","image_id","image_name");
?>
</select>
<br>
<strong>Headline 2:</strong><br> <input type="text" id="headline2" name="headline2" value="<?php if($editing){ echo stripslashes($ad['head_2']); } ?>">
<input type="text" size="8" id="shortheadline2" name="shortheadline2" value="<?php if($editing){ echo $abbreviations[2]; } ?>">
<select name="h2_size">
<?php
if($editing)
	$form->populate("font_sizes","font_size","font_size",$form->fetchFontSizeBySize($ad['head_2_size']));
else
	$form->populate("font_sizes","font_size","font_size");
?>
</select>
<br>
<?php 
if($editing)
{
	echo "<input type=\"hidden\" name=\"edit\" id=\"edit\" value=\"" . $_GET['id'] . "\" />";
}
?>
<input type="submit" value="Submit">
</form>

<script type="text/javascript">
function validate(form){
    var date = form.date.value;
    var zincfin = form.zincfin.value;

    if (date.length === 0) {
        alert("You must enter a date.");
        return false;
    }
 
    if (zincfin.length === 0) {
        alert("You must enter a zinfin number (4 digits).");
        return false;
    }
	
	if(form.headline1.value.length === 0) {
		alert("You must enter a first headline");
		return false;
	}
	
	if(form.headline2.value.length == 0) {
		alert("You must enter a second headline");
		return false;
	}
	
	if(form.shortheadline1.value.length === 0) {
		alert("You must enter an abbreviation for headline 1"); 
		return false;
	}
 
	if(form.shortheadline2.value.length === 0) {
		alert("You must enter an abbreviation for headline 2");
		return false;
	}
	
	var target = form.target;
	var product1 = form.product1;
	var product2 = form.product2;
	
	//if((target.options[target.selectedIndex].value > 1) && (product1.options[product1.selectedIndex].value == 180  || product1.options[product1.selectedIndex].value == 186 || product2.options[product2.selectedIndex].value == 180 || product2.options[product2.selectedIndex].value == 186)) {
	//	alert("You cannot run the given product(s) in the selected target");
	//	return false;
	//}	

    return true;
}
</script>


</body>
</html>