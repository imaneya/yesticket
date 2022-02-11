<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
    
<style type="text/css">
.dimm{position:absolute;left:0;top:0;z-index:99999999;background-color:#000;display:none;opacity: 0.4;}
</style>

<script>
$(function(){
    $('body').append('<div class="dimm"></div>');
});
function  fnSubmit( form )
{

    var order_data = $(form).serialize();
    var save_result = "";
    $.ajax({
        type: "POST",
        data: order_data,
        url: g5_url+"/shop/ajax.orderdatasave.php",
        cache: false,
        async: false,
        success: function(data) {
            save_result = data;
        }
    });

    if (save_result) {
        alert(save_result);
    }
    else {

        var paywin = window.open("", "eximbaywinpayment", "scrollbars=yes,status=no,toolbar=no,resizable=yes,location=no,menu=no,width=500,height=470");
        form.target = "eximbaywinpayment";
        form.action = "./eximbay/order_call.php";
        form.submit();
        paywin.focus();

        var maskHeight = $(document).height();
        var maskWidth = $(window).width() + 17;

        $('.dimm').css({'width':maskWidth,'height':maskHeight});
        $('.dimm').fadeIn(300);      	 
        $('.dimm').fadeTo('fast');
        $('html').css('overflow-y','hidden');

        var crono = window.setInterval(function() {
            if (paywin.closed !== false) { // !== opera compatibility reasons
                window.clearInterval(crono);
                paywinClosed();
            }
        }, 250);

    }

}

function ppSubmit( form )
{

    var paywin = window.open("", "eximbaywinpayment", "scrollbars=yes,status=no,toolbar=no,resizable=yes,location=no,menu=no,width=500,height=470");
    form.target = "eximbaywinpayment";
    form.action = "./eximbay/pp_call.php";
    form.submit();
    paywin.focus();

    var maskHeight = $(document).height();
    var maskWidth = $(window).width() + 17;

    $('.dimm').css({'width':maskWidth,'height':maskHeight});
    $('.dimm').fadeIn(300);      	 
    $('.dimm').fadeTo('fast');
    $('html').css('overflow-y','hidden');

    var crono = window.setInterval(function() {
        if (paywin.closed !== false) { // !== opera compatibility reasons
            window.clearInterval(crono);
            paywinClosed();
        }
    }, 250);

}

function paywinClosed(){
    $(top.document).find('.dimm').hide();
    $(top.document).find('html').css('overflow-y','auto');
}

</script>

<?php
    /* ============================================================================== */
    /* =   2. 가맹점 필수 정보 설정                                                 = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수 - 결제에 반드시 필요한 정보입니다.                               = */
    /* = -------------------------------------------------------------------------- = */
    // 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용
?>
    <input type="hidden" name="charset"         id="charset"        value="UTF-8" /><!-- 기본 값 : UTF-8 -->
    <input type="hidden" name="eb_product"      id="eb_product"     value="<?php echo $goods; ?>" />
    <input type="hidden" name="eb_goods_cnt"    id="eb_goods_cnt"   value="1" />	<!--mandatory-->
    <input type="hidden" name="wz_mobile"       id="wz_mobile"      value="0" />
    <input type="hidden" name="wz_user_id"      id="wz_user_id"     value="<?php echo $is_member ? $member['mb_id'] : 'guest' ;?>" />
    <input type="hidden" name="wz_ip"           id="wz_ip"          value="<?php echo $_SERVER['REMOTE_ADDR'] ;?>" />

    <input type="hidden" name="item_0_product"      id="item_0_product"     value="<?php echo $goods; ?>" />
    <input type="hidden" name="item_0_quantity"     id="item_0_quantity"    value="1" />
    <input type="hidden" name="item_0_unitPrice"    id="item_0_unitPrice"   value="<?php echo $tot_price; ?>" />

<?php
    /* = -------------------------------------------------------------------------- = */
    /* =   2. 가맹점 필수 정보 설정 END                                             = */
    /* ============================================================================== */
?>