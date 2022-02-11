<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품진열 10 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($this->list_mod >= 2) { // 1줄 이미지 : 2개 이상
        if ($i%$this->list_mod == 0) $sct_last = 'sct_last'; // 줄 마지막
        else if ($i%$this->list_mod == 1) $sct_last = 'sct_clear'; // 줄 첫번째
        else $sct_last = '';
    } else { // 1줄 이미지 : 1개
        $sct_last = 'sct_clear';
    }

    if ($i == 1) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_10\">\n";
        }
    }
    if($this->list_mod <= 2) {
      echo "<li class='sct_li {$sct_last} p2 m2 fl' style='padding:5px;'>\n";
    } else {
      echo "<li class='sct_li {$sct_last} p4 m2 fl' style='padding:5px;'>\n";
    }
    echo "<div style='background-color:#FFF;'>\n";

    echo "<div class=\"sct_img\">\n";

    if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height-80, '', '', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "</a>\n";
    }


    echo "</div>\n";

	echo "<div class='text_wrap'>";

    if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\" style='font-weight:700;'>\n";
    }
    if ($this->view_it_name) {
        echo "<h3 class='it_title'>".stripslashes($row['it_name'])."</h3>\n";
    }
    if ($this->href) {
        echo "</a>\n";
    }

	echo "<h6 class='period'>".date('F d, Y',strtotime($row['it_maker']))." ~ ".date('F d, Y',strtotime($row['it_origin']))."</h6>";

  if ($this->view_it_basic && $row['it_basic']) {
      echo "<h5 class='it_basic'>".stripslashes($row['it_basic'])."</h5>\n";
  }
  
	echo "</div>";

//    if ($this->view_it_cust_price || $this->view_it_price) {
//
//        echo "<div class=\"sct_cost\">\n";
//
//        if ($this->view_it_cust_price && $row['it_cust_price']) {
//            echo "<span class=\"sct_discount\">".display_price($row['it_cust_price'])."</span>\n";
//        }
//
//        if ($this->view_it_price) {
//            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
//        }
//
//        echo "</div>\n";
//
//    }

    if ($this->view_it_icon) {
        echo "<div class=\"sct_icon\">".item_icon($row)."</div>\n";
    }

	echo "</div>\n";

    echo "</li>\n";
}

if ($i > 1) echo "</ul>\n";

if($i == 1) echo "<p class=\"sct_noitem\">No items are ready yet.</p>\n";
?>
<!-- } 상품진열 10 끝 -->
