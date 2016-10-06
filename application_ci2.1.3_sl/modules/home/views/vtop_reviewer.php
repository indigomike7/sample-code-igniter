<div id="wrapper" class="top-review">
	<div class="space_title">
        Top Reviewer
    </div>

	<div id="top-reviewer">
	<?php foreach($top_reviewer as $r): ?>
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
			<div class="review-numb"><b><?php echo $r->review_numb; ?> Reviews</b></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	</div>
</div>