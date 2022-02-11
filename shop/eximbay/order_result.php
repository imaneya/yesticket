<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
require_once(G5_SHOP_PATH.'/settle_eximbay.inc.php');

$secretKey  = $g_conf_site_key;	//set merchant's secretkey
$od_id      = clean_xss_tags($_REQUEST['ref']);
$rescode    = clean_xss_tags($_REQUEST['rescode']);
$resmsg     = clean_xss_tags($_REQUEST['resmsg']);

if ($rescode == '0000') { 

    $sql = " select * from {$g5['g5_shop_order_data_table']} where od_id = '$od_id' ";
    if($is_member)
        $sql .= " and mb_id = '{$member['mb_id']}' ";

    $sql .= " order by dt_time desc limit 1 ";

    $row = sql_fetch($sql, true);

    $od_time = $row['dt_time'];

    $data = unserialize(base64_decode($row['dt_data']));
    $od_ip              = $data['wz_ip'];
    $od_email           = $data['od_email'];
    $od_name            = $data['od_name'];
    $od_tel             = $data['od_tel'];
    $od_hp              = $data['od_hp'];
    $od_zip             = $data['od_zip'];
    $od_addr1           = $data['od_addr1'];
    $od_addr2           = $data['od_addr2'];
    $od_addr3           = $data['od_addr3'];
    $r_addr             = $data['r_addr'];
    $od_addr_jibeon     = $data['od_addr_jibeon'];
    $od_b_name          = $data['od_b_name'];
    $od_b_tel           = $data['od_b_tel'];
    $od_b_hp            = $data['od_b_hp'];
    $od_b_addr1         = $data['od_b_addr1'];
    $od_b_addr2         = $data['od_b_addr2'];
    $od_b_addr3         = $data['od_b_addr3'];
    $r_b_addr             = $data['r_b_addr'];
    $od_b_addr_jibeon   = $data['od_b_addr_jibeon'];
    $od_customsno       = $data['od_customsno'];
    $od_memo            = $data['od_memo'];
    $od_deposit_name    = $data['od_deposit_name'];
    $od_hope_date       = $data['od_hope_date'];
    $od_b_zip   = preg_replace('/[^0-9]/', '', $od_b_zip);
    $od_b_zip1  = substr($od_b_zip, 0, 3);
    $od_b_zip2  = substr($od_b_zip, 3);

    // orderview 에서 사용하기 위해 session에 넣고
    $uid = md5($od_id.$od_time.$od_ip);
    set_session('ss_orderview_uid', $uid);

    // 주문번호제거
    set_session('ss_order_id', '');

    // 기존자료 세션에서 제거
    if (get_session('ss_direct'))
        set_session('ss_cart_direct', '');

} 
else {

    $sw_direct = get_session("ss_direct") ? '1' : '';
    
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
        alert('결제가 실패되었습니다.', G5_SHOP_URL.'/orderform.php?sw_direct='.$sw_direct);
    }
}
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

    document.onkeydown = noRefresh ;

    window.onload = function (){
        gopage();
    }
    function gopage() {
        setTimeout(function(){ 
            <?php if (!is_mobile()) { // 모바일은 새창을 사용하지 않음?>
            opener.location.replace("<?php echo G5_SHOP_URL?>/orderinquiryview.php?od_id=<?php echo $od_id?>&uid=<?php echo $uid?>"); 
            this.close(); 
            <?php } else { ?>
            location.replace("<?php echo G5_SHOP_URL?>/orderinquiryview.php?od_id=<?php echo $od_id?>&uid=<?php echo $uid?>"); 
            <?php } ?>
        }, 
        1000);
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