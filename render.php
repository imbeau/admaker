<?php

include_once("renderHandler.php");

$handler = new renderHandler();


$date = "";
if(isset($_POST['date']))
{
	$date = $_POST['date'];
}
elseif(isset($_GET['date']))
{
	$date = $_GET['date'];
}

?>



<html>
<head>

	<style type="text/css">
		#meta_container { width:300px; height:250px; padding:0; position:relative; background-color:#fff; }
		#container { width:274px; height:224px; border:1px solid #999999; padding:10px 12px; z-index:0; position:relative; }
		#imgs_container { height:155px; width:274px; float:left; display:inline-block; z-index:0; position:relative; }
		.img { float:left; display:inline-block; width:130px; height:155px; z-index:0; position:relative; }
		#img_left { width:144px; }
		#img_right { width:130px; }
		#brands_container { height:14px; width:274px; float:left; display:inline-block; padding-top:2px; z-index:0; position:relative; }
		.brand_container { float:left; display:inline-block; width:130px; height:14px; z-index:0; position:relative; }
		#brand_right { margin-left:14px; }
		.brand { float:left; display:inline-block; text-align:right; font:9px Arial, Helvetica, sans-serif; color:#828282; width:130px; z-index:0; position:relative; }
		#heads_container { height:49px; width:274px; float:left; display:inline-block; margin-top:4px; z-index:0; position:relative; }
		.head_container { float:left; display:inline-block; width:130px; height:53px; z-index:0; position:relative; }
		#head_left { width:136px; }
		.head { float:left; display:inline-block; font:bold 16px Arial, Helvetica, sans-serif; color:#000; width:130px; line-height:16px; z-index:0; position:relative; }
		#divider { float:left; display:inline-block; height:53px; width:7px; border-left:1px dotted #d3d3d3; z-index:0; position:relative; }
		#link_left { float:left; display:inline-block; height:250px; width:150px; display:block; position:absolute; top:0; left:0; background:url(http://imgs.zincfin.com/blank.gif) repeat; }
		#link_right { float:left; display:inline-block; height:250px; width:150px; display:block; position:absolute; top:0; left:150px; z-index:1000; background:url(http://imgs.zincfin.com/blank.gif) repeat; }
	</style>

	<script type="text/javascript">
		function hoverOverLeft(id) {
			document.getElementById(id).style.color = "#3399ff";
		}
		function hoverOutLeft(id) {
			document.getElementById(id).style.color = "#000";
		}
		function hoverOverRight(id) {
			document.getElementById(id).style.color = "#3399ff";
		}
		function hoverOutRight(id) {
			document.getElementById(id).style.color = "#000";
		}
	</script>

    <script  type="text/javascript">
    	function selectAll(id) {
		    document.getElementById(id).focus();
		    document.getElementById(id).select();
	}
    </script>

</head>
<body>
<form name="render" action="render.php" method="post">
<strong>Date:</strong><br> <input type="text" name="date" value="<?php echo $date; ?>"><br>
<input type="submit" value="Submit">
</form>
<?php


if($date)
{

	if(($date ==""))
		die("Please enter a date!");
	$ads = $handler->fetchAds($date);
	echo "<h1>Viewing Ads for the " . $date . " Homepage</h1><hr>";
	$ad_count = 1;
	foreach($ads as $ad)
	{

		$image1_url = $handler->fetchImageUrl($ad['image_1']);
		$image2_url = $handler->fetchImageUrl($ad['image_2']);
		$image_domain = "http://imgs.zincfin.com/";
?>


			<div style="float:left; margin:25px 0; width:1300px; height:250px; clear:both;">
			<div style="float:left; width:300px; height:250px;">
				<div id="meta_container">
					<div id="container">
						<div id="imgs_container">
							<div class="img" id="img_left"><img src="<?php  echo $image_domain . $image1_url; ?>" width="130" height="155" border="0" alt="" /></div>
							<div class="img" id="img_right"><img src="<?php echo $image_domain . $image2_url; ?>" width="130" height="155" border="0" alt="" /></div>
						</div>
						<div id="brands_container">
							<div class="brand_container">
								<div class="brand"><?php echo $ad['brand_1']; ?></div>
							</div>
							<div class="brand_container" id="brand_right">
								<div class="brand"><?php echo $ad['brand_2']; ?></div>
							</div>
						</div>
						<div id="heads_container">
							<div class="head_container" id="head_left">
					            <div class="head" id="headl<?php echo $ad_count; ?>"
					            <?php echo $handler->getHeadlineSizeHtml($ad['head_1_size']); ?> <?php echo $ad['head_1']; ?>
								</div>
							</div>
							<div id="divider"></div>
							<div class="head_container">
					            <div class="head" id="headr<?php echo $ad_count; ?>"
					            <?php echo $handler->getHeadlineSizeHtml($ad['head_2_size']) . $ad['head_2']; ?>
					        	</div>
							</div>
						</div>
					</div>
					<a href="<?php echo "%ZZECLICK%" . $ad['link_1']; ?>" target="_blank" id="link_left" onmouseover="hoverOverLeft('headl<?php echo $ad_count; ?>')" onmouseout="hoverOutLeft('headl<?php echo $ad_count; ?>')"></a>
					<a href="<?php echo "%ZZECLICK%" . $ad['link_2']; ?>" target="_blank" id="link_right" onmouseover="hoverOverRight('headr<?php echo $ad_count; ?>')" onmouseout="hoverOutRight('headr<?php echo $ad_count; ?>')"></a>
				</div>
			</div>
			<div style="float:left; width:300px; height:250px; margin-left:50px;">
				<textarea id="namebox<?php echo $ad_count; ?>" style="width:300px; height:240px;" onclick="selectAll('namebox<?php echo $ad_count; ?>')"><?php echo "HTML_" . $ad['ad_name']; ?></textarea>
			</div>
			<div style="float:left; width:300px; height:250px; margin-left:25px;">
				<textarea id="copybox<?php echo $ad_count; ?>" style="width:300px; height:240px;" onclick="selectAll('copybox<?php echo $ad_count; ?>')"><script type="text/javascript" src="http://www.zincfin.com/<?php echo $ad['tracker']; ?>"></script><style type="text/css">#meta_container{width:300px;height:250px;padding:0;position:relative;background-color:#fff;}#container{width:274px;height:224px;border:1px solid #999999;padding:10px 12px;z-index:0;position:relative;}#imgs_container{height:155px;width:274px;float:left;display:inline-block;z-index:0;position:relative;}.img{float:left;display:inline-block;width:130px;height:155px;z-index:0;position:relative;}#img_left{width:144px;}#img_right{width:130px;}#brands_container{height:14px;width:274px;float:left;display:inline-block;padding-top:2px;z-index:0;position:relative;}.brand_container{float:left;display:inline-block;width:130px;height:14px;z-index:0;position:relative;}#brand_right{margin-left:14px;}.brand{float:left;display:inline-block;text-align:right;font:9px Arial, Helvetica, sans-serif;color:#828282;width:130px;z-index:0;position:relative;}#heads_container{height:49px;width:274px;float:left;display:inline-block;margin-top:4px;z-index:0;position:relative;}.head_container{float:left;display:inline-block;width:130px;height:53px;z-index:0;position:relative;}#head_left{width:136px;}.head{float:left;display:inline-block;font:bold 16px Arial, Helvetica, sans-serif;color:#000;width:130px;line-height:16px;z-index:0;position:relative;}#headr{font-size:15px;}#divider{float:left;display:inline-block;height:53px;width:7px;border-left:1px dotted #d3d3d3;z-index:0;position:relative;}#link_left{float:left;display:inline-block;height:250px;width:150px;display:block;position:absolute;top:0;left:0;background:url(http://imgs.zincfin.com/blank.gif) repeat;}#link_right{float:left;display:inline-block;height:250px;width:150px;display:block;position:absolute;top:0;left:150px;z-index:1000;background:url(http://imgs.zincfin.com/blank.gif) repeat;}</style><script type="text/javascript">function hoverOverLeft(){document.getElementById("headl").style.color="#3399ff";}function hoverOutLeft(){document.getElementById("headl").style.color="#000";}function hoverOverRight(){document.getElementById("headr").style.color="#3399ff";}function hoverOutRight(){document.getElementById("headr").style.color="#000";}</script><div id="meta_container"><div id="container"><div id="imgs_container"><div class="img" id="img_left"><img src="<?php echo $image_domain . $image1_url; ?>" width="130" height="155" border="0" alt=""/></div><div class="img" id="img_right"><img src="<?php echo $image_domain . $image2_url; ?>" width="130" height="155" border="0" alt=""/></div></div><div id="brands_container"><div class="brand_container"><div class="brand"><?php echo $ad['brand_1']; ?></div></div><div class="brand_container" id="brand_right"><div class="brand"><?php echo $ad['brand_2']; ?></div></div></div><div id="heads_container"><div class="head_container" id="head_left"><div class="head" id="headl"<div class="head" id="headl"<?php echo $handler->getHeadlineSizeHtml($ad['head_1_size']) . $ad['head_1'];?></div></div><div id="divider"></div><div class="head_container"><div class="head" id="headr"<?php echo $handler->getHeadlineSizeHtml($ad['head_2_size']) . $ad['head_2'];?></div></div></div><a href="<?php echo "%ZZECLICK%" . $ad['link_1']; ?>" target="_blank" id="link_left" onmouseover="hoverOverLeft()" onmouseout="hoverOutLeft()"></a><a href="<?php echo "%ZZECLICK%" . $ad['link_2']; ?>" target="_blank" id="link_right" onmouseover="hoverOverRight()" onmouseout="hoverOutRight()"></a></div></textarea>
			</div>
			<!-- Start ZincFin Separate
			<div style="float:left; width:300px; height:250px; margin-left:25px;">
				<textarea id="zincbox1" style="width:300px; height:240px;" onclick="selectAll('zincbox1')">http://www.zincfin.com/301990001822</textarea>
			</div>
			End ZincFin Separate -->
			<div style="float:left; width:300px; height:220px; margin-left:25px;">
				<textarea id="blinkbox<?php echo $ad_count; ?>" style="width:300px; height:240px;" onclick="selectAll('blinkbox<?php echo $ad_count; ?>')"><?php echo $ad['link_backup']; ?></textarea>
				<a href="create.php?action=edit&id=<?php echo $ad['uid']; ?>">Edit this ad >></a>
			</div>
		</div>


<?php
$ad_count++;
	}
}
?>



</body>
</html>