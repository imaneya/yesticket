<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
require_once(G5_SHOP_PATH.'/settle_eximbay.inc.php');

$secretKey  = $g_conf_site_key;	//set merchant's secretkey 
$ver        = clean_xss_tags($_POST['ver']);
$mid        = clean_xss_tags($_POST['mid']);
$txntype    = clean_xss_tags($_POST['txntype']);
$ref        = clean_xss_tags($_POST['ref']);
$cur        = clean_xss_tags($_POST['cur']);
$amt        = clean_xss_tags($_POST['amt']);
$shop       = clean_xss_tags($_POST['shop']);
$buyer      = clean_xss_tags($_POST['buyer']);
$tel        = clean_xss_tags($_POST['tel']);
$email      = clean_xss_tags($_POST['email']);
$product    = clean_xss_tags($_POST['product']);
$lang       = clean_xss_tags($_POST['lang']);
$param1     = clean_xss_tags($_POST['param1']);
$param2     = clean_xss_tags($_POST['param2']);
$param3     = clean_xss_tags($_POST['param3']);

$transid    = clean_xss_tags($_POST['transid']);
$rescode    = clean_xss_tags($_POST['rescode']);
$resmsg     = clean_xss_tags($_POST['resmsg']);
$authcode   = clean_xss_tags($_POST['authcode']);
$cardco     = clean_xss_tags($_POST['cardco']);
$resdt      = clean_xss_tags($_POST['resdt']);
$cardholder = clean_xss_tags($_POST['cardholder']);
$fgkey      = clean_xss_tags($_POST['fgkey']);
$cardno1    = clean_xss_tags($_POST['cardno1']);
$cardno4    = clean_xss_tags($_POST['cardno4']);
$paymethod  = clean_xss_tags($_POST['paymethod']); // 결제수단 코드


// 로그기록
$log_txt = date('Y-m-d H:i:s', time());
$log_txt .= '|IP : '.getenv("REMOTE_ADDR").' ';
foreach($_POST as $uk=>$uv) {
    $log_txt .= "\$_POST['".$uk."'] = '".iconv("euc-kr", "utf-8", $uv)."';";
}

foreach($_GET as $uk=>$uv) {
    $log_txt .= "\$_GET['".$uk."'] = '".iconv("euc-kr", "utf-8", $uv)."';";
}

$log_dir = G5_DATA_PATH.'/eximbaylog'; 

@mkdir($log_dir, G5_DIR_PERMISSION);
@chmod($log_dir, G5_DIR_PERMISSION);

wz_fwrite_log($log_dir."/query_".date("Ymd").".log", $log_txt);

function wz_fwrite_log($log_dir, $error) { 
    $log_file = fopen($log_dir, "a");
    fwrite($log_file, $error."\r\n");
    fclose($log_file);
}

if ($rescode == '0000') { // 성공

    $hashMap = array();
    foreach ($_POST as $Key => $value) {
        if ($Key == 'fgkey') {
            continue;
        }
        $hashMap[$Key] = $value;
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

    $linkBuf = $secretKey.'?'.$sortingParams;
    $newFgkey = hash('sha256', $linkBuf);
    
    if (strtolower($fgkey) != $newFgkey) {
        die('rescode!=0000');
    }

    $od_id      = $ref;
    $tno        = $transid;
    $app_no     = $authcode;
    $amount     = $amt;
    $app_time   = $resdt;
    $card_name  = $cardco;
    $od_eximbay_cur  = $cur; // 결제취소시 반드시 필요.
    $od_settle_case  = '신용카드'; 

    $error = "";
    
    $personal = false;
    $sql = " select pp_id, od_id, pp_price, pp_tno from {$g5['g5_shop_personalpay_table']} where pp_id = '$od_id' and pp_use = '1' ";
    $pp = sql_fetch($sql);
    if($pp['pp_id']) {

        $order_price        = $pp['pp_price']; // 결제해야할 미수금
        $od_tno             = $pp['pp_tno']; // 승인번호
        $od_name            = $pp['pp_name'];
        $i_price            = $order_price;
        $personal           = true;
        
    }
    else {

        $sql = " select * from {$g5['g5_shop_order_data_table']} where od_id = '$od_id' order by dt_time desc limit 1 ";
        $row = sql_fetch($sql);
        if (!$row['od_id']) {
            $error = $log_txt." 주문정보가 존재하지 않음.";
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
            die('rescode!=0000');
        }

        $od_time = $row['dt_time'];
        
        $data = unserialize(base64_decode($row['dt_data']));
        $tmp_cart_id = $row['cart_id'];

        if (get_cart_count($tmp_cart_id) == 0) { // 장바구니에 담기
            $error = $log_txt." 장바구니가 비어 있음.";
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
            die('rescode!=0000');
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
            if ($row['ct_qty'] > $it_stock_qty) {
                $error = $log_txt." 재고수량 부족.";
                include './pg_error_mail.php';
                wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
                die('rescode!=0000');
            }
        }

        $i_price            = (int)$data['od_price'];
        $od_send_cost       = (int)$data['od_send_cost'];
        $od_send_cost2      = (int)$data['od_send_cost2'];
        $od_send_coupon     = (int)$data['od_send_coupon'];
        $od_temp_point      = (int)$data['od_temp_point'];
        $mb_id              = trim($data['wz_user_id']);
        $od_ip              = trim($data['wz_ip']);
        $_POST['od_pwd']    = trim($data['od_pwd']);

        $i_send_cost        = $od_send_cost;
        $i_send_cost2       = $od_send_cost2;
        $i_send_coupon      = $od_send_coupon;
        $i_temp_point       = $od_temp_point;
        
        $od_b_zip       = $data['od_b_zip'];
        $escw_yn        = $data['escw_yn'];

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
        $r_b_addr           = $data['r_b_addr'];
        $od_b_addr_jibeon   = $data['od_b_addr_jibeon'];
        $od_customsno       = $data['od_customsno'];
        $od_memo            = $data['od_memo'];
        $od_deposit_name    = $data['od_deposit_name'];
        $od_hope_date       = $data['od_hope_date'];

        $_POST['it_id']             = $data['it_id'];
        $_POST['cp_id']             = $data['cp_id'];
        $_POST['od_cp_id']          = $data['od_cp_id'];
        $_POST['sc_cp_id']          = $data['sc_cp_id'];
        $_POST['comm_tax_mny']      = $data['comm_tax_mny'];
        $_POST['comm_vat_mny']      = $data['comm_vat_mny'];
        $_POST['comm_free_mny']     = $data['comm_free_mny'];
        $od_mobile                  = $data['wz_mobile'];

        $is_member = false;
        if ($mb_id && $mb_id != 'guest') { 
            $is_member = true;
            $member = get_member($mb_id, 'mb_id, mb_point, mb_password');
        } 
            
        // 주문금액이 상이함
        $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as od_price,
                      COUNT(distinct it_id) as cart_count
                    from {$g5['g5_shop_cart_table']} where od_id = '$tmp_cart_id' and ct_select = '1' ";
        $row = sql_fetch($sql);
        $tot_ct_price = $row['od_price'];
        $cart_count = $row['cart_count'];
        $tot_od_price = $tot_ct_price;

        // 쿠폰금액계산
        $tot_cp_price = 0;
        if($is_member) {
            // 상품쿠폰
            $tot_it_cp_price = $tot_od_cp_price = 0;
            $it_cp_cnt = count($_POST['cp_id']);
            $arr_it_cp_prc = array();
            for($i=0; $i<$it_cp_cnt; $i++) {
                $cid = $_POST['cp_id'][$i];
                $it_id = $_POST['it_id'][$i];
                $sql = " select cp_id, cp_method, cp_target, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum
                            from {$g5['g5_shop_coupon_table']}
                            where cp_id = '$cid'
                              and mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_method IN ( 0, 1 ) ";
                $cp = sql_fetch($sql);
                if(!$cp['cp_id'])
                    continue;

                // 사용한 쿠폰인지
                if(is_used_coupon($member['mb_id'], $cp['cp_id']))
                    continue;

                // 분류할인인지
                if($cp['cp_method']) {
                    $sql2 = " select it_id, ca_id, ca_id2, ca_id3
                                from {$g5['g5_shop_item_table']}
                                where it_id = '$it_id' ";
                    $row2 = sql_fetch($sql2);

                    if(!$row2['it_id'])
                        continue;

                    if($row2['ca_id'] != $cp['cp_target'] && $row2['ca_id2'] != $cp['cp_target'] && $row2['ca_id3'] != $cp['cp_target'])
                        continue;
                } else {
                    if($cp['cp_target'] != $it_id)
                        continue;
                }

                // 상품금액
                $sql = " select SUM( IF(io_type = '1', io_price * ct_qty, (ct_price + io_price) * ct_qty)) as sum_price
                            from {$g5['g5_shop_cart_table']}
                            where od_id = '$tmp_cart_id'
                              and it_id = '$it_id'
                              and ct_select = '1' ";
                $ct = sql_fetch($sql);
                $item_price = $ct['sum_price'];

                if($cp['cp_minimum'] > $item_price)
                    continue;

                $dc = 0;
                if($cp['cp_type']) {
                    $dc = floor(($item_price * ($cp['cp_price'] / 100)) / $cp['cp_trunc']) * $cp['cp_trunc'];
                } else {
                    $dc = $cp['cp_price'];
                }

                if($cp['cp_maximum'] && $dc > $cp['cp_maximum'])
                    $dc = $cp['cp_maximum'];

                if($item_price < $dc)
                    continue;

                $tot_it_cp_price += $dc;
                $arr_it_cp_prc[$it_id] = $dc;
            }

            $tot_od_price -= $tot_it_cp_price;

            // 주문쿠폰
            if($_POST['od_cp_id']) {
                $sql = " select cp_id, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum
                            from {$g5['g5_shop_coupon_table']}
                            where cp_id = '{$_POST['od_cp_id']}'
                              and mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_method = '2' ";
                $cp = sql_fetch($sql);

                // 사용한 쿠폰인지
                $cp_used = is_used_coupon($member['mb_id'], $cp['cp_id']);

                $dc = 0;
                if(!$cp_used && $cp['cp_id'] && ($cp['cp_minimum'] <= $tot_od_price)) {
                    if($cp['cp_type']) {
                        $dc = floor(($tot_od_price * ($cp['cp_price'] / 100)) / $cp['cp_trunc']) * $cp['cp_trunc'];
                    } else {
                        $dc = $cp['cp_price'];
                    }

                    if($cp['cp_maximum'] && $dc > $cp['cp_maximum'])
                        $dc = $cp['cp_maximum'];

                    if($tot_od_price < $dc)
                        die('Order coupon error.');

                    $tot_od_cp_price = $dc;
                    $tot_od_price -= $tot_od_cp_price;
                }
            }

            $tot_cp_price = $tot_it_cp_price + $tot_od_cp_price;
        }

        if ((int)($row['od_price'] - $tot_cp_price) !== $i_price) {
            $error = $log_txt." Error";
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
            die('rescode!=0000');
        }

        // 배송비가 상이함
        $send_cost = get_sendcost($tmp_cart_id);

        $tot_sc_cp_price = 0;
        if($is_member && $send_cost > 0) {
            // 배송쿠폰
            if($_POST['sc_cp_id']) {
                $sql = " select cp_id, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum
                            from {$g5['g5_shop_coupon_table']}
                            where cp_id = '{$_POST['sc_cp_id']}'
                              and mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '".G5_TIME_YMD."'
                              and cp_end >= '".G5_TIME_YMD."'
                              and cp_method = '3' ";
                $cp = sql_fetch($sql);

                // 사용한 쿠폰인지
                $cp_used = is_used_coupon($member['mb_id'], $cp['cp_id']);

                $dc = 0;
                if(!$cp_used && $cp['cp_id'] && ($cp['cp_minimum'] <= $tot_od_price)) {
                    if($cp['cp_type']) {
                        $dc = floor(($send_cost * ($cp['cp_price'] / 100)) / $cp['cp_trunc']) * $cp['cp_trunc'];
                    } else {
                        $dc = $cp['cp_price'];
                    }

                    if($cp['cp_maximum'] && $dc > $cp['cp_maximum'])
                        $dc = $cp['cp_maximum'];

                    if($dc > $send_cost)
                        $dc = $send_cost;

                    $tot_sc_cp_price = $dc;
                }
            }
        }

        if ((int)($send_cost - $tot_sc_cp_price) !== (int)($i_send_cost - $i_send_coupon)) {
            $error = $log_txt." Error..";
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
            die('rescode!=0000');
        }

        // 추가배송비가 상이함
        $od_b_zip   = preg_replace('/[^0-9]/', '', $od_b_zip);
        $od_b_zip1  = substr($od_b_zip, 0, 3);
        $od_b_zip2  = substr($od_b_zip, 3);
        $zipcode = $od_b_zip;
        $sql = " select sc_id, sc_price from {$g5['g5_shop_sendcost_table']} where sc_zip1 <= '$zipcode' and sc_zip2 >= '$zipcode' ";
        $tmp = sql_fetch($sql);
        if(!$tmp['sc_id'])
            $send_cost2 = 0;
        else
            $send_cost2 = (int)$tmp['sc_price'];
        if($send_cost2 !== $i_send_cost2) {
            $error = $log_txt." Error...";
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
            die('rescode!=0000');
        }

        // 결제포인트가 상이함
        // 회원이면서 포인트사용이면
        $temp_point = 0;
        if ($is_member && $config['cf_use_point'])
        {
            if($member['mb_point'] >= $default['de_settle_min_point']) {
                $temp_point = (int)$default['de_settle_max_point'];

                if($temp_point > (int)$tot_od_price)
                    $temp_point = (int)$tot_od_price;

                if($temp_point > (int)$member['mb_point'])
                    $temp_point = (int)$member['mb_point'];

                $point_unit = (int)$default['de_settle_point_unit'];
                $temp_point = (int)((int)($temp_point / $point_unit) * $point_unit);
            }
        }

        if (($i_temp_point > (int)$temp_point || $i_temp_point < 0) && $config['cf_use_point']) {
            $error = $log_txt." Error....";
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
            die('rescode!=0000');
        }

        if ($od_temp_point)
        {
            if ($member['mb_point'] < $od_temp_point) {
                $error = $log_txt." 회원님의 포인트가 부족하여 포인트로 결제 할 수 없습니다.";
                include './pg_error_mail.php';
                wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $error);
                die('rescode!=0000');
            }
        }

        $i_price = $i_price + $i_send_cost + $i_send_cost2 - $i_temp_point - $i_send_coupon;
        $order_price = $tot_od_price + $send_cost + $send_cost2 - $tot_sc_cp_price - $od_temp_point;
    }
    
    $od_tno             = $tno;
    $od_app_no          = $app_no;
    $od_receipt_price   = $amount;
    $od_receipt_point   = $i_temp_point;
    $od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
    $od_bank_account    = $card_name;
    $pg_price           = $amount;
    $od_misu            = $i_price - $od_receipt_price;
    if($od_misu == 0)
        $od_status      = '입금';

    $od_pg = 'eximbay';

    // 주문금액과 결제금액이 일치하는지 체크
    if($tno) {
        if((int)$order_price !== (int)$pg_price) {
            $cancel_msg = $log_txt.' 결제금액 불일치';
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $cancel_msg);
            die('rescode!=0000');
        }
    }
    
    if ($personal) { // 개인결제라면..

        // 결제정보 입력
        $sql = " update {$g5['g5_shop_personalpay_table']}
                    set pp_tno              = '$od_tno',
                        pp_app_no           = '$od_app_no',
                        pp_receipt_price    = '$pg_price',
                        pp_bank_account     = '$od_bank_account',
                        pp_deposit_name     = '$od_deposit_name',
                        pp_receipt_time     = '$od_receipt_time',
                        pp_receipt_ip       = '{$_SERVER['REMOTE_ADDR']}'
                    where pp_id = '{$pp['pp_id']}' ";
        $result = sql_query($sql, false);


        // 주문번호가 있으면 결제정보 반영
        if($pg_price > 0 && $pp['pp_id'] && $pp['od_id']) {

            $sql = " update {$g5['g5_shop_order_table']}
                        set od_receipt_price    = od_receipt_price + '$pg_price',
                            od_receipt_time     = '$od_receipt_time',
                            od_tno              = '$od_tno',
                            od_app_no           = '$od_app_no',
                            od_settle_case      = '$od_settle_case',
                            od_deposit_name     = '$od_deposit_name',
                            od_bank_account     = '$od_bank_account',
                            od_shop_memo = concat(od_shop_memo, \"\\n개인결제 ".$pp['pp_id']." 로 결제완료 - ".$od_receipt_time."\")
                        where od_id = '{$pp['od_id']}' ";
            $result = sql_query($sql, false);

            // 미수금 정보 업데이트
            $info = get_order_info($pp['od_id']);
       
            $sql = " update {$g5['g5_shop_order_table']}
                        set od_misu     = '{$info['od_misu']}' ";
            if($info['od_misu'] == 0)
                $sql .= " , od_status = '입금' ";
            $sql .= " where od_id = '{$pp['od_id']}' ";
            sql_query($sql, FALSE);

            // 장바구니 상태변경
            if($info['od_misu'] == 0) {
                $sql = " update {$g5['g5_shop_cart_table']}
                            set ct_status = '입금'
                            where od_id = '{$pp['od_id']}' ";
                sql_query($sql, FALSE);
            }
        }

    }
    else {

        if ($is_member)
            $od_pwd = $member['mb_password'];
        else
            $od_pwd = get_encrypt_string($_POST['od_pwd']);

        // 주문번호를 얻는다.
        //$od_id = get_session('ss_order_id'); // wetoz : 위에서 얻음.
        
        $od_escrow = 0;
        if($escw_yn == 'Y')
            $od_escrow = 1;

        // 복합과세 금액
        $od_tax_mny = round($i_price / 1.1);
        $od_vat_mny = $i_price - $od_tax_mny;
        $od_free_mny = 0;
        if($default['de_tax_flag_use']) {
            $od_tax_mny = (int)$_POST['comm_tax_mny'];
            $od_vat_mny = (int)$_POST['comm_vat_mny'];
            $od_free_mny = (int)$_POST['comm_free_mny'];
        }

        $od_email         = get_email_address($od_email);
        $od_name          = clean_xss_tags($od_name);
        $od_tel           = clean_xss_tags($od_tel);
        $od_hp            = clean_xss_tags($od_hp);
        $od_zip           = preg_replace('/[^0-9]/', '', $od_zip);
        $od_zip1          = substr($od_zip, 0, 3);
        $od_zip2          = substr($od_zip, 3);
        $od_addr1         = clean_xss_tags($od_addr1);
        $od_addr2         = clean_xss_tags($od_addr2);
        $od_addr3         = clean_xss_tags($od_addr3);
        $od_addr_jibeon   = clean_xss_tags($od_addr_jibeon);
        $od_b_name        = clean_xss_tags($od_b_name);
        $od_b_tel         = clean_xss_tags($od_b_tel);
        $od_b_hp          = clean_xss_tags($od_b_hp);
        $od_b_addr1       = clean_xss_tags($od_b_addr1);
        $od_b_addr2       = clean_xss_tags($od_b_addr2);
        $od_b_addr3       = clean_xss_tags($od_b_addr3);
        $od_b_addr_jibeon = clean_xss_tags($od_b_addr_jibeon);
        $od_memo          = clean_xss_tags($od_memo);
        $od_deposit_name  = clean_xss_tags($od_deposit_name);
        $od_tax_flag      = $default['de_tax_flag_use'];

            
        // 주문서에 입력
        $sql = " insert {$g5['g5_shop_order_table']}
                    set od_id             = '$od_id',
                        mb_id             = '{$member['mb_id']}',
                        od_pwd            = '$od_pwd',
                        od_name           = '$od_name',
                        od_email          = '$od_email',
                        od_tel            = '$od_tel',
                        od_hp             = '$od_hp',
                        od_zip1           = '$od_zip1',
                        od_zip2           = '$od_zip2',
                        od_addr1          = '$od_addr1',
                        od_addr2          = '$od_addr2',
                        od_addr3          = '$od_addr3',
                        r_addr            = '$r_addr',
                        od_addr_jibeon    = '$od_addr_jibeon',
                        od_b_name         = '$od_b_name',
                        od_b_tel          = '$od_b_tel',
                        od_b_hp           = '$od_b_hp',
                        od_b_zip1         = '$od_b_zip1',
                        od_b_zip2         = '$od_b_zip2',
                        od_b_addr1        = '$od_b_addr1',
                        od_b_addr2        = '$od_b_addr2',
                        od_b_addr3        = '$od_b_addr3',
                        r_b_addr          = '$r_b_addr',
                        od_b_addr_jibeon  = '$od_b_addr_jibeon',
                        od_deposit_name   = '$od_deposit_name',
                        od_memo           = '$od_memo',
                        od_cart_count     = '$cart_count',
                        od_cart_price     = '$tot_ct_price',
                        od_cart_coupon    = '$tot_it_cp_price',
                        od_send_cost      = '$od_send_cost',
                        od_send_coupon    = '$tot_sc_cp_price',
                        od_send_cost2     = '$od_send_cost2',
                        od_coupon         = '$tot_od_cp_price',
                        od_receipt_price  = '$od_receipt_price',
                        od_receipt_point  = '$od_receipt_point',
                        od_bank_account   = '$od_bank_account',
                        od_receipt_time   = '$od_receipt_time',
                        od_misu           = '$od_misu',
                        od_pg             = '$od_pg',
                        od_tno            = '$od_tno',
                        od_app_no         = '$od_app_no',
                        od_escrow         = '$od_escrow',
                        od_tax_flag       = '$od_tax_flag',
                        od_tax_mny        = '$od_tax_mny',
                        od_vat_mny        = '$od_vat_mny',
                        od_free_mny       = '$od_free_mny',
                        od_status         = '$od_status',
                        od_shop_memo      = '',
                        od_hope_date      = '$od_hope_date',
                        od_time           = '$od_time',
                        od_mobile         = '$od_mobile',
                        od_ip             = '$od_ip',
                        od_settle_case    = '$od_settle_case',
                        od_test           = '{$default['de_card_test']}',
                        od_eximbay_cur    = '$od_eximbay_cur'
                        ";
        $result = sql_query($sql, false);

        // 주문정보 입력 오류시 결제 취소
        if(!$result) {

            // 관리자에게 오류 알림 메일발송
            $error = $log_txt.' order';
            include G5_SHOP_PATH.'/ordererrormail.php';
            
            $cancel_msg = $log_txt.' 주문정보 입력 오류';
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $cancel_msg);
            die('rescode!=0000');
        }

          
        // 장바구니 상태변경
        // 신용카드로 주문하면서 신용카드 포인트 사용하지 않는다면 포인트 부여하지 않음
        $cart_status = $od_status;
        $sql_card_point = "";
        if ($od_receipt_price > 0 && !$default['de_card_point']) {
            $sql_card_point = " , ct_point = '0' ";
        }
        $sql = "update {$g5['g5_shop_cart_table']}
                   set od_id = '$od_id',
                       ct_status = '$cart_status'
                       $sql_card_point
                 where od_id = '$tmp_cart_id'
                   and ct_select = '1' ";
        $result = sql_query($sql, false);

        // 주문정보 입력 오류시 결제 취소
        if(!$result) {

            // 관리자에게 오류 알림 메일발송
            $error = $log_txt.' status';
            include G5_SHOP_PATH.'/ordererrormail.php';

            // 주문삭제
            sql_query(" delete from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");

            $cancel_msg = $log_txt.' 주문상태 변경 오류';
            include './pg_error_mail.php';
            wz_fwrite_log($log_dir."/log_".date("Ymd").".log", $cancel_msg);
            die('rescode!=0000');
        }

        // 회원이면서 포인트를 사용했다면 테이블에 사용을 추가
        if ($is_member && $od_receipt_point)
            insert_point($member['mb_id'], (-1) * $od_receipt_point, "주문번호 $od_id 결제");

        $od_memo = nl2br(htmlspecialchars2(stripslashes($od_memo))) . "&nbsp;";


        // 쿠폰사용내역기록
        if($is_member) {
            $it_cp_cnt = count($_POST['cp_id']);
            for($i=0; $i<$it_cp_cnt; $i++) {
                $cid = $_POST['cp_id'][$i];
                $cp_it_id = $_POST['it_id'][$i];
                $cp_prc = (int)$arr_it_cp_prc[$cp_it_id];

                if(trim($cid)) {
                    $sql = " insert into {$g5['g5_shop_coupon_log_table']}
                                set cp_id       = '$cid',
                                    mb_id       = '{$member['mb_id']}',
                                    od_id       = '$od_id',
                                    cp_price    = '$cp_prc',
                                    cl_datetime = '".G5_TIME_YMDHIS."' ";
                    sql_query($sql);
                }

                // 쿠폰사용금액 cart에 기록
                $cp_prc = (int)$arr_it_cp_prc[$cp_it_id];
                $sql = " update {$g5['g5_shop_cart_table']}
                            set cp_price = '$cp_prc'
                            where od_id = '$od_id'
                              and it_id = '$cp_it_id'
                              and ct_select = '1'
                            order by ct_id asc
                            limit 1 ";
                sql_query($sql);
            }

            if($_POST['od_cp_id']) {
                $sql = " insert into {$g5['g5_shop_coupon_log_table']}
                            set cp_id       = '{$_POST['od_cp_id']}',
                                mb_id       = '{$member['mb_id']}',
                                od_id       = '$od_id',
                                cp_price    = '$tot_od_cp_price',
                                cl_datetime = '".G5_TIME_YMDHIS."' ";
                sql_query($sql);
            }

            if($_POST['sc_cp_id']) {
                $sql = " insert into {$g5['g5_shop_coupon_log_table']}
                            set cp_id       = '{$_POST['sc_cp_id']}',
                                mb_id       = '{$member['mb_id']}',
                                od_id       = '$od_id',
                                cp_price    = '$tot_sc_cp_price',
                                cl_datetime = '".G5_TIME_YMDHIS."' ";
                sql_query($sql);
            }
        }


        include_once(G5_SHOP_PATH.'/ordermail1.inc.php');
        include_once(G5_SHOP_PATH.'/ordermail2.inc.php');

        // SMS BEGIN --------------------------------------------------------
        // 주문고객과 쇼핑몰관리자에게 SMS 전송
        if($config['cf_sms_use'] && ($default['de_sms_use2'] || $default['de_sms_use3'])) {
            $is_sms_send = false;

            // 충전식일 경우 잔액이 있는지 체크
            if($config['cf_icode_id'] && $config['cf_icode_pw']) {
                $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);

                if($userinfo['code'] == 0) {
                    if($userinfo['payment'] == 'C') { // 정액제
                        $is_sms_send = true;
                    } else {
                        $minimum_coin = 100;
                        if(defined('G5_ICODE_COIN'))
                            $minimum_coin = intval(G5_ICODE_COIN);

                        if((int)$userinfo['coin'] >= $minimum_coin)
                            $is_sms_send = true;
                    }
                }
            }

            if($is_sms_send) {
                $sms_contents = array($default['de_sms_cont2'], $default['de_sms_cont3']);
                $recv_numbers = array($od_hp, $default['de_sms_hp']);
                $send_numbers = array($default['de_admin_company_tel'], $default['de_admin_company_tel']);

                $sms_count = 0;
                $sms_messages = array();

                for($s=0; $s<count($sms_contents); $s++) {
                    $sms_content = $sms_contents[$s];
                    $recv_number = preg_replace("/[^0-9]/", "", $recv_numbers[$s]);
                    $send_number = preg_replace("/[^0-9]/", "", $send_numbers[$s]);

                    $sms_content = str_replace("{이름}", $od_name, $sms_content);
                    $sms_content = str_replace("{보낸분}", $od_name, $sms_content);
                    $sms_content = str_replace("{받는분}", $od_b_name, $sms_content);
                    $sms_content = str_replace("{주문번호}", $od_id, $sms_content);
                    $sms_content = str_replace("{주문금액}", number_format($tot_ct_price + $od_send_cost + $od_send_cost2), $sms_content);
                    $sms_content = str_replace("{회원아이디}", $member['mb_id'], $sms_content);
                    $sms_content = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content);

                    $idx = 'de_sms_use'.($s + 2);

                    if($default[$idx] && $recv_number) {
                        $sms_messages[] = array('recv' => $recv_number, 'send' => $send_number, 'cont' => $sms_content);
                        $sms_count++;
                    }
                }

                // SMS 전송
                if($sms_count > 0) {
                    if($config['cf_sms_type'] == 'LMS') {
                        include_once(G5_LIB_PATH.'/icode.lms.lib.php');

                        $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

                        // SMS 모듈 클래스 생성
                        if($port_setting !== false) {
                            $SMS = new LMS;
                            $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

                            for($s=0; $s<count($sms_messages); $s++) {
                                $strDest     = array();
                                $strDest[]   = $sms_messages[$s]['recv'];
                                $strCallBack = $sms_messages[$s]['send'];
                                $strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
                                $strSubject  = '';
                                $strURL      = '';
                                $strData     = iconv_euckr($sms_messages[$s]['cont']);
                                $strDate     = '';
                                $nCount      = count($strDest);

                                $res = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

                                $SMS->Send();
                                $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
                            }
                        }
                    } else {
                        include_once(G5_LIB_PATH.'/icode.sms.lib.php');

                        $SMS = new SMS; // SMS 연결
                        $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);

                        for($s=0; $s<count($sms_messages); $s++) {
                            $recv_number = $sms_messages[$s]['recv'];
                            $send_number = $sms_messages[$s]['send'];
                            $sms_content = iconv_euckr($sms_messages[$s]['cont']);

                            $SMS->Add($recv_number, $send_number, $config['cf_icode_id'], $sms_content, "");
                        }

                        $SMS->Send();
                        $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
                    }
                }
            }
        }
        // SMS END   --------------------------------------------------------

        // 주문 정보 임시 데이터 삭제
        // order_result.php 파일에서 사용하기 위해 삭제하지 않음.
        //$sql = " delete from {$g5['g5_shop_order_data_table']} where od_id = '$od_id' and dt_pg = '$od_pg' ";
        //sql_query($sql);

        // orderview 에서 사용하기 위해 session에 넣고
        //$uid = md5($od_id.G5_TIME_YMDHIS.$REMOTE_ADDR); // wetoz : 필요없음
        //set_session('ss_orderview_uid', $uid); // wetoz : 필요없음

        // 주문번호제거
        //set_session('ss_order_id', ''); // wetoz : 필요없음

        // 기존자료 세션에서 제거
        //if (get_session('ss_direct')) // wetoz : 필요없음
        //    set_session('ss_cart_direct', ''); // wetoz : 필요없음

        // 배송지처리
        if($is_member) {
            $sql = " select * from {$g5['g5_shop_order_address_table']}
                        where mb_id = '{$member['mb_id']}'
                          and ad_name = '$od_b_name'
                          and ad_tel = '$od_b_tel'
                          and ad_hp = '$od_b_hp'
                          and ad_zip1 = '$od_b_zip1'
                          and ad_zip2 = '$od_b_zip2'
                          and ad_addr1 = '$od_b_addr1'
                          and ad_addr2 = '$od_b_addr2'
                          and ad_addr3 = '$od_b_addr3' ";
            $row = sql_fetch($sql);

            // 기본배송지 체크
            if($ad_default) {
                $sql = " update {$g5['g5_shop_order_address_table']}
                            set ad_default = '0'
                            where mb_id = '{$member['mb_id']}' ";
                sql_query($sql);
            }

            if($row['ad_id']){
                $sql = " update {$g5['g5_shop_order_address_table']}
                              set ad_default = '$ad_default',
                                  ad_subject = '$ad_subject',
                                  ad_jibeon  = '$od_b_addr_jibeon'
                            where mb_id = '{$member['mb_id']}'
                              and ad_id = '{$row['ad_id']}' ";
            } else {
                $sql = " insert into {$g5['g5_shop_order_address_table']}
                            set mb_id       = '{$member['mb_id']}',
                                ad_subject  = '$ad_subject',
                                ad_default  = '$ad_default',
                                ad_name     = '$od_b_name',
                                ad_tel      = '$od_b_tel',
                                ad_hp       = '$od_b_hp',
                                ad_zip1     = '$od_b_zip1',
                                ad_zip2     = '$od_b_zip2',
                                ad_addr1    = '$od_b_addr1',
                                ad_addr2    = '$od_b_addr2',
                                ad_addr3    = '$od_b_addr3',
                                ad_jibeon   = '$od_b_addr_jibeon' ";
            }

            sql_query($sql);
        }
    }
    
    die('rescode=0000&resmsg=Succes');

}