<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if(! class_exists('Tumblr_Gallery_Admin')){
    class Tumblr_Gallery_Admin {
        public function __construct(){
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
            add_action('admin_menu', array( $this,'tumblr_gallery_menu'));
            add_action('init',  array( $this,'tumblr_gallery_do_output_buffer'));
            add_action( 'wp_ajax_nopriv_tumblr_ajax_sendmail', array( $this, 'tumblr_ajax_sendmail' ) );
            add_action( 'wp_ajax_tumblr_ajax_sendmail', array( $this, 'tumblr_ajax_sendmail' ) );
        }
        public function tumblr_gallery_do_output_buffer() {
            ob_start();
        }
        public function enqueue_admin_scripts(){
            wp_enqueue_style( 'tumblr_gallery_admin_css', TUMBLR_GALLERY_PLUGIN_URL . '/assets/css/tumblr-admin.css', false );
            wp_enqueue_script( 'tumblr_gallery_admin_js', TUMBLR_GALLERY_PLUGIN_URL . '/assets/js/tumblr-admin.js', array( 'jquery' ), true );
            $admin_url      = admin_url('admin-ajax.php');
            $tumblr_admin_url   = array( 'url' => $admin_url);
            wp_localize_script('tumblr_gallery_admin_js', 'tumblr_ajax', $tumblr_admin_url);
            wp_enqueue_style( 'wp-color-picker');
            wp_enqueue_script( 'wp-color-picker');
        }
        public function tumblr_gallery_menu(){
            add_menu_page('Tumblr Gallery', 'Tumblr Gallery', 'delete_pages', 'tumblr_gallery', array($this,'tumblr_gallery_function'), plugins_url('tumblr_gallery.png', __FILE__));
            add_submenu_page('tumblr_gallery', 'Tumblr Gallery', 'All Galleries', 'delete_pages', 'tumblr_gallery', array($this,'tumblr_gallery_function'));
            add_submenu_page('tumblr_gallery', 'About', 'About', 'delete_pages', 'tumblr_gallery_about', array($this,'tumblr_gallery_about'));
        }
        public function tumblr_ajax_sendmail(){
            $tb_object = $_POST['tb_subject'];
            $tb_name = $_POST['tb_name'];
            $tb_email = $_POST['tb_email'];
            $tb_message = $_POST['tb_message'];
            $email="miniplugins@gmail.com";
            $subject=$tb_object;
            $message = $tb_message;
            $headers = 'From:' . $tb_email;

            wp_mail($email, $subject, $message, $headers)
            ?>
            <p> Thanks so much!</p>
            <?php
            exit();
        }

        public function tumblr_gallery_function(){
            require_once("tumblr-admin-functions.php");
            require_once("tumblr-admin-html.php");
            if (isset($_GET["task"]))
                $task = $_GET["task"];
            else
                $task = '';
            if (isset($_GET["id"]))
                $id = $_GET["id"];
            else
                $id = 0;
            switch ($task) {
                case 'add_tumblr_gallery':
                    add_tumblr_gallery();
                    break;
                case 'edit_tumblr_gallery':
                        edit_tumblr_gallery($id);
                    break;
                case 'remove_tumblr_gallery':
                        remove_tumblr_gallery($id);
                        shows_tumblr_gallery();
                    break;
                case 'apply':
                    tumblr_gallery_apply($id);
                    break;

                default:
                    shows_tumblr_gallery();
                    break;
            }
        }
        public function tumblr_gallery_about(){
            $admin_email = get_option('admin_email');
            ?>
            <div class="tumblr-wrap tumblr-wrap-about">
                <div class="tumblr-title">
                    <h3><?php echo esc_html_e('Tumblr Gallery','tumblr-gallery');?></h3>
                </div>
                <div class="tumblr-about-content">
                    <h2> Thanks for using Tumblr Gallery.</h2>
                    <p>We hope you can send us any suggestions. We will update plugin better.</p>
                    <div class="tumblr_suggest">
                        <input type="text" placeholder="Subject..." name="tumblr-subject" class="tumblr-subject">
                        <input type="text" placeholder="Your Name" class="tumblr-name">
                        <input type="hidden" class="tumblr-email" value="<?php echo esc_attr($admin_email);?>">
                        <textarea class="tumblr-message" placeholder="Your Suggestion..."></textarea>

                        <button class="tumblr-send">Send</button>
                    </div>

                </div>
            </div>
<?php
        }
    }
}
new Tumblr_Gallery_Admin();