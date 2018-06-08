<?php
/*
Plugin Name:  Milo S3 Browser
Description:  S3 Bucket Browser for MILO Range
Author:       FWD Creative, LLC
Author URI:   https://designfwd.com/
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  milo
*/

// Load AWS SDK files
require 'vendor/autoload.php';

function milo_register_scripts() {
  wp_enqueue_script( 's3-browser', plugins_url( 'assets/scripts/dist/main.min.js', __FILE__), array('sage/js') );

  wp_register_style('s3-browser', plugins_url( 'assets/styles/dist/main.css', __FILE__), array('sage/css') );
  wp_enqueue_style('s3-browser');
}
add_action( 'wp_enqueue_scripts', 'milo_register_scripts');

// Load admin dashboard files
require (dirname(__FILE__) . '/admin/acf.php');
require (dirname(__FILE__) . '/admin/custom-post-types.php');
require (dirname(__FILE__) . '/admin/functions.php');
require (dirname(__FILE__) . '/admin/settings-page.php');

// Load public files
require (dirname(__FILE__) . '/public/functions.php');
require (dirname(__FILE__) . '/public/shortcode.php');
