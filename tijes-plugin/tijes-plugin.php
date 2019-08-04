<?php
  /**
   * @package Tijes Plugin
   */
  /*
  Plugin Name: Tijesuimi's Plugin
  Plugin URI: https://github.com/tijesunimi-peters/tijes-plugin
  Description: Just as plugin
  Version: 1.0.0
  Author: Tijesunimi Peters
  Author URI: https://github.com/tijesunimi-peters
  License: GPLv2 or later
  Text Domain: tijes-plugin
  */

  defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

  require_once __DIR__.'/vendor/autoload.php'; // Loads all the classes

  define( 'TIJES_PLUGIN_VERSION', '1.0.0' );
  define( 'TIJES__MINIMUM_WP_VERSION', '4.0' );
  define( 'TIJES_PLUGIN__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
  
  register_activation_hook( __FILE__, array( 'TijesPlugin', 'plugin_activation' ) );
  register_deactivation_hook( __FILE__, array( 'TijesPlugin', 'plugin_deactivation' ) );
  
  add_action( 'init', array( 'TijesPlugin', 'init' ) );
