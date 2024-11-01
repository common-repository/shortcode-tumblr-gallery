<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(! class_exists('Tumblr_gallery_Install')){
    class Tumblr_gallery_Install {
        public function __construct() {
            update_option( 'tumblr_gallery_version', TUMBLR_GALLERY_VERSION );
            $this->tumblr_gallery_active();
        }

        public function tumblr_gallery_active(){
            global $wpdb;
            $table_name = $wpdb->prefix . 'tumblr_gallery';

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
              tumblr_title varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              tumblr_name varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              tumblr_key varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              tumblr_type varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              tumblr_options text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
              PRIMARY KEY (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }
    new Tumblr_gallery_Install();
}