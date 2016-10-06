<div id="wrapper">
	<div class="space_title">
        <?php echo $breadcrumb; ?>
    </div>

    <div class="university">
    	<div class="image-col">
    		<img src="<?php echo $detail->image_url; ?>" width="275px" />
    	</div>
    	<div class="text-col">
    		<div class="name">
    			<?php echo $detail->university_name; ?>
    		</div>
    		<div class="desc">
    			<?php echo $detail->university_description; ?>
    		</div>
    		<div class="score">
    			Average <b><?php echo $detail->rates; ?></b> <span>of 10</span>
    		</div>
    		<div class="rates">
    			<div class="rate-large rl-<?php echo $detail->star; ?>"></div>
    		</div>
    		<div class="views">
    			<?php echo $detail->review; ?> Reviews
    		</div>
            
            <div class="review-button">
                <a href="<?php echo site_url('university/'.$detail->university_id.'/add_review') ?>" class="review-button">Rate this school</a>
            </div>
            <div class="clear"></div>
    	   
        </div>
        <div class="clear"></div>
    </div>
	<div class="space_title">
        Reviews
    </div>
    <div class="result-wrapper">

        <?php if($review): ?>

            <?php foreach ($review as $item): ?>

            <!-- [RESULT ITEM] -->
            <div class="result-item">
                <div class="name">
                    <a href="<?php echo site_url('home/review/detail/'.$item->review_id); ?>"><?php echo character_limiter($item->title,60); ?></a>
                </div>
                <div style="font-size:10px;">
                    by. <?php echo $item->first_name.' '.$item->last_name;?>
                </div>
                <div class="route" style="font-size:12px;">
                	<?php //echo $item->link; ?>
                </div>
                <div  style="font-size:12px;line-height:16px;margin-bottom:10px;">
                    <?php echo $item->review; ?>
                </div>
                <div class="scorre">
                    Average <b><?php echo $item->rates; ?></b> <span>of 10</span>
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