<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

require_once(G5_SHOP_PATH . '/settle_' . $default['de_pg_service'] . '.inc.php');
require_once(G5_SHOP_PATH . '/settle_kakaopay.inc.php');

// wetoz : eximbay
if ($default['de_eximbay_use']) {
    require_once(G5_SHOP_PATH . '/settle_eximbay.inc.php');
}

if ($default['de_inicis_lpay_use']) {   //이니시스 Lpay 사용시
    require_once(G5_SHOP_PATH . '/inicis/lpay_common.php');
}

// 결제대행사별 코드 include (스크립트 등)
require_once(G5_SHOP_PATH . '/' . $default['de_pg_service'] . '/orderform.1.php');

if ($default['de_inicis_lpay_use']) {   //이니시스 L.pay 사용시
    require_once(G5_SHOP_PATH . '/inicis/lpay_form.1.php');
}

if ($is_kakaopay_use) {
    require_once(G5_SHOP_PATH . '/kakaopay/orderform.1.php');
}
?>
<style>
    .buyInfo li{width:80%;}
    .buyInfo label {
        margin: 10px;
        padding-left:10px;
        margin-left:0;
        margin-right:0.1%;
        font-size: 1.2em;
    }

    .buyInfo input {
        margin-bottom: 10px;
        height: 40px;
        font-size: 1.1em;
    }

    .buyInfo button {
        margin-bottom: 10px;
        height: 40px;
        border: 1px solid #b5a2c1;
    }

    .buyInfo select {
        margin-bottom: 10px;
        height: 40px;
    }
</style>
<style>
    .fix{position:fixed;_position:absolute;top:0px;}
</style>
<div id="sit_ov_wrap">
  <h2 id="sit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">요약정보 및 구매</span></h2>
<!-- 상품이미지 미리보기 시작 { -->
    <div id="it_img_slider" style="margin-bottom:15px;">
            <div id="sit_pvi_big" style="background-color:#fff;">
                <?php
                $big_img_count = 0;
                $thumbnails = array();
                for ($i = 1; $i <= 10; $i++) {
                    if (!$it['it_img' . $i])
                        continue;

                    $img = get_it_thumbnail($it['it_img' . $i], 379, 283);

                    if ($img) {
                        // 썸네일
                        $thumb = get_it_thumbnail($it['it_img' . $i], 379, 283);
                        $thumbnails[] = $thumb;
                        $big_img_count++;

                        echo '<div class="sct_img">'.$img.'</div>';
                    }
                }

                if ($big_img_count == 0) {
                    echo '<img src="' . G5_SHOP_URL . '/img/no_image.gif" alt="">';
                }
                ?>
            </div>
            <?php
            // 썸네일
            $thumb1 = true;
            $thumb_count = 0;
            $total_count = count($thumbnails);
            if ($total_count > 0) {
                echo '<ul id="sit_pvi_thumb">';
                foreach ($thumbnails as $val) {
                    $thumb_count++;
                    $sit_pvi_last = '';
                    if ($thumb_count % 5 == 0) $sit_pvi_last = 'class="li_last"';
                    echo '<li ' . $sit_pvi_last . '>';
                    //echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$thumb_count.'" target="_blank" class="popup_item_image img_thumb">'.$val.'<span class="sound_only"> '.$thumb_count.'번째 이미지 새창</span></a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
</div>
<style>
    #it_img_slider {
    }

    #it_img_slider img {
        width: 100% !important;
        height: 100% !important;
        padding: 15px;
        padding-left: 15px;
        padding-right: 0px;
    }

    #it_img_slider .bx-clone {
    }

    #it_img_slider .bx-viewport {
    }

    #it_img_slider .bx-wrapper {
        max-width:1155px !important;
        position: relative;
        background-color:#FFF;
        padding-right:15px !important;
    }

    #it_img_slider .bx-controls {
        position: absolute;
        top: 42%;
        width: 100%;
    }

    #it_img_slider .bx-prev {
        float: left;
        padding: 3px 5px;
        margin: 5px;
        background-color: #FFF;
        color: #603779;
        font-weight: 700;
        font-size: 1.4em;
    }

    #it_img_slider .bx-next {
        float: right;
        padding: 3px 5px;
        margin: 5px;
        background-color: #FFF;
        color: #603779;
        font-weight: 700;
        font-size: 1.4em;
    }
</style>
<script>
$(function() {
        // 상품이미지 첫번째 링크
        $("#sit_pvi_big a:first").addClass("visible");

        // 상품이미지 미리보기 (썸네일에 마우스 오버시)
        $("#sit_pvi .img_thumb").bind("mouseover focus", function() {
            var idx = $("#sit_pvi .img_thumb").index($(this));
            $("#sit_pvi_big a.visible").removeClass("visible");
            $("#sit_pvi_big a:eq(" + idx + ")").addClass("visible");
        });

        // 상품이미지 크게보기
        $(".popup_item_image").click(function() {
            var url = $(this).attr("href");
            var top = 10;
            var left = 10;
            var opt = 'scrollbars=yes,top=' + top + ',left=' + left;
            popup_window(url, "largeimage", opt);

            return false;
        });
        $('#sit_pvi_big').bxSlider({
            minSlides: 1,
            maxSlides: 3,
            moveSlides: 1,
            auto: 0,
            slideWidth: 379,
            controls: 1,
            slideMargin: 0,
            pager: 0,
            shrinkItems: 1,
            hideControlOnEnd: 0,
            touchEnabled: 0,
            adaptiveHeight: true,
            preloadImages: 'all',
            nextText: '>',
            prevText: '<',
        });
    });


</script>
<form name="forderform" id="forderform" method="post" action="<?php echo $order_action_url; ?>" autocomplete="off">
    <div id="sod_frm">
        <!-- 주문상품 확인 시작 { -->
        <div class="tbl_head03 tbl_wrap od_prd_list">
            <table id="sod_list" class="none">
                <thead>
                    <tr>
                        <th scope="col" style="width:100px;">Date</th>
                        <th scope="col">Product Info</th>
                        <th scope="col">Person</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tot_point = 0;
                    $tot_sell_price = 0;

                    $goods = $goods_it_id = "";
                    $goods_count = -1;

                    // $s_cart_id 로 현재 장바구니 자료 쿼리
                    $sql = " select a.ct_id,
                        a.it_id,
                        a.it_name,
                        a.ct_price,
                        a.ct_point,
                        a.ct_qty,
                        a.ct_status,
                        a.ct_send_cost,
                        a.it_sc_type,
                        a.select_date,
                        b.ca_id,
                        b.ca_id2,
                        b.ca_id3,
                        b.it_notax
                   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                  where a.od_id = '$s_cart_id'
                    and a.ct_select = '1' ";
                    $sql .= " group by a.it_id ";
                    $sql .= " order by a.ct_id ";
                    $result = sql_query($sql);

                    $good_info = '';
                    $it_send_cost = 0;
                    $it_cp_count = 0;

                    $comm_tax_mny = 0; // 과세금액
                    $comm_vat_mny = 0; // 부가세
                    $comm_free_mny = 0; // 면세금액
                    $tot_tax_mny = 0;

                    for ($i = 0; $row = sql_fetch_array($result); $i++) {
                        // 합계금액 계산
                        $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                            SUM(ct_point * ct_qty) as point,
                            SUM(ct_qty) as qty
                        from {$g5['g5_shop_cart_table']}
                        where it_id = '{$row['it_id']}'
                          and od_id = '$s_cart_id' ";
                        $sum = sql_fetch($sql);

                        if (!$goods) {
                            //$goods = addslashes($row[it_name]);
                            //$goods = get_text($row[it_name]);
                            $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row['it_name']);
                            $goods_it_id = $row['it_id'];
                        }
                        $goods_count++;

                        // 에스크로 상품정보
                        if ($default['de_escrow_use']) {
                            if ($i > 0)
                                $good_info .= chr(30);
                            $good_info .= "seq=" . ($i + 1) . chr(31);
                            $good_info .= "ordr_numb={$od_id}_" . sprintf("%04d", $i) . chr(31);
                            $good_info .= "good_name=" . addslashes($row['it_name']) . chr(31);
                            $good_info .= "good_cntx=" . $row['ct_qty'] . chr(31);
                            $good_info .= "good_amtx=" . $row['ct_price'] . chr(31);
                        }

                        $image = get_it_image($row['it_id'], 80, 80);

                        $it_name = '<b>' . stripslashes($row['it_name']) . '</b>';
                        $it_options = print_item_options($row['it_id'], $s_cart_id);
                        // if ($it_options) {
                        //     $it_name .= '<div class="sod_opt">' . $it_options . '</div>';
                        // }

                        // 복합과세금액
                        if ($default['de_tax_flag_use']) {
                            if ($row['it_notax']) {
                                $comm_free_mny += $sum['price'];
                            } else {
                                $tot_tax_mny += $sum['price'];
                            }
                        }

                        $point      = $sum['point'];
                        $sell_price = $sum['price'];

                        // 쿠폰
                        if ($is_member) {
                            $cp_button = '';
                            $cp_count = 0;

                            $sql = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_start <= '" . G5_TIME_YMD . "'
                              and cp_end >= '" . G5_TIME_YMD . "'
                              and cp_minimum <= '$sell_price'
                              and (
                                    ( cp_method = '0' and cp_target = '{$row['it_id']}' )
                                    OR
                                    ( cp_method = '1' and ( cp_target IN ( '{$row['ca_id']}', '{$row['ca_id2']}', '{$row['ca_id3']}' ) ) )
                                  ) ";
                            $res = sql_query($sql);

                            for ($k = 0; $cp = sql_fetch_array($res); $k++) {
                                if (is_used_coupon($member['mb_id'], $cp['cp_id']))
                                    continue;

                                $cp_count++;
                            }

                            if ($cp_count) {
                                $cp_button = '<button type="button" class="cp_btn">쿠폰적용</button>';
                                $it_cp_count++;
                            }
                        }

                        // 배송비
                        switch ($row['ct_send_cost']) {
                            case 1:
                                $ct_send_cost = '착불';
                                break;
                            case 2:
                                $ct_send_cost = '무료';
                                break;
                            default:
                                $ct_send_cost = '선불';
                                break;
                        }

                        // 조건부무료
                        if ($row['it_sc_type'] == 2) {
                            $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                            if ($sendcost == 0)
                                $ct_send_cost = '무료';
                        }
                    ?>

                        <tr>
                            <td class="td_num"><?php echo $row['select_date']; ?></td>
                            <td class="td_prd">
                                <div class="sod_img"><?php echo $image; ?></div>
                                <div class="sod_name">
                                    <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                                    <input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($row['it_name']); ?>">
                                    <input type="hidden" name="it_price[<?php echo $i; ?>]" value="<?php echo $sell_price; ?>">
                                    <input type="hidden" name="cp_id[<?php echo $i; ?>]" value="">
                                    <input type="hidden" name="cp_price[<?php echo $i; ?>]" value="0">
                                    <?php if ($default['de_tax_flag_use']) { ?>
                                        <input type="hidden" name="it_notax[<?php echo $i; ?>]" value="<?php echo $row['it_notax']; ?>">
                                    <?php } ?>
                                    <?php echo $it_name; ?>
                                    <?php echo $cp_button; ?>

                                </div>
                            </td>
                            <td class="td_num"><?php echo number_format($sum['qty']); ?></td>
                            <td class="td_numbig  text_right"><span class="total_price"><?php echo number_format($sell_price); ?></span></td>
                        </tr>

                    <?php
                        $tot_point      += $point;
                        $tot_sell_price += $sell_price;
                    } // for 끝

                    if ($i == 0) {
                        //echo '<tr><td colspan="7" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
                        alert('장바구니가 비어 있습니다.', G5_SHOP_URL . '/cart.php');
                    } else {
                        // 배송비 계산
                        $send_cost = get_sendcost($s_cart_id);
                    }

                    // 복합과세처리
                    if ($default['de_tax_flag_use']) {
                        $comm_tax_mny = round(($tot_tax_mny + $send_cost) / 1.1);
                        $comm_vat_mny = ($tot_tax_mny + $send_cost) - $comm_tax_mny;
                    }
                    $tot_price = $tot_sell_price;
                    ?>
                </tbody>
            </table>
        </div>

        <?php if ($goods_count) $goods .= ' 외 ' . $goods_count . '건'; ?>
        <!-- } 주문상품 확인 끝 -->

        <section class="sod_left fl m1 mf0">
            <input type="hidden" name="od_price" value="<?php echo $tot_sell_price; ?>">
            <input type="hidden" name="org_od_price" value="<?php echo $tot_sell_price; ?>">
            <input type="hidden" name="od_send_cost" value="<?php echo $send_cost; ?>">
            <input type="hidden" name="od_send_cost2" value="0">
            <input type="hidden" name="item_coupon" value="0">
            <input type="hidden" name="od_coupon" value="0">
            <input type="hidden" name="od_send_coupon" value="0">
            <input type="hidden" name="od_goods_name" value="<?php echo $goods; ?>">

            <?php
            // 결제대행사별 코드 include (결제대행사 정보 필드)
            require_once(G5_SHOP_PATH . '/' . $default['de_pg_service'] . '/orderform.2.php');

            if ($is_kakaopay_use) {
                require_once(G5_SHOP_PATH . '/kakaopay/orderform.2.php');
            }
            ?>

            <div style="background-color:#EC8AAB; color:#FFF; font-weight:600; margin-bottom:10px;">
              <div class="sod_schedule_hd_txt fl <?php if(substr($it['ca_id'],0,2)=='30') echo "none";?>">
                <p style="padding:22px 25px 18px; font-size:1.7em;"><span>SCHEDULE: </span> from <b><?php echo date('F d',strtotime($it['it_maker'])); ?></b> to <b><?php echo date('F d',strtotime($it['it_origin'])); ?></b></p>
              </div>
            </div>
            <!-- 주문하시는 분 입력 시작 { -->
            <section id="sod_frm_orderer">
                <div class="buyInfo" style="background-color:#FFF; padding:20px; margin-bottom:50px;">
                    <!-- 주문자 정보 받기 -->
                    <div style="padding:15px; color:#FFF; background-color:#bfc1c0; font-weight:bold; font-size:1.3em;">Buyer information</div>
                    <div id="sit_inf_explan" style="padding:15px;">
                        <ul>
                            <li>
                                <label style="width:44%; float:left; margin-right:11.9%;" for="fname">First Name</label>
                                <label style="width:44%; float:left;" for="lname">Last Name</label>
                            </li>
                            <li>
                              <input style="width:44%; float:left; margin-right:11.9%;" type="text" required class="required frm_input full_input name" value="<?php echo get_text($member['mb_name']); ?>" id="fname" name="od_addr2">
                              <input style="width:44%; float:left;" type="text" required class="required frm_input full_input name" value="<?php echo get_text($member['mb_nick']); ?>" id="lname" name="od_addr3">
                              <input type="hidden" name="od_name" value="" id="od_name" required class="frm_input required" maxlength="20">
                            </li>
                            <li><label style="width:44%; float:left; margin-right:11.9%;" for="od_addr1">Country</label><label style="width:44%; float:left;" for="od_tel">Phone number</label></li>
                            <li>
                                    <select name="od_addr1" id="od_addr1" <?php echo $required ?> style="width:44%; float:left; margin-right:11.9%;">
                    									<option disabled selected value="">ex) United States, Japan...</option>
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
                                    <script>
                                      $("#od_addr1").val("<?= $member['mb_1'] ?>").attr("selected", "selected");
                                    </script><input style="width:44%; float:left;" type="text" required class="required frm_input full_input name" name="od_tel" id="od_tel" value="<?php echo get_text($member['mb_tel']); ?>">
                                  </li>

                                  <li><label style="width:100%; float:left;" for="r_addr">Address</label></li>
                                  <li><input style="width:100%; float:left;" type="text" required class="required frm_input full_input name" name="r_addr" id="r_addr" value="<?php echo get_text($member['mb_addr1']).' '.get_text($member['mb_addr2']); ?>"></li>
                                  <li><label style="width:100%; float:left;" for="od_email">Email</label></li>
                                  <li><input style="width:100%; float:left;" type="text" required class="required frm_input full_input name" name="od_email" id="od_email" value="<?php echo get_text($member['mb_email']); ?>"></li>
                                </div>
                    <div style="padding:15px; color:#FFF; background-color:#bfc1c0; font-weight:bold; font-size:1.3em; margin-top:10px;"><?php if(substr($it['ca_id'],0,2)=='30') echo "Delivery Information"; else echo "Traveler information";?></div>
                    <div id="sit_inf_explan" style="padding:15px;">
                        <ul>
                          <li>
                            <label for="b_fname" style="width:30%; float:left; margin-right:4.9%">Passport name (first)</label>
                            <label for="b_lname" style="width:30%; float:left; margin-right:4.9%">Passport name (last)</label>
                            <label for="gender" style="width:30%; float:left;">Gender</label>
                          </li>
                          <li><input style="width:30%; float:left; margin-right:4.9%" type="text" required class="required frm_input full_input name" name="od_b_addr2" id="b_fname">
                            <input style="width:30%; float:left; margin-right:4.9%" type="text" required class="required frm_input full_input name" name="od_b_addr3" id="b_lname">
                            <select style="width:30%; float:left;" name="od_addr_jibeon" id="gender" class="required frm_input full_input name">
                              <option value="Male">Male</option>
                              <option value="FeMale">Female</option>
                            </select>
                          </li>
                          <li>
                            <label style="width:44%; float:left; margin-right:11.9%;"for="od_b_addr1">Country</label>
                            <label style="width:44%; float:left;"for="od_b_tel" style="width:100%;">Phone number</label>
                          </li>
                          <li>
                                <select name="od_b_addr1" id="od_b_addr1" <?php echo $required ?> style="width:44%; float:left; margin-right:11.9%;">
                    							<option disabled selected value="">ex) United States, Japan...</option>
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
                                <input style="width:44%; float:left;" type="text" required class="required frm_input full_input name" name="od_b_tel" id="od_b_tel">
                            </li>
                            <li><label style="width:100%; float:left;" for="r_b_addr">Address</label></li>
                            <li><input style="width:100%; float:left;" type="text" required class="required frm_input full_input name" name="r_b_addr" id="r_b_addr"></li>
                            <li><label style="width:100%; float:left;" for="b_email">Email</label></li>
                            <li><input style="width:100%; float:left;" type="text" required class="required frm_input full_input name" name="od_b_addr_jibeon" id="b_email"></li>
                            <li><label style="width:100%; float:left;" for="od_memo">Memo</label></li>
                            <li><textarea style="width:100%; float:left; height:150px" type="text" required class="required frm_input full_input name" name="od_memo" id="od_memo"></textarea></li>
                        </ul>
                    </div>
                    <div style="padding:15px; color:#FFF; background-color:#bfc1c0; font-weight:bold; font-size:1.3em; margin-top:10px;">Select payment method</div>
                    <div id="sit_inf_explan" style="padding:15px;">
                        <ul>
                            <li>
                              <?php
                              // wetoz : eximbay
                              if ($default['de_eximbay_use']) {

                              ?>
                                  <style>
                                      #sod_frm_paysel .paypal_icon {
                                          background: url('./eximbay/img/pay_icon12.png') no-repeat 17px 50% #fff;
                                      }

                                      #sod_frm_paysel .alipay_icon {
                                          background: url('./eximbay/img/pay_icon11.png') no-repeat 17px 50% #fff;
                                      }

                                      #sod_frm_paysel .wechat_icon {
                                          background: url('./eximbay/img/pay_icon10.png') no-repeat 17px 50% #fff;
                                      }
                                  </style>
                                  <?php
                                  require_once(G5_SHOP_PATH . '/eximbay/orderform.enc.php');
                                  $de_eximbay_pay = unserialize($default['de_eximbay_pay']);
                                  if (is_array($de_eximbay_pay)) {
                                      $z = 0;
                                      foreach ($de_eximbay_pay as $k) {
                                          $pay_name = payment_type($k);
                                          $pay_class = 'card_icon';
                                          if (strtolower($pay_name) == 'paypal') {
                                              $pay_class = 'paypal_icon';
                                          } else if (strtolower($pay_name) == 'alipay') {
                                              $pay_class = 'alipay_icon';
                                          } else if (strtolower($pay_name) == 'wechat') {
                                              $pay_class = 'wechat_icon';
                                          }
                                          if($z==0) $check='checked';
                                          else $check ='';
                                          echo '<input type="radio" id="od_settle_eximbay' . $z . '" name="od_settle_case" value="' . $k . '" class="od_settle_eximbay" style="margin-top:11px;" data-eximbay="1"' . $check . '>
                                                <label for="od_settle_eximbay' . $z . '" class="lb_icon ' . $pay_class . '" style="margin-right:5%; padding-left:0.5%;">' . $pay_name . '</label>' . PHP_EOL;
                                          $z++;
                                      }
                                      $checked = '';
                                  }
                                  $multi_settle++;
                              }
                                // 무통장입금 사용
                                if ($default['de_bank_use']) {
                                  $multi_settle++;
                                  echo '<input type="radio" id="od_settle_bank" name="od_settle_case" style="margin-top:11px;" value="무통장" '.$checked.'>
                                        <label for="od_settle_bank" class="lb_icon bank_icon" style="padding-left:0;">무통장입금</label>'.PHP_EOL; $checked = '';
                                }
                                if ($default['de_bank_use']) {
                                    // 은행계좌를 배열로 만든후
                                      $str = explode("\n", trim($default['de_bank_account']));

                                      $bank_account = '<select name="od_bank_account" id="od_bank_account">' . PHP_EOL;
                                      $bank_account .= '<option value="">선택하십시오.</option>';
                                      for ($i = 0; $i < count($str); $i++) {
                                        //$str[$i] = str_replace("\r", "", $str[$i]);
                                        $str[$i] = trim($str[$i]);
                                        $bank_account .= '<option value="' . $str[$i] . '">' . $str[$i] . '</option>' . PHP_EOL;
                                      }
                                    $bank_account .= '</select>' . PHP_EOL;
                                    echo '</li>
                                          <div id="settle_bank" style="display:none">';
                                    echo '<li><label for="od_bank_account">계좌정보</label>';
                                    echo $bank_account;
                                    echo '<li><label for="od_deposit_name">입금자명</label> ';
                                    echo '<input type="text" name="od_deposit_name" id="od_deposit_name" size="10" maxlength="20"></li>';
                                    echo '</div>';
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- } 받으시는 분 입력 끝 -->
        </section>

        <section class="sod_right">

            <!-- 결제정보 입력 시작 { -->
            <?php
            $oc_cnt = $sc_cnt = 0;
            if ($is_member) {
                // 주문쿠폰
                $sql = " select cp_id
                        from {$g5['g5_shop_coupon_table']}
                        where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                          and cp_method = '2'
                          and cp_start <= '" . G5_TIME_YMD . "'
                          and cp_end >= '" . G5_TIME_YMD . "'
                          and cp_minimum <= '$tot_sell_price' ";
                $res = sql_query($sql);

                for ($k = 0; $cp = sql_fetch_array($res); $k++) {
                    if (is_used_coupon($member['mb_id'], $cp['cp_id']))
                        continue;

                    $oc_cnt++;
                }

                if ($send_cost > 0) {
                    // 배송비쿠폰
                    $sql = " select cp_id
                            from {$g5['g5_shop_coupon_table']}
                            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
                              and cp_method = '3'
                              and cp_start <= '" . G5_TIME_YMD . "'
                              and cp_end >= '" . G5_TIME_YMD . "'
                              and cp_minimum <= '$tot_sell_price' ";
                    $res = sql_query($sql);

                    for ($k = 0; $cp = sql_fetch_array($res); $k++) {
                        if (is_used_coupon($member['mb_id'], $cp['cp_id']))
                            continue;

                        $sc_cnt++;
                    }
                }
            }

            ?>

            <section id="sod_frm_pay" class="fl m1 mf0" style="width:100%; margin-left:15px;  font-weight:600; padding-right:15px; background-color:#FFF; font-size:1.1em;">
              <div style="background-color:#FFF;" id="side_sel">
                <!-- <h2>결제정보</h2> -->
                <div style="background-color:#603779; color:#FFF; height:51px; line-height:50px;  padding-left:20px; font-size:1.2em;text-align:left;">
                    Number of Personnel
                </div>
                <div style="background-color:#603779; color:#FFF; height:41px; margin-top:-5px; font-size:1.2em; padding-right:20px; text-align:right;">
                    <?= number_format($sum['qty']) ?> <?php if(substr($it['ca_id'],0,2)=='30') echo "Purchases"; else echo "Person";?>
                </div>
                <div id="sit_tot_price" style="color:#565656; padding:20px; margin-top:-5px; margin-bottom:-35px; font-size:1.4em; font-weight:300;">
                    TOTAL PRICE
                </div>
                <div id="sit_tot_price" style="color:#a7a7a7; font-weight:700; padding:20px; margin-bottom:15px; font-size:2.4em;">
                    <span>$<?php echo number_format($tot_price); ?></span>
                </div>
                <!-- <div id="od_tot_price">
                    <span>TOTAL PRICE</span>
                    <strong></strong>
                </div> -->

                <div id="od_pay_sl">
                    <!-- <h3>결제수단</h3> -->
                    <?php
                    $multi_settle == 0;
                    $checked = '';

                    $escrow_title = "";
                    if ($default['de_escrow_use']) {
                        $escrow_title = "에스크로<br>";
                    }

                    if ($is_kakaopay_use || $default['de_bank_use'] || $default['de_vbank_use'] || $default['de_iche_use'] || $default['de_card_use'] || $default['de_hp_use'] || $default['de_easy_pay_use'] || $default['de_inicis_lpay_use']) {
                        echo '<fieldset id="sod_frm_paysel">';
                        echo '<legend>결제방법 선택</legend>';
                    }

                    // 카카오페이
                    if ($is_kakaopay_use) {
                        $multi_settle++;
                        echo '<input type="radio" id="od_settle_kakaopay" name="od_settle_case" value="KAKAOPAY" ' . $checked . '> <label for="od_settle_kakaopay" class="kakaopay_icon lb_icon">KAKAOPAY</label>' . PHP_EOL;
                        $checked = '';
                    }

                    // 가상계좌 사용
                    if ($default['de_vbank_use']) {
                        $multi_settle++;
                        echo '<input type="radio" id="od_settle_vbank" name="od_settle_case" value="가상계좌" ' . $checked . '> <label for="od_settle_vbank" class="lb_icon vbank_icon">' . $escrow_title . '가상계좌</label>' . PHP_EOL;
                        $checked = '';
                    }

                    // 계좌이체 사용
                    if ($default['de_iche_use']) {
                        $multi_settle++;
                        echo '<input type="radio" id="od_settle_iche" name="od_settle_case" value="계좌이체" ' . $checked . '> <label for="od_settle_iche" class="lb_icon iche_icon">' . $escrow_title . '계좌이체</label>' . PHP_EOL;
                        $checked = '';
                    }

                    // 휴대폰 사용
                    if ($default['de_hp_use']) {
                        $multi_settle++;
                        echo '<input type="radio" id="od_settle_hp" name="od_settle_case" value="휴대폰" ' . $checked . '> <label for="od_settle_hp" class="lb_icon hp_icon">휴대폰</label>' . PHP_EOL;
                        $checked = '';
                    }


                    // PG 간편결제
                    if ($default['de_easy_pay_use']) {
                        switch ($default['de_pg_service']) {
                            case 'lg':
                                $pg_easy_pay_name = 'PAYNOW';
                                break;
                            case 'inicis':
                                $pg_easy_pay_name = 'KPAY';
                                break;
                            default:
                                $pg_easy_pay_name = 'PAYCO';
                                break;
                        }

                        $multi_settle++;
                        echo '<input type="radio" id="od_settle_easy_pay" name="od_settle_case" value="간편결제" ' . $checked . '> <label for="od_settle_easy_pay" class="' . $pg_easy_pay_name . ' lb_icon">' . $pg_easy_pay_name . '</label>' . PHP_EOL;
                        $checked = '';
                    }

                    //이니시스 Lpay
                    if ($default['de_inicis_lpay_use']) {
                        echo '<input type="radio" id="od_settle_inicislpay" data-case="lpay" name="od_settle_case" value="lpay" ' . $checked . '> <label for="od_settle_inicislpay" class="inicis_lpay lb_icon">L.pay</label>' . PHP_EOL;
                        $checked = '';
                    }

                    $temp_point = 0;
                    // 회원이면서 포인트사용이면
                    if ($is_member && $config['cf_use_point']) {
                        // 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
                        if ($member['mb_point'] >= $default['de_settle_min_point']) {
                            $temp_point = (int) $default['de_settle_max_point'];

                            if ($temp_point > (int) $tot_sell_price)
                                $temp_point = (int) $tot_sell_price;

                            if ($temp_point > (int) $member['mb_point'])
                                $temp_point = (int) $member['mb_point'];

                            $point_unit = (int) $default['de_settle_point_unit'];
                            $temp_point = (int) ((int) ($temp_point / $point_unit) * $point_unit);
                        ?>
                            <div class="sod_frm_point">
                                <div>
                                    <label for="od_temp_point">사용 포인트(<?php echo $point_unit; ?>점 단위)</label>
                                    <input type="hidden" name="max_temp_point" value="<?php echo $temp_point; ?>">
                                    <input type="text" name="od_temp_point" value="0" id="od_temp_point" size="7"> 점
                                </div>
                                <div id="sod_frm_pt">
                                    <span><strong>보유포인트</strong><?php echo display_point($member['mb_point']); ?></span>
                                    <span class="max_point_box"><strong>최대 사용 가능 포인트</strong><em id="use_max_point"><?php echo display_point($temp_point); ?></em></span>
                                </div>
                            </div>
                    <?php
                            $multi_settle++;
                        }
                    }

                    if ($is_kakaopay_use || $default['de_bank_use'] || $default['de_vbank_use'] || $default['de_iche_use'] || $default['de_card_use'] || $default['de_hp_use'] || $default['de_easy_pay_use'] || $default['de_inicis_lpay_use']) {
                        echo '</fieldset>';
                    }

                    if ($multi_settle == 0)
                        echo '<p>결제할 방법이 없습니다.<br>운영자에게 알려주시면 감사하겠습니다.</p>';
                    ?>
                </div>
            <!-- } 결제 정보 입력 끝 -->
            <?php
            // 결제대행사별 코드 include (주문버튼)
            require_once(G5_SHOP_PATH . '/' . $default['de_pg_service'] . '/orderform.3.php');

            if ($is_kakaopay_use) {
                require_once(G5_SHOP_PATH . '/kakaopay/orderform.3.php');
            }
            ?>

            <?php
            if ($default['de_escrow_use']) {
                // 결제대행사별 코드 include (에스크로 안내)
                require_once(G5_SHOP_PATH . '/' . $default['de_pg_service'] . '/orderform.4.php');
            }
            ?>
          </div>
            </section>
        </section>
    </div>
</form>

<?php
if ($default['de_inicis_lpay_use']) {   //이니시스 L.pay 사용시
    require_once(G5_SHOP_PATH . '/inicis/lpay_order.script.php');
}
?>
<script>
    var zipcode = "";
    var form_action_url = "<?php echo $order_action_url; ?>";

    $(function() {
        var $cp_btn_el;
        var $cp_row_el;

        $(".cp_btn").click(function() {
            $cp_btn_el = $(this);
            $cp_row_el = $(this).closest("tr");
            $("#cp_frm").remove();
            var it_id = $cp_btn_el.closest("tr").find("input[name^=it_id]").val();

            $.post(
                "./orderitemcoupon.php", {
                    it_id: it_id,
                    sw_direct: "<?php echo $sw_direct; ?>"
                },
                function(data) {
                    $cp_btn_el.after(data);
                }
            );
        });

        $(document).on("click", ".cp_apply", function() {
            var $el = $(this).closest("tr");
            var cp_id = $el.find("input[name='f_cp_id[]']").val();
            var price = $el.find("input[name='f_cp_prc[]']").val();
            var subj = $el.find("input[name='f_cp_subj[]']").val();
            var sell_price;

            if (parseInt(price) == 0) {
                if (!confirm(subj + "쿠폰의 할인 금액은 " + price + "원입니다.\n쿠폰을 적용하시겠습니까?")) {
                    return false;
                }
            }

            // 이미 사용한 쿠폰이 있는지
            var cp_dup = false;
            var cp_dup_idx;
            var $cp_dup_el;
            $("input[name^=cp_id]").each(function(index) {
                var id = $(this).val();

                if (id == cp_id) {
                    cp_dup_idx = index;
                    cp_dup = true;
                    $cp_dup_el = $(this).closest("tr");;

                    return false;
                }
            });

            if (cp_dup) {
                var it_name = $("input[name='it_name[" + cp_dup_idx + "]']").val();
                if (!confirm(subj + "쿠폰은 " + it_name + "에 사용되었습니다.\n" + it_name + "의 쿠폰을 취소한 후 적용하시겠습니까?")) {
                    return false;
                } else {
                    coupon_cancel($cp_dup_el);
                    $("#cp_frm").remove();
                    $cp_dup_el.find(".cp_btn").text("적용").focus();
                    $cp_dup_el.find(".cp_cancel").remove();
                }
            }

            var $s_el = $cp_row_el.find(".total_price");;
            sell_price = parseInt($cp_row_el.find("input[name^=it_price]").val());
            sell_price = sell_price - parseInt(price);
            if (sell_price < 0) {
                alert("쿠폰할인금액이 상품 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
                return false;
            }
            $s_el.text(number_format(String(sell_price)));
            $cp_row_el.find("input[name^=cp_id]").val(cp_id);
            $cp_row_el.find("input[name^=cp_price]").val(price);

            calculate_total_price();
            $("#cp_frm").remove();
            $cp_btn_el.text("변경").focus();
            if (!$cp_row_el.find(".cp_cancel").size())
                $cp_btn_el.after("<button type=\"button\" class=\"cp_cancel\">취소</button>");
        });

        $(document).on("click", "#cp_close", function() {
            $("#cp_frm").remove();
            $cp_btn_el.focus();
        });

        $(document).on("click", ".cp_cancel", function() {
            coupon_cancel($(this).closest("tr"));
            calculate_total_price();
            $("#cp_frm").remove();
            $(this).closest("tr").find(".cp_btn").text("적용").focus();
            $(this).remove();
        });

        $("#od_coupon_btn").click(function() {
            $("#od_coupon_frm").remove();
            var $this = $(this);
            var price = parseInt($("input[name=org_od_price]").val()) - parseInt($("input[name=item_coupon]").val());
            if (price <= 0) {
                alert('상품금액이 0원이므로 쿠폰을 사용할 수 없습니다.');
                return false;
            }
            $.post(
                "./ordercoupon.php", {
                    price: price
                },
                function(data) {
                    $this.after(data);
                }
            );
        });

        $(document).on("click", ".od_cp_apply", function() {
            var $el = $(this).closest("tr");
            var cp_id = $el.find("input[name='o_cp_id[]']").val();
            var price = parseInt($el.find("input[name='o_cp_prc[]']").val());
            var subj = $el.find("input[name='o_cp_subj[]']").val();
            var send_cost = $("input[name=od_send_cost]").val();
            var item_coupon = parseInt($("input[name=item_coupon]").val());
            var od_price = parseInt($("input[name=org_od_price]").val()) - item_coupon;

            if (price == 0) {
                if (!confirm(subj + "쿠폰의 할인 금액은 " + price + "원입니다.\n쿠폰을 적용하시겠습니까?")) {
                    return false;
                }
            }

            if (od_price - price <= 0) {
                alert("쿠폰할인금액이 주문금액보다 크므로 쿠폰을 적용할 수 없습니다.");
                return false;
            }

            $("input[name=sc_cp_id]").val("");
            $("#sc_coupon_btn").text("쿠폰적용");
            $("#sc_coupon_cancel").remove();

            $("input[name=od_price]").val(od_price - price);
            $("input[name=od_cp_id]").val(cp_id);
            $("input[name=od_coupon]").val(price);
            $("input[name=od_send_coupon]").val(0);
            $("#od_cp_price").text(number_format(String(price)));
            $("#sc_cp_price").text(0);
            calculate_order_price();
            $("#od_coupon_frm").remove();
            $("#od_coupon_btn").text("변경").focus();
            if (!$("#od_coupon_cancel").size())
                $("#od_coupon_btn").after("<button type=\"button\" id=\"od_coupon_cancel\" class=\"cp_cancel\">취소</button>");
        });

        $(document).on("click", "#od_coupon_close", function() {
            $("#od_coupon_frm").remove();
            $("#od_coupon_btn").focus();
        });

        $(document).on("click", "#od_coupon_cancel", function() {
            var org_price = $("input[name=org_od_price]").val();
            var item_coupon = parseInt($("input[name=item_coupon]").val());
            $("input[name=od_price]").val(org_price - item_coupon);
            $("input[name=sc_cp_id]").val("");
            $("input[name=od_coupon]").val(0);
            $("input[name=od_send_coupon]").val(0);
            $("#od_cp_price").text(0);
            $("#sc_cp_price").text(0);
            calculate_order_price();
            $("#od_coupon_frm").remove();
            $("#od_coupon_btn").text("쿠폰적용").focus();
            $(this).remove();
            $("#sc_coupon_btn").text("쿠폰적용");
            $("#sc_coupon_cancel").remove();
        });

        $("#sc_coupon_btn").click(function() {
            $("#sc_coupon_frm").remove();
            var $this = $(this);
            var price = parseInt($("input[name=od_price]").val());
            var send_cost = parseInt($("input[name=od_send_cost]").val());
            $.post(
                "./ordersendcostcoupon.php", {
                    price: price,
                    send_cost: send_cost
                },
                function(data) {
                    $this.after(data);
                }
            );
        });

        $(document).on("click", ".sc_cp_apply", function() {
            var $el = $(this).closest("tr");
            var cp_id = $el.find("input[name='s_cp_id[]']").val();
            var price = parseInt($el.find("input[name='s_cp_prc[]']").val());
            var subj = $el.find("input[name='s_cp_subj[]']").val();
            var send_cost = parseInt($("input[name=od_send_cost]").val());

            if (parseInt(price) == 0) {
                if (!confirm(subj + "쿠폰의 할인 금액은 " + price + "원입니다.\n쿠폰을 적용하시겠습니까?")) {
                    return false;
                }
            }

            $("input[name=sc_cp_id]").val(cp_id);
            $("input[name=od_send_coupon]").val(price);
            $("#sc_cp_price").text(number_format(String(price)));
            calculate_order_price();
            $("#sc_coupon_frm").remove();
            $("#sc_coupon_btn").text("변경").focus();
            if (!$("#sc_coupon_cancel").size())
                $("#sc_coupon_btn").after("<button type=\"button\" id=\"sc_coupon_cancel\" class=\"cp_cancel\">취소</button>");
        });

        $(document).on("click", "#sc_coupon_close", function() {
            $("#sc_coupon_frm").remove();
            $("#sc_coupon_btn").focus();
        });

        $(document).on("click", "#sc_coupon_cancel", function() {
            $("input[name=od_send_coupon]").val(0);
            $("#sc_cp_price").text(0);
            calculate_order_price();
            $("#sc_coupon_frm").remove();
            $("#sc_coupon_btn").text("쿠폰적용").focus();
            $(this).remove();
        });

        $("#od_b_addr2").focus(function() {
            var zip = $("#od_b_zip").val().replace(/[^0-9]/g, "");
            if (zip == "")
                return false;

            var code = String(zip);

            if (zipcode == code)
                return false;

            zipcode = code;
            calculate_sendcost(code);
        });

        $("#od_settle_bank").on("click", function() {
            $("[name=od_deposit_name]").val($("[name=od_name]").val());
            $("#settle_bank").show();
        });

        // wetoz : eximbay : ,.od_settle_eximbay 추가
        $("#od_settle_iche,#od_settle_card,#od_settle_vbank,#od_settle_hp,#od_settle_easy_pay,#od_settle_kakaopay,.od_settle_eximbay").bind("click", function() {
            $("#settle_bank").hide();
        });

        // 배송지선택
        $("input[name=ad_sel_addr]").on("click", function() {
            var addr = $(this).val().split(String.fromCharCode(30));

            if (addr[0] == "same") {
                gumae2baesong();
            } else {
                if (addr[0] == "new") {
                    for (i = 0; i < 10; i++) {
                        addr[i] = "";
                    }
                }
                var f = document.forderform;
                f.od_b_name.value = addr[0];
                f.od_b_tel.value = addr[1];
                f.od_b_hp.value = addr[2];
                f.od_b_zip.value = addr[3] + addr[4];
                f.od_b_addr1.value = addr[5];
                f.od_b_addr2.value = addr[6];
                f.od_b_addr3.value = addr[7];
                f.od_b_addr_jibeon.value = addr[8];
                f.ad_subject.value = addr[9];

                var zip1 = addr[3].replace(/[^0-9]/g, "");
                var zip2 = addr[4].replace(/[^0-9]/g, "");

                var code = String(zip1) + String(zip2);

                if (zipcode != code) {
                    calculate_sendcost(code);
                }
            }
        });

        // 배송지목록
        $("#order_address").on("click", function() {
            var url = this.href;
            window.open(url, "win_address", "left=100,top=100,width=800,height=600,scrollbars=1");
            return false;
        });
    });

    function coupon_cancel($el) {
        var $dup_sell_el = $el.find(".total_price");
        var $dup_price_el = $el.find("input[name^=cp_price]");
        var org_sell_price = $el.find("input[name^=it_price]").val();

        $dup_sell_el.text(number_format(String(org_sell_price)));
        $dup_price_el.val(0);
        $el.find("input[name^=cp_id]").val("");
    }

    function calculate_total_price() {
        var $it_prc = $("input[name^=it_price]");
        var $cp_prc = $("input[name^=cp_price]");
        var tot_sell_price = sell_price = tot_cp_price = 0;
        var it_price, cp_price, it_notax;
        var tot_mny = comm_tax_mny = comm_vat_mny = comm_free_mny = tax_mny = vat_mny = 0;
        var send_cost = parseInt($("input[name=od_send_cost]").val());

        $it_prc.each(function(index) {
            it_price = parseInt($(this).val());
            cp_price = parseInt($cp_prc.eq(index).val());
            sell_price += it_price;
            tot_cp_price += cp_price;
        });

        tot_sell_price = sell_price - tot_cp_price + send_cost;

        $("#ct_tot_coupon").text(number_format(String(tot_cp_price)));
        $("#ct_tot_price").text(number_format(String(tot_sell_price)));

        $("input[name=good_mny]").val(tot_sell_price);
        $("input[name=od_price]").val(sell_price - tot_cp_price);
        $("input[name=item_coupon]").val(tot_cp_price);
        $("input[name=od_coupon]").val(0);
        $("input[name=od_send_coupon]").val(0);
        <?php if ($oc_cnt > 0) { ?>
            $("input[name=od_cp_id]").val("");
            $("#od_cp_price").text(0);
            if ($("#od_coupon_cancel").size()) {
                $("#od_coupon_btn").text("쿠폰적용");
                $("#od_coupon_cancel").remove();
            }
        <?php } ?>
        <?php if ($sc_cnt > 0) { ?>
            $("input[name=sc_cp_id]").val("");
            $("#sc_cp_price").text(0);
            if ($("#sc_coupon_cancel").size()) {
                $("#sc_coupon_btn").text("쿠폰적용");
                $("#sc_coupon_cancel").remove();
            }
        <?php } ?>
        $("input[name=od_temp_point]").val(0);
        <?php if ($temp_point > 0 && $is_member) { ?>
            calculate_temp_point();
        <?php } ?>
        calculate_order_price();
    }

    function calculate_order_price() {
        var sell_price = parseInt($("input[name=od_price]").val());
        var send_cost = parseInt($("input[name=od_send_cost]").val());
        var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
        var send_coupon = parseInt($("input[name=od_send_coupon]").val());
        var tot_price = sell_price + send_cost + send_cost2 - send_coupon;

        $("input[name=good_mny]").val(tot_price);
        $("#od_tot_price").text(number_format(String(tot_price)));
        <?php if ($temp_point > 0 && $is_member) { ?>
            calculate_temp_point();
        <?php } ?>
    }

    function calculate_temp_point() {
        var sell_price = parseInt($("input[name=od_price]").val());
        var mb_point = parseInt(<?php echo $member['mb_point']; ?>);
        var max_point = parseInt(<?php echo $default['de_settle_max_point']; ?>);
        var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
        var temp_point = max_point;

        if (temp_point > sell_price)
            temp_point = sell_price;

        if (temp_point > mb_point)
            temp_point = mb_point;

        temp_point = parseInt(temp_point / point_unit) * point_unit;

        $("#use_max_point").text(number_format(String(temp_point)) + "점");
        $("input[name=max_temp_point]").val(temp_point);
    }

    function calculate_sendcost(code) {
        $.post(
            "./ordersendcost.php", {
                zipcode: code
            },
            function(data) {
                $("input[name=od_send_cost2]").val(data);
                $("#od_send_cost2").text(number_format(String(data)));

                zipcode = code;

                calculate_order_price();
            }
        );
    }

    function calculate_tax() {
        var $it_prc = $("input[name^=it_price]");
        var $cp_prc = $("input[name^=cp_price]");
        var sell_price = tot_cp_price = 0;
        var it_price, cp_price, it_notax;
        var tot_mny = comm_free_mny = tax_mny = vat_mny = 0;
        var send_cost = parseInt($("input[name=od_send_cost]").val());
        var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
        var od_coupon = parseInt($("input[name=od_coupon]").val());
        var send_coupon = parseInt($("input[name=od_send_coupon]").val());
        var temp_point = 0;

        $it_prc.each(function(index) {
            it_price = parseInt($(this).val());
            cp_price = parseInt($cp_prc.eq(index).val());
            sell_price += it_price;
            tot_cp_price += cp_price;
            it_notax = $("input[name^=it_notax]").eq(index).val();
            if (it_notax == "1") {
                comm_free_mny += (it_price - cp_price);
            } else {
                tot_mny += (it_price - cp_price);
            }
        });

        if ($("input[name=od_temp_point]").size())
            temp_point = parseInt($("input[name=od_temp_point]").val());

        tot_mny += (send_cost + send_cost2 - od_coupon - send_coupon - temp_point);
        if (tot_mny < 0) {
            comm_free_mny = comm_free_mny + tot_mny;
            tot_mny = 0;
        }

        tax_mny = Math.round(tot_mny / 1.1);
        vat_mny = tot_mny - tax_mny;
        $("input[name=comm_tax_mny]").val(tax_mny);
        $("input[name=comm_vat_mny]").val(vat_mny);
        $("input[name=comm_free_mny]").val(comm_free_mny);
    }

    function forderform_check(f) {
        // 재고체크
        var stock_msg = order_stock_check();
        if (stock_msg != "") {
            alert(stock_msg);
            return false;
        }

        errmsg = "";
        errfld = "";
        var deffld = "";
        var fl_name = f.od_addr2.value + " " + f.od_addr3.value;
        f.od_name.value = fl_name;
        var fl_b_name = f.od_b_addr2.value + " " + f.od_b_addr3.value;
        f.od_name.value = fl_b_name;

        if (typeof(f.od_pwd) != 'undefined') {
            clear_field(f.od_pwd);
            if ((f.od_pwd.value.length < 3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/) != -1))
                error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
        }

        //check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
        // check_field(f.od_zip, "");

        clear_field(f.od_email);
        if (f.od_email.value == '' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
            error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

        if (typeof(f.od_hope_date) != "undefined") {
            clear_field(f.od_hope_date);
            if (!f.od_hope_date.value)
                error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
        }

        //check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
        check_field(f.od_name, "Buyer information First Name is Null");
        check_field(f.od_name, "Buyer information last Name is Null");
        check_field(f.od_tel, "Buyer information Phone number is Null");
        check_field(f.od_addr1, "Buyer information Country is Null");
        check_field(f.r_addr, "Buyer information Address is Null");

        check_field(f.od_b_tel, "Traveler information Phone number is Null");
        check_field(f.od_b_addr2, "Traveler information Passport name(first) is Null");
        check_field(f.od_b_addr3, "Traveler information Passport name(last) is Null");
        check_field(f.r_b_addr, "Traveler information Address is Null");
        check_field(f.od_b_addr_jibeon, "Traveler information email is Null");
        check_field(f.od_b_addr1, "Traveler information Country is Null");
        //check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
        // check_field(f.od_b_zip, "");

        var od_settle_bank = document.getElementById("od_settle_bank");
        if (od_settle_bank) {
            if (od_settle_bank.checked) {
                check_field(f.od_bank_account, "계좌번호를 선택하세요.");
                check_field(f.od_deposit_name, "입금자명을 입력하세요.");
            }
        }

        // 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
        f.od_send_cost.value = parseInt(f.od_send_cost.value);

        if (errmsg) {
            alert(errmsg);
            errfld.focus();
            return false;
        }

        var settle_case = document.getElementsByName("od_settle_case");
        var settle_check = false;
        var settle_method = "";
        for (i = 0; i < settle_case.length; i++) {
            if (settle_case[i].checked) {
                settle_check = true;
                settle_method = settle_case[i].value;
                break;
            }
        }
        if (!settle_check) {
            alert("결제방식을 선택하십시오.");
            return false;
        }

        var od_price = parseInt(f.od_price.value);
        var send_cost = parseInt(f.od_send_cost.value);
        var send_cost2 = parseInt(f.od_send_cost2.value);
        var send_coupon = parseInt(f.od_send_coupon.value);

        var max_point = 0;
        if (typeof(f.max_temp_point) != "undefined")
            max_point = parseInt(f.max_temp_point.value);

        var temp_point = 0;
        if (typeof(f.od_temp_point) != "undefined") {
            if (f.od_temp_point.value) {
                var point_unit = parseInt(<?php echo $default['de_settle_point_unit']; ?>);
                temp_point = parseInt(f.od_temp_point.value);

                if (temp_point < 0) {
                    alert("포인트를 0 이상 입력하세요.");
                    f.od_temp_point.select();
                    return false;
                }

                if (temp_point > od_price) {
                    alert("상품 주문금액(배송비 제외) 보다 많이 포인트결제할 수 없습니다.");
                    f.od_temp_point.select();
                    return false;
                }

                if (temp_point > <?php echo (int) $member['mb_point']; ?>) {
                    alert("회원님의 포인트보다 많이 결제할 수 없습니다.");
                    f.od_temp_point.select();
                    return false;
                }

                if (temp_point > max_point) {
                    alert(max_point + "점 이상 결제할 수 없습니다.");
                    f.od_temp_point.select();
                    return false;
                }

                if (parseInt(parseInt(temp_point / point_unit) * point_unit) != temp_point) {
                    alert("포인트를 " + String(point_unit) + "점 단위로 입력하세요.");
                    f.od_temp_point.select();
                    return false;
                }

                // pg 결제 금액에서 포인트 금액 차감
                if (settle_method != "무통장") {
                    f.good_mny.value = od_price + send_cost + send_cost2 - send_coupon - temp_point;
                }
            }
        }

        var tot_price = od_price + send_cost + send_cost2 - send_coupon - temp_point;

        if (document.getElementById("od_settle_iche")) {
            if (document.getElementById("od_settle_iche").checked) {
                if (tot_price < 150) {
                    alert("계좌이체는 150원 이상 결제가 가능합니다.");
                    return false;
                }
            }
        }

        // if (document.getElementById("od_settle_card")) {
        //     if (document.getElementById("od_settle_card").checked) {
        //         if (tot_price < 1000) {
        //             alert("신용카드는 1000원 이상 결제가 가능합니다.");
        //             return false;
        //         }
        //     }
        // }

        if (document.getElementById("od_settle_hp")) {
            if (document.getElementById("od_settle_hp").checked) {
                if (tot_price < 350) {
                    alert("휴대폰은 350원 이상 결제가 가능합니다.");
                    return false;
                }
            }
        }

        <?php if ($default['de_tax_flag_use']) { ?>
            calculate_tax();
        <?php } ?>

        <?php if ($default['de_pg_service'] == 'inicis') { ?>
            if (f.action != form_action_url) {
                f.action = form_action_url;
                f.removeAttribute("target");
                f.removeAttribute("accept-charset");
            }
        <?php } ?>

        // 카카오페이 지불
        if (settle_method == "KAKAOPAY") {
            <?php if ($default['de_tax_flag_use']) { ?>
                f.SupplyAmt.value = parseInt(f.comm_tax_mny.value) + parseInt(f.comm_free_mny.value);
                f.GoodsVat.value = parseInt(f.comm_vat_mny.value);
            <?php } ?>
            getTxnId(f);
            return false;
        }

        <?php if ($default['de_eximbay_use']) { // wetoz : eximbay
        ?>
            var eximbay_use = $(':input:radio[name=od_settle_case]:checked').attr('data-eximbay');
            if (eximbay_use == '1' && settle_method != '무통장') {
                fnSubmit(f);
                return false;
            }
        <?php } ?>

        var form_order_method = '';

        if (settle_method == "lpay") { //이니시스 L.pay 이면 ( 이니시스의 삼성페이는 모바일에서만 단독실행 가능함 )
            form_order_method = 'samsungpay';
        }

        if (jQuery(f).triggerHandler("form_sumbit_order_" + form_order_method) !== false) {

            // pay_method 설정
            <?php if ($default['de_pg_service'] == 'kcp') { ?>
                f.site_cd.value = f.def_site_cd.value;
                f.payco_direct.value = "";
                switch (settle_method) {
                    case "계좌이체":
                        f.pay_method.value = "010000000000";
                        break;
                    case "가상계좌":
                        f.pay_method.value = "001000000000";
                        break;
                    case "휴대폰":
                        f.pay_method.value = "000010000000";
                        break;
                    case "신용카드":
                        f.pay_method.value = "100000000000";
                        break;
                    case "간편결제":
                        <?php if ($default['de_card_test']) { ?>
                            f.site_cd.value = "S6729";
                        <?php } ?>
                        f.pay_method.value = "100000000000";
                        f.payco_direct.value = "Y";
                        break;
                    default:
                        f.pay_method.value = "무통장";
                        break;
                }
            <?php } else if ($default['de_pg_service'] == 'lg') { ?>
                f.LGD_EASYPAY_ONLY.value = "";
                if (typeof f.LGD_CUSTOM_USABLEPAY === "undefined") {
                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", "LGD_CUSTOM_USABLEPAY");
                    input.setAttribute("value", "");
                    f.LGD_EASYPAY_ONLY.parentNode.insertBefore(input, f.LGD_EASYPAY_ONLY);
                }

                switch (settle_method) {
                    case "계좌이체":
                        f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
                        f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
                        break;
                    case "가상계좌":
                        f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
                        f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
                        break;
                    case "휴대폰":
                        f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
                        f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
                        break;
                    case "신용카드":
                        f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
                        f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
                        break;
                    case "간편결제":
                        var elm = f.LGD_CUSTOM_USABLEPAY;
                        if (elm.parentNode)
                            elm.parentNode.removeChild(elm);
                        f.LGD_EASYPAY_ONLY.value = "PAYNOW";
                        break;
                    default:
                        f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
                        break;
                }
            <?php } else if ($default['de_pg_service'] == 'inicis') { ?>
                switch (settle_method) {
                    case "계좌이체":
                        f.gopaymethod.value = "DirectBank";
                        break;
                    case "가상계좌":
                        f.gopaymethod.value = "VBank";
                        break;
                    case "휴대폰":
                        f.gopaymethod.value = "HPP";
                        break;
                    case "신용카드":
                        f.gopaymethod.value = "Card";
                        f.acceptmethod.value = f.acceptmethod.value.replace(":useescrow", "");
                        break;
                    case "간편결제":
                        f.gopaymethod.value = "Kpay";
                        break;
                    case "lpay":
                        f.gopaymethod.value = "onlylpay";
                        f.acceptmethod.value = f.acceptmethod.value + ":cardonly";
                        break;
                    default:
                        f.gopaymethod.value = "무통장";
                        break;
                }
            <?php } ?>

            // 결제정보설정
            <?php if ($default['de_pg_service'] == 'kcp') { ?>
                f.buyr_name.value = f.od_name.value;
                f.buyr_mail.value = f.od_email.value;
                f.buyr_tel1.value = f.od_tel.value;
                f.buyr_tel2.value = f.od_hp.value;
                f.rcvr_name.value = f.od_b_name.value;
                f.rcvr_tel1.value = f.od_b_tel.value;
                f.rcvr_tel2.value = f.od_b_hp.value;
                f.rcvr_mail.value = f.od_email.value;
                f.rcvr_zipx.value = f.od_b_zip.value;
                f.rcvr_add1.value = f.od_b_addr1.value;
                f.rcvr_add2.value = f.od_b_addr2.value;

                if (f.pay_method.value != "무통장") {
                    jsf__pay(f);
                } else {
                    f.submit();
                }
            <?php } ?>
            <?php if ($default['de_pg_service'] == 'lg') { ?>
                f.LGD_BUYER.value = f.od_name.value;
                f.LGD_BUYEREMAIL.value = f.od_email.value;
                f.LGD_BUYERPHONE.value = f.od_hp.value;
                f.LGD_AMOUNT.value = f.good_mny.value;
                f.LGD_RECEIVER.value = f.od_b_name.value;
                f.LGD_RECEIVERPHONE.value = f.od_b_hp.value;
                <?php if ($default['de_escrow_use']) { ?>
                    f.LGD_ESCROW_ZIPCODE.value = f.od_b_zip.value;
                    f.LGD_ESCROW_ADDRESS1.value = f.od_b_addr1.value;
                    f.LGD_ESCROW_ADDRESS2.value = f.od_b_addr2.value;
                    f.LGD_ESCROW_BUYERPHONE.value = f.od_hp.value;
                <?php } ?>
                <?php if ($default['de_tax_flag_use']) { ?>
                    f.LGD_TAXFREEAMOUNT.value = f.comm_free_mny.value;
                <?php } ?>

                if (f.LGD_CUSTOM_FIRSTPAY.value != "무통장") {
                    launchCrossPlatform(f);
                } else {
                    f.submit();
                }
            <?php } ?>
            <?php if ($default['de_pg_service'] == 'inicis') { ?>
                f.price.value = f.good_mny.value;
                <?php if ($default['de_tax_flag_use']) { ?>
                    f.tax.value = f.comm_vat_mny.value;
                    f.taxfree.value = f.comm_free_mny.value;
                <?php } ?>
                f.buyername.value   = f.od_name.value;
                f.buyeremail.value  = f.od_email.value;
                f.buyertel.value    = f.od_hp.value ? f.od_hp.value : f.od_tel.value;
                f.recvname.value    = f.od_b_name.value;
                f.recvtel.value     = f.od_b_hp.value ? f.od_b_hp.value : f.od_b_tel.value;
                f.recvpostnum.value = f.od_b_zip.value;
                f.recvaddr.value    = f.od_b_addr1.value + " " +f.od_b_addr2.value;

                if (f.gopaymethod.value != "무통장") {
                    // 주문정보 임시저장
                    var order_data = $(f).serialize();
                    var save_result = "";
                    $.ajax({
                        type: "POST",
                        data: order_data,
                        url: g5_url + "/shop/ajax.orderdatasave.php",
                        cache: false,
                        async: false,
                        success: function(data) {
                            save_result = data;
                        }
                    });

                    if (save_result) {
                        alert(save_result);
                        return false;
                    }

                    if (!make_signature(f))
                        return false;

                    paybtn(f);
                } else {
                    f.submit();
                }
            <?php } ?>
        }

    }

    // 구매자 정보와 동일합니다.
    function gumae2baesong() {
        var f = document.forderform;

        f.od_b_name.value = f.od_name.value;
        f.od_b_tel.value = f.od_tel.value;
        f.od_b_hp.value = f.od_hp.value;
        // f.od_b_zip.value = f.od_zip.value;
        f.od_b_addr1.value = f.od_addr1.value;
        f.od_b_addr2.value = f.od_addr2.value;
        f.od_b_addr3.value = f.od_addr3.value;
        f.od_b_addr_jibeon.value = f.od_addr_jibeon.value;

        calculate_sendcost(String(f.od_b_zip.value));
    }

    <?php if ($default['de_hope_date_use']) { ?>
        $(function() {
            $("#od_hope_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                showButtonPanel: true,
                yearRange: "c-99:c+99",
                minDate: "+<?php echo (int) $default['de_hope_date_after']; ?>d;",
                maxDate: "+<?php echo (int) $default['de_hope_date_after'] + 6; ?>d;"
            });
        });
    <?php } ?>
</script>

<script>
//스크롤시 사이드 박스 메뉴 고정
$(window).scroll(
    function(){
        if($(window).scrollTop() > 1440 && $(window).width() >1180 && $(window).scrollTop()<($(document).height()-910)){
        /* if(window.pageYOffset >= $('원하는위치의엘리먼트').offset().top){ */
            let side_width = $('#sod_frm_pay').width();
            $('#side_sel').addClass("fix");
            $('#side_sel').css("width",side_width);
            //위의 if문에 대한 조건 만족시 fix라는 class를 부여함
        }else{
            $('#side_sel').removeClass("fix");
            $('#side_sel').css("width","auto");
            //위의 if문에 대한 조건 아닌경우 fix라는 class를 삭제함
        }
    }
);
</script>
