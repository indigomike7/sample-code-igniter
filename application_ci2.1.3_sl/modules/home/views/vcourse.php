<div id="wrapper">
    <?php //$all = $this->session->all_userdata(); print_r($all); ?>

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
    			<?php echo $course->course_name; ?>
    		</div>
    		<div class="desc">
    			<?php echo $detail->university_name; ?>, <?php echo $program->program_name; ?> Programs
    		</div>
    		<div class="score">
    			Average <b><?php echo $course->c_review->rates; ?></b> <span>of 10</span>
    		</div>
    		<div class="rates">
    			<div class="rate-large rl-<?php echo $course->star; ?>"></div>
    		</div>
    		<div class="views">
    			<?php echo $course->c_review->review; ?> Reviews
    		</div>
            <div class="review-button">
                <a href="<?php echo site_url(uri_string().'/add_review') ?>" class="review-button">Rate this course</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="space_title">
        Related course in this program
    </div>

    <div id="program" class="col-50">
    	
        <div id="tab-link">
            <a href="#regular">Course List</a>
            <!-- <a href="#graduate">Graduate Programs</a> -->
        </div>

        <div id="tab-content-wrapper">
            <div id="regular" class="tab-content">
                <?php if (!$program->course): ?>
                    No Available Course for this Program
                <?php else: ?>
                    <ul>
                        <?php foreach ($program->course as $c): ?>
                            <li><a href="<?php echo site_url('university/'.$detail->university_id.'/program/'.$program->program_id.'/course/'.$c->course_id); ?>"><?php echo $c->course_name; ?></a> ( by. <?php echo $c->lecturer_name; ?> )</li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        </div>
        
    </div>

    <div id="review" class="col-50 right">
        <?php foreach($review as $r): ?>
        <!-- REVIEW ITEM -->
    	<div class="review-item">
    		<div class="image-col">
    			<div class="picture-profile-s">
                <a href="<?php echo site_url('home/contributor/'.$r->user_id); ?>">
                <?php if($r->thumb_url == NULL): ?>
                     <img src="<?php echo base_url('upload/users/no-picture.jpg'); ?>" alt="image">
                <?php else: ?>
                    <img src="<?php echo $r->thumb_url; ?>" alt="image" width="120px">
                <?php endif; ?>
                </a>
                </div>
    		</div>
    		<div class="text-col">
    			<div class="title">
                    <a href="<?php echo site_url('home/review/detail/'.$r->review_id); ?>">
    				<?php echo character_limiter($r->title,25); ?>
                    </a>
    			</div>
    			<div class="ratings">
    				<div class="rate r-<?php echo $r->star; ?> inline-block"></div> <span> Rating: <?php echo $r->rates; ?></span>
    			</div>
    			<div class="desc">
    			     <?php echo $r->review; ?>	
                </div>
    			<div class="share">
    				<a href="#"><span class="soc fb"></span></a>
    				<a href="#"><span class="soc tw"></span></a>
    				<a href="#"><span class="soc gp"></span></a>
                    <div class="clear"></div>
    			</div>
    		</div>
    		<div class="clear"></div>
    	</div>
        <!-- /REVIEW ITEM -->
        <?php endforeach; ?>

       <div class="category-pager">
            <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
            <!--
            <a href="#" class="nav">Prev</a>
            <span>Page</span>
            <ul>
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li>...</li>
            </ul>
            <a href="#" class="nav">Next</a>
            -->
        </div>

        <a href="<?php echo site_url(uri_string().'/all_review') ?>" class="all-reviews">List all reviews</a>
    </div>

    <div class="clear"></div>
</div>