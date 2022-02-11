<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<!-- 메인이미지 시작 { -->
<?php // echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<!-- } 메인이미지 끝 -->

<article>
	<?
		include_once('./slider.php');
	?>
	<section class="h300" style="background-color:#fff;">
		<div class="w1000">
			<section class="sct_wrap">
				<header>
					<h2 class="fl">Ticket</h2>
					<a class="fr" href="/shop/list.php?ca_id=10">See More</a>
				</header>
					<?php
						$list = new item_list();
						$list->set_category('10', 1);
						$list->set_list_mod(4);
						$list->set_list_row(1);
						$list->set_img_size(230, 230);
						$list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
						$list->set_view('it_img', true);
						$list->set_view('it_name', true);
						$list->set_view('it_basic', true);
						echo $list->run();
					?>
			</section>

			<section class="sct_wrap">
				<header>
					<h2 class="fl">Tour</h2>
					<a class="fr" href="/shop/list.php?ca_id=20">See More</a>
				</header>
					<?php
						$list = new item_list();
						$list->set_category('20', 1);
						$list->set_list_mod(4);
						$list->set_list_row(1);
						$list->set_img_size(230, 230);
						$list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
						$list->set_view('it_img', true);
						$list->set_view('it_name', true);
						$list->set_view('it_basic', true);
						echo $list->run();
					?>
			</section>

			<section class="sct_wrap">
				<header>
					<h2 class="fl">Goods</h2>
					<a class="fr" href="/shop/list.php?ca_id=30">See More</a>
				</header>
				<?php
						$list = new item_list();
						$list->set_category('30', 1);
						$list->set_list_mod(4);
						$list->set_list_row(1);
						$list->set_img_size(230, 230);
						$list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
						$list->set_view('it_img', true);
						$list->set_view('it_name', true);
						$list->set_view('it_basic', true);
						echo $list->run();
					?>
			</section>

			<section class="sct_wrap m1 p2 fl">
				<header>
					<h2 class="fl">Hotel</h2>
					<a class="fr" href="/shop/list.php?ca_id=40">See More</a>
				</header>
				<?php
						$list = new item_list();
						$list->set_category('40', 1);
						$list->set_list_mod(2);
						$list->set_list_row(1);
						$list->set_img_size(230, 230);
						$list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
						$list->set_view('it_img', true);
						$list->set_view('it_name', true);
						$list->set_view('it_basic', true);
						echo $list->run();
					?>
			</section>

			<section class="sct_wrap m1 p2 fl">
				<header>
					<h2 class="fl">Car</h2>
					<a class="fr" href="/shop/list.php?ca_id=50">See More</a>
				</header>
				<?php
						$list = new item_list();
						$list->set_category('50', 1);
						$list->set_list_mod(2);
						$list->set_list_row(1);
						$list->set_img_size(230, 230);
						$list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
						$list->set_view('it_img', true);
						$list->set_view('it_name', true);
						$list->set_view('it_basic', true);
						echo $list->run();
					?>
			</section>
		</div>
	</section>
	<section class="h300" style="background-color:#603779; color:#FFF;">
		<div class="w1000">
			<h1 id="sectitle" class="pad10">YESTICKET SNS</h1>
		</div>
	</section>

</article>
<style>
	.sct_wrap {padding:25px 0;}
	.sct_wrap p {margin-bottom:10px;}
	.sct_wrap a.fr {font-size:0.8em; color:#AAA; text-decoration: underline; margin:20px; text-transform: uppercase;}
	.sct_wrap h2 {font-size:1.6em; color:#EC8AAB; margin:10px auto;}
	.sct_wrap h3 {font-size:1.2em;}
	.sct_wrap h5 {font-size:0.9em; text-transform: uppercase; color:#AAA; font-weight: 600;}
	#sectitle {font-size:1.6em;}
</style>
<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>
