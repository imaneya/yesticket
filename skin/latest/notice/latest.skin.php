<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="notice">
	<div>
							<h4 class="fl"><?php echo $bo_subject ?></h4>
							<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>" class="fr">SEE MORE</a>
						</div>
						<div class="p1 m1">
							<ul class="board_footer">
								<?php for ($i=0; $i<count($list); $i++) {  ?>
									<li><span class="qmark"><?php if ($bo_table == 'qa') {echo 'Q';} else {echo ($i+1);} ?></span>
										<a href="<?php echo $list[$i]['href'];?>"><? echo $list[$i]['subject'];?></a>
										<?php if ($bo_table == 'free') {echo '<p class="fr">'.$list[$i]['datetime'].'</p>';}?>
									</li>
								<?php }  ?>
							</ul>
						</div>


    <ul>

</div>
