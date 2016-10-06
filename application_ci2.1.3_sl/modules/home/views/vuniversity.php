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
        Universities
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
        Study Program in This School
    </div>

    <div id="program" class="col-50">
    	
        <div id="tab-link">
            <a href="#regular">Under Graduate</a>
            <a href="#graduate">Post Graduate</a>
        </div>

        <div id="tab-content-wrapper">
            <div id="regular" class="tab-content">
                <?php if($detail->program): ?>
                    <ul>
                        <?php foreach($detail->program as $p): ?>
                            <?php if ($p->category_id == 0): ?>
                                <li><a href="<?php echo site_url('university/'.$detail->university_id.'/program/'.$p->program_id); ?>"><?php echo $p->program_name; ?></a></li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>

                <?php endif; ?>
            </div>
            <div id="graduate" class="tab-content">
                <?php if($detail->program): ?>
                    <ul>
                        <?php foreach($detail->program as $p): ?>
                            <?php if ($p->category_id == 1): ?>
                                <li><a href="<?php echo site_url('university/'.$detail->university_id.'/program/'.$p->program_id); ?>"><?php echo $p->program_name; ?></a></li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>

                <?php endif; ?>
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
                </div>
                </a>
    		</div>
    		<div class="text-col">
    			<div class="title">
                    <a href="<?php echo site_url('home/review/detail/'.$r->review_id); ?>">
    				<?php echo character_limiter($r->title,25); ?>
                    </a>
    			</div>
                <div style="font-size:10px;">
                    by. <?php echo $r->first_name.' '.$r->last_name;?>
                </div>
    			<div class="ratings">
    				<div class="rate r-<?php echo $r->star; ?> inline-block"></div> <span> Rating: <?php echo $r->rates; ?></span>
    			</div>
    			<div style="font-size:12px;line-height:16px;">
    			     <?php echo $r->review; ?>	
                </div>
    			<div class="share">
    				<a href="#"><span class="soc fb"></span></a>
    				<a href="#"><span class="soc tw"></span></a>
    				<a href="#"><span class="soc gp"></span></a>
                    <span style="font-size:12px;">( <?php echo date('F d, Y', strtotime($r->review_date)); ?> )</span>
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