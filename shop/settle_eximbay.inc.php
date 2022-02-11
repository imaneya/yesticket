<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$test = '';
$g_conf_receipt_url = 'https://secureapi.eximbay.com/web/invoice/down.jsp?transid={transactid}&ref={ref}'; // 결제영수증 PC용 URL
if (is_mobile())
    $g_conf_receipt_url = 'https://secureapi.eximbay.com/web/invoice/mdown.jsp?transid={transactid}&ref={ref}'; // 결제영수증 PC용 URL

$g_conf_cancel_url  = 'https://secureapi.eximbay.com/Gateway/DirectProcessor.krp';

if ($default['de_card_test']) {
    $default['de_eximbay_mid'] = '1849705C64';
    $default['de_eximbay_key'] = '289F40E6640124B2628640168C3C5464';
    $test = 'test.';
    $g_conf_cancel_url  = 'https://secureapi.test.eximbay.com/Gateway/DirectProcessor.krp';
    $g_conf_receipt_url = 'https://secureapi.test.eximbay.com/web/invoice/down.jsp?transid={transactid}&ref={ref}';
    if (is_mobile())
        $g_conf_receipt_url = 'https://secureapi.test.eximbay.com/web/invoice/mdown.jsp?transid={transactid}&ref={ref}';
}

$g_conf_ver         = '230';
$g_conf_home_dir    = G5_SHOP_PATH.'/eximbay';
$g_conf_key_dir     = '';
$g_conf_site_cd     = $default['de_eximbay_mid'];
$g_conf_site_key    = $default['de_eximbay_key'];
$g_conf_action_url  = "https://secureapi.{$test}eximbay.com/Gateway/BasicProcessor.krp"; // real url : https://secureapi.eximbay.com/Gateway/BasicProcessor.krp , test url : https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp
$g_conf_currency    = $default['de_eximbay_cur']; // 통화단위 (USD, SGD, KRW, EUR, JPY, CAD, CNY...)
$g_conf_language    = $default['de_eximbay_lan']; // 결제창 언어 (KR, EN, CN, JP, DK...)
$g_conf_paymethod   = $default['de_eximbay_pay']; // 결제수단
$g_ship_country     = 'EN'; // 배송지 국적 (KR, EN, CN, JP, DK...)

// EXIMBAY SITE KEY 입력 체크
if(trim($g_conf_site_key) == '')
    alert('EXIMBAY SITE KEY를 입력해 주십시오.');

function payment_type($type = 'P000') { 
    switch ($type) {
        case 'P001':
            return 'Paypal';
        break;
        case 'P003':
            return 'Alipay';
        break;
        case 'P004':
            return 'Tenpay';
        break;
        case 'P141':
            return 'WeChat';
        break;
        case 'P005':
            return '99Bill';
        break;
        default:
            return 'CreaditCard';
        break;
    }
} 
?>