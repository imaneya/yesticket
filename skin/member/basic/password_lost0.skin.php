<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 찾기 시작 { -->
<div style="background-color:#EC8AAB; height:50px; width:100%; margin-bottom:25px;">
	</div>
<div id="find_info" class="new_win">
    <h1 id="win_title">Account Info Lost</h1>
    <div class="new_win_con">
        <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
        <fieldset id="info_fs">
            <p>
                Please input your email address below.<br>
                We will send you the connected ID and Passwords with the email address.
            </p>
            <label for="mb_email" class="sound_only">E-mail Address</label>
            <input type="text" name="mb_email" id="mb_email" required class="required frm_input full_input email" size="30" placeholder="E-mail Address">
        </fieldset>
        <?php echo captcha_html();  ?>
        <input type="submit" value="Confirm" class="btn_submit">

    </div>
    <button type="button" onclick="window.close();" class="btn_close">Close</button>

    </form>
</div>

<script>
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->
