<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . G5_SHOP_CSS_URL . '/style.css">', 0);

$cate_skin = $skin_dir . '/listcategory2.skin.php';

if (!is_file($cate_skin))

    $cate_skin = G5_SHOP_SKIN_PATH . '/listcategory2.skin.php';

//if(strlen($ca_id)==2){//대분류면 패스
include $cate_skin;
//}
?>
<style>
    .fix{position:fixed;_position:absolute;top:0px;}
</style>

<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return fitem_submit(this);">
    <input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
    <input type="hidden" name="sw_direct">
    <input type="hidden" name="url">

    <div id="sit_ov_wrap">
        <h2 id="sit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">요약정보 및 구매</span></h2>
        <!-- 상품이미지 미리보기 시작 { -->
        <div id="it_img_slider" style="margin-bottom:15px;">
            <div id="sit_pvi_big" style="background-color:#fff;">
                <?php
                $big_img_count = 0;
                $thumbnails = array();
                if($it['it_img2']==null) $im=1; else $im=2;
                for ($i=$im; $i <= 10; $i++) {
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

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <section class="fl m1 mf0 sit_schedule" style="width:75%;">
            <div class="sit_schedule_hd <?php if(substr($it['ca_id'],0,2)=='30') echo "none";?>" style="background-color:#EC8AAB; color:#FFF; font-weight:600; margin-bottom:10px;">
                <div class="fl sit_schedule_hd_txt" style="width:100%; margin-right:-250px;">
                  <p style="padding:26px 25px; font-size:1.7em;"><span>SCHEDULE: </span> from <b><?php echo date('F d',strtotime($it['it_maker'])); ?></b>
                    to <b><?php echo date('F d',strtotime($it['it_origin'])); ?></b></p>
                </div>
                <div class="fl sit_schedule_hd_input" style="width:230px">
                  <input type="text" class="fr" id="select_date" name="select_date" readonly style="padding:10px 0 13px; margin:19px 0 20px;
                    width:230px; cursor:pointer; text-align:center; font-size:1.3em; border:none; outline:none; background-color:#FFF; color:#EC8AAB;" value="<?php if(substr($it['ca_id'],0,2)=='30') echo date("Y-m-d"); else echo "Select another day";?>">
                </div>
            </div>

            <div style="min-height: 500px; background-color:#FFF; padding:20px; margin-bottom:50px;">
                <div style="padding:15px; color:#FFF; background-color:#bfc1c0; font-weight:bold; font-size:1.4em;"><?php if(substr($it['ca_id'],0,2)=='30') echo "Product Information"; else echo "Detailed Schedule";?></div>
                <p id="sit_desc"><?php // echo $it['it_basic'];
                                    ?></p>
                <?php if ($it['it_explan']) { ?>
                    <div id="sit_inf_explan" style="padding:15px;">
                        <?php echo conv_content($it['it_explan'], 1); ?>
                    </div>
                <?php } ?>
            </div>
        </section>
        <!-- } 상품이미지 미리보기 끝 -->

        <!-- 상품 요약정보 및 구매 시작 { -->
        <section id="sit_ov" class="2017_renewal_itemform">
            <p id="sit_desc"><?php //echo $it['it_basic'];
                                ?></p>
            <?php if ($is_orderable) { ?>
                <p id="sit_opt_info" class="none">
                    상품 선택옵션 <?php echo $option_count; ?> 개, 추가옵션 <?php echo $supply_count; ?> 개
                </p>
            <?php } ?>
            <div class="sit_info">
                <table class="sit_ov_tbl none">
                    <colgroup>
                        <col class="grid_3">
                        <col>
                    </colgroup>
                    <tbody>
                        <?php if ($it['it_maker']) { ?>
                            <tr>
                                <th scope="row">제조사</th>
                                <td><?php echo $it['it_maker']; ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($it['it_origin']) { ?>
                            <tr>
                                <th scope="row">원산지</th>
                                <td><?php echo $it['it_origin']; ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($it['it_brand']) { ?>
                            <tr>
                                <th scope="row">브랜드</th>
                                <td><?php echo $it['it_brand']; ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($it['it_model']) { ?>
                            <tr>
                                <th scope="row">모델</th>
                                <td><?php echo $it['it_model']; ?></td>
                            </tr>
                        <?php } ?>

                        <?php if (!$it['it_use']) { // 판매가능이 아닐 경우
                        ?>
                            <tr>
                                <th scope="row">판매가격</th>
                                <td>판매중지</td>
                            </tr>
                        <?php } else if ($it['it_tel_inq']) { // 전화문의일 경우
                        ?>
                            <tr>
                                <th scope="row">판매가격</th>
                                <td>전화문의</td>
                            </tr>
                        <?php } else { // 전화문의가 아닐 경우
                        ?>
                            <?php if ($it['it_cust_price']) { ?>
                                <tr>
                                    <th scope="row">시중가격</th>
                                    <td><?php echo display_price($it['it_cust_price']); ?></td>
                                </tr>
                            <?php } // 시중가격 끝
                            ?>

                            <tr>
                                <th scope="row">판매가격</th>
                                <td>
                                    <strong><?php echo display_price(get_price($it)); ?></strong>
                                    <input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
                                </td>
                            </tr>
                        <?php } ?>

                        <?php
                        /* 재고 표시하는 경우 주석 해제
            <tr>
                <th scope="row">재고수량</th>
                <td><?php echo number_format(get_it_stock_qty($it_id)); ?> 개</td>
            </tr>
            */
                        ?>

                        <?php if ($config['cf_use_point']) { // 포인트 사용한다면
                        ?>
                            <tr>
                                <th scope="row">포인트</th>
                                <td>
                                    <?php
                                    if ($it['it_point_type'] == 2) {
                                        echo '구매금액(추가옵션 제외)의 ' . $it['it_point'] . '%';
                                    } else {
                                        $it_point = get_item_point($it);
                                        echo number_format($it_point) . '점';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php
                        $ct_send_cost_label = '배송비결제';

                        if ($it['it_sc_type'] == 1)
                            $sc_method = '무료배송';
                        else {
                            if ($it['it_sc_method'] == 1)
                                $sc_method = '수령후 지불';
                            else if ($it['it_sc_method'] == 2) {
                                $ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
                                $sc_method = '<select name="ct_send_cost" id="ct_send_cost">
                                      <option value="0">주문시 결제</option>
                                      <option value="1">수령후 지불</option>
                                  </select>';
                            } else
                                $sc_method = '주문시 결제';
                        }
                        ?>
                        <tr>
                            <th><?php echo $ct_send_cost_label; ?></th>
                            <td><?php echo $sc_method; ?></td>
                        </tr>
                        <?php if ($it['it_buy_min_qty']) { ?>
                            <tr>
                                <th>최소구매수량</th>
                                <td><?php echo number_format($it['it_buy_min_qty']); ?> 개</td>
                            </tr>
                        <?php } ?>
                        <?php if ($it['it_buy_max_qty']) { ?>
                            <tr>
                                <th>최대구매수량</th>
                                <td><?php echo number_format($it['it_buy_max_qty']); ?> 개</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            if ($option_item) {
            ?>
                <!-- 선택옵션 시작 { -->
                <section class="sit_option none">
                    <h3>선택옵션</h3>

                    <?php // 선택옵션
                    echo $option_item;
                    ?>
                </section>
                <!-- } 선택옵션 끝 -->
            <?php
            }
            ?>

            <?php
            if ($supply_item) {
            ?>
                <!-- 추가옵션 시작 { -->
                <section class="sit_option">
                    <h3>추가옵션</h3>
                    <?php // 추가옵션
                    echo $supply_item;
                    ?>
                </section>
                <!-- } 추가옵션 끝 -->
            <?php
            }
            ?>

            <?php if ($is_orderable) { ?>
                <!-- 선택된 옵션 시작 { -->
                <section id="sit_sel_option" class="fl m1 mf0" style="width:100%; margin-left:15px; padding-right:15px;">
                    <div style="background-color:#FFF;" id="side_sel">
                        <div style="background-color:#c0c0c0; color:#FFF; height:45px;">
                            <h2 style="font-weight:600; font-size:1.3em; text-align:center; padding-top:14px;"><?php if(substr($it['ca_id'],0,2)=='30') echo "Number of Purchases"; else echo "Select Numbers of Payment";?></h2>

                        </div>
                        <?php
                        if (!$option_item) {
                            if (!$it['it_buy_min_qty'])
                                $it['it_buy_min_qty'] = 1;
                        ?>
                            <ul id="sit_opt_added">
                                <li class="sit_opt_list" style="background-color:#c0c0c0; color:#FFF; height:45px; font-size:1.2em; padding-right:20px; font-weight:700;">

                                    <input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
                                    <input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
                                    <input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
                                    <input type="hidden" class="io_price" value="0">
                                    <input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">
                                    <div class="opt_count">
                                        <label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
                                        <input type="text" readonly name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="num_input back_gray2" size="5"
                                        style="cursor:default; border:none; outline:none; background-color:#c0c0c0 !important; color:#FFF;">
                                        <div class="fr">
                                            <button type="button" class="sit_qty_minus" style="border:none; outline:none; background: none; color:#FFF;"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
                                            <button type="button" class="sit_qty_plus" style="border:none; outline:none; background: none; color:#FFF;"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
                                        </div>
                                        <span class="sit_opt_prc"></span>
                                    </div>

                                    <script>
                                        $(function() {
                                            price_calculate();
                                        });
                                    </script>


                                </li>
                            </ul>
                        <?php } ?>

                        <!-- } 선택된 옵션 끝 -->

                        <!-- 총 구매액 -->
                        <div id="sit_tot_price" style="background-color:#FFF; color:#565656 !important; font-weight:700; padding:15px; font-size:2.5em; font-weight: bold;">

                    </div>
                    <?php } ?>

                    <?php if ($is_soldout) { ?>
                        <p id="sit_ov_soldout">SOLD OUT</p>
                    <?php } ?>

                    <div id="sit_ov_btn" class="mt50" style="text-align:center;">
                        <?php if ($is_orderable) { ?>
                            <button class="pink_btn" type="submit" onclick="document.pressed=this.value;" style="width:85%; margin-bottom:12px; padding-top:6px; font-size:1.4em; font-weight:600; height:45px;" value="바로구매" id="sit_btn_buy">Buy It Now</button>
                        <?php } ?>
                    </div>
                    </div>

                </section>

                <script>
                    // 상품보관
                    function item_wish(f, it_id) {
                        f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id=" + it_id;
                        f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
                        f.submit();
                    }

                    // 추천메일
                    function popup_item_recommend(it_id) {
                        if (!g5_is_member) {
                            if (confirm("회원만 추천하실 수 있습니다."))
                                document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_SHOP_URL . "/item.php?it_id=$it_id"); ?>";
                        } else {
                            url = "./itemrecommend.php?it_id=" + it_id;
                            opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
                            popup_window(url, "itemrecommend", opt);
                        }
                    }

                    // 재입고SMS 알림
                    function popup_stocksms(it_id) {
                        url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
                        opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
                        popup_window(url, "itemstocksms", opt);
                    }
                </script>
        </section>
        <!-- } 상품 요약정보 및 구매 끝 -->

    </div>
</form>


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
    });

    function fsubmit_check(f) {
        // 판매가격이 0 보다 작다면
        if (document.getElementById("it_price").value < 0) {
            alert("전화로 문의해 주시면 감사하겠습니다.");
            return false;
        }

        if ($(".sit_opt_list").size() < 1) {
            alert("상품의 선택옵션을 선택해 주십시오.");
            return false;
        }

        var val, io_type, result = true;
        var sum_qty = 0;
        var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
        var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
        var $el_type = $("input[name^=io_type]");

        $("input[name^=ct_qty]").each(function(index) {
            val = $(this).val();

            if (val.length < 1) {
                alert("수량을 입력해 주십시오.");
                result = false;
                return false;
            }

            if (val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자로 입력해 주십시오.");
                result = false;
                return false;
            }

            if (parseInt(val.replace(/[^0-9]/g, "")) < 1) {
                alert("수량은 1이상 입력해 주십시오.");
                result = false;
                return false;
            }

            io_type = $el_type.eq(index).val();
            if (io_type == "0")
                sum_qty += parseInt(val);
        });

        if (!result) {
            return false;
        }

        if (min_qty > 0 && sum_qty < min_qty) {
            alert("선택옵션 개수 총합 " + number_format(String(min_qty)) + "개 이상 주문해 주십시오.");
            return false;
        }

        if (max_qty > 0 && sum_qty > max_qty) {
            alert("선택옵션 개수 총합 " + number_format(String(max_qty)) + "개 이하로 주문해 주십시오.");
            return false;
        }

        return true;
    }
    // 바로구매, 장바구니 폼 전송
    function fitem_submit(f) {
        f.action = "<?php echo $action_url; ?>";
        f.target = "";

        if (document.pressed == "장바구니") {
            f.sw_direct.value = 0;
        } else { // 바로구매
            f.sw_direct.value = 1;
        }
        if (document.getElementById("select_date").value == 'Select another day') {
            alert("날짜를 선택해주세요");
            return false;
        }
        // 판매가격이 0 보다 작다면
        if (document.getElementById("it_price").value < 0) {
            alert("전화로 문의해 주시면 감사하겠습니다.");
            return false;
        }

        if ($(".sit_opt_list").size() < 1) {
            alert("상품의 선택옵션을 선택해 주십시오.");
            return false;
        }

        var val, io_type, result = true;
        var sum_qty = 0;
        var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
        var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
        var $el_type = $("input[name^=io_type]");

        $("input[name^=ct_qty]").each(function(index) {
            val = $(this).val();

            if (val.length < 1) {
                alert("수량을 입력해 주십시오.");
                result = false;
                return false;
            }

            if (val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자로 입력해 주십시오.");
                result = false;
                return false;
            }

            if (parseInt(val.replace(/[^0-9]/g, "")) < 1) {
                alert("수량은 1이상 입력해 주십시오.");
                result = false;
                return false;
            }

            io_type = $el_type.eq(index).val();
            if (io_type == "0")
                sum_qty += parseInt(val);
        });

        if (!result) {
            return false;
        }

        if (min_qty > 0 && sum_qty < min_qty) {
            alert("선택옵션 개수 총합 " + number_format(String(min_qty)) + "개 이상 주문해 주십시오.");
            return false;
        }

        if (max_qty > 0 && sum_qty > max_qty) {
            alert("선택옵션 개수 총합 " + number_format(String(max_qty)) + "개 이하로 주문해 주십시오.");
            return false;
        }

        return true;
    }
</script>
<style>
    #it_img_slider {
    }

    #sit_pvi_big img {
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
<?php
//날짜 시작일 종료일 지정
$s_year = substr($it['it_maker'], 0, 4);
$s_month = substr($it['it_maker'], 4, 2);
$s_day = substr($it['it_maker'], 6, 8);
$e_year = substr($it['it_origin'], 0, 4);
$e_month = substr($it['it_origin'], 4, 2);
$e_day = substr($it['it_origin'], 6, 8);

$n_date = strtotime(date("Y-m-d H:i:s"));
$s_date = strtotime($s_year.'-'.$s_month.'-'.$s_day.' 00:00:00');
if($s_date<$n_date) $mindate = date("Y-m-d");
else $mindate = $s_year.'-'.$s_month.'-'.$s_day;
$maxdate = $e_year.'-'.$e_month.'-'.$e_day;
?>
<script>
    $(document).ready(function() {
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
    $(function() {
        $("#select_date").datepicker({
            dateFormat: "yy-mm-dd",
            dayNames: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            dayNamesMin: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            minDate: "<?= $mindate?>",
            maxDate: "<?= $maxdate ?>"
        });
    });
</script>
<script>
//스크롤시 사이드 박스 메뉴 고정
$(window).scroll(
    function(){
        if($(window).scrollTop() > 1440 && $(window).width() >1180 && $(window).scrollTop()<($(document).height()-910)){
        /* if(window.pageYOffset >= $('원하는위치의엘리먼트').offset().top){ */
            let side_width = $('#sit_sel_option').width();
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

<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>
