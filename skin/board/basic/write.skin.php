<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$captcha_js = $is_guest = '';
?>
<?
include_once(G5_SHOP_PATH.'/slider.php');
?>

<div id="sct_location" class="w1000 tc">
	<div class="mt50 mb50" style="position:relative;">
		<hr style="display:block; border-top:#603779 2px solid; position:absolute; top:40%; width:100%; z-index: 10;">
	    <h2 style="font-size:2.2em; padding:15px; background-color:#eeeeee; cursor:default; display: inline-block; position:relative; z-index: 11; margin:auto; text-transform: uppercase; color:#603779;"><?php echo $board['bo_subject']; ?></h2>
		</div>
</div>

<section id="bo_w" class="w1000" style="padding:20px; background-color:#FFF; margin-bottom:50px;">
    <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= "\n".'<input class="none" type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice"></label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= "\n".'<input class="none" type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html"></label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    ?>

    <?php if ($is_category) { ?>
    <div class="bo_w_select write_div">
        <label for="ca_name"  class="sound_only">분류</label>
        <select name="ca_name" id="ca_name" required>
            <option value="">분류를 선택하세요</option>
            <?php echo $category_option ?>
        </select>
    </div>
    <?php } ?>

    <div class="write_board">
		<ul>
	    <li><label for="wr_subject">Title</label></li>
			<li><input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input full_input required" size="50" maxlength="255"></li>
		</ul>
		<ul>
      <li><label for="wr_name">Author</label></li>
      <li><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required"></li>
		</ul>
		<ul>
    	<li><label for="wr_password">Password</label></li>
    	<li><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>"></li>
		</ul>
		<ul>
			<li><label for="wr_email">E-mail</label></li>
      <li><input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email "></li>
		</ul>
		<ul>
			<li><label for="wr_content">Text</label></li>
			<li><div id="wr_con" class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
					<?php if($write_min || $write_max) { ?>
					<!-- 최소/최대 글자 수 사용 시 -->
					<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
					<?php } ?>
					<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
					<?php if($write_min || $write_max) { ?>
					<!-- 최소/최대 글자 수 사용 시 -->
					<div id="char_count_wrap"><span id="char_count"></span>글자</div>
					<?php } ?>
			</div><li>
		</ul>
		<script>
			var texta = jQuery(".smarteditor2").contents().find("#smart_editor2");
			var css = '<style type="text/css">' +
          '#smart_editor2{min-width:0 !important;}; ' +
          '</style>';
					jQuery(texta).append(css);
		</script>
		<ul style="margin-top:15px;">
		<?$file_count=1?>
    <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <li><label for="wr_file" class="lb_icon"><span>Attach File</span></label></li>
				<li><input type="text" name="wr_file" id="wr_file" value="" readonly class="frm_input upload-name bo_w_sel2" style="cursor:default;" placeholder="Search Files"></li>
				<li><label for="bf_file_<?php echo $i+1 ?>" id="wr_sel" class="purple_btn" style="color:#fff; float:left !important; text-align:center; background-color:#603779; min-width:0 !important;
					font-size:1.2em; font-weight:500; height:40px; margin-left:-1px;">Select</label></li>
        <li><input type="file" name="bf_file[]" id="bf_file_<?php echo $i+1 ?>" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file none"></li>
        <?php if($w == 'u' && $file[$i]['file']) { ?>
				<li style="float:left; width:70% !important;"><input style="float:right; width:20px !important; margin-top:5px !important" type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"></li>
				<li><label style="width:22% !important; padding:0px !important" for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label></li>
        <?php } ?>
    <?php } ?>
		<script>
			document.getElementById("bf_file_1").onchange = function () {
				document.getElementById("wr_file").value = this.value;
			};
		</script>
		<ul style="margin-top:100px; margin-bottom:30px;">
			<li style="width:49% !important; float:left; margin-right:1%;"><input type="submit" value="Confirm" id="wr_confirm" accesskey="s" class="purple_btn wr_button"
				style="height:40px; border:#603779 1px solid; float:right;"></li>
			<li style="width:49% !important; float:left;"><label for="wr_content" class="purple_btn2 wr_button"	id="wr_cancel" style="text-align:center; color:#603779; height:40px;
			padding:0px;"><a href="./board.php?bo_table=<?php echo $bo_table ?>">Cancel</a></label></li>
		</ul>
    </form>
	</div>
    <script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->
