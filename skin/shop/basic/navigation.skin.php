<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($ca_id)
{
    $navigation = $bar = "";
    $len = strlen($ca_id) / 2;

        $code = substr($ca_id,0,2);

        $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$code' ";
        $row = sql_fetch($sql);

        $sct_here = '';
        if ($ca_id == $code) // 현재 분류와 일치하면
            $sct_here = 'sct_here';

        if ($i != $len) // 현재 위치의 마지막 단계가 아니라면
            $sct_bg = 'sct_bg';
        else $sct_bg = '';

        $navigation .= $bar.'<a href="./list.php?ca_id='.$code.'" class="'.$sct_here.' '.$sct_bg.'">'.$row['ca_name'].'</a>';

}
else
    $navigation = $g5['title'];

//if ($it_id) $navigation .= " > $it[it_name]";

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<div id="sct_location" class="w1000 tc">
	<div class="mt50 mb50" style="position:relative; display:block;">
		<hr style="display:block; border-top:#603779 2px solid; top:40%; background-color:#eee; width:100%; position:absolute; z-index: 10;">
	    <h2 style="font-size:2.0em; padding:15px; font-weight:600; background-color:#eee; display: inline-block; position:relative; z-index: 11; margin:auto; text-transform: uppercase; color:#603779;"><?php echo $navigation; ?></h2>
	</div>
</div>
