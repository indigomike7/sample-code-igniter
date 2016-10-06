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
    	</div>
        <div class="clear"></div>
    </div>

    <div class="space_title">
        Write your review
    </div>

    <div class="review-form">
        <?php echo validation_errors(); ?>
        
        <form action="<?php echo site_url('university/'.$detail->university_id.'/add_review') ;?>" method="post" id="form-review">
            <div>
                <label for="review">Title</label>
                <?php echo form_input('title',@$title,'style="width:600px;" id="title"'); ?>
                <span id="title_error" style="display:block;"></span>
            </div>
            <div>
                <label for="review">Review</label>
                <?php echo form_textarea('review',@$review,'style="width:600px;height:200px;" id="review"'); ?>
                <span id="review_error" style="display:block;"></span>
            </div>
            <div>
                <label for="rate">Rate</label>
                <?php echo form_dropdown('rate', $rate_data, @$rate); ?>
            </div>
            <div>
                <input type="submit" name="submit" value="Submit" >
            </div>
        </form>

    </div>

    <div class="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        /*
        $("#form-review").validate({
            rules:{
                title:{
                    required:true,
                    minlenght:3
                },
                review:{
                    required:true,
                    minlenght:20  
                }
            },
            messages:{
                title:{
                    required:"Title field is required",
                    minlength:"Title minimum character 3"
                },
                review:{
                    required:"Review field is required",
                    minlength:"Review minimum character 20"  
                }
            },
            errorPlacement: function(error,element) {
                element.parent().children("span").html("");
                error.prependTo(element.parent().children("span"));
            },
            submitHandler:function() {

            },
            success:function() {

            }
        });
    });*/
</script>