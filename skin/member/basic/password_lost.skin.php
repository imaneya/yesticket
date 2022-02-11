<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);

$page = $_GET['page'];
if ($page == "0") {
	$disp1 = "none";
	$disp2 = "inline-block";
	$backg1 = "background-color:#603779; color:#fff;";
	$backg2 = "background-color:#d2d2d2;";
} else {
	$page = 1;
	$disp1 = "inline-block";
	$disp2 = "none";
	$backg1 = "background-color:#d2d2d2;";
	$backg2 = "background-color:#603779; color:#fff;";
}
?>

<!-- 회원정보 찾기 시작 { -->
<div style="background-color:#EC8AAB; height:50px; width:100%; text-align:center; margin-bottom:35px;">
</div>
<h1 class="pink mt50 mb30 tc bold" style="font-size:2.0em; margin-top:0px; margin-bottom:55px;">FIND LOGIN INFO</h1>
<div class="w1000 tc" style="background-color:white; text-align:center; margin-bottom:70px; padding-bottom:50px;">
	<div id="lost_tab">
		<ul>
			<a href="<?= G5_BBS_URL ?>/password_lost.php?page=0">
				<li style="width:50%; height:40px; <?= $backg1 ?> font-size:1.2em; float:left; padding-top:9px; height:45px; font-weight:bold;">
					<span>
						Find my ID
					</span>
				</li>
			</a>
			<a href="<?= G5_BBS_URL ?>/password_lost.php?page=1">
				<li style="width:50%; height:40px; <?= $backg2 ?> font-size:1.2em; float:right; padding-top:9px; height:45px; font-weight:bold;">
					<span>
						Find my password
					</span>
				</li>
			</a>
		</ul>
	</div>


	<div class="lostidpw" style="max-width:50%; margin-left:25%; margin-top:20px; font-size:1.1em;">
		<form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
			<fieldset id="info_fs" style="margin-bottom:70px; text-align:left;">
			<?php
				if($page == "0"){
					?>
				<label for="lost_name" style="margin-bottom:10px; margin-top:5px; font-weight:600; color:#696969; display:inline-block;">First Name</label>

				<input type="text" name="mb_name" id="lost_name" style="margin-bottom:20px; height:45px; display:" required class="required frm_input full_input name" placeholder="Type for First Name">
				<label for="lost_nick" style="margin-bottom:10px; margin-top:5px; font-weight:600; color:#696969; display:inline-block;">Last Name</label>
				<input type="text" name="mb_nick" id="lost_nick" style="margin-bottom:20px; height:45px; display:" required class="required frm_input full_input name" placeholder="Type for Last Name">
			<?php
				}else if($page == "1"){
			?>
				<label for="lost_id" style="margin-bottom:10px; margin-top:5px; font-weight:600; color:#696969; display:inline-block;">ID</label>
				<input type="text" name="mb_id" id="lost_id" style="margin-bottom:20px; height:45px;" required class="required frm_input full_input name" placeholder="Type for name">
			<?php
				}
			?>
				<label for="email" style="margin-bottom:10px; display: inline-block; font-weight:600; color:#696969;">E-mail</label>
				<input type="text" name="mb_email" id="lost_pw" style="margin-bottom:10px; height:45px; display: inline-block;" required class="required frm_input full_input email" placeholder="Type for E-mail address">
			</fieldset>
			<li class="fl w100" style="display:inline; margin-bottom:-10px;">
				<button type="button" onclick="void(0);" class="btn_cancel2" style="width : 49.4%; float:left; margin-right:1%; height:46px; margin-bottom:10px;">CANCEL</button>
				<input type="submit" value="SUBMIT" class="btn_submit purple_btn" style="width : 49.4%; float:left;">
			</li>
	</div>

	</form>
</div>
</div>
<!-- } 회원정보 찾기 끝 -->
