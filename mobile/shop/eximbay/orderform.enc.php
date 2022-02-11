<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

?>

    <script>
    function  fnSubmit( form )
    {
        $('#display_pay_button').hide();
        $('#display_pay_process').show();

        form.action = "<?php echo G5_SHOP_URL?>/eximbay/order_call.php";
        form.submit();
    }
    function  ppSubmit( form )
    {
        $('#display_pay_button').hide();
        $('#display_pay_process').show();

        form.action = "<?php echo G5_SHOP_URL?>/eximbay/pp_call.php";
        form.submit();
    }
    </script>

    <input type="hidden" name="charset"         id="charset"        value="UTF-8" /><!-- 기본 값 : UTF-8 -->
    <input type="hidden" name="eb_product"      id="eb_product"     value="<?php echo $goods; ?>" />
    <input type="hidden" name="eb_goods_cnt"    id="eb_goods_cnt"   value="1" />	<!--mandatory-->
    <input type="hidden" name="wz_mobile"       id="wz_mobile"      value="1" />
    <input type="hidden" name="wz_user_id"      id="wz_user_id"     value="<?php echo $is_member ? $member['mb_id'] : 'guest' ;?>" />
    <input type="hidden" name="wz_ip"           id="wz_ip"          value="<?php echo $_SERVER['REMOTE_ADDR'];?>" />

    <input type="hidden" name="item_0_product"      id="item_0_product"     value="<?php echo $goods; ?>" />
    <input type="hidden" name="item_0_quantity"     id="item_0_quantity"    value="1" />
    <input type="hidden" name="item_0_unitPrice"    id="item_0_unitPrice"   value="<?php echo $tot_price; ?>" />