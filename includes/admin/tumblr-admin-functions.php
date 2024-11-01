<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
 * Function Add new gallery
 * */
if(! function_exists('shows_tumblr_gallery')) {
    function shows_tumblr_gallery()
    {
        global $wpdb;
        $query = "SELECT * FROM ".$wpdb->prefix."tumblr_gallery";
        $rows = $wpdb->get_results($query);
        show_tumblr_galelry_list($rows );
    }
}
/*
 * Function Add new gallery
 * */
if(! function_exists('add_tumblr_galelry')){
    function add_tumblr_gallery(){
        global $wpdb;
        $table_name = $wpdb->prefix . "tumblr_gallery";
        $sql_insert = "INSERT INTO `$table_name` ( `tumblr_title` , `tumblr_name` , `tumblr_key` , `tumblr_type` ,`tumblr_options` )
    VALUES
    ('Gallery Title', 'Tumblr name', '', 'photo', '')";
        $wpdb->query($sql_insert);
        $query_id = "SELECT id FROM $table_name order by id DESC LIMIT 1";
        $max_id = $wpdb->get_row($query_id);
        header('Location:admin.php?page=tumblr_gallery&task=edit_tumblr_gallery&id='.$max_id->id.'');
        exit;
    }
}
/*
 * Function Edit gallery
 * */
if(! function_exists('edit_tumblr_gallery')){
    function edit_tumblr_gallery($id){
        $save ='';
        if(isset($_GET["save"])){
            if($_GET["save"] != ''){
                $save =1;
            }
        }
        global $wpdb;
        $query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."tumblr_gallery WHERE id= %d",$id);
        $row=$wpdb->get_row($query);
        tumblr_gallery_edit_form($row,$save);
    }
}
/*
 * Function Remove gallery
 * */
if(! function_exists('remove_tumblr_gallery')){
    function remove_tumblr_gallery($id){
        global $wpdb;
        $sql_remov=$wpdb->prepare("DELETE FROM ".$wpdb->prefix."tumblr_gallery WHERE id = %d", $id);
        if(!$wpdb->query($sql_remov))
        {
            ?>
            <div id="message" class="error"><p><?php echo esc_html_e('Gallery Not Deleted','tumblr-gallery');?></p></div>
            <?php
        }
        else{
            ?>
            <div class="updated"><p><strong><?php esc_html_e('Gallery Deleted.','tumblr-gallery' ); ?></strong></p></div>
            <?php
        }
    }
}
/*
 * Function Apply gallery
 * */
if(! function_exists('tumblr_gallery_apply')){
    function tumblr_gallery_apply($id){
        $tumblr_options = array(
//            "color" => $_POST['options_color'],
            "columns" => $_POST['options_columns'],
            "padding" => $_POST['options_padding'],
            "limit" => $_POST['options_limit'],
        );

        global $wpdb;
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tumblr_gallery SET  tumblr_title = '%s'  WHERE ID = %d ", $_POST["tumblr-title"], $id));
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tumblr_gallery SET  tumblr_name = '%s'  WHERE ID = %d ", $_POST["tumblr-account"], $id));
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tumblr_gallery SET  tumblr_key = '%s'  WHERE ID = %d ", $_POST["tumblr-key"], $id));
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tumblr_gallery SET  tumblr_type = '%s'  WHERE ID = %d ", $_POST["tumblr-type"], $id));
        $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."tumblr_gallery SET  tumblr_options = '%s'  WHERE ID = %d ", serialize($tumblr_options), $id));
        header('Location:admin.php?page=tumblr_gallery&task=edit_tumblr_gallery&id='.$id.'&save=1');
        exit;
    }}