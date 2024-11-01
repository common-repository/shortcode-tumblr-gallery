<?php
if(!function_exists('current_user_can')){
    die('Access Denied');
}
if(! function_exists('show_tumblr_galelry_list')){
    function show_tumblr_galelry_list($rows){
        ?>
        <div class="tumblr-wrap">
            <div class="tumblr-title">
                <h3><?php echo esc_html_e('Tumblr Gallery','tumblr-gallery');?></h3>
                <a class="tumblr_add_new" onclick="window.location.href='admin.php?page=tumblr_gallery&task=add_tumblr_gallery'">
                    <?php echo esc_html_e('Add new Gallery','tumblr-gallery');?>
                </a>
            </div>
            <table class="wp-list-table widefat fixed pages" style="width:95%">
                <thead>
                <tr>
                    <th scope="col" id="id" style="width:30px" ><span><?php echo esc_html_e('ID','tumblr-gallery');?></span></th>
                    <th scope="col" id="type" style="width:30px" ><span><?php echo esc_html_e('Gallery Type','tumblr-gallery');?></span></th>
                    <th scope="col" id="title" style="width:85px" ><span><?php echo esc_html_e('Title','tumblr-gallery');?></span></th>
                    <th scope="col" id="user"  style="width:75px;" ><span><?php echo __('User','tumblr-gallery');?></span></th>
                    <th scope="col" id="shortcode"  style="width:75px;" ><span><?php echo __('Shortcode','tumblr-gallery');?></span></th>
                    <th style="width:10px"><?php echo __('Delete','tumblr-gallery');?></th>
                </tr>
                </thead>
                <tbody>
                <?php $count = 1; foreach($rows as $row_item){
                    ?>
                    <tr <?php if($count%2==0){ echo 'class="tumblr-background"';}?>>
                        <td><?php echo esc_attr($row_item->id); ?></td>
                        <td><span><?php echo esc_attr($row_item->tumblr_type);?> </span></td>
                        <td><a  href="admin.php?page=tumblr_gallery&task=edit_tumblr_gallery&id=<?php echo esc_attr($row_item->id);?>">
                                <?php echo esc_html(stripslashes($row_item->tumblr_title)); ?>
                            </a>
                        </td>
                        <td><?php echo esc_attr($row_item->tumblr_name);?></td>
                        <td><textarea class="full" readonly="readonly">[tumblr_gallery id="<?php echo $row_item->id; ?>"]</textarea></td>
                        <td><a class="tumblr-delete" data-value="<?php echo esc_attr($row_item->id)?>"><?php echo __('Delete','tumblr-gallery');?></a></td>
                    </tr>
                    <?php

                    $count++; }

                ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
if(! function_exists('tumblr_gallery_edit_form')) {
    function tumblr_gallery_edit_form($row,$save)
    { $row_options = unserialize($row->tumblr_options);
    ?>
        <script type="text/javascript">
            function submitbutton(pressbutton)
            {
                document.getElementById("adminForm").action=document.getElementById("adminForm").action+"&task="+pressbutton;
                document.getElementById("adminForm").submit();
            }
        </script>
        <div class="tumblr-wrap">
            <div class="tumblr-title">
                <h3><?php echo esc_html_e('Tumblr Gallery','tumblr-gallery');?></h3>
                <a class="tumblr_add_new" onclick="window.location.href='admin.php?page=tumblr_gallery&task=add_tumblr_gallery'">
                    <?php echo esc_html_e('Add new Gallery','tumblr-gallery');?>
                </a>
            </div>
            <div class="tumblr-form">
                <?php
                if($save==1){
                    ?>
                <strong>
                    <?php
                    echo esc_html_e('Gallery saved','tumblr-gallery');
                    ?>
                </strong>
                <?php
                }
                ?>
                <form action="admin.php?page=tumblr_gallery&id=<?php echo $row->id; ?>" method="post" name="adminForm" id="adminForm">
                    <div class="tumblr-content">
                        <div class="basic-info">
                            <div class="tumblr_field">
                                <label for="tumblr-title"><?php echo esc_html_e('Gallery Title','tumblr-gallery');?></label>
                                <input type="text" id="tumblr-title" name="tumblr-title" value="<?php echo esc_attr($row->tumblr_title);?>" placeholder="<?php echo esc_html_e('Gallery Title','tumblr-gallery');?>"/>
                            </div>
                            <div class="tumblr_field">
                                <label for="tumblr-account"><?php echo esc_html_e('Tumblr Name','tumblr-gallery');?></label>
                                <input type="text" id="tumblr-account" name="tumblr-account" value="<?php echo esc_attr($row->tumblr_name);?>" placeholder="<?php echo esc_html_e('Tumblr account','tumblr-gallery');?>"/>
                                <div class="info">
                                    Your Tumblr name<a href="<?php echo plugins_url( '/tumblr_name.jpg' , __FILE__ );?>" target="_blank">Get Tumblr name </a>
                                </div>
                            </div>
                            <div class="tumblr_field">
                                <label for="tumblr-key"><?php echo esc_html_e('API Key','tumblr-gallery');?></label>
                                <input type="text" id="tumblr-key" name="tumblr-key" value="<?php echo esc_attr($row->tumblr_key);?>" placeholder="<?php echo esc_html_e('Tumblr API key','tumblr-gallery');?>"/>
                                <div class="info">
                                    Get Your tumblr API KEY<a href="https://www.tumblr.com/docs/en/api/v2" target="_blank">Get Tumblr API KEY </a>
                                    Or <a href="https://youtu.be/_SqjxA_pG6w" target="_blank">Video help</a>
                                </div>
                            </div>
                            <div class="tumblr_field">
                                <label for="tumblr-type"><?php echo esc_html_e('Data Type','tumblr-gallery');?></label>
                                <select id="tumblr-type" name="tumblr-type">
                                    <option value="photo" <?php if($row->tumblr_type=='photo'){ echo "selected";}?>><?php echo esc_html_e('Photo','tumblr-gallery');?></option>
                                    <option value="video" <?php if($row->tumblr_type=='video'){ echo "selected";}?> ><?php echo esc_html_e('Video','tumblr-gallery');?></option>
<!--                                    <option value="all" --><?php //if($row->tumblr_type=='all'){ echo "selected";}?><!-->--><?php //echo esc_html_e('All','tumblr-gallery');?><!--</option>-->
                                </select>
                            </div>
                            <div class="tumblr_field">
                                <label for="options_limit"><?php echo esc_html_e('Limit','tumblr-gallery');?></label>
                                <input type="text" id="options_limit" name="options_limit" value="<?php echo esc_attr($row_options['limit']);?>" placeholder="12"/>
                            </div>
                            <div class="tumblr-button">
                                <input type="button" onclick="submitbutton('apply')" value="<?php echo esc_html_e('Save gallery','tumblr-gallery');?>" id="save-buttom" class="button button-primary button-large">
                                <a class="tumblr-delete" data-value="<?php echo esc_attr($row->id)?>" ><?php echo esc_html_e('Delete','tumblr-gallery');?></a>
                            </div>
                        </div>
                        <div class="basic-options">
                            <div class="box-option">
                                <h3><?php echo esc_html_e('Basic Options','tumblr-gallery');?></h3>
<!--                                <h4>--><?php //echo esc_html_e('Box color','tumblr-gallery');?><!--</h4>-->
<!--                                <input data-default-color="#38beea" type="text" id="boxColor" value="--><?php //echo esc_attr($row_options['color']);?><!--" name="options_color" />-->
<!--                                <p class="description">--><?php //_e('Set color for box gallery thumbnails.') ?><!--</p>-->
<!--                                <script type="text/javascript">-->
<!--                                    jQuery(document).ready(function($){-->
<!--                                        $("#boxColor").wpColorPicker();-->
<!--                                    });-->
<!--                                </script>-->

                                <h4><?php echo esc_html_e('Columns layout','tumblr-gallery');?></h4>
                                <select name="options_columns" class="options_columns">
                                    <option value="2" <?php if($row_options['columns']==2){?>selected <?php }?>><?php echo esc_html_e('2 Columns','tumblr-gallery');?></option>
                                    <option value="3" <?php if($row_options['columns']==3){?>selected <?php }?>><?php echo esc_html_e('3 Columns','tumblr-gallery');?></option>
                                    <option value="4" <?php if($row_options['columns']==4){?>selected <?php }?>><?php echo esc_html_e('4 Columns','tumblr-gallery');?></option>
                                    <option value="5" <?php if($row_options['columns']==5){?>selected <?php }?>><?php echo esc_html_e('5 Columns','tumblr-gallery');?></option>
                                    <option value="6" <?php if($row_options['columns']==6){?>selected <?php }?>><?php echo esc_html_e('6 Columns','tumblr-gallery');?></option>
                                    <option value="7" <?php if($row_options['columns']==7){?>selected <?php }?>><?php echo esc_html_e('7 Columns','tumblr-gallery');?></option>
                                    <option value="8" <?php if($row_options['columns']==8){?>selected <?php }?>><?php echo esc_html_e('8 Columns','tumblr-gallery');?></option>
                                    <option value="8" <?php if($row_options['columns']==9){?>selected <?php }?>><?php echo esc_html_e('9 Columns','tumblr-gallery');?></option>
                                    <option value="8" <?php if($row_options['columns']==10){?>selected <?php }?>><?php echo esc_html_e('10 Columns','tumblr-gallery');?></option>
                                </select>
                                <h4><?php echo esc_html_e('Gallery Padding','tumblr-gallery');?></h4>
                                <input type="text" value="<?php echo esc_attr($row_options['padding']);?>" placeholder="5px" name="options_padding" class="options_padding"/>
                            </div>
                            <div class="box-option">
                                <h3><?php echo esc_html_e('Usage','tumblr-gallery');?></h3>
                                <div class="inside">
                                <h4><?php echo esc_html_e('Shortcode','tumblr-gallery');?></h4>
                                <p><?php echo esc_html_e('Copy &amp; paste the shortcode directly into any WordPress post or page.','tumblr-gallery');?></p>
                                <textarea class="full" readonly="readonly">[tumblr_gallery id="<?php echo $row->id; ?>"]</textarea>

                                <h4><?php echo esc_html_e('Template Include','tumblr-gallery');?></h4>
                                <p><?php echo esc_html_e('Copy &amp; paste this code into a template file to include the slideshow within your theme.','tumblr-gallery');?></p>
                                <textarea class="full" readonly="readonly">&lt;?php echo do_shortcode("[tumblr_gallery id='<?php echo $row->id; ?>']"); ?&gt;</textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php }}