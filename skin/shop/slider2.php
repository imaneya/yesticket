<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH.'/shop.head.php');
// include_once(G5_URL.'/snsimg/insta.php');
include_once(G5_URL.'/snsimg/aa.php');
?>

<section style="background-color:#603779; color:#FFF; height:335px;">
		<h1 id="sectitle" class="w1000" style="font-size:1.9em; font-weight:500; padding:25px; padding-left:0px;">YESTICKET SNS</h1>
		<iframe src='<?php echo G5_URL.'/snsimg/insta.php'?>?width=100%&inline=25&view=25&toolbar=false' data-inwidget scrolling='no' frameborder='no'
			style='border:none;width:102%; height:254px; margin:-15px 0px 15px -10px; overflow:hidden;'></iframe>
</section>

<script>
    $(document).ready(function(){
      $('#sliderb').bxSlider({
			  minSlides:1,
			  maxSlides:15,
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
				onSliderLoad: function(){
					$("#sliderb").css("visibility", "visible").animate({opacity:1}); }
		  });
    });
</script>
<style>
	#sliderb {color:#FFF;}
	#sliderb img{width:245px !important; height:245px !important;}
	/* .slide_w{height:333px;} */
</style>
