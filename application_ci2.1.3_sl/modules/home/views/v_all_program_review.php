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
                <?php echo $program->program_name; ?>
            </div>
            <div class="desc">
                <?php echo $detail->university_name; ?>
            </div>
            <div class="score">
                Average <b><?php echo $program->p_review->rates; ?></b> <span>of 10</span>
            </div>
            <div class="rates">
                <div class="rate-large rl-<?php echo $program->star; ?>"></div>
            </div>
            <div class="views">
                <?php echo $program->p_review->review; ?> Reviews
            </div>
            <div class="review-button">
                <a href="<?php echo site_url(uri_string().'/add_review') ?>" class="review-button">Rate this program</a>
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
                    <a href="<?php echo site_url('home/review/detail/'.$item->review_id); ?>"><?php echo $item->title; ?></a>
                </div>
                <div class="route" style="font-size:12px;">
                	<?php //echo $item->link; ?>
                </div>
                <div style="font-size:12px;line-height:16px;margin-bottom:10px;">
                    <?php echo $item->review; ?>
                </div>
                <div class="scorre">
                    Average <b><?php echo $item->rates; ?></b> <span>of 10</span>
                </div>
                <div class="rates">
                    <div class="rate-large r-<?php echo $item->star; ?>"></div>
                </div>
            </div>
            <!-- [/RESULT ITEM] -->

            <?php endforeach; ?>

        <?php else: ?>

            <div class="result-item">No Review</div>
        <?php endif; ?>

    </div>
</div>