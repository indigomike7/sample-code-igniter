<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding"></head>
<title><?php echo $site_title;?></title>
<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/style.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/bootstrap.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/bootstrap-responsive.css'); ?>"/>
<meta content="<?php echo $site_meta_keyword; ?>" name="keywords">
<meta content="<?php echo $site_meta_description; ?>" name="description">
<script src="<?php echo site_url('js/jquery-1.8.2.js');?>" type="text/javascript"></script>
<!-- start jquery.validate -->
<script type="text/javascript" src="<?php echo site_url("js/jquery.validate.js");?>"></script>
<!-- eof jquery.validate -->
<script src="<?php echo site_url('js/jquery-ui-1.9.0.custom.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('js/i18n/grid.locale-en.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('js/jquery.jqGrid.min.js');?>" type="text/javascript"></script>
<!-- eof jqgrid -->
<!-- start button -->
<link rel="stylesheet" href="<?php echo site_url('css/css3-buttons-grey.css');?>" type="text/css"  media="screen"> 
<link rel="stylesheet" href="<?php echo site_url('css/css3-buttons.css');?>" type="text/css"  media="screen">
<!-- eof button -->
<!-- start jquery.fancybox -->  
<!-- Add jQuery library -->

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo site_url('lib/jquery.mousewheel-3.0.6.pack.js');?>"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo site_url('fancybox/jquery.fancybox.js?v=2.1.3');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('fancybox/jquery.fancybox.css?v=2.1.2');?>" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5');?>" />
<script type="text/javascript" src="<?php echo site_url('fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5');?>"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7');?>" />
<script type="text/javascript" src="<?php echo site_url('fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7');?>"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="<?php echo site_url('fancybox/helpers/jquery.fancybox-media.js?v=1.0.5');?>"></script>
<!-- eof jquery.fancybox -->
<!-- start fckeditor -->
<script type="text/javascript" src="<?php echo site_url('editor/nicEdit.js');?>"></script>
<!-- eof fckeditor -->
<!-- start uploader -->
<script type="text/javascript" src="<?php echo site_url("swfupload/swfupload.js");?>"></script>
<script type="text/javascript" src="<?php echo site_url("js/swfupload.queue.js");?>"></script>
<script type="text/javascript" src="<?php echo site_url("js/fileprogress.js");?>"></script>
<script type="text/javascript" src="<?php echo site_url("js/handlers.js");?>"></script>

<link rel="stylesheet" href="http://blueimp.github.com/jQuery-Image-Gallery/css/jquery.image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the jQuery UI progress bars -->
<link rel="stylesheet" href="<?php echo site_url('css/jquery.fileupload-ui.css'); ?>">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo site_url('css/jquery.fileupload-ui-noscript.css'); ?>"></noscript>

</head>
<body>
	<div id="body">
		<div id="header">
                    <a href="<?php echo site_url();?>">
			<div id="logo">
			</div>
                    </a>
			<div id="slogan">
				<span id="dq_start"></span>
				<h1><?php echo $site_slogan;?></h1>
				<span id="dq_end"></span>
			</div>
                    <?php 
                    if($this->router->class != "log" && ((bool)$this->session->userdata('usernameuser')==false))                         
                    {
                    ?>
                        <a  id="signreg" href="<?php echo site_url('home/log');?>">
                                <div class="button_sr">
                                </div>
                        </a>
                        <?php 
                    }
                    elseif((bool)$this->session->userdata('usernameuser')==true)
                    {
                        ?>
                            <ul id="home_header_menu">
                                <li><a href="<?php echo site_url('user/user/logout');?>">Log Out</a></li>
                                <li><a href="<?php echo site_url('home/log/edit_user');?>"><?php echo $this->session->userdata('usernameuser');?></a></?li>
                            </ul>
                        <?php
                    }
                        ?>
			<div class="clear">&nbsp;</div>
			<div id="hr_top">&nbsp;</div>
		</div>
                <div id="content">
                <!-- Start Content -->
    