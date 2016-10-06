<div id="wrapper">
	<div class="space_title">
        Review Detail
    </div>

    <div class="university">
    	<div class="text-col">
    		<div class="name">
    			<?php echo character_limiter($detail->title,60); ?>
    		</div>
    		<div class="link">
    			<?php echo $detail->link ?>
    		</div>
    		
    		<div class="score">
    			Rating <b><?php echo $detail->rates; ?></b> <span>of 10</span>
    		</div>
    		<div class="rates">
    			<div class="rate-large rl-<?php echo $detail->star; ?>"></div>
    		</div>
    		<div style="font-size:14px;">
    			<?php echo $detail->review; ?>
    		</div>
    		<div class="by" style="padding: 10px 0;">
    			<div class="picture-profile-t" style="float:left;">
                    <a href="<?php echo site_url('home/contributor/'.$detail->user_id); ?>">
                    <?php if($detail->thumb_url == NULL): ?>
                         <img src="<?php echo base_url('upload/users/no-picture.jpg'); ?>" alt="image" width="35px">
                    <?php else: ?>
                        <img src="<?php echo $detail->thumb_url; ?>" alt="image" width="35px">
                    <?php endif; ?>
                    </a>
                </div>
                <span>
                	<a href="<?php echo site_url('home/contributor/'.$detail->user_id); ?>">
					<?php 
						echo $detail->first_name.' '.$detail->last_name;
						if(@$detail->bachelor_degree != NULL OR @$detail->bachelor_degree != '') {
							echo ', '.$detail->bachelor_degree;
						}
						if(@$detail->master_degree != NULL OR @$detail->master_degree != '') {
							echo ', '.$detail->master_degree;
						} 
					?>
					</a>
				</span>
                <div class="clear"></div>
    		</div>

            <div class="share">
                <a href="#"><span class="soc fb"></span></a>
                <a href="#"><span class="soc tw"></span></a>
                <a href="#"><span class="soc gp"></span></a>
                <span style="font-size:12px;">( <?php echo date('F d, Y', strtotime($detail->review_date)); ?> )</span>
                <div class="clear"></div>
            </div>
    		
        </div>
        <div class="clear"></div>
    </div>
</div>