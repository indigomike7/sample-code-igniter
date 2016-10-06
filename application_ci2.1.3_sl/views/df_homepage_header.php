<!DOCTYPE HTML>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="utf-8" http-equiv="encoding" />
<title><?php echo $site_title;?></title>
<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/bootstrap.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/bootstrap-responsive.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo site_url('css/df_style.css'); ?>"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
  $.noConflict();
  jQuery(document).ready(function($) {

  });
</script>
</head>

<body>
<div class="container">
	<div class="row" id="header">
    	<div class="span8">
        	<a href="<?php echo site_url();?>"><div class="logo"></div></a>
            <div class="slogan">
                <span class="dq_start"></span>
                <h1><?php echo $site_slogan;?></h1>
                <span class="dq_end"></span>
            </div>
   		</div>
        <div class="span4">
                <?php 
                if($this->router->class != "log" && ((bool)$this->session->userdata('usernameuser')==false))                         
                {
                ?>
                    <a href="<?php echo site_url('home/log');?>">
                            <div class="button_sr pull-right"></div>
                    </a>
                <?php 
                }
                elseif((bool)$this->session->userdata('usernameuser')==true)
                {
                ?>
                        <ul class="head_menu pull-right">
                            <li><a href="<?php echo site_url('user/user/logout');?>">Log Out</a></li>
                            <li><a href="<?php echo site_url('user/user/user_setting');?>">User Setting</a></li>
                        </ul>
                <?php
                }
                ?>
    	</div>
    </div>
   	<hr class="line top" />
    <div class="row">
    	<div class="span12"><div id="content"><!-- Start Content -->