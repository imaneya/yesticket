<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$fgdate = array();
$fgdate['ver']        = $g_conf_ver;
$fgdate['mid']        = $g_conf_site_cd;
$fgdate['txntype']    = 'REFUND';
$fgdate['refundtype'] = 'F'; // F: Fully, P: Partial 
$fgdate['ref']        = $od_id; // 원 승인 거래 ref
$fgdate['cur']        = $eximbay_cur; // 원 승인 거래 통화
$fgdate['amt']        = $pg_price; // 원 승인 거래 금액 (e.g. 1000.50, 9.15) 금액 3자리 구분 "," 는 사용하지 않음.
$fgdate['refundamt']  = $pg_price; // 취소 요청 금액 원 승인 거래 금액을 초과할 수 없습니다. refundamt가 정의되지 않은 경우, transid에 해당하는 승인 거래 총 금액을 취소 처리 합니다. 
$fgdate['transid']    = $od_tno; // 승인 거래의 결제사 거래 아이디 
$fgdate['reason']     = $cancel_msg;
$fgdate['lang']       = $g_conf_language; // 결제정보 언어타입
$fgdate['returnurl']  = '';
$fgdate['param1']     = '';
$fgdate['param2']     = '';
$fgdate['param3']     = '';
$fgdate['charset']    = 'UTF-8';
$fgdate['balance']    = '';
$fgdate['refundid']   = $od_id; // 환불 요청에 대한 유일한 값으로 가맹점에서 생성. 모든 요청데이터의 refundid는 Unique 해야 합니다.

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

$fgdate['fgkey'] = $fgkey;


if (function_exists('http_build_query')) { // php5, php 7
    $post_string = http_build_query($fgdate);
} 
else {
    foreach ( $fgdate as $key => $value) {
        $post_items[] = $key . '=' . $value;
        $post_array[$key] = $value;
    }
    $post_string = implode ('&', $post_items);
}

$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL,$g_conf_cancel_url); //접속할 URL 주소
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
// default 값이 true 이기때문에 이부분을 조심 (https 접속시에 필요)
curl_setopt ($ch, CURLOPT_SSLVERSION,1); // SSL 버젼 (https 접속시에 필요)
curl_setopt ($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
curl_setopt ($ch, CURLOPT_POST, 1); // Post Get 접속 여부
curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_string);
curl_setopt ($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
$result = curl_exec($ch);
curl_close ($ch);

if ($result) { 
    parse_str($result, $arr_res);
    $res_cd  = $arr_res['rescode'];
    $res_msg = $arr_res['resmsg'];
}