<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

//언어 세션
if($_GET['cn']==1) set_session($lang, 1);
else if($_GET['cn']==2) set_session($lang, 2);
?>

<script src="/js/jquery.bxslider.js" language="javascript" type="application/javascript"></script>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>YES TICKET</title>
	<!-- <link rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css"> -->
</head>
<body>
	<header style="margin-bottom:80px;">
		<article style="max-width:1180px; margin:auto;">
		<div id="topmenu">
			<ul class="fr">
				<? if ($is_admin) {?><a href="/adm"><li>ADM</li></a><? }?>
				<? if (get_session($lang)==1) {?><a href="/shop/index.php?cn=2"><li>ENGLISH</li></a><?}
				else if (get_session($lang)==2||get_session($lang)==0){?><a href="/shop/index.php?cn=1"><li>CHINESE</li></a><?}?>
				<a href="/bbs/board.php?bo_table=<? if (get_session($lang)==1) echo 'event_cn'; else echo 'event'; ?>"><li>EVENT</li></a>
				<a href="/bbs/board.php?bo_table=<? if (get_session($lang)==1) echo 'gallery_cn'; else echo 'gallery'; ?>"><li>GALLERY</li></a>
				<? if ($is_member) {?><a href="/bbs/member_confirm.php?url=register_form.php&page=0"><li>MY PAGE</li></a><? }?>
				<? if (!$is_member) {?><a href="/bbs/register_form.php"><li>SIGN UP</li></a><? }?>
				<? if ($is_member) {?><a href="/bbs/logout.php"><li>LOG OUT</li></a><? } else {?><a href="/bbs/login.php"><li <?php if($_SERVER['PHP_SELF']=="/bbs/login.php")echo'style="color:#604271;"'?>>LOG IN</li></a><? }?>
			</ul>
		</div>
		<div id="mainmenu">
			<ul>
				<a href="/shop"><img id="logo" src="/img/logo.png" alt="YesTicket Logo" class="fl"></a>
				<li><a href="/shop/list.php?ca_id=10">TICKET</a></li>
				<li><a href="/shop/list.php?ca_id=20">TOUR</a></li>
				<li><a href="/shop/list.php?ca_id=30">GOODS</a></li>
				<li><a href="/shop/list.php?ca_id=40">HOTEL</a></li>
				<li><a href="/shop/list.php?ca_id=50">CAR</a></li>
			</ul>
				<span id="hd_sch" class="fr">
            <h3>쇼핑몰 검색</h3>
            <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">

            <label for="sch_str" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
						<button type="submit" id="sch_submit"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
            <input type="text" name="q" placeholder="Tickets, Tour Programs, Goods, and so on..." value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" id="sch_str" required>

            </form>
            <script>
            function search_submit(f) {
                if (f.q.value.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.q.select();
                    f.q.focus();
                    return false;
                }
                return true;
            }
            </script>
        </span>
				<!-- <input id="searchbox" placeholder="Tickets, Tour Programs, Goods, and so on..."><img src=""> -->
		</div>
		</article>
	</header>

<div id="side_menu">
    <button type="button" id="btn_sidemenu" class="btn_sidemenu_cl"><i class="fa fa-outdent" aria-hidden="true"></i><span class="sound_only">사이드메뉴버튼</span></button>
    <div class="side_menu_wr">
        <?php echo outlogin('shop_basic'); // 아웃로그인 ?>
        <div class="side_menu_shop">
            <button type="button" class="btn_side_shop">오늘본상품<span class="count"><?php echo get_view_today_items_count(); ?></span></button>
            <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
            <button type="button" class="btn_side_shop">장바구니<span class="count"><?php echo get_boxcart_datas_count(); ?></span></button>
            <?php include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니 ?>
            <button type="button" class="btn_side_shop">위시리스트<span class="count"><?php echo get_wishlist_datas_count(); ?></span></button>
            <?php include_once(G5_SHOP_SKIN_PATH.'/boxwish.skin.php'); // 위시리스트 ?>
        </div>
        <?php include_once(G5_SHOP_SKIN_PATH.'/boxcommunity.skin.php'); // 커뮤니티 ?>

    </div>
</div>

<script>
$(function (){

    $(".btn_sidemenu_cl").on("click", function() {
        $(".side_menu_wr").toggle();
        $(".fa-outdent").toggleClass("fa-indent")
    });

    $(".btn_side_shop").on("click", function() {
        $(this).next(".op_area").slideToggle(300).siblings(".op_area").slideUp();
    });
});
</script>

<div>
    <!-- 콘텐츠 시작 { -->
    <div class="back_gray">
