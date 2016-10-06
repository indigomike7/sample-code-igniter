<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mail Configuration
 */
/*
$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';


$config['mailtype'] = 'html';*/
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'localhost';
$config['smtp_port'] = 25;