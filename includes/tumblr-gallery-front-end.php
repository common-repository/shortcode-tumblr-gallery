<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once( 'lib/Eher/vendor/autoload.php' );
require_once( 'lib/Guzzle/vendor/autoload.php' );

require_once( 'lib/Tumblr/API/Client.php' );
require_once( 'lib/Tumblr/API/RequestHandler.php' );
require_once( 'lib/Tumblr/API/RequestException.php' );

function front_end_base_gallery($tumblr_gallery, $id)
{
    ?>
    <div id="gallery_default<?php echo esc_attr($id);?>" class="tumblr-layout-default grid">
    <?php
    // Authenticate via API Key
    $apiKey = $tumblr_gallery->tumblr_key;
    $blogName = $tumblr_gallery->tumblr_name;
    $type = $tumblr_gallery->tumblr_type;
    $options = unserialize($tumblr_gallery->tumblr_options);
    $client = new Tumblr\API\Client($apiKey);
//    $color =$options['color'];
    $column =$options['columns'];
    $padding =$options['padding'];
    $limit =$options['limit'];
    $width = 100/$column;
    ?>
    <style type="text/css">
        #gallery_default<?php echo esc_attr($id);?> figure.effect-kira{
            width:<?php echo esc_attr($width);?>%;
        }
        #gallery_default<?php echo esc_attr($id);?> figure.effect-kira .kira-item{
            padding:<?php echo esc_attr($padding);?>;
        }
    </style>
<?php
    // Photo request
    if($type=='photo'){
        $getBlogPosts = $client->getBlogPosts($blogName, array('type' => $type, 'limit' => $limit));
        $all_post = $getBlogPosts->posts;
        if( $all_post ){
            foreach($all_post as $post){
                $photo_original_size_url = ($post->photos[0]->original_size->url);
                $photo_alt_sizes_url = ($post->photos[0]->alt_sizes[2]->url);
                $summary = $post->summary;
                ?>
                <figure class="effect-kira">
                    <div class="kira-item">
                        <img src="<?php echo TUMBLR_GALLERY_PLUGIN_URL;?>/assets/img/square.png"
                             style="background-image:url(<?php echo esc_url($photo_alt_sizes_url );?>)" alt="<?php echo esc_attr($summary);?>">
                        <figcaption>
                            <h2><?php echo esc_attr($summary);?></h2>
                            <p>
                                <a href="<?php echo esc_url($post->post_url);?>"><i class="fa fa-fw fa-home"></i></a>
                                <a href="<?php echo esc_url($photo_original_size_url);?>"><i class="fa fa-fw fa-download"></i></a>
                                <a href="https://www.tumblr.com/reblog/<?php echo esc_attr($post->id);?>/<?php echo esc_attr($post->reblog_key);?>"><i class="fa fa-retweet"></i></a>
                                <a href="<?php echo esc_url($photo_original_size_url);?>" rel="gallery-<?php echo esc_attr($id);?>" class="swipebox<?php echo esc_attr($id);?>" title="<?php echo esc_attr($summary);?>"><i class="fa fa-search"></i></a>
                            </p>
                        </figcaption>
                    </div>
                </figure>
                <?php
            }
        }
    }
    if($type=='video'){
//     Video request
        $getBlogPosts = $client->getBlogPosts($blogName, array('type' => 'video', 'limit' => 9));
        $all_post = $getBlogPosts->posts;
        if( $all_post ){
            foreach($all_post as $post){
//                var_dump($post);
                $summary = $post->summary;
                //$embed = $post->player[2]->embed_code;
                $thumbnail_url = $post->thumbnail_url;
                if( isset($post->video_url) ) $video_url = $post->video_url;
                if( isset($post->permalink_url) ) $video_url = $post->permalink_url;
                ?>
                <figure class="effect-kira">
                    <div class="kira-item">
                        <img src="<?php echo TUMBLR_GALLERY_PLUGIN_URL;?>/assets/img/square.png"
                             style="background-image:url(<?php echo esc_url($thumbnail_url );?>)" alt="<?php echo esc_attr($summary);?>">
                        <figcaption>
                            <h2><?php echo esc_attr($summary);?></h2>
                            <p>
                                <a href="<?php echo esc_url($post->post_url);?>"><i class="fa fa-fw fa-home"></i></a>
                                <a href="<?php echo esc_url($video_url);?>"><i class="fa fa-fw fa-download"></i></a>
                                <a href="https://www.tumblr.com/reblog/<?php echo esc_attr($post->id);?>/<?php echo esc_attr($post->reblog_key);?>"><i class="fa fa-retweet"></i></a>
                                <a href="<?php echo esc_url($video_url);?>"
                                   rel="gallery-<?php echo esc_attr($id);?>" class="swipebox<?php echo esc_attr($id);?>"
                                   title="<?php echo esc_attr($summary);?>">
                                    <i class="fa fa-search"></i>
                                </a>
                            </p>
                        </figcaption>
                    </div>
                </figure>
                <?php
            }
        }
    }
    ?>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery( '.swipebox<?php echo esc_attr($id);?>' ).swipebox({
                hideBarsDelay : 0
            });
        })
    </script>
    <?php
}