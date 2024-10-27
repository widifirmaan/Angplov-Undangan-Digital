<?php

$options = get_option( 'wdp_options' );

global $wp_version;

function wdp_checked_array( $value, $array ){

    if( in_array( $value, (array) $array) ){

        echo 'checked="checked"';
    }
}

?>

<div class="wrap">

    <!-- Display Plugin Icon and Header -->

    <?php //screen_icon( 'wdp' ); ?>

    <h2 <?php if( version_compare( $wp_version, "3.8", ">=" ) ) echo 'class="title-settings"'; ?>><?php _e( WDP_PLUGIN_NAME . ' Settings', 'WDP' ); ?></h2>

    <?php

    if( ! isset( $_REQUEST['settings-updated'] ) )

        $_REQUEST['settings-updated'] = false;

    ?>

    <?php if( false !== $_REQUEST['settings-updated'] ) : ?>

        <div class="message updated" style="width:80%"><p><strong><?php _e( 'Options saved', 'WDP' ); ?></strong></p>

        </div>

    <?php endif; ?>

    <h2 id="wdp-tabs" class="nav-tab-wrapper">

        <a class="nav-tab" href="#wdp-tab-content"><?php _e( 'Customization', 'WDP' ); ?></a>
        <a class="nav-tab" href="#wdp-tab-data-export"><?php _e('Export CSV', 'WDP'); ?></a>

    </h2>

    <form id="wdp-form" action="<?php echo admin_url( 'options.php' ); ?>" method="post">

        <?php settings_fields( 'wdp_group_options' ); ?>

        <div class="wdp-tab-container">

            <div id="wdp-tab-content" class="wdp-tab-content">

                <fieldset class="wdp-control-group">
                    <div class="wdp-control-label">
                        <label><?php _e( 'Who can comment?', 'WDP' ); ?></label>
                    </div><!--.wdp-control-label-->
                    <div class="wdp-controls">
                        <input id="wdp-only-by-name" name="wdp_options[comment_by_name]" type="checkbox"
                               value="true" <?php if( isset( $options['comment_by_name'] ) ){
                            checked( 'true', $options['comment_by_name'] );
                        } ?> />
                        <label for="wdp-only-by-name"><?php _e( 'Only name via link can comment', 'WDP' ); ?></label>
                        <br/>
                        <p class="wdp-descrip-item"></p>
                    </div><!--.wdp-controls-->
                </fieldset>

                <fieldset class="wdp-control-group">
                    <div class="wdp-control-label">
                        <label><?php _e( 'Required Confirmation of Attendance?', 'WDP' ); ?></label>
                    </div><!--.wdp-control-label-->
                    <div class="wdp-controls">
                        <input id="wdp-only-by-name" name="wdp_options[confirm_attendance]" type="checkbox"
                               value="true" <?php if( isset( $options['confirm_attendance'] ) ){
                            checked( 'true', $options['confirm_attendance'] );
                        } ?> />
                        <label for="wdp-only-by-name"><?php _e( 'User Required Confirmation of Attendance?', 'WDP' ); ?></label>
                        <br/>
                        <p class="wdp-descrip-item"></p>
                    </div><!--.wdp-controls-->
                </fieldset>

                <fieldset class="wdp-control-group">
                    <div class="wdp-control-label">
                        <label><?php _e( 'Disable Reply Comments', 'WDP' ); ?></label>
                        <p class="wdp-descrip-item"></p>
                    </div><!--.wdp-control-label-->
                    <div class="wdp-controls">
                        <div class="wdp-radio wdp-radio-h wdp-float-l wdp-5-box">
                            <input id="wdp-disable-reply-true" name="wdp_options[disable_reply]" type="radio"
                                   value="true" <?php checked( 'true', $options['disable_reply'] ); ?> />
                            <label for="wdp-disable-reply-true"><?php _e( 'Yes', 'WDP' ); ?></label>
                        </div><!--.wdp-radio-->
                        <div class="wdp-radio wdp-radio-h wdp-float-l wdp-5-box">
                            <input id="wdp-disable-reply-false" name="wdp_options[disable_reply]" type="radio"
                                   value="false" <?php checked( 'false', $options['disable_reply'] ); ?> />
                            <label for="wdp-disable-reply-false"><?php _e( 'Not', 'WDP' ); ?></label>
                        </div><!--.wdp-radio-->
                        <br/>
                        <p class="wdp-descrip-item"><?php _e( 'If enabled, then the reply comments will be disabled for all post/pages.', 'WDP' ); ?></p>
                    </div><!--.wdp-controls-->
                </fieldset>


                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="group-name"><?php _e( 'Number of comments per page', 'WDP' ); ?></label>

                        <p class="wdp-descrip-item"></p>



                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="wdp-num-comments-by-page" type="text" name="wdp_options[num_comments_by_page]"

                               value="<?php echo $options['num_comments_by_page']; ?>"/>

                        <p class="wdp-descrip-item"><?php _e( 'Default value', 'WDP' ); ?>:

                            10<br/><strong><?php _e( 'Note: ', 'WDP' ); ?></strong><?php _e( 'If the total number of comments is less than the number of comments per page, the pager will not be displayed.', 'WDP' ); ?>

                        </p>

                    </div><!--.wdp-controls-->

                </fieldset>


                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="group-name"><?php _e( 'Placeholder Comment Field', 'WDP' ); ?></label>

                        <p class="wdp-descrip-item"></p>



                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="text-comment-placeholder" type="text" name="wdp_options[text-comment-placeholder]"

                               value="<?php echo $options['text-comment-placeholder']; ?>"/>

                    </div><!--.wdp-controls-->

                </fieldset>


                <!-- Texto del enlace Mostrar Comentarios -->

                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label><?php _e( 'Show comments link text', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <div class="wdp-float-l wdp-3-box">

                            <input id="text_0_comments" type="text" name="wdp_options[text_0_comments]"

                                   value="<?php echo $options['text_0_comments']; ?>"/>

                            <span class="wdp-descrip-item wdp-first"><?php _e( 'If the post has no comments', 'WDP' ); ?></span>

                        </div><!--.wdp-3-box-->

                        <div class="wdp-float-l wdp-3-box">

                            <input id="text_1_comment" type="text" name="wdp_options[text_1_comment]"

                                   value="<?php echo $options['text_1_comment']; ?>"/>

                            <span class="wdp-descrip-item wdp-first"><?php _e( 'If the post has 1 comment', 'WDP' ); ?></span>

                        </div><!--.wdp-3-box-->

                        <div class="wdp-float-l wdp-3-box wdp-last">

                            <input id="text_more_comments" type="text" name="wdp_options[text_more_comments]"

                                   value="<?php echo $options['text_more_comments']; ?>"/>

                            <span class="wdp-descrip-item wdp-first"><?php _e( 'For more than one comment', 'WDP' ); ?></span>

                        </div><!--.wdp-3-box-->



                        <p class="wdp-descrip-item"><?php _e( 'Use #N# to display the number of comments,  remove it if you don\'t want to show it.', 'WDP' ); ?></p>

                    </div><!--.wdp-controls-->

                </fieldset>

                <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>





            

                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="avatar_url"><?php _e( 'Avatar Url', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                       <!--  <div class="wdp-float-l wdp-5-box"> -->

                            <input id="avatar_url" type="text" name="wdp_options[avatar_url]"

                                   value="<?php echo $options['avatar_url']; ?>"/>

                        <!-- </div> --><!--.wdp-3-box-->

                        <p class="wdp-descrip-item"><?php _e( '', 'WDP' ); ?></p>

                    </div><!--.wdp-controls-->

                </fieldset>

                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="avatar_size"><?php _e( 'Avatar size', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <div class="wdp-float-l wdp-5-box">

                            <input id="avatar_size" type="text" name="wdp_options[avatar_size]"

                                   value="<?php echo $options['avatar_size']; ?>"/>

                        </div><!--.wdp-3-box-->

                        <p class="wdp-descrip-item"><?php _e( '', 'WDP' ); ?></p>

                    </div><!--.wdp-controls-->

                </fieldset>

                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="base_font_size"><?php _e( 'Base font size', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <div class="wdp-float-l wdp-5-box">

                            <input id="base_font_size" type="text" name="wdp_options[base_font_size]"

                                   value="<?php echo $options['base_font_size']; ?>"/>

                        </div><!--.wdp-3-box-->

                        <p class="wdp-descrip-item"><?php _e( 'Base font size for all text in the comment box.', 'WDP' ); ?></p>

                    </div><!--.wdp-controls-->

                </fieldset>

                <!-- Ancho de la caja de Comentarios -->

                

                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="wdp-theme"><?php _e( 'Comments Box Style', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <select name="wdp_options[theme]" id="wdp-theme">

                            <option value='default' <?php selected( 'default', $options['theme'] ); ?>

                                    style="padding:2px 8px;"><?php _e( 'Default', 'WDP' ); ?></option>

                            <option value='facebook' <?php selected( 'facebook', $options['theme'] ); ?>

                                    style="padding:2px 8px;"><?php _e( 'Facebook', 'WDP' ); ?></option>

                            <option value='golden' <?php selected( 'golden', $options['theme'] ); ?>

                                    style="padding:2px 8px;"><?php _e( 'Golden', 'WDP' ); ?></option>

                            <option value='dark' <?php selected( 'dark', $options['theme'] ); ?>

                                    style="padding:2px 8px;"><?php _e( 'Dark', 'WDP' ); ?></option>

                            <option value='custom' <?php selected( 'custom', $options['theme'] ); ?>

                                    style="padding:2px 8px;"><?php _e( 'Custom', 'WDP' ); ?></option>

                        </select>

                        <span class="wdp-descrip-item"><?php _e( 'Select "Custom" to use the below custom colors.', 'WDP' ); ?></span>



                    </div><!--.wdp-controls-->

                </fieldset>



                <div class="wdp-line-sep"></div>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_background_box"><?php _e( 'Main Background', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_background_box" type="text" name="wdp_options[css_background_box]"

                               class="wdp-colorpicker" value="<?php echo $options['css_background_box']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Main background the comment box.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_border_color"><?php _e( 'Borders', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_border_color" type="text" name="wdp_options[css_border_color]"

                               class="wdp-colorpicker" value="<?php echo $options['css_border_color']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Border for input, textarea, comments.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_text_color"><?php _e( 'Text', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_text_color" type="text" name="wdp_options[css_text_color]"

                               class="wdp-colorpicker" value="<?php echo $options['css_text_color']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color of comments.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_link_color"><?php _e( 'Text links', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_link_color" type="text" name="wdp_options[css_link_color]"

                               class="wdp-colorpicker" value="<?php echo $options['css_link_color']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color of links.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_link_color_hover"><?php _e( 'Text links hover', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_link_color_hover" type="text" name="wdp_options[css_link_color_hover]"

                               class="wdp-colorpicker" value="<?php echo $options['css_link_color_hover']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color of links on hover.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_text_color_secondary"><?php _e( 'Date comment', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_text_color_secondary" type="text"

                               name="wdp_options[css_text_color_secondary]" class="wdp-colorpicker"

                               value="<?php echo $options['css_text_color_secondary']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color for the date of each comment.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_background_input"><?php _e( 'Input Background', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_background_input" type="text" name="wdp_options[css_background_input]"

                               class="wdp-colorpicker" value="<?php echo $options['css_background_input']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Background color for input and textarea.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_background_input"><?php _e( 'Confirmation Background', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_background_confirm" type="text" name="wdp_options[css_background_confirm]"

                               class="wdp-colorpicker" value="<?php echo $options['css_background_confirm']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Background color for Confirmation.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_background_button"><?php _e( 'Submit button', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_background_button" type="text" name="wdp_options[css_background_button]"

                               class="wdp-colorpicker" value="<?php echo $options['css_background_button']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Background color for the submit button.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_background_button_hover"><?php _e( 'Submit button hover', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_background_button_hover" type="text"

                               name="wdp_options[css_background_button_hover]" class="wdp-colorpicker"

                               value="<?php echo $options['css_background_button_hover']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Background color for the submit button on hover.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_text_color_button"><?php _e( 'Text submit button', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_text_color_button" type="text" name="wdp_options[css_text_color_button]"

                               class="wdp-colorpicker" value="<?php echo $options['css_text_color_button']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color for the submit button.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_success_color"><?php _e( 'Success Message', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_success_color" type="text" name="wdp_options[css_success_color]"

                               class="wdp-colorpicker" value="<?php echo $options['css_success_color']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color of success message.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="css_error_color"><?php _e( 'Error Message', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="css_error_color" type="text" name="wdp_options[css_error_color]"

                               class="wdp-colorpicker" value="<?php echo $options['css_error_color']; ?>"/>

                        <span class="wdp-descrip-item"><?php _e( 'Text color of error message.', 'WDP' ); ?></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="custom_css"><?php _e( 'Custom CSS', 'WDP' ); ?></label>

                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                            <textarea name="wdp_options[custom_css]"

                                      id="custom_css"><?php echo $options['custom_css']; ?></textarea>

                        <span class="wdp-descrip-item"></span>

                    </div><!--.wdp-controls-->

                </fieldset>



                <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>

                <fieldset class="wdp-control-group">

                    <div class="wdp-control-label">

                        <label for="wdp-defaults"><?php _e( 'Reset options to default', 'WDP' ); ?></label>

                        <p class="wdp-descrip-item"></p>



                    </div><!--.wdp-control-label-->

                    <div class="wdp-controls">

                        <input id="wdp-defaults" name="wdp_options[default_options]" type="checkbox"

                               value="true" <?php if( isset( $options['default_options'] ) ){

                            checked( 'true', $options['default_options'] );

                        } ?> />

                        <label for="wdp-defaults"><span

                                    style="color:#333333;margin-left:3px;"><?php _e( 'Restore to default values', 'WDP' ); ?></span></label>

                        <p class="wdp-descrip-item"><?php _e( 'Mark this option only if you want to return to the original settings of the plugin.', 'WDP' ); ?></p>

                    </div><!--.wdp-controls-->

                </fieldset>



            </div><!--.wdp-tab-customization-->


            <div id="wdp-tab-data-export" class="wdp-tab-content">
                <?php wp_nonce_field('nonce_ajax_export', '_token', false); ?>
                <fieldset class="wdp-control-group option-exclude-post-types">
                    <div class="wdp-control-label">
                        <label for="export_post_type"><?php _e('Export in Post Types', 'CUI'); ?></label>
                    </div><!--.wdp-control-label-->
                    <div class="wdp-controls">
                        <?php
                        $post_types = get_post_types(array('public' => true, '_builtin' => true), 'objects');
                        $post_types2 = get_post_types(array('public' => true, '_builtin' => false), 'objects');
                        $post_types = array_merge($post_types, $post_types2);
                        ?>
                        <select name="export_post_type" id="export_post_type" multiple>
                            <option value="custom">Spesific Posts</option>
                        </select>
 <!--                        <p class="wdp-descrip-item"><?php _e("Select the post types where you don't want to export the comment data", 'CUI'); ?></p> -->
                    </div><!--.wdp-controls-->
                </fieldset>


                <fieldset class="wdp-control-group"></fieldset>
                <div id="custom-export-ids" style="display: none">
                    <fieldset class="wdp-control-group option-export_pages">
                        <div class="wdp-control-label">
                            <label for="export_ids"><?php _e('Only export this post', 'CUI'); ?></label>
                        </div><!--.wdp-control-label-->
                        <div class="wdp-controls">
                            <input id="export_ids" type="text" name="export_ids"

                            <p class="wdp-descrip-item"
                               style="clear:both; float:left;"><?php _e('Just export these Posts/Pages. Add post slugs separated by commas. e.g:  blog-page, example-post', 'CUI'); ?></p>
                            <p>Leave blank if will export all data</p>
                        </div><!--.wdp-controls-->
                    </fieldset>
                </div>
               

                <fieldset class="wdp-control-group"></fieldset>

                <fieldset class="wdp-control-group option-exclude_pages">
                    <div class="wdp-control-label"><label for=""></label></div>
                    <div class="wdp-controls">
                        <button type="button" data-content="button-export" class="button button-secondary">Process
                            Export
                        </button>
                    </div>
                </fieldset>

            </div>
           

        </div><!--.wdp-tab-container-->


        <fieldset id="wdp-item-submit" class="wdp-control-group" style="padding:0">

            <div class="wdp-control-label">

                <p class="submit">

                    <input type="submit" name="Submit" class="button-primary"

                           value="<?php _e( 'Save Changes', 'WDP' ) ?>"/>

                </p>

            </div><!--.wdp-control-label-->

            <div class="wdp-controls">

            </div><!--.wdp-controls-->

        </fieldset>

    </form>



</div><!--.wrap-->

