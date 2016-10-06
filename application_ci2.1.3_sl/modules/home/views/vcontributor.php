<div id="wrapper">
	<div class="space_title">
        Contributor
    </div>
    <div id="top-reviewer">
	<?php foreach($user_data as $r): ?>
	<div class="top-item">
		<div class="picture-col">
			<div class="picture-profile-s">
				<?php if($r->thumb_url != NULL): ?>
					<img src="<?php echo $r->thumb_url; ?>" alt="image" width="120px">
				<?php else: ?>
					<img src="<?php echo base_url('upload/users/no-picture.jpg'); ?>" alt="image">
				<?php endif; ?>
			</div>
		</div>
		<div class="text-col">
			<div class="name">
				<b>
				<?php 
					echo $r->first_name.' '.$r->last_name;
					if(@$r->bachelor_degree != NULL OR @$r->$r->bachelor_degree != '') {
						echo ', '.$r->bachelor_degree;
					}
					if(@$r->master_degree != NULL OR @$r->$r->master_degree != '') {
						echo ', '.$r->master_degree;
					} 
				?>
				</b>
			</div>
			<?php if($r->university_bachelor != NULL OR $r->university_bachelor != ''): ?>
				<div class="bachelor">Bachelor Degree at <?php echo $r->university_bachelor; ?></div>
			<?php endif; ?>
			<?php if($r->university_master != NULL OR $r->university_master != ''): ?>
				<div class="master">Master Degree at <?php echo $r->university_master; ?></div>
			<?php endif; ?>
			<div class="review-numb"><b><?php if($user_reviews){echo count($user_reviews);} else {echo '0';} ?> Reviews</b></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	</div>
	<div class="space_title">
        Reviews
    </div>
    <div class="result-wrapper">

        <?php if($user_reviews): ?>

            <?php foreach ($user_reviews as $item): ?>

            <!-- [RESULT ITEM] -->
            <div class="result-item">
                <div class="name">
                    <a href="<?php echo site_url('home/review/detail/'.$item->review_id); ?>"><?php echo character_limiter($item->title,60); ?></a>
                </div>
                <div class="route" style="font-size:12px;">
                	<?php echo $item->link; ?>
                </div>
                <div style="font-size:14px;">
                    <?php echo $item->review; ?>
                </div>
                <div class="scorre">
                    Rating <b><?php echo $item->rates; ?></b> <span>of 10</span>
                </div>
                <div class="rates">
                    <div class="rate-large r-<?php echo $item->star; ?>"></div>
                </div>
                <div class="share">
	                <a href="#"><span class="soc fb"></span></a>
	                <a href="#"><span class="soc tw"></span></a>
	                <a href="#"><span class="soc gp"></span></a>
	                <span style="font-size:12px;">( <?php echo date('F d, Y', strtotime($item->review_date)); ?> )</span>
	                <div class="clear"></div>
	            </div>
            </div>
            <!-- [/RESULT ITEM] -->

            <?php endforeach; ?>

        <?php else: ?>

            <div class="result-item">No Review</div>
        <?php endif; ?>

    </div>
</div>