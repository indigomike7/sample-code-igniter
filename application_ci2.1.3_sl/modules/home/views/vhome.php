<div id="box_search_index">
    <div class="float_left width468 center">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <h1 id="home_search_title" class="">
            <?php 
            $this->load->config('home', TRUE);
            echo $this->config->item('title_home_search','home'); 
            ?>
        </h1>
        <div id="slogan" class="text_align_left">
                <span id="dq_start"></span>
                <h1><?php echo $this->config->item('word_home_search','home');?></h1>
                <span id="dq_end"></span>
        </div>
        <div>
        <form action="<?php echo site_url('home/search/');?>" method="post">
            <input type="text" name="query" id="query" class="width250 font_size_20" value="<?php echo $this->session->userdata('query');?>"/><button type="submit" class="front_search_button">&nbsp;&nbsp;&nbsp;Search</button>
        </form>
            <a id="categories_button" href="<?php echo site_url('home/categories');?>">Categories</a>
        </div>
        
    </div>
    <div class="float_left width468 center">
        <div>
            <h1 id="home_title_big"><?php echo $this->config->item('home_title_big','home'); ?></h1>
            <p><?php echo $this->config->item('home_word','home'); ?></p>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div id="hr_box_search_index" class="home-bottom">
    <div class="cols rotd">
        <h3>Review of the day</h3>
        <div class="review-item">
            <div class="image-col">
                <div class="picture-profile-s">
                <a href="<?php echo site_url('home/contributor/'.$rotd->user_id) ?>">
                <?php if($rotd->thumb_url == NULL): ?>
                     <img src="<?php echo base_url('upload/users/no-picture.jpg'); ?>" alt="image" width="120px">
                <?php else: ?>
                    <img src="<?php echo $rotd->thumb_url; ?>" alt="image" width="120px">
                <?php endif; ?>
                </a>
                </div>
            </div>
            <div class="text-col">
                <div class="title">
                    <?php echo anchor(site_url('home/review/detail/'.$rotd->review_id),character_limiter($rotd->title,20)); ?>
                </div>
                <div class="link" style="font-size:12px;line-height:12px;"><?php echo $rotd->link; ?></div>
                <div class="link" style="font-size:10px;">
                    by. <?php 
                        echo $rotd->first_name.' '.$rotd->last_name;
                        /*
                        if(@$rotd->bachelor_degree != NULL OR @$rotd->bachelor_degree != '') {
                            echo ', '.$rotd->bachelor_degree;
                        }
                        if(@$rotd->master_degree != NULL OR @$rotd->master_degree != '') {
                            echo ', '.$rotd->master_degree;
                        } */
                    ?> 

                </div>
                <div class="ratings">
                    <div class="rate r-<?php echo $rotd->star; ?> inline-block"></div> <span> Rating: <?php echo $rotd->rates; ?></span>
                </div>
                <div class="desc">
                     <?php echo word_limiter($rotd->review,30); ?> 
                </div>
                <div class="share">
                    <a href="#"><span class="soc fb"></span></a>
                    <a href="#"><span class="soc tw"></span></a>
                    <a href="#"><span class="soc gp"></span></a>
                    <span style="font-size:12px;">( <?php echo date('F d, Y', strtotime($rotd->review_date)); ?> )</span>
                    <div class="clear"></div>

                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="cols recent">
        <h3>Recent reviews</h3>
        <?php foreach ($recent as $rc): ?>
            <div class="recent-item">
                <div class="picture-profile-t">
                    <a href="<?php echo site_url('home/contributor/'.$rc->user_id); ?>">
                    <?php if($rc->thumb_url == NULL): ?>
                         <img src="<?php echo base_url('upload/users/no-picture.jpg'); ?>" alt="image" width="35px">
                    <?php else: ?>
                        <img src="<?php echo $rc->thumb_url; ?>" alt="image" width="35px">
                    <?php endif; ?>
                    </a>
                </div>
                <div class="text-col">
                    <div class="name">
                        <?php echo anchor(site_url('home/review/detail/'.$rc->review_id),character_limiter($rc->title,25)); ?>
                    </div>
                    <div class="link" style="font-size:10px;line-height:10px;"><?php echo $rotd->link; ?></div>
                    <div class="link" style="font-size:10px;line-height:10px;margin:3px 0;">
                        by. <?php echo $rc->first_name.' '.$rc->last_name;?>
                    </div>
                    <div class="review"><?php echo word_limiter($rc->review,6); ?></div>
                </div> 
                <div class="clear"></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="cols top">
        <h3>Top contributors</h3>
        <?php foreach ($top as $t): ?>
            <div class="picture-profile-t">
                <a href="<?php echo site_url('home/contributor/'.$t->user_id); ?>">
                <?php if($t->thumb_url == NULL): ?>
                     <img src="<?php echo base_url('upload/users/no-picture.jpg'); ?>" alt="image" width="35px">
                <?php else: ?>
                    <img src="<?php echo $t->thumb_url; ?>" alt="image" width="35px">
                <?php endif; ?>
                `</a>
            </div>
        <?php endforeach ?>
         <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>