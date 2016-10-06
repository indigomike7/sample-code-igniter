<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".home-short, .home-countries").change(function(){
            var homeShort = $(".home-short").val();
            var homeCountries = $(".home-countries").val();
            var siteUrl = "<?php echo site_url(); ?>";

            window.location.replace(siteUrl+"home/categories/countries/"+homeCountries+"/short/"+homeShort);
        });
    });    
</script>

<div class="width962 center">
    <div class="float_left width468 center">
        <p>&nbsp;</p>
        <form action="<?php echo site_url('home/search');?>" method="post">
            <input type="text" name="query" id="query" class="width250 font_size_20" value="<?php echo $this->session->userdata('query');?>"/><button type="submit" class="front_search_button">&nbsp;&nbsp;&nbsp;Search</button>
        </form>
    </div>
    <div class="float_left width468 center">
        <p>&nbsp;</p>
            <a id="categories_button" href="<?php echo site_url('home/categories');?>" style="margin-top:18px;">Categories</a>
    </div>
    <div class="clear"></div>
    <div class="space_title">
        Universities
    </div>
    <div style="float:right; ">
        <span>Sort : 
            <!--
            <select name="home_sort" class="home-short">
                <option value="none" selected>None</option>
                <option value="rank" <?php if($current_short != FALSE && $current_short == 'rank' ) { echo 'selected';} ?>>Rank</option>
            </select>
            -->
            <?php echo form_dropdown('home_sort', $categories, $current_short, 'class="home-short"'); ?>
        </span>
        <span>Countries : 
            <select name="home_countries" class="home-countries">
                <option value="all">All</option>
                <?php
                for($i=0;$i<count($countries);$i++)
                {
                    if($current_country != 'all' && $current_country != FALSE && $current_country == $countries[$i]->country_id ) {
                        echo "<option value=\"".$countries[$i]->country_id."\" selected>".$countries[$i]->country_name."</option>";     
                    } else {
                        echo "<option value=\"".$countries[$i]->country_id."\">".$countries[$i]->country_name."</option>";
                    }
                }
                ?>
                
            </select></span>
    </div>

    <div class="clear"></div>

    <div id="category-content">
        <?php $numb = count($universities); ?>

        <?php if ($numb > 0): ?>
            
            <div class="search-cols col-50">

            <?php $i=1; ?>

            <?php foreach ($universities as $univ): ?>

            <div class="university-item">
                <div class="image-col">
                    <img src="<?php echo $univ->image_url; ?>" width="80px" alt="">
                </div>
                <div class="text-col">
                    <div class="name">
                        <a href="<?php echo site_url('university/'.$univ->university_id); ?>">
                        <?php echo $univ->university_name; ?>
                        </a>
                    </div>
                    <div class="desc">
                        <?php echo word_limiter($univ->university_description, 20); ?>
                    </div>
                    <div class="rates">
                        <?php 
                            $rates = floor($univ->rates); 
                            $star = floor($rates/2);
                        ?>
                        <div class="rate r-<?php echo $star; ?> inline-block"></div>
                        <span style="font-size:12px;"> Rating: <?php echo $rates ?> - <?php echo $univ->review; ?> reviews</span>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

            <?php  
                
                if($i == 3) {
                    echo '</div><div class="search-cols col-50">';
                    $i = 1;
                }
                $i++;
            ?>

            <?php endforeach ?>

            </div>

        <?php else: ?>

            <div style="text-align:center;padding: 20px 0;">No Result</div>

        <?php endif ?>

        <div class="clear"></div>
    </div>

    <div id="category-pager">
        <div class="show-note">
            Showing <?php echo $numb; ?> of <?php echo $all ?> Universities
        </div>
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
        <div class="clear"></div>
    </div>
    
    <div class="space_title">
        Top Programs and Course
    </div>

    <div class="col-50">
        <h3>Top 5 Programs</h3>
        <ol class="shorted-program">
            <?php foreach ($top_five_p as $tp): ?>
            <li>
                <div class="name"><?php echo anchor(site_url('university/'.$tp->university_id.'/program/'.$tp->program_id),$tp->program_name); ?></div>
                <!-- <div class="name"><?php echo $tp->program_name; ?></div> -->
                <div style="font-size:12px;"><?php echo anchor(site_url('university/'.$tp->university_id),$tp->university_name); ?></div>
                <div class="rates">
                    <?php 
                        $rates = floor($tp->rates); 
                        $star = floor($rates/2);
                    ?>
                    <div class="rate r-<?php echo $star; ?> inline-block"></div>
                    <span> Rating: <?php echo $rates ?> - <?php echo $tp->reviews; ?> reviews</span>
                </div>
            </li>
            <?php endforeach ?>
        </ol>
    </div>

    <div class="col-50">
        <h3>Top 5 Course</h3>
        <ol class="shorted-program">
            <?php foreach ($top_five_c as $tc): ?>
            <li>
                <div class="name">
                    <?php echo anchor(site_url('university/'.$tc->university_id.'/program/'.$tc->program_id.'/course/'.$tc->course_id),$tc->course_name); ?>
                </div>
                <div style="font-size:12px;">
                    <?php echo anchor(site_url('university/'.$tc->university_id.'/program/'.$tc->program_id),$tc->program_name); ?> of 
                    <?php echo anchor(site_url('university/'.$tc->university_id),$tc->university_name); ?>
                </div>
                <div class="rates">
                    <?php 
                        $rates = floor($tc->rates); 
                        $star = floor($rates/2);
                    ?>
                    <div class="rate r-<?php echo $star; ?> inline-block"></div>
                    <span> Rating: <?php echo $rates ?> - <?php echo $tc->reviews; ?> reviews</span>
                </div>
            </li>
            <?php endforeach ?>
        </ol>
    </div>

    <div class="clear"></div>

    <div style="padding:20px 0;"></div>

    <div class="space_title">
        Bottom Programs and Course
    </div>

    <div class="col-50">
        <h3>Bottom 5 Programs</h3>
        <ol class="shorted-program">
            <?php foreach ($bottom_five_p as $tp): ?>
            <li>
                <div class="name"><?php echo anchor(site_url('university/'.$tp->university_id.'/program/'.$tp->program_id),$tp->program_name); ?></div>
                <div style="font-size:12px;"><?php echo anchor(site_url('university/'.$tp->university_id),$tp->university_name); ?></div>
                <div class="rates">
                    <?php 
                        $rates = floor($tp->rates); 
                        $star = floor($rates/2);
                    ?>
                    <div class="rate r-<?php echo $star; ?> inline-block"></div>
                    <span> Rating: <?php echo $rates ?> - <?php echo $tp->reviews; ?> reviews</span>
                </div>
            </li>
            <?php endforeach ?>
        </ol>
    </div>

    <div class="col-50">
        <h3>Bottom 5 Course</h3>
        <ol class="shorted-program">
            <?php foreach ($bottom_five_c as $tc): ?>
            <li>
                <div class="name">
                    <?php echo anchor(site_url('university/'.$tc->university_id.'/program/'.$tc->program_id.'/course/'.$tc->course_id),$tc->course_name); ?>
                </div>
                <div style="font-size:12px;">
                    <?php echo anchor(site_url('university/'.$tc->university_id.'/program/'.$tc->program_id),$tc->program_name); ?> of 
                    <?php echo anchor(site_url('university/'.$tc->university_id),$tc->university_name); ?>
                </div>
                <div class="rates">
                    <?php 
                        $rates = floor($tc->rates); 
                        $star = floor($rates/2);
                    ?>
                    <div class="rate r-<?php echo $star; ?> inline-block"></div>
                    <span> Rating: <?php echo $rates ?> - <?php echo $tc->reviews; ?> reviews</span>
                </div>
            </li>
            <?php endforeach ?>
        </ol>
    </div>

    <div class="clear"></div>
</div>