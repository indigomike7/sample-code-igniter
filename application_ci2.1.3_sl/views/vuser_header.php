<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
<meta name="generator" content="2.2.6.166"/>
<title>Campagne de financement CMND</title>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/site.css');?>" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/styles.css');?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/style.css');?>" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/jquery-ui-1.9.0.custom.css');?>" media="screen"/>
<script src="<?php echo site_url('js/jquery-1.8.2.js');?>" type="text/javascript"></script>
<script src="<?php echo site_url('js/index.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('js/jquery-ui-1.9.0.custom.js'); ?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo site_url("css/ui.jqgrid.css");?>" />
<script src="<?php echo site_url("js/i18n/grid.locale-en.js");?>" type="text/javascript"></script>
<script src="<?php echo site_url("js/jquery.jqGrid.min.js");?>" type="text/javascript"></script>
</head>
<body>
<div class="row" id="page">
    <div id="banner_top">
            <p>&nbsp;</p>
    </div>
    <div class="container">
        <!-- start container -->
        <?php //echo  $this->router->class;?>
        <div id='cssmenu'>
        <ul>
        <li class='<?php if($this->router->class == "admin_home" && $this->router->method == "index"){ echo ' active ';} ?> '><a href='<?php echo site_url("admin/admin_home");?>'><span>Home</span></a></li>
        <li class='has-sub <?php if($this->router->class == "admin" && $this->router->method == "user"){ echo ' active ';} ?>'><a href='#'><span>Students</span></a>
            <ul>
                <li><a href='<?php echo site_url("admin/user");?>'><span>Students Data</span></a></li>
                <li><a href='<?php echo site_url("admin/user/import");?>'><span>Import Data</span></a></li>
            </ul>
        </li>
        <li class='<?php if($this->router->class == "admin" && $this->router->method == "logout"){ echo ' active ';} ?> '><a href='<?php echo site_url("admin/logout");?>'><span>Logout</span></a></li>
        </ul>
        </div>
        
        <div id="content">
