<div id="wrapper">

	<div class="col-50">
	    <form action="<?php echo site_url('home/search/');?>" method="post">
	        <input type="text" name="query" id="query" class="width250 font_size_20" value="<?php echo $this->session->userdata('query');?>"/><button type="submit" class="front_search_button">&nbsp;&nbsp;&nbsp;Search</button>
	    </form>
    </div>
    <div class="col-50 right">
    	<a id="categories_button" href="<?php echo site_url('home/categories');?>">Categories</a>
    </div>
    <div class="clear"></div>

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
        </div>
        <div class="clear"></div>
    </div>

    <div class="space_title">
        Write your review
    </div>

    <div class="review-form">
        <?php echo validation_errors(); ?>
        
        <form action="<?php echo site_url(uri_string()) ;?>" method="post">
            <label for="review">Title</label>
            <?php echo form_input('title',@$title,'style="width:600px;"'); ?>
            <label for="review">Review</label>
            <?php echo form_textarea('review',@$review,'style="width:600px;height:200px;"'); ?>
            <label for="rate">Rate</label>
            <?php echo form_dropdown('rate', $rate_data, @$rate); ?>
            <div>
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>

    </div>

    <div class="clear"></div>
</div>