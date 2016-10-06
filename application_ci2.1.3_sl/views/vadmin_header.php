<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding"></head>
    <title> Study Ratings - Admin </title>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('css/smoothness/jquery-ui-1.9.0.custom.css');?>" media="screen"/>
    <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/bootstrap.css');?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/bootstrap-responsive.css');?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo site_url('css/style.css');?>"/>
    <script src="<?php echo site_url('js/jquery-1.8.2.js');?>" type="text/javascript"></script>
    <!-- start jquery.validate -->
    <script type="text/javascript" src="<?php echo site_url("js/jquery.validate.js");?>"></script>
  <!-- eof jquery.validate -->
    <script src="<?php echo site_url('js/jquery-ui-1.9.0.custom.js'); ?>" type="text/javascript"></script>
    <!-- Start Menu -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('css/jquerycssmenu.css');?>" />
    <!--[if lte IE 7]>
    <style type="text/css">
    html .jquerycssmenu{height: 1%;} /*Holly Hack for IE7 and below*/
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo site_url('js/jquerycssmenu.js');?>"></script>
    <!-- eof Menu -->

    <!-- start jqgrid -->
<!--    <link rel="stylesheet" type="text/css" media="screen" href="css/ui-lightness/jquery-ui-1.7.1.custom.css" />-->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo site_url('css/ui.jqgrid.css');?>" />
<!--    <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>-->
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

  <!-- eof uploader -->
  

  <body>
	<div id="body">
            <div id="header">
                    <div id="logo">
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div id="hr_top">&nbsp;</div>
            </div>
            <div id="container">
                <?php
                        if ($this->admin_ion_auth->logged_in() === TRUE)
                        {
                ?>
                    <div id="myjquerymenu" class="jquerycssmenu">
                    <ul>
                        <li>
                            <a href="<?php echo site_url("admin/admin_home");?>"><span> Home </span></a>
                        </li>
                        <li>
                            <a href="#"><span> Master Data </span></a>
                                <ul>
                                    <li class="arrow"></li>
                                    <li>
                                        <a href="#"><span>Location</span></a>
                                        <ul>
                                            <li><a href="<?php echo site_url("admin/region"); ?>"><span>Region</span></a></li>
                                            <li><a href="<?php echo site_url("admin/sub_region"); ?>"><span>Sub Region</span></a></li>
                                            <li><a href="<?php echo site_url("admin/country"); ?>"><span>Country</span></a></li>
                                            <li><a href="<?php echo site_url("admin/city"); ?>"><span>Cities</span></a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href=""><span>Study</span></a>
                                        <ul>
                                            <li><a href="<?php echo site_url("admin/university_category"); ?>"><span>University Category</span></a></li>
                                            <li><a href="<?php echo site_url("admin/university"); ?>"><span>University</span></a></li>
                                            <li><a href="<?php echo site_url("admin/program_category"); ?>"><span>Program Category</span></a></li>
                                            <li><a href="<?php echo site_url("admin/program"); ?>"><span>Program</span></a></li>
                                            <li><a href="<?php echo site_url("admin/course"); ?>"><span>Course</span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                        </li>
                        <li>
                            <a href="#"><span> Content </span></a>
                                <ul>
                                    <li class="arrow"></li>
                                    <li>
                                        <a href="#"><span>Page</span></a>
                                        <ul>
                                            <li><a href="<?php echo site_url("admin/page_category"); ?>"><span>Category</span></a></li>
                                            <li><a href="<?php echo site_url("admin/page"); ?>"><span>Page</span></a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><span>Article</span></a>
                                        <ul>
                                            <li><a href="<?php echo site_url("admin/article_category"); ?>"><span>Category</span></a></li>
                                            <li><a href="<?php echo site_url("admin/article"); ?>"><span>Article</span></a></li>
                                        </ul>
                                    </li>
                                </ul>
                        </li>
                        <li><a href="<?php echo site_url("admin/site_setting"); ?>"><span>Site Setting</span></a></li>
                        <li><a href="<?php echo site_url("admin/password"); ?>"><span>Password</span></a></li>
                        <li class="last"><a href="<?php echo site_url("admin/logout"); ?>"><span>Log Out</span></a></li>
                    </ul>
                        <br style="clear: left" />
                </div>    
              
        <?php 
        }
        ?>
