<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(! class_exists('tumblr_gallery_shortcode')) {
    class tumblr_gallery_shortcode
    {
        public function __construct() {
            add_shortcode('tumblr_gallery', array( $this,'tumblr_gallery_shotrcode'));
        }
        public function tumblr_gallery_shotrcode($atts){
            extract(shortcode_atts(array(
                'id' => 'no gallery_id',

            ), $atts));
            $id= $atts['id'];

            require_once('tumblr-gallery-front-end.php');
            global $wpdb;
            $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tumblr_gallery WHERE id = '%d'",$id);
            $tumblr_gallery=$wpdb->get_row($query);
            if($tumblr_gallery){
                return front_end_base_gallery($tumblr_gallery, $id);
            }
        }
    }
}
new tumblr_gallery_shortcode();