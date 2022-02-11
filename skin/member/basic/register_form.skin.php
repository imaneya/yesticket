<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div style="background-color:#EC8AAB; height:50px; width:100%; margin-bottom:25px;">
	</div>
<style>
	input, select {padding:8px 15px 10px 15px; margin-bottom:10px; color:#111;}
	label.button {border:1px solid #b5a2c1; padding:8px 10px 10px 10px; color:#603779; height:40px;}
	.form_01 li { margin: 10px 1px; }
	#register_form { border: 1px solid #bbb; }
	#fregisterform label {padding-left:8px; font-size: 15px; font-weight:400;display: inline-block; margin-bottom : 5px; color : #515151;}
	#fregisterform input[type=radio]{display:none; margin:10px;}
	#fregisterform input[type=radio]+label{display:inline-block; margin:-2px; height:40px; padding-top:10px; margin-bottom:10px; text-align:center; background-color:#816095; color:#fff; font-weight:700; border:1px solid #603779;}
	#fregisterform input[type=radio]:radio+label{background-image:none; height:40px; background-color:#fff;  margin-bottom:10px; color:#816095;;}
	#fregisterform input[type=checkbox]{display:none; margin:10px;}
	#fregisterform input[type=checkbox]+label{display:inline-block; padding-left:0px !important; margin:-2px; height:40px; margin-left:0.1%; padding-top:8px; text-align:center; background-color:#816095; color:#fff; font-weight:700; border:1px solid #603779;}
	#fregisterform input[type=checkbox]:checkbox+label{background-image:none; padding-left:0px !important; height:40px; margin-left:0.1%; background-color:#fff; color:#616161;}
</style>
<!-- 회원정보 입력/수정 시작 { -->

<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>

<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="url" value="<?php echo $urlencode ?>">
<input type="hidden" name="agree" value="<?php echo $agree ?>">
<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
<input type="hidden" name="cert_no" value="">
<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
<?php }  ?>
<div class="m1" style="max-width:527px; margin:auto; margin-bottom:40px;">
 <div id="register_form"  class="form_01">
    <div>
        <h2 class="pink tc" style="font-size:2.1em; font-weight:600;">SIGN UP</h2>
        <ul>
            <li>
                <label for="reg_mb_id" style="margin-right:0px;">ID</label><br>
                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input  <?php echo $required ?> w100 <?php echo $readonly ?>" minlength="3" maxlength="20"
									style="width:100%; margin-right:-79px;" placeholder="Enter your name">
                <span id="msg_mb_id"></span>
								<input type="button" onclick="id_overlap_Check()" value="Check ID" id="btn_check" class="btn_check purple_btn"
								style="background-color:#816095; margin-top:-10px; border-color:#816095; font-weight:500; font-size:1.0em; line-height:0; width:80px; height:40px;">
            </li>
            <li>
                <label for="reg_mb_password">Password</label>
                <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input w100 <?php echo $required ?>" minlength="3" maxlength="20" placeholder="Enter your password">
						</li>
						<li>
                <li style="margin:0px;"><label for="reg_mb_password_re">Re-enter Password</label><label id="password_not" style="display:none; color:red; float:right;">Password is not identical.</label>
                <label id="password_ok" style="display:none; color:green; float:right;">Password is identical.</label></li>
                <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input w100 right_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="Confirm your password">
            </li>
			<li style="margin-bottom:0px;">
				<label for="reg_mb_password_re">Nationality</label>
								<select name="mb_1" id="mb_1" <?php echo $required ?> style="width:100%;">
									<option disabled selected>ex) United States, Japan...</option>
									<option>Australia</option>
									<option>Belgium</option>
									<option>Brunei Darussalam</option>
									<option>Canada</option>
									<option>Chile</option>
									<option>China</option>
									<option>Taiwan</option>
									<option>Denmark</option>
									<option>Finland</option>
									<option>France</option>
									<option>Germany</option>
									<option>Hongkong</option>
									<option>India</option>
									<option>Indonesia</option>
									<option>Italy</option>
									<option>Japan</option>
									<option>Kazakhstan</option>
									<option>Rep. of Korea</option>
									<option>Macao</option>
									<option>Malaysia</option>
									<option>Mexico</option>
									<option>Mongolia</option>
									<option>Netherlands</option>
									<option>New Zealand</option>
									<option>Philippines</option>
									<option>Portugal</option>
									<option>Russia</option>
									<option>Singapore</option>
									<option>Spain</option>
									<option>Sweden</option>
									<option>Switzerland</option>
									<option>Thailand</option>
									<option>United Kingdom</option>
									<option>United States</option>
									<option>Viet Nam</option>
								</select>
			</li>

            <li class="fl w100" style="display:inline; margin-bottom:-10px;">
                <label for="reg_mb_name" style="width : 49.7%; float:left;">First name</strong></label>
								<label style="width : 49.7%; float:left;" for="reg_mb_nick">Last name</label>
						</li>
						<li class="fl w100">
                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input w100 <?php echo $required ?> <?php echo $readonly ?>"
								style="width : 49.7%; float:left; margin-right:0.1%;" size="10" placeholder="First Name">
                <?php
                if($config['cf_cert_use']) {
                    if($config['cf_cert_ipin'])
                        echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>'.PHP_EOL;
                    if($config['cf_cert_hp'])
                        echo '<button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>'.PHP_EOL;

                    echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
                }
                ?>
                <?php
                if ($config['cf_cert_use'] && $member['mb_certify']) {
                    if($member['mb_certify'] == 'ipin')
                        $mb_cert = '아이핀';
                    else
                        $mb_cert = '휴대폰';
                ?>

                <div id="msg_certify">
                    <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
                </div>
                <?php } ?>
                <?php if ($config['cf_cert_use']) { ?>
                <span class="frm_info">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
                <?php } ?>

                <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                <input type="text" style="width : 49.7%; float:left; margin-left:0px; margin-right:0.1%;" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input w100 required nospace" size="10" maxlength="20" placeholder="Last Name">
                <span id="msg_mb_nick"></span>
							</li>

			<li style="margin-bottom:20px;">
				<label for="reg_mb_password_re">Date of Birth</label><br>
        <select name="mb_2" id="mb_2" class="fl p3 tc" style="margin:0.1%;width : 33.1%;">
					<option disabled selected>YEAR</option>
                    <? for ($n=date('Y'); $n>=1900; $n--) { ?>
                        <option value="<?=$n?>"><?=$n?></option>
                        <? } ?>
				</select>

				<select name="mb_3" id="mb_3" class="fl p3 tc" style="margin:0.1%;width : 33.1%;">
					<option disabled selected>MONTH</option>
					<? for ($n=1; $n<=12; $n++) { ?><option value="<?=$n?>"><?=$n?></option><? } ?>
				</select>
				<select name="mb_4" id="mb_4" class="fl p3 tc" style="margin:0.1%;width : 33.1%;">
					<option disabled selected>DATE</option>
					<? for ($n=1; $n<=31; $n++) { ?><option value="<?=$n?>"><?=$n?></option><? } ?>
				</select>
	 </li>
	 <li style="margin-bottom:20px;">
                <label>Gender</label><br>
                <input type="hidden" name="mb_5" id="mb_5">
		 		<label class="fl p2 tc button" for="Male" style="width : 49.8%; margin: 0.1%; color:#816095;">
      	        <input type="radio" name="gender" id="Male" class="none" value="Male">Male</label>
				<label class="fl p2 tc button" for="Female" style="color:#FFF;background-color:#603779;width : 49.8%; margin: 0.1%;">
				<input type="radio" name="gender" id="Female" class="none" value="Female" checked>Female</label>
	 </li>

	 <li>
            <?php if ($config['cf_use_tel']) {  ?>

                <label for="reg_mb_tel">Telephone</label>
                <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input w100 <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="Your telephone number">
            <?php }  ?>

            <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
                <label for="reg_mb_hp">Cellphone</label>

                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input right_input w100 <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="Your cellphone number">
                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                <?php } ?>
            <?php }  ?>
            </li>


            <li>
                <label for="reg_mb_email">E-mail</label>

                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
                    <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                </span>
                <?php }  ?>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email full_input required" size="70" maxlength="100" placeholder="E-mail">

            </li>

            <?php if ($config['cf_use_homepage']) {  ?>
            <li>
                <label for="reg_mb_homepage" class="sound_only">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong>필수</strong><?php } ?></label>
                <input type="text" name="mb_homepage" class="sound_only" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255" placeholder="홈페이지">
            </li>
            <?php }  ?>




            <?php if ($config['cf_use_addr']) { ?>
            <li>
                <?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
                <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_zip" value="000000" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input sound_only <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
                <label for="reg_mb_addr1">Address</label><br>
                <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address full_input required <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="Detailed Address">
                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address full_input required" size="50"  placeholder="City, Province, Country">
                <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address full_input none" size="50" readonly="readonly"  placeholder="참고항목">
                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">

            </li>
            <?php }  ?>

            <?php if ($config['cf_use_signature']) {  ?>
            <li>
                <label for="reg_mb_signature" class="sound_only">서명<?php if ($config['cf_req_signature']){ ?><strong>필수</strong><?php } ?></label>
                <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"   placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
            </li>
            <?php }  ?>

            <?php if ($config['cf_use_profile']) {  ?>
            <li style="margin-top:35px; margin-bottom:60px; display:inline;">
                <label for="reg_mb_profile" style="margin-bottom:10px;">Category of Interest</label><br>
                    <input type="hidden" name="mb_6" id="mb_6">
                    <input name="sex" id="ticket" type="checkbox" value="ticket">
                    <label style="width:19.4%; background-color:#fff; color:#b5a2c1; border:1px solid #b5a2c1;" for="ticket">Ticket</label>
                    <input name="sex" id="tour" type="checkbox" value="tour">
                    <label style="width:19.4%; background-color:#fff; color:#b5a2c1; border:1px solid #b5a2c1;" for="tour">Tour</label>
                    <input name="sex" id="goods" type="checkbox" value="goods">
                    <label style="width:19.4%; background-color:#fff; color:#b5a2c1; border:1px solid #b5a2c1;" for="goods">Goods</label>
                    <input name="sex" id="hotel" type="checkbox" value="hotel">
                    <label style="width:19.4%; background-color:#fff; color:#b5a2c1; border:1px solid #b5a2c1;" for="hotel">Hotel</label>
                    <input name="sex" id="car" type="checkbox" value="car">
                    <label style="width:19.4%; background-color:#fff; color:#b5a2c1; border:1px solid #b5a2c1;" for="car">Car</label>
                <textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?> none" placeholder=""><?php echo $member['mb_profile'] ?></textarea>
            </li>
            <?php }  ?>


<!--
            <li class="is_captcha_use">
                Captcha
                <?php // echo captcha_html(); ?>
            </li>
-->
	 		<li>
				<div class="btn_confirm" style="margin:50px auto 0;">
					<a href="<?php echo G5_URL ?>" class="btn_cancel purple purple_btn2 fl p2" style="margin:0; height:40px; line-height:36px;">CANCEL</a>
					<input type="submit" value="<?php echo $w==''?'CONFIRM':'CONFIRM'; ?>" id="btn_submit" class="btn_submit purple_btn p2" style="margin:0; height:40px; padding-bottom:2px;" accesskey="s">
				</div>
			</li>
        </ul>
    </div>

</div>
</div>
</form>

    <script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>

        //성별 체크
        $('input[name=gender]').click(function(){
            $('input[name=gender]').attr('checked',false);
            $(this).attr('checked',true);
            $('label[for=Male]').css("color","#816095");
            $('label[for=Male]').css("background-color","#FFF");
            $('label[for=Female]').css("color","#816095");
            $('label[for=Female]').css("background-color","#FFF");
            let ck = $('#Female').is(':checked');//여자체크
            if(ck === true){//여자일때
                $('label[for=Female]').css("color","#FFF");
                $('label[for=Female]').css("background-color","#603779");
            }else{
                $('label[for=Male]').css("color","#FFF");
                $('label[for=Male]').css("background-color","#603779");
            }
        })
        //관심 카테고리 선택
        $('#ticket').click(function(){
            if($(this).is(':checked')){
                $('label[for=ticket]').css("color","#FFF");
                $('label[for=ticket]').css("background-color","#603779");
            }else{
                $('label[for=ticket]').css("color","#b5a2c1");
                $('label[for=ticket]').css("background-color","#FFF");
            }
        })
        $('#tour').click(function(){
            if($(this).is(':checked')){
                $('label[for=tour]').css("color","#FFF");
                $('label[for=tour]').css("background-color","#603779");
            }else{
                $('label[for=tour]').css("color","#b5a2c1");
                $('label[for=tour]').css("background-color","#FFF");
            }
        })
        $('#goods').click(function(){
            if($(this).is(':checked')){
                $('label[for=goods]').css("color","#FFF");
                $('label[for=goods]').css("background-color","#603779");
            }else{
                $('label[for=goods]').css("color","#b5a2c1");
                $('label[for=goods]').css("background-color","#FFF");
            }
        })
        $('#hotel').click(function(){
            if($(this).is(':checked')){
                $('label[for=hotel]').css("color","#FFF");
                $('label[for=hotel]').css("background-color","#603779");
            }else{
                $('label[for=hotel]').css("color","#b5a2c1");
                $('label[for=hotel]').css("background-color","#FFF");
            }
        })
        $('#car').click(function(){
            if($(this).is(':checked')){
                $('label[for=car]').css("color","#FFF");
                $('label[for=car]').css("background-color","#603779");
            }else{
                $('label[for=car]').css("color","#b5a2c1");
                $('label[for=car]').css("background-color","#FFF");
            }
        })
        $("#reg_mb_password,#reg_mb_password_re").keyup(function() {
        var pwd1 = $("#reg_mb_password").val();
        var pwd2 = $("#reg_mb_password_re").val();
        if (pwd1 != "" || pwd2 != "") {
          if (pwd1 == pwd2) {
            $("#password_ok").show();
            $("#password_not").hide();
          } else {
            $("#password_ok").hide();
            $("#password_not").show();
          }
        }
      });
    });
    //아이디 중복확인
    function id_overlap_Check(){
        var id_val = $('#reg_mb_id').val();
        $.ajax({
            url : "/bbs/ajax.mb_id.php",
            data: {reg_mb_id: id_val},
            type: "POST",
            dataType: "html",
            success:function(data){
                if(data == ""){
                    alert("사용 가능한 ID 입니다.");
                }else{
                    alert(data);
                }
            }
        })
    }
    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("Password should be more than three letters.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("Passwords are not identical.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("Password should be more than three letters.");
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=="") {
            if (f.mb_name.value.length < 1) {
                alert("Fill out your name.");
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }
				if (f.mb_1.value == "ex) United States, Japan...") {
            alert("Please enter your Nationality.");
            f.mb_1.focus();
            return false;
        }
        if (f.mb_2.value == "YEAR") {
            alert("Please enter your birthday Year.");
            f.mb_2.focus();
            return false;
        }
        if (f.mb_3.value == "MONTh") {
            alert("Please enter your birthday Month.");
            f.mb_3.focus();
            return false;
        }
        if (f.mb_4.value == "DATE") {
            alert("Please enter your birthday Day.");
            f.mb_4.focus();
            return false;
        }
        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
            return false;
        }
        <?php } ?>

        // // 닉네임 검사
        // if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        //     var msg = reg_mb_nick_check();
        //     if (msg) {
        //         alert(msg);
        //         f.reg_mb_nick.select();
        //         return false;
        //     }
        // }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원아이콘이 이미지 파일이 아닙니다.");
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof f.mb_img != "undefined") {
            if (f.mb_img.value) {
                if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원이미지가 이미지 파일이 아닙니다.");
                    f.mb_img.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert("본인을 추천할 수 없습니다.");
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }
        var checkBoxArr = [];
        $("input[name=sex]:checked").each(function(i){
            checkBoxArr.push($(this).val());  //관심사 배열로
        });
        $('#mb_6').val(checkBoxArr);
        $('#mb_5').val(f.gender.value);
        <?php // echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

<!-- } 회원정보 입력/수정 끝 -->
