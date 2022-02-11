<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$str = '';
$exists = false;

$ca_id_len = strlen($ca_id);
$len2 = $ca_id_len + 2;
$len4 = $ca_id_len + 4;

// 최하위 분류의 경우 상단에 동일한 레벨의 분류를 출력해주는 코드
if (!$exists) {
    $str = '';

    $tmp_ca_id = substr($ca_id, 0, strlen($ca_id)-2);
    $tmp_ca_id_len = strlen($tmp_ca_id);
    $len2 = $tmp_ca_id_len + 2;
    $len4 = $tmp_ca_id_len + 4;

    // 차차기 분류의 건수를 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id like '$tmp_ca_id%' and ca_use = '1' and length(ca_id) = $len4 ";
    $row = sql_fetch($sql);
    $cnt = $row['cnt'];

    $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '$tmp_ca_id%' and ca_use = '1' and length(ca_id) = $len2 order by ca_order, ca_id ";
    $result = sql_query($sql);
    $j=0;
    while ($row=sql_fetch_array($result)) {
      if ($cnt) {
            $str .= '';
            $sql2 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '{$row['ca_id']}%' and ca_use = '1' and length(ca_id) = $len4 order by ca_order, ca_id ";
            $result2 = sql_query($sql2);
            $k=0;
            while ($row2=sql_fetch_array($result2)) {
				      $category_num = substr($row2['ca_id'],0,2);
				      if ($ca_id == $category_num) {
                $sct_ct_here = '';
                if ($ca_id == $row['ca_id']) // 활성 분류 표시
                    $sct_ct_here = 'sct_ct_here';
                if($k==0) $str .= '<ul>';
                if($k%5==0&&$k!=0) $str .= '<ul style="border-top:#eee 2px solid;">';
                $str .= '<li id="submenu" style="">';
				        $str .= '<span><a href="./list.php?ca_id='.$row2['ca_id'].'">'.$row2['ca_name'].'</a></span>';
                if(($k+1)%5==0) $str .= '</ul>';
                $k++;
				      }
            }
        } else {
            $sct_ct_here = '';
            if ($ca_id == $row['ca_id']) // 활성 분류 표시
              $sct_ct_here = 'sct_ct_here';
            if($j==0) $str .= '<ul>';
            if($j%5==0&&$j!=0) $str .= '<ul style="border-top:#eee 2px solid;">';
            $str .= '<li id="submenu" style="">';
            $str .= '<span><a href="./list.php?ca_id='.$row['ca_id'].'" class="sct_ct_parent'.$sct_ct_here.'">'.$row['ca_name'].'</a></span>';
        }
        $str .= '</li>';
        $exists = true;
        if(($j+1)%5==0) $str .= '</ul>';
        $j++;
    }
}


if ($exists) {

    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    //add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<!-- 상품분류 2 시작 { -->
<aside id="sct_ct_2" class="sct_ct len<?=$len2?> <?php if(strlen($str)>30) echo 'mb50';?>">
    <!-- <ul> -->
        <?php echo $str; ?>
    <!-- </ul> -->
</aside>

<!-- } 상품분류 2 끝 -->

<?php } ?>

<script>
	$('li:empty').css('display','none');
	$('.sct_ct_parentsct_ct_here').parents('li').addClass('ct_here');
</script>
<style>
	.sct_ct_parent {display:none;}

  .len2 #submenu span, .len4 #submenu span{font-weight:400; font-size:1.2em; color:#acacac;}
  .len4 li, .len2 li {justify-content: space-around; flex: 1; text-align: center; background-color:#FFF;
    border-right:#eee 2px solid;}
	.len2 #submenu span:last-child, .len4 #submenu span:last-child, .len2 li:last-child, .len4 li:last-child {border-right:none;}
	.len2 li, .len4 li, .len2 ul, .len4 ul {display: flex;}
	#submenu span a {padding: 11px 0 6px; display: inline-block; overflow: hidden; text-overflow: ellipsis;}
	.ct_here, .ct_here span{background-color:#603779 !important; color:#FFF !important; font-weight:700 !important;}

</style>
