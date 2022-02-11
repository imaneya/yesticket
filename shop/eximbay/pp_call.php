<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH.'/settle_eximbay.inc.php');

$pp_id              = clean_xss_tags($_POST['pp_id']);
$od_id              = $pp_id;
$pp_pg              = 'eximbay';
$pp_email           = get_email_address($pp_email);
$pp_settle_case     = clean_xss_tags($_POST['pp_settle_case']);
$good_mny           = clean_xss_tags($_POST['good_mny']);
$eb_product         = clean_xss_tags($_POST['eb_product']);
$buyer              = clean_xss_tags($_POST['pp_name']);
$pp_hp              = clean_xss_tags($_POST['pp_hp']);
$email              = clean_xss_tags($_POST['pp_email']);
$eb_goods_cnt       = clean_xss_tags($_POST['eb_goods_cnt']);
$g_conf_paymethod   = $pp_settle_case; // 결제방식

// 개인결제 정보
$pp_check = false;
$sql = " select * from {$g5['g5_shop_personalpay_table']} where pp_id = '$od_id' and pp_use = '1' ";
$pp = sql_fetch($sql);
if(!$pp['pp_id']) {
    if (!is_mobile()) { 
        alert_close('개인결제 정보가 존재하지 않습니다.');
    }
    else {
        alert('개인결제 정보가 존재하지 않습니다.');
    }
}

if($pp['pp_tno']) {
    if (!is_mobile()) { 
        alert_close('이미 결제하신 개인결제 내역입니다.');
    }
    else {
        alert('이미 결제하신 개인결제 내역입니다.');
    }
}

$amt = (int)$pp['pp_price'];
if (!$amt) {
    if (!is_mobile()) { 
        alert_close('결제하실 금액이 없습니다.');
    }
    else {
        alert('결제하실 금액이 없습니다.');
    }
}

$hash_data = md5($od_id.$good_mny.$pp['pp_time']);
if($od_id != get_session('ss_personalpay_id') || $hash_data != get_session('ss_personalpay_hash'))
    die('개인결제 정보가 올바르지 않습니다.');

// 결제정보 입력
$sql = " update {$g5['g5_shop_personalpay_table']}
            set pp_email            = '$pp_email',
                pp_hp               = '$pp_hp',
                pp_pg               = '$pp_pg',
                pp_settle_case      = '신용카드'
            where pp_id = '{$pp['pp_id']}' ";
$result = sql_query($sql, false);

// 개인결제번호제거
set_session('ss_personalpay_id', '');
set_session('ss_personalpay_hash', '');

$uid = md5($pp['pp_id'].$pp['pp_time'].$_SERVER['REMOTE_ADDR']);
set_session('ss_personalpay_uid', $uid);

if ($g_conf_paymethod == 'P141' && is_mobile()) { // 결제환경이 모바일일경우 weChat 은 P142 로 변경한다.
    $g_conf_paymethod = 'P142'; // INAPP 결제
} 

$fgdate = array();
$fgdate['ver']                   = $g_conf_ver;
$fgdate['txntype']               = 'PAYMENT';
$fgdate['charset']               = 'UTF-8';
$fgdate['statusurl']             = G5_SHOP_URL.'/eximbay/pg_hub.php';
$fgdate['returnurl']             = G5_SHOP_URL.'/eximbay/pp_result.php';
$fgdate['dm_shipTo_country']     = $g_ship_country;
$fgdate['dm_shipTo_phoneNumber'] = $pp_hp;
$fgdate['mid']                   = $g_conf_site_cd;
$fgdate['ref']                   = $od_id;
$fgdate['ostype']                = is_mobile() ? 'M' : 'P';
$fgdate['displaytype']           = 'P'; // P: popup (default)/ I: iframe(layer) / R: Page redirect
$fgdate['cur']                   = $g_conf_currency;
$fgdate['amt']                   = $amt;
$fgdate['shop']                  = $default['de_admin_company_name'];
$fgdate['buyer']                 = $buyer;
$fgdate['email']                 = $email;
$fgdate['tel']                   = $pp_hp;
$fgdate['lang']                  = $g_conf_language;
$fgdate['paymethod']             = $g_conf_paymethod;
$fgdate['autoclose']             = 'Y';
$fgdate['item_0_product']        = $eb_product;
$fgdate['item_0_quantity']       = $eb_goods_cnt;
$fgdate['item_0_unitPrice']      = $amt;

$sortingParams = ''; // 파라미터 정렬 관련
$hashMap = array();

foreach($fgdate as $Key => $value) {
    $hashMap[$Key]  = $value;
}
$size = count($hashMap);
ksort($hashMap);
$counter = 0;
foreach ($hashMap as $key => $val) {
    if ($counter == $size-1) {
        $sortingParams .= $key.'='.$val;
    }
    else {
        $sortingParams .= $key.'='.$val.'&';
    }
    ++$counter;
}

$linkBuf = $g_conf_site_key.'?'. $sortingParams;
$fgkey = hash('sha256', $linkBuf);

include_once(G5_PATH.'/head.sub.php');
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