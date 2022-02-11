<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<section id="slidera" style="position: relative; display:block; background-color:#fff; visibility:hidden; padding-bottom:11px;">
		<div style="position:absolute; bottom:0; width:8%; height:100%; z-index: 12;">
			<img style="width:100%; height:100%;" src="<?php echo G5_SHOP_URL.'/img/blur1.png'?>">
		</div>
		<div style="position:absolute; bottom:0; right:0; width:8%; height:100%; z-index: 12;">
			<img style="width:100%; height:100%;" src="<?php echo G5_SHOP_URL.'/img/blur2.png'?>">
		</div>
			<section class="slide_w" style="position:relative; z-index: 11;">
				<?php
				$list1 = new item_list();
				$list1->set_type(1);
				$list1->set_list_mod(15);
				$list1->set_list_row(1);
				$list1->set_img_size(234, 332);
				$list1->set_list_skin(G5_SHOP_SKIN_PATH.'/list.20.skin.php');
				$list1->set_view('it_img', true);
				$list1->set_view('it_id', false);
				$list1->set_view('it_basic', false);
				echo $list1->run();
				?>
			</section>
		<div style="position:absolute; bottom:0; height:55.9%; width:100%; background-color:#EC8AAB; z-index: 10;"></div>
</section>

<script>
    $(document).ready(function(){
      $('#slider').bxSlider({
			  minSlides:1,
			  maxSlides:15,
			  moveSlides:1,
			  slideWidth:234,
			  auto:1,
			  controls:0,
			  slideMargin:20,
			  pager:0,
			  pause:2500,
			  shrinkItems:1,
			  preloadImages:'all',
			  touchEnabled: 0,
				onSliderLoad: function(){
					$("#slidera").css("visibility", "visible").animate({opacity:1}); }
		  });
    });
</script>
<style>
	#slider {color:#FFF;}
	#slider img{width:100% !important; height:100% !important;}
	#slider h3{font-weight:600;}
</style>
