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
	<section class="back_gray mb50 mt50">
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
						$list->set_img_size(279, 394);
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
						$list->set_img_size(279, 394);
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
						$list->set_img_size(279, 394);
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
						$list->set_img_size(279, 394);
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
						$list->set_img_size(279, 394);
						$list->set_list_skin(G5_SHOP_SKIN_PATH.'/list.10.skin.php');
						$list->set_view('it_img', true);
						$list->set_view('it_name', true);
						$list->set_view('it_basic', true);
						echo $list->run();
					?>
			</section>
		</div>
	</section>
			<?
				include_once('./slider2.php');
			?>
</article>
<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>
