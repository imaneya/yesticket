<?php
include_once('./_common.php');

if ($_SERVER['HTTPS'] == 'on') {
    $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $url, true, 301);
    exit();
}

// 분류 위치
include_once(G5_SHOP_PATH.'/slider.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

// 주문상품 재고체크 js 파일
add_javascript('<script src="'.G5_JS_URL.'/shop.order.js"></script>', 0);

$sw_direct = preg_replace('/[^a-z0-9_]/i', '', $sw_direct);

// 모바일 주문인지
$is_mobile_order = is_mobile();

set_session("ss_direct", $sw_direct);

// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_cart_id = get_session('ss_cart_direct');
}
else {
    $tmp_cart_id = get_session('ss_cart_id');
}
if (get_cart_count($tmp_cart_id) == 0)
    alert('장바구니가 비어 있습니다.', G5_SHOP_URL.'/cart.php');

// 새로운 주문번호 생성
$od_id = get_uniqid();
set_session('ss_order_id', $od_id);
$s_cart_id = $tmp_cart_id;
if($default['de_pg_service'] == 'inicis' || $default['de_inicis_lpay_use'])
    set_session('ss_order_inicis_id', $od_id);

$g5['title'] = '주문서 작성';

if(G5_IS_MOBILE)
    include_once(G5_MSHOP_PATH.'/_head.php');
else
    include_once(G5_SHOP_PATH.'/_head.php');

// 희망배송일 지정
if ($default['de_hope_date_use']) {
    include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
}
// HOME > 1단계 > 2단계 ... > 6단계 분류
$sql = " select it_id from {$g5['g5_shop_cart_table']} where od_id = '$s_cart_id'  ";
$it_id = sql_fetch($sql);
$it_id = $it_id['it_id'];
$sql = " select a.*, b.ca_name, b.ca_use from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b where a.it_id = '$it_id' and a.ca_id = b.ca_id ";
$it = sql_fetch($sql);
$ca_id = $it['ca_id'];
?>
<div class="w1000">
<?
$nav_skin = $skin_dir.'/navigation.skin.php';
if(!is_file($nav_skin))
    $nav_skin = G5_SHOP_SKIN_PATH.'/navigation.skin.php';
include $nav_skin;

$cate_skin = $skin_dir.'/listcategory2.skin.php';
if(!is_file($cate_skin))
    $cate_skin = G5_SHOP_SKIN_PATH.'/listcategory2.skin.php';
include $cate_skin;

// 기기별 주문폼 include
if($is_mobile_order) {
    // $order_action_url = G5_HTTPS_MSHOP_URL.'/orderformupdate.php';
    // require_once(G5_MSHOP_PATH.'/orderform.sub.php');
    $order_action_url = G5_HTTPS_SHOP_URL.'/orderformupdate.php';
    require_once(G5_SHOP_PATH.'/orderform.sub.php');
} else {
    $order_action_url = G5_HTTPS_SHOP_URL.'/orderformupdate.php';
    require_once(G5_SHOP_PATH.'/orderform.sub.php');
}

?>
</div>
<?
if(G5_IS_MOBILE)
    include_once(G5_MSHOP_PATH.'/_tail.php');
else
    include_once(G5_SHOP_PATH.'/_tail.php');
?>
