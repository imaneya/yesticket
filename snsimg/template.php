<?php
/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        template.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * https://inwidget.ru/MIT-license.txt
 *
 * @link https://inwidget.ru
 * @copyright 2014-2020 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @package inWidget
 *
 */

if(!$inWidget instanceof \inWidget\Core) {
	throw new \Exception('inWidget object was not initialised.');
}

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>inWidget - free Instagram widget for your site!</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?= $inWidget->langName ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="stylesheet" type="text/css" href="<?= $inWidget->skinPath.$inWidget->skinName ?>.css?r2" media="all" />
		<?php if($inWidget->adaptive === false): ?>
		<?php
			else: require_once 'plugins/adaptive.php';
			endif;
		?>
		<link rel="stylesheet" href="bxslider/src/css/jquery.bxslider.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="bxslider/dist/jquery.bxslider.min.js"></script>

		<script>
  		$(document).ready(function(){
    		$('.slider').bxSlider(({
			  	minSlides:1,
			  	maxSlides:11,
			  	moveSlides:1,
			  	slideWidth:245,
			  	auto:1,
			  	controls:0,
			  	slideMargin:20,
			  	pager:0,
			  	pause:2500,
			  	shrinkItems:1,
			  	preloadImages:'all',
			  	touchEnabled: 0,
					responsive:true,
					onSliderLoad: function(){
						$("#slider").css("visibility", "visible").animate({opacity:1}); }
		  	}));
  		});
		</script>
	</head>
<body>
<div id="widget" class="widget">
	<?php if($inWidget->toolbar == true): ?>
		<?php endif;
		$i = 0;
		$count = $inWidget->countAvailableImages($inWidget->data->images);
		if($count>0) {
			if($inWidget->config['imgRandom'] === true) shuffle($inWidget->data->images);
			echo '<div id="widgetData" class="data slider">';
				foreach ($inWidget->data->images as $key=>$item){
					if($inWidget->isBannedUserId($item->authorId) === true) continue;
					switch ($inWidget->preview){
						case 'large':
							$thumbnail = $item->large;
							break;
						case 'fullsize':
							$thumbnail = $item->fullsize;
							break;
						default:
							$thumbnail = $item->small;
					}
					echo '<div style="position:relative;"><a href="'.$item->link.'" class="image" target="_blank"><span style="background-image:url('.$thumbnail.');">&nbsp;</span></a>
					<img src="skins/i/icon_instagram2.png" width="32px" height="32px" style="position:absolute; z-index:11; bottom:0; right:0; margin-bottom:20px; margin-right:10px;"></div>';
					$i++;
					if($i >= $inWidget->view) break;
				}
			echo '</div>';
		}
		else {
			if(!empty($inWidget->config['HASHTAG'])) {
				$inWidget->lang['imgEmptyByHash'] = str_replace(
					'{$hashtag}',
					$inWidget->config['HASHTAG'],
					$inWidget->lang['imgEmptyByHash']
				);
				echo '<div class="empty">'.$inWidget->lang['imgEmptyByHash'].'</div>';
			}
			else echo '<div class="empty">'.$inWidget->lang['imgEmpty'].'</div>';
		}
	?>
</div>
<?php if(isset($inWidget->data->isBackup)): ?>
	<div class='cacheError'>
		<?= $inWidget->lang['errorCache'].' '.date('Y-m-d H:i:s',$inWidget->data->lastupdate) .' <br /> '. $inWidget->lang['updateNeeded'] ?>
	</div>
<?php endif;?>
</body>
</html>
<!--
	inWidget - free Instagram widget for your site!
	https://inwidget.ru
	© Alexandr Kazarmshchikov
-->
