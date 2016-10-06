<div class="slideshow">
	<?php for($x=1;$x<5;$x++){ ?>
    <img src="<?php echo site_url('images/slideshow'.$x.'.jpg'); ?>" />
    <?php } ?>
</div>
<script src="<?php echo site_url('js/jquery.nivo.slider.js'); ?>"></script>
<script>
jQuery(document).ready(function($) {
	$('#content .slideshow').nivoSlider({
		pauseOnHover: false,
		pauseTime: 5000,
		directionNav: false,
		controlNav: false,
		showCaption: false,
		onImageLoad: function(img) {},
		onImageChange: function(img) {}
	});
	$('#content .nivoSlider').height('350px');
});
</script>