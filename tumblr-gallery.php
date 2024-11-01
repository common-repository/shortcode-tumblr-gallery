<?php
/*
Plugin Name: Tumblr Gallery
Plugin URI: http://miniplugins.com/tumblr-gallery/tumblr-photos/
Description: Plugin get all videos, photos, feeds from your tumblr and display on your site.
Version: 1.0.0
Requires at least: 3.8
Tested up to: 4.9.7
Author: miniplugins
Author URI: http://miniplugins.com
Author Email: miniplugins@gmail.com
License: GNU General Public License v3.0
Text Domain: tumblr-gallery
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(! class_exists('Tumblr_Gallery')){
    class Tumblr_Gallery{
        public function __construct() {
            define('TUMBLR_GALLERY_VERSION','1.0');
            define( 'TUMBLR_GALLERY_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
            if ( is_admin() ) {
                include( 'includes/admin/tumblr.php' );
            }
            register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), create_function( "", "include_once( 'includes/tumblr-gallery-install.php' );" ), 10 );

            add_action( 'admin_init', array( $this, 'updates' ) );
            add_action('wp_enqueue_scripts',array($this,'tumblr_front_end_style'));
            include( 'includes/tumblr-gallery-shortcode.php' );
        }

        public function updates() {
            if ( version_compare( TUMBLR_GALLERY_VERSION, get_option( 'tumblr_gallery_version' ), '>' ) )
                include_once( 'includes/tumblr-gallery-install.php' );
        }
        function tumblr_front_end_style($hook) {
            wp_enqueue_style( 'lity-css',    TUMBLR_GALLERY_PLUGIN_URL . '/assets/css/swipebox.min.css', false, '1.3.0');
            wp_enqueue_style("tumblr_default_css", TUMBLR_GALLERY_PLUGIN_URL.'/assets/css/default.css', false);
            wp_enqueue_style("font-awesome", TUMBLR_GALLERY_PLUGIN_URL.'/assets/css/font-awesome.min.css', false);
            wp_enqueue_style("tumblr_set2_css", TUMBLR_GALLERY_PLUGIN_URL.'/assets/css/set2.css', false);

            wp_enqueue_script( 'lity-script', TUMBLR_GALLERY_PLUGIN_URL . '/assets/js/jquery.swipebox.js', array(), '1.3.0', true );
            wp_enqueue_script( 'tumblr-gallery-script', TUMBLR_GALLERY_PLUGIN_URL . '/assets/js/tumblr-gallery.js', array(), '1.0', true );
        }
    }
    $GLOBALS['tumblr_gallery'] = new Tumblr_Gallery();
}