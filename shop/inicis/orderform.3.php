<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="display_pay_button" class="btn_confirm">
    <input type="button" value="Checkout" style="background-color:#603779; margin:20px; width:85%; height:45px;" onclick="forderform_check(this.form);" class="btn_submit">
    <!-- <a href="javascript:history.go(-1);" class="btn01">Cancel</a> -->
</div>
<div id="display_pay_process" style="display:none">
    <img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="">
    <span>Please wait for completing order.</span>
</div>
