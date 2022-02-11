<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
require_once(G5_SHOP_PATH.'/settle_eximbay.inc.php');

$secretKey  = $g_conf_site_key;	//set merchant's secretkey
$pp_id      = clean_xss_tags($_REQUEST['ref']);
$rescode    = clean_xss_tags($_REQUEST['rescode']);
$resmsg     = clean_xss_tags($_REQUEST['resmsg']);

if ($rescode == '0000') { 
    $uid = get_session('ss_personalpay_uid');
} 
else {

    if (!is_mobile()) { 
        ?>
        <script type="text/javascript">
        <!--
            alert('결제가 실패되었습니다.');
            $('#display_pay_button', opener.document).show();
            $('#display_pay_process', opener.document).hide();
            this.close();
        //-->
        </script>
        <?php
        exit;
    }
    else {
        alert('결제가 실패되었습니다.', G5_SHOP_URL.'/personalpayform.php?pp_id='.$pp_id);
    }
}
?>

    <script type="text/javascript">
    <!--
    window.onload = function (){
        gopage();
    }
    function gopage() {
        setTimeout(function(){ 
            <?php if (!is_mobile()) { // 모바일은 새창을 사용하지 않음?>
            opener.location.replace("<?php echo G5_SHOP_URL?>/personalpayresult.php?pp_id=<?php echo $pp_id?>&uid=<?php echo $uid?>"); 
            this.close(); 
            <?php } else { ?>
            location.replace("<?php echo G5_SHOP_URL?>/personalpayresult.php?pp_id=<?php echo $pp_id?>&uid=<?php echo $uid?>"); 
            <?php } ?>
        }, 
        2000);
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

<?php
include_once(G5_PATH.'/tail.sub.php');
?>
