<?php
$options = get_option('cui_options');
global $wp_version;


function cui_checked_array($value, $array)
{
    if (in_array($value, (array)$array)) {
        echo 'checked="checked"';
    }
}

?>
<div class="wrap">
    <!-- Display Plugin Icon and Header -->
    <?php //screen_icon( 'cui' ); ?>
    <h2 <?php if (version_compare($wp_version, "3.8", ">=")) echo ''; ?>><?php _e(WDP3_PLUGIN_NAME . ' Settings', 'CUI'); ?></h2>

    <?php
    if (!isset($_REQUEST['settings-updated']))
        $_REQUEST['settings-updated'] = false;
    ?>
    <?php if (false !== $_REQUEST['settings-updated']) : ?>
        <div class="message updated" style="width:80%"><p><strong><?php _e('Options saved', 'CUI'); ?></strong></p>
        </div>
    <?php endif; ?>

    <h2 id="cui-tabs" class="nav-tab-wrapper">
        <a class="nav-tab" href="#cui-tab-general"><?php _e('General', 'CUI'); ?></a>
        <a class="nav-tab" href="#cui-tab-content"><?php _e('Content', 'CUI'); ?></a>
        <a class="nav-tab" href="#cui-tab-customization"><?php _e('Customization', 'CUI'); ?></a>
        <a class="nav-tab" href="#cui-tab-translation"><?php _e('Message translation', 'CUI'); ?></a>
        <a class="nav-tab" href="#cui-tab-data-export"><?php _e('Export CSV', 'CUI'); ?></a>
    </h2>
    <form id="cui-form" action="<?php echo admin_url('options.php'); ?>" method="post">
        <?php settings_fields('cui_group_options'); ?>
        <div class="cui-tab-container">
            <div id="cui-tab-general" class="cui-tab-content">

                <!-- Carga Automáticamente -->
                
                <fieldset class="cui-control-group">

                    <div class="cui-control-label">

                        <label for="avatar_url"><?php _e( 'Avatar Url', 'CUI' ); ?></label>

                    </div><!--.cui-control-label-->

                    <div class="cui-controls">

                       <!--  <div class="cui-float-l cui-5-box"> -->

                            <input id="avatar_url" type="text" name="cui_options[avatar_url]"

                                   value="<?php echo $options['avatar_url']; ?>"/>

                        <!-- </div> --><!--.cui-3-box-->

                        <p class="cui-descrip-item"><?php _e( '', 'CUI' ); ?></p>

                    </div><!--.cui-controls-->

                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Hide Badge Confirmation?', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-close_badge" name="cui_options[close_badge]" type="checkbox"
                               value="true" <?php if (isset($options['close_badge'])) {
                            checked('true', $options['close_badge']);
                        } ?> />
                        <label for="cui-close_badge"><?php _e('Hide Badge Confirmation', 'CUI'); ?></label>
                        <br/>
                        <p class="cui-descrip-item"></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Hide konfirmasi masih ragu?', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-close_masih_ragu" name="cui_options[close_masih_ragu]" type="checkbox"
                               value="true" <?php if (isset($options['close_masih_ragu'])) {
                            checked('true', $options['close_masih_ragu']);
                        } ?> />
                        <label for="cui-close_masih_ragu"><?php _e('Hide konfirmasi masih ragu', 'CUI'); ?></label>
                        <br/>
                        <p class="cui-descrip-item"></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Disable Reply Comments', 'CUI'); ?></label>
                    </div>
                    <div class="cui-controls">
                        <div class="cui-radio cui-radio-h cui-float-l cui-5-box">
                            <input id="cui-disable-reply-true" name="cui_options[disable_reply]" type="radio"
                                   value="true" <?php checked('true', $options['disable_reply']); ?> />
                            <label for="cui-disable-reply-true"><?php _e('Yes', 'CUI'); ?></label>
                        </div>
                        <div class="cui-radio cui-radio-h cui-float-l cui-5-box">
                            <input id="cui-disable-reply-false" name="cui_options[disable_reply]" type="radio"
                                   value="false" <?php checked('false', $options['disable_reply']); ?> />
                            <label for="cui-disable-reply-false"><?php _e('Not', 'CUI'); ?></label>
                        </div>
                        <br/>
                        <p class="cui-descrip-item"><?php _e('If enabled, then the reply comments will be disabled for all post/pages.', 'CUI'); ?></p>
                    </div>
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e( 'Required Confirmation of Attendance?', 'WDP' ); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-only-by-name" name="cui_options[cui_confirm_attendance]" type="checkbox"
                               value="true" <?php if( isset( $options['cui_confirm_attendance'] ) ){
                            checked( 'true', $options['cui_confirm_attendance'] );
                        } ?> />
                        <label for="cui-only-by-name"><?php _e( 'User Required Confirmation of Attendance?', 'WDP' ); ?></label>
                        <br/>
                        <p class="cui-descrip-item"></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Show New Field?', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-close_note" name="cui_options[close_note]" type="checkbox"
                               value="true" <?php if (isset($options['close_note'])) {
                            checked('true', $options['close_note']);
                        } ?> />
                        <label for="cui-close_note"><?php _e('New field, can you rename field name (default: add note)', 'CUI'); ?></label>
                        <br/>
                        <p class="cui-descrip-item"></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Número de Comentarios -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="num_comments"><?php _e('Number maximum of comments to load', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="num_comments" type="text" name="cui_options[num_comments]"
                               value="<?php echo $options['num_comments']; ?>"/>
                        <p class="cui-descrip-item"><?php _e('Default value', 'CUI'); ?>:
                            30. <?php _e('Indicates the maximum number of comments of a post to be extracted from the data base.', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Orden de los Comentarios -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Order of the comments', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-order_comments-des" name="cui_options[order_comments]" type="radio"
                                   value="DESC" <?php checked('DESC', $options['order_comments']); ?> />
                            <label for="cui-order_comments-des"><?php _e('Newest Comments', 'CUI'); ?></label>
                            <span class="cui-descrip-item"><?php _e('Sorts the comments from newest to oldest', 'CUI'); ?></span>
                        </div><!--.cui-radio-->
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-order_comments-asc" name="cui_options[order_comments]" type="radio"
                                   value="ASC" <?php checked('ASC', $options['order_comments']); ?> />
                            <label for="cui-order_comments-asc"><?php _e('Oldest Comments', 'CUI'); ?></label>
                            <span class="cui-descrip-item"><?php _e('Sorts the comments from the oldest to the newest', 'CUI'); ?></span>
                        </div><!--.cui-radio-->

                    </div><!--.cui-controls-->
                </fieldset>


                <!-- Carga de jQuery -->
                

                <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="cui-defaults"><?php _e('Reset options to default', 'CUI'); ?></label>
                        <p class="cui-descrip-item"></p>

                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-defaults" name="cui_options[default_options]" type="checkbox"
                               value="true" <?php if (isset($options['default_options'])) {
                            checked('true', $options['default_options']);
                        } ?> />
                        <label for="cui-defaults"><span
                                    style="color:#333333;margin-left:3px;"><?php _e('Restore to default values', 'CUI'); ?></span></label>
                        <p class="cui-descrip-item"><?php _e('Mark this option only if you want to return to the original settings of the plugin.', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

            </div><!--.cui-tab-general-->

            <div id="cui-tab-target" class="cui-tab-content">
                <!-- Mostrar sólo en algunas páginas -->
                <fieldset class="cui-control-group option-include_pages">
                    <div class="cui-control-label">
                        <label for="include_pages"><?php _e('Only show in', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="include_pages" type="text" name="cui_options[include_pages]"
                               value="<?php echo $options['include_pages']; ?>"/>
                        <p class="cui-descrip-item"
                           style="clear:both; float:left;"><?php _e('Just show the comment box on these Posts/Pages. Add IDs separated by commas. e.g: 4,72 or blog-page, example-post', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Excluir algunas páginas -->
                <fieldset class="cui-control-group option-exclude_pages">
                    <div class="cui-control-label">
                        <label for="exclude_pages"><?php _e('Not show in', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="exclude_pages" type="text" name="cui_options[exclude_pages]"
                               value="<?php echo $options['exclude_pages']; ?>"/>
                        <p class="cui-descrip-item"
                           style="clear:both; float:left;"><?php _e('Exclude Posts or Pages. Add IDs separated by commas. e.g: 4,72 or blog-page, example-post', 'CUI'); ?></p>
                        <div class="cui-row">
                            <div class="cui-float-l cui-2-box">
                                <input id="exclude_home" name="cui_options[exclude_home]" type="checkbox"
                                       value="true" <?php if (isset($options['exclude_home'])) {
                                    checked('true', $options['exclude_home']);
                                } ?> />
                                <label for="exclude_home"><?php _e('Not show in Home', 'CUI'); ?></label>
                            </div><!--.cui-2-box-->
                            <div class="cui-float-l cui-2-box cui-last">
                                <input id="exclude_all_pages" name="cui_options[exclude_all_pages]" type="checkbox"
                                       value="true" <?php if (isset($options['exclude_all_pages'])) {
                                    checked('true', $options['exclude_all_pages']);
                                } ?> />
                                <label for="exclude_all_pages"><?php _e('Exclude all pages', 'CUI'); ?></label>
                            </div><!--.cui-2-box-->
                        </div><!--.cui-row-->
                    </div><!--.cui-controls-->
                </fieldset>



                <fieldset class="cui-control-group option-exclude-page-templates">
                    <div class="cui-control-label">
                        <label for="exclude_page_templates"><?php _e('Not show in Page Templates', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <?php
                        $templates = wp_get_theme()->get_page_templates();
                        $exclude_page_templates = isset($options['exclude_page_templates']) ? (array)$options['exclude_page_templates'] : array();
                        ?>
                        <select name="cui_options[exclude_page_templates][]" id="exclude_page_templates" multiple>
                            <option value=""> - Select -</option>
                            <?php
                            foreach ($templates as $value => $display) {
                                $selected = in_array($value, $exclude_page_templates) ? ' selected' : '';
                                echo "<option value='{$value}' $selected>{$display}</option>";
                            }
                            ?>
                        </select>
                        <p class="cui-descrip-item"><?php _e("Select the page templates where you don't want to show the comment box", 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group option-exclude-post-types">
                    <div class="cui-control-label">
                        <label for="exclude_post_types"><?php _e('Not show in Post Types', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <?php
                        $post_types = get_post_types(array('public' => true, '_builtin' => true), 'objects');
                        $post_types2 = get_post_types(array('public' => true, '_builtin' => false), 'objects');
                        $post_types = array_merge($post_types, $post_types2);
                        $exclude_post_types = isset($options['exclude_post_types']) ? (array)$options['exclude_post_types'] : array();
                        ?>
                        <select name="cui_options[exclude_post_types][]" id="exclude_post_types" multiple>
                            <option value=""> - Select -</option>
                            <?php
                            foreach ($post_types as $post_type) {
                                $selected = in_array($post_type->name, $exclude_post_types) ? ' selected' : '';
                                echo "<option value='{$post_type->name}' $selected>{$post_type->label}</option>";
                            }
                            ?>
                        </select>
                        <p class="cui-descrip-item"><?php _e("Select the post types where you don't want to show the comment box", 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group option-exclude-post-types">
                    <div class="cui-control-label">
                        <label for="allow_post_types"><?php _e('Allow Comments in Post Types', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <?php
                        $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');
                        $allow_post_types = isset($options['allow_post_types']) ? (array)$options['allow_post_types'] : array();
                        ?>
                        <select name="cui_options[allow_post_types][]" id="allow_post_types" multiple>
                            <option value=""> - Select -</option>
                            <?php
                            foreach ($post_types as $post_type) {
                                $selected = in_array($post_type->name, $allow_post_types) ? ' selected' : '';
                                echo "<option value='{$post_type->name}' $selected>{$post_type->label}</option>";
                            }
                            ?>
                        </select>
                        <p class="cui-descrip-item"><?php _e("This will allow comments on custom post types.", 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>
            </div><!--.cui-tab-target-->

            <div id="cui-tab-content" class="cui-tab-content">
                <!-- Paginación de Comentarios -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="group-name"><?php _e('Pagination of comments', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-jpages-true" name="cui_options[jpages]" type="radio"
                                   value="true" <?php checked('true', $options['jpages']); ?> />
                            <label for="cui-jpages-true"><?php _e('Yes', 'CUI'); ?></label>
                            <span class="cui-descrip-item"></span>
                        </div><!--.cui-radio-->
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-jpages-false" name="cui_options[jpages]" type="radio"
                                   value="false" <?php checked('false', $options['jpages']); ?> />
                            <label for="cui-jpages-false"><?php _e('Not', 'CUI'); ?></label>
                            <span class="cui-descrip-item"></span>
                        </div><!--.cui-radio-->

                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Número de Comentarios por Página -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="group-name"><?php _e('Number of comments per page', 'CUI'); ?></label>
                        <p class="cui-descrip-item"></p>

                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-num-comments-by-page" type="text" name="cui_options[num_comments_by_page]"
                               value="<?php echo $options['num_comments_by_page']; ?>"/>
                        <p class="cui-descrip-item"><?php _e('Default value', 'CUI'); ?>:
                            10<br/><strong><?php _e('Note: ', 'CUI'); ?></strong><?php _e('If the total number of comments is less than the number of comments per page, the pager will not be displayed.', 'CUI'); ?>
                        </p>
                    </div><!--.cui-controls-->
                </fieldset>

                <div class="cui-line-sep"></div>

                <!-- Activar Textarea Counter -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="group-name"><?php _e('Character limiter', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-text_counter-true" name="cui_options[text_counter]" type="radio"
                                   value="true" <?php checked('true', $options['text_counter']); ?> />
                            <label for="cui-text_counter-true"><?php _e('Yes', 'CUI'); ?></label>
                            <span class="cui-descrip-item"></span>
                        </div><!--.cui-radio-->
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-text_counter-false" name="cui_options[text_counter]" type="radio"
                                   value="false" <?php checked('false', $options['text_counter']); ?> />
                            <label for="cui-text_counter-false"><?php _e('Not', 'CUI'); ?></label>
                            <span class="cui-descrip-item"></span>
                        </div><!--.cui-radio-->
                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Número de Máximo de Caracteres -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="group-name"><?php _e('Maximum number of characters for comment', 'CUI'); ?></label>
                        <p class="cui-descrip-item"></p>

                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-text_counter_num" type="text" name="cui_options[text_counter_num]"
                               value="<?php echo $options['text_counter_num']; ?>"/>
                        <p class="cui-descrip-item"><?php _e('Default value', 'CUI'); ?>: 300.</p>
                    </div><!--.cui-controls-->
                </fieldset>

                <div class="cui-line-sep"></div>

                <!-- Formulario de Comentarios -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Display comment form?', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-display-form-true" name="cui_options[display_form]" type="radio"
                                   value="true" <?php checked('true', $options['display_form']); ?> />
                            <label for="cui-display-form-true"><?php _e('Yes', 'CUI'); ?></label>
                            <span class="cui-descrip-item"><?php _e('It displays the form to add a comment next to the list of comments', 'CUI'); ?></span>
                        </div><!--.cui-radio-->
                        <div class="cui-radio cui-radio-v">
                            <input id="cui-display-form-false" name="cui_options[display_form]" type="radio"
                                   value="false" <?php checked('false', $options['display_form']); ?> />
                            <label for="cui-display-form-false"><?php _e('Not', 'CUI'); ?></label>
                            <span class="cui-descrip-item"><?php _e('It does not show the comments form', 'CUI'); ?></span>
                        </div><!--.cui-radio-->

                    </div><!--.cui-controls-->
                </fieldset>


               

                <!-- <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Disable edit/delete comment after', 'CUI'); ?></label>
                    </div>
                    <div class="cui-controls">
                        <div class="cui-float-l cui-6-box" style="margin-right: 10px">
                            <input id="disable_actions_after_time" type="number" step="0.1"
                                   name="cui_options[disable_actions_after_time]"
                                   value="<?php echo $options['disable_actions_after_time']; ?>"/>
                        </div>
                        <p class="cui-descrip-item"><?php _e('Hours', 'CUI'); ?></p>
                    </div>
                </fieldset> -->


                <div class="cui-line-sep"></div>

                <!-- Tamaño Máximo para las imágenes -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Max width of images', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-float-l cui-5-box">
                            <input id="cui-max_width_images" type="text" name="cui_options[max_width_images]"
                                   value="<?php echo $options['max_width_images']; ?>"/>
                        </div><!--.cui-3-box-->
                        <div class="cui-float-l cui-9-box" style="padding-top:6px;">
                            <input id="cui-unit_%_size_images" name="cui_options[unit_images_size]" type="radio"
                                   value="%" <?php checked('%', $options['unit_images_size']); ?> />
                            <label for="cui-unit_%_size_images"><?php _e('%', 'CUI'); ?></label>
                        </div><!--.cui-3-box-->
                        <div class="cui-float-l cui-9-box" style="padding-top:6px;">
                            <input id="cui-unit_px_size_images" name="cui_options[unit_images_size]" type="radio"
                                   value="px" <?php checked('px', $options['unit_images_size']); ?> />
                            <label for="cui-unit_px_size_images"><?php _e('px', 'CUI'); ?></label>
                        </div><!--.cui-3-box-->

                        <p class="cui-descrip-item"><?php _e('By default the maximum width of the images in the comments is 100%. If you want to change that value add it here.', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <div style="margin-top:6px; border-bottom: 2px dashed #DDD;"></div>


            </div><!--.cui-tab-content-->

            <div id="cui-tab-customization" class="cui-tab-content">
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="avatar_size"><?php _e('Avatar size', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-float-l cui-5-box">
                            <input id="avatar_size" type="text" name="cui_options[avatar_size]"
                                   value="<?php echo $options['avatar_size']; ?>"/>
                        </div><!--.cui-3-box-->
                        <p class="cui-descrip-item"><?php _e('', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="base_font_size"><?php _e('Base font size', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-float-l cui-5-box">
                            <input id="base_font_size" type="text" name="cui_options[base_font_size]"
                                   value="<?php echo $options['base_font_size']; ?>"/>
                        </div><!--.cui-3-box-->
                        <p class="cui-descrip-item"><?php _e('Base font size for all text in the comment box.', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>
                <!-- Ancho de la caja de Comentarios -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="width_comments"><?php _e('Width of the container of the comments', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-float-l cui-5-box">
                            <input id="width_comments" type="text" name="cui_options[width_comments]"
                                   value="<?php echo $options['width_comments']; ?>"/>
                        </div><!--.cui-3-box-->
                        <div class="cui-float-l cui-2-box cui-last" style="padding-top:6px;">
                            <input id="cui-border" name="cui_options[border]" type="checkbox"
                                   value="false" <?php if (isset($options['border'])) {
                                checked('false', $options['border']);
                            } ?> />
                            <label for="cui-border"><?php _e('Remove the container edge', 'CUI'); ?></label>
                        </div><!--.cui-3-box-->

                        <p class="cui-descrip-item"><?php _e('Minimum width 180px. It adds the width in pixels of the box containing the comments. If you leave blank are shall refer to the width of the parent div.', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="group-name"><?php _e('Maximum Content Height (px)', 'CUI'); ?></label>
                        <p class="cui-descrip-item"></p>

                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-float-l cui-5-box">
                            <input id="cui-num-comments-by-page" type="text"
                                   name="cui_options[num_maximum_content_height]"
                                   value="<?php echo $options['num_maximum_content_height']; ?>"/>
                        </div>
                        <p class="cui-descrip-item"><?php _e('Default value', 'CUI'); ?>:
                            0
                            (auto)<br/><strong><?php _e('Note: ', 'CUI'); ?></strong><?php _e('If the total content height is more than number of maximum height, the content will be show scroll thumb', 'CUI'); ?>
                        </p>
                    </div><!--.cui-controls-->
                </fieldset>
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="cui-theme"><?php _e('Comments Box Style', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <select name="cui_options[theme]" id="cui-theme">
                            <option value='default' <?php selected('default', $options['theme']); ?>
                                    style="padding:2px 8px;"><?php _e('Default', 'CUI'); ?></option>
                            <option value='facebook' <?php selected('facebook', $options['theme']); ?>
                                    style="padding:2px 8px;"><?php _e('Facebook', 'CUI'); ?></option>
                            <option value='golden' <?php selected('golden', $options['theme']); ?>
                                    style="padding:2px 8px;"><?php _e('Golden', 'CUI'); ?></option>
                            <option value='dark' <?php selected('dark', $options['theme']); ?>
                                    style="padding:2px 8px;"><?php _e('Dark', 'CUI'); ?></option>
                            <option value='custom' <?php selected('custom', $options['theme']); ?>
                                    style="padding:2px 8px;"><?php _e('Custom', 'CUI'); ?></option>
                        </select>
                        <span class="cui-descrip-item"><?php _e('Select "Custom" to use the below custom colors.', 'CUI'); ?></span>

                    </div><!--.cui-controls-->
                </fieldset>

                <div class="cui-line-sep"></div>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_background_box"><?php _e('Main Background', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_background_box" type="text" name="cui_options[css_background_box]"
                               class="cui-colorpicker" value="<?php echo $options['css_background_box']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Main background the comment box.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_border_color"><?php _e('Borders', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_border_color" type="text" name="cui_options[css_border_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_border_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Border for input, textarea, comments.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_text_color"><?php _e('Text', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_text_color" type="text" name="cui_options[css_text_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_text_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color of comments.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_link_color"><?php _e('Text links', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_link_color" type="text" name="cui_options[css_link_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_link_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color of links.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_link_color_hover"><?php _e('Text links hover', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_link_color_hover" type="text" name="cui_options[css_link_color_hover]"
                               class="cui-colorpicker" value="<?php echo $options['css_link_color_hover']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color of links on hover.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_text_color_secondary"><?php _e('Date comment', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_text_color_secondary" type="text"
                               name="cui_options[css_text_color_secondary]" class="cui-colorpicker"
                               value="<?php echo $options['css_text_color_secondary']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color for the date of each comment.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_background_input"><?php _e('Input Background', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_background_input" type="text" name="cui_options[css_background_input]"
                               class="cui-colorpicker" value="<?php echo $options['css_background_input']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Background color for input and textarea.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_background_button"><?php _e('Submit button', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_background_button" type="text" name="cui_options[css_background_button]"
                               class="cui-colorpicker" value="<?php echo $options['css_background_button']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Background color for the submit button.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_background_button_hover"><?php _e('Submit button hover', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_background_button_hover" type="text"
                               name="cui_options[css_background_button_hover]" class="cui-colorpicker"
                               value="<?php echo $options['css_background_button_hover']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Background color for the submit button on hover.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_text_color_button"><?php _e('Text submit button', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_text_color_button" type="text" name="cui_options[css_text_color_button]"
                               class="cui-colorpicker" value="<?php echo $options['css_text_color_button']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color for the submit button.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_rating_color"><?php _e('Thumbs rating', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_rating_color" type="text" name="cui_options[css_rating_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_rating_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Color for the icons "like/dislike".', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_rating_color_hover"><?php _e('Thumbs rating hover', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_rating_color_hover" type="text" name="cui_options[css_rating_color_hover]"
                               class="cui-colorpicker" value="<?php echo $options['css_rating_color_hover']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Color for the icons "like/dislike" on hover', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_rating_positive_color"><?php _e('Counter positive rating', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_rating_positive_color" type="text"
                               name="cui_options[css_rating_positive_color]" class="cui-colorpicker"
                               value="<?php echo $options['css_rating_positive_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Color positive number.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_rating_negative_color"><?php _e('Counter negative rating', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_rating_negative_color" type="text"
                               name="cui_options[css_rating_negative_color]" class="cui-colorpicker"
                               value="<?php echo $options['css_rating_negative_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Color negative number.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_success_color"><?php _e('Success Message', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_success_color" type="text" name="cui_options[css_success_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_success_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color of success message.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_error_color"><?php _e('Error Message', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_error_color" type="text" name="cui_options[css_error_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_error_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Text color of error message.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_hadir_color"><?php _e('Background color Hadir', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_hadir_color" type="text" name="cui_options[css_hadir_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_hadir_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Background color konfirmasi hadir.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_tidak_hadir_color"><?php _e('Background color Tidak Hadir', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_tidak_hadir_color" type="text" name="cui_options[css_tidak_hadir_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_tidak_hadir_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Background color konfirmasi tidak hadir.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="css_masih_ragu_color"><?php _e('Background color masih ragu', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="css_masih_ragu_color" type="text" name="cui_options[css_masih_ragu_color]"
                               class="cui-colorpicker" value="<?php echo $options['css_masih_ragu_color']; ?>"/>
                        <span class="cui-descrip-item"><?php _e('Background color konfirmasi masih ragu.', 'CUI'); ?></span>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="custom_css"><?php _e('Custom CSS', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                            <textarea name="cui_options[custom_css]"
                                      id="custom_css"><?php echo $options['custom_css']; ?></textarea>
                        <span class="cui-descrip-item"></span>
                    </div><!--.cui-controls-->
                </fieldset>

            </div><!--.cui-tab-customization-->

            <div id="cui-tab-user" class="cui-tab-content">
                <!-- Quién puede Comentar -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Who can comment?', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-only-registered" name="cui_options[only_registered]" type="checkbox"
                               value="true" <?php if (isset($options['only_registered'])) {
                            checked('true', $options['only_registered']);
                        } ?> />
                        <label for="cui-only-registered"><?php _e('Only registered users can comment', 'CUI'); ?></label>
                        <br/>
                        <p class="cui-descrip-item"></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="exclude_users"><?php _e('Exclude users', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <div class="cui-float-l cui-3-box">
                            <input id="exclude_users" type="text" name="cui_options[exclude_users]"
                                   value="<?php echo $options['exclude_users']; ?>"/>
                        </div><!--.cui-3-box-->
                        <p class="cui-descrip-item"
                           style="clear:both; float:left;"><?php _e('Exclude users. Add IDs separated by commas. e.g: 2,5', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Texto quién puede Comentar -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label for="cui-text-only-registered"><?php _e('Text for Only registered users can comment', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-text-only-registered" name="cui_options[text_only_registered]" type="text"
                               value="<?php echo $options['text_only_registered']; ?>"/>
                        <p class="cui-descrip-item"><?php _e('If the user is not registered, a link is displayed to log, you can accompany with some text', 'CUI'); ?></p>
                    </div><!--.cui-controls-->
                </fieldset>

                <!-- Quién puede calificar -->
                <fieldset class="cui-control-group">
                    <div class="cui-control-label">
                        <label><?php _e('Who can rate?', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <input id="cui-only-logged-in-can-rate" name="cui_options[only_loggedin_can_rate]"
                               type="checkbox"
                               value="true" <?php if (isset($options['only_loggedin_can_rate'])) {
                            checked('true', $options['only_loggedin_can_rate']);
                        } ?> />
                        <label for="cui-only-logged-in-can-rate"><?php _e('Only logged-in users can rate', 'CUI'); ?></label>
                        <br/>
                        <p class="cui-descrip-item"></p>
                    </div><!--.cui-controls-->
                </fieldset>

                

            </div><!--.cui-tab-user-->

            <div id="cui-tab-translation" class="cui-tab-content">
                <?php
                foreach (get_basic_text_translations_CUI() as $option_key => $option_value) {
                    ?>
                    <fieldset class="cui-control-group">
                        <div class="cui-control-label">
                            <label for="cui-<?php echo $option_key; ?>"><?php echo $option_value; ?></label>
                        </div><!--.cui-control-label-->
                        <div class="cui-controls">
                            <input id="cui-<?php echo $option_key; ?>" type="text"
                                   name="cui_options[<?php echo $option_key; ?>]"
                                   value="<?php echo $options[$option_key]; ?>"/>
                        </div><!--.cui-controls-->
                    </fieldset>
                <?php } ?>

                                <fieldset class="cui-control-group">

                    <div class="cui-control-label">

                        <label><?php _e( 'Show comments link text', 'WDP' ); ?></label>

                    </div><!--.cui-control-label-->

                    <div class="cui-controls">

                        <div class="cui-float-l cui-3-box">

                            <input id="text_0_comments" type="text" name="cui_options[text_0_comments]"

                                   value="<?php echo $options['text_0_comments']; ?>"/>

                            <span class="cui-descrip-item cui-first"><?php _e( 'If the post has no comments', 'WDP' ); ?></span>

                        </div><!--.cui-3-box-->

                        <div class="cui-float-l cui-3-box">

                            <input id="text_1_comment" type="text" name="cui_options[text_1_comment]"

                                   value="<?php echo $options['text_1_comment']; ?>"/>

                            <span class="cui-descrip-item cui-first"><?php _e( 'If the post has 1 comment', 'WDP' ); ?></span>

                        </div><!--.cui-3-box-->

                        <div class="cui-float-l cui-3-box cui-last">

                            <input id="text_more_comments" type="text" name="cui_options[text_more_comments]"

                                   value="<?php echo $options['text_more_comments']; ?>"/>

                            <span class="cui-descrip-item cui-first"><?php _e( 'For more than one comment', 'WDP' ); ?></span>

                        </div><!--.cui-3-box-->



                        <p class="cui-descrip-item"><?php _e( 'Use #N# to display the number of comments,  remove it if you don\'t want to show it.', 'WDP' ); ?></p>

                    </div><!--.cui-controls-->

                </fieldset>
            </div><!--.cui-tab-translation-->

            <!-- data-export to csv-->
            <div id="cui-tab-data-export" class="cui-tab-content">
                <?php wp_nonce_field('nonce_ajax_export', '_token', false); ?>
                <fieldset class="cui-control-group option-exclude-post-types">
                    <div class="cui-control-label">
                        <label for="export_post_type"><?php _e('Export in Post Types', 'CUI'); ?></label>
                    </div><!--.cui-control-label-->
                    <div class="cui-controls">
                        <?php
                        $post_types = get_post_types(array('public' => true, '_builtin' => true), 'objects');
                        $post_types2 = get_post_types(array('public' => true, '_builtin' => false), 'objects');
                        $post_types = array_merge($post_types, $post_types2);
                        ?>
                        <select name="export_post_type" id="export_post_type" multiple>
                            <option value="custom">Spesific Posts</option>
                        </select>
 <!--                        <p class="cui-descrip-item"><?php _e("Select the post types where you don't want to export the comment data", 'CUI'); ?></p> -->
                    </div><!--.cui-controls-->
                </fieldset>


                <fieldset class="cui-control-group"></fieldset>
                <div id="custom-export-ids" style="display: none">
                    <fieldset class="cui-control-group option-export_pages">
                        <div class="cui-control-label">
                            <label for="export_ids"><?php _e('Only export this post', 'CUI'); ?></label>
                        </div><!--.cui-control-label-->
                        <div class="cui-controls">
                            <input id="export_ids" type="text" name="export_ids"

                            <p class="cui-descrip-item"
                               style="clear:both; float:left;"><?php _e('Just export these Posts/Pages. Add post slugs separated by commas. e.g:  blog-page, example-post', 'CUI'); ?></p>
                            <p>Leave blank if will export all data</p>
                        </div><!--.cui-controls-->
                    </fieldset>
                </div>
               

                <fieldset class="cui-control-group"></fieldset>

                <fieldset class="cui-control-group option-exclude_pages">
                    <div class="cui-control-label"><label for=""></label></div>
                    <div class="cui-controls">
                        <button type="button" data-content="button-export" class="button button-secondary">Process
                            Export
                        </button>
                    </div>
                </fieldset>

            </div>
           

        </div><!--.cui-tab-container-->

        <fieldset id="cui-item-submit" class="cui-control-group" style="padding:0">
            <div class="cui-control-label">
                <p class="submit">
                    <input type="submit" name="Submit" class="button-primary"
                           value="<?php _e('Save Changes', 'CUI') ?>"/>
                </p>
            </div><!--.cui-control-label-->
            <div class="cui-controls">
            </div><!--.cui-controls-->
        </fieldset>
    </form>

</div><!--.wrap-->
