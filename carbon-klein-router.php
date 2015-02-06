<?php
/*
Plugin Name:  Carbon Router Wordpress
Plugin URI:   http://github.com/carboncreative/carbon-router-wordpress
Description:  A simple router for Wordpress
Version:      0.0.1
Author:       Tom Moitié
Author URI:   http://www.carboncreative.net/
*/

if (!class_exists('Carbon\\Router\\Routing') && file_exists(__DIR__.'/vendor/autoload.php')) {
    require_once(__DIR__ . '/vendor/autoload.php');
}
