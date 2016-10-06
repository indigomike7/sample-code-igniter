<div id="wrapper">
    <div class="float_left width468 center">
        <p>&nbsp;</p>
        <form action="<?php echo site_url('home/search');?>" method="post" style="width:700px;">
            <input type="text" name="query" id="query" class="width250 font_size_20"  style="float:left;" value="<?php echo $phrase; ?>"/>
            <?php $options = array('university'=>'University','program'=>'Program','course'=>'Course'); ?>
            <?php echo form_dropdown('filter', $options, $this->uri->segment(5), 'style="float:left;height: 40px; margin: 10px 10px;"'); ?>

            
            <button type="submit" class="front_search_button" style="float:left; margin: 10px 10px;">&nbsp;&nbsp;&nbsp;Search</button>
        </form>
    </div>
    <div class="clear"></div>
	<div class="space_title">
        Search result for "<?php echo $phrase; ?>"
    </div>
    <div class="result-wrapper">

        <?php if($search): ?>

            <?php foreach ($search as $item): ?>
                <!-- [RESULT ITEM] -->
                <div class="result-item">
                    <div class="name">
                        <?php echo $item->link; ?>
                    </div>
                    <div class="desc">
                        <?php echo $item->description; ?>
                    </div>
                    <div class="scorre">
                        Average <b><?php echo $item->rates; ?></b> <span>of 10</span>
                    </div>
                    <div class="rates">
                        <div class="rate-large rl-<?php echo $item->star; ?>"></div>
                    </div>
                    <div class="views">
                        <?php echo $item->review; ?> reviews
                    </div>
                </div>
                <!-- [/RESULT ITEM] -->
            <?php endforeach; ?>

        <?php else: ?>

            <div class="result-item">No Result</div>

        <?php endif; ?>

        <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>

    </div>
</div>