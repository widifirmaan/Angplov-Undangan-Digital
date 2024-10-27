<?php 
$sidesToShow = isset($settings['twae_slides_to_show'])
&& !empty($settings['twae_slides_to_show'])?$settings['twae_slides_to_show']:2;

echo '<div id="twae-horizontal-wrapper" class="twae-wrapper twae-horizontal swiper-container" data-slidestoshow = "'.esc_attr($sidesToShow).'" data-autoplay="'.esc_attr($autoplay).'">
    <div class="twae-horizontal-timeline swiper-wrapper">';
  if(is_array($data)){
        foreach($data as $index=>$content){
           
            $timeline_description = $content['twae_description'];
            $show_year_label = esc_html($content['twae_show_year_label']);
            $timeline_year = esc_html($content['twae_year']);
            $story_date_label = esc_html($content['twae_date_label']);
            $story_extra_label = esc_html($content['twae_extra_label']);
            $timeline_story_title = esc_html($content['twae_story_title']);
            $story_icon = $content['twae_story_icon']['value'];
            $thumbnail_size = $content['twae_thumbnail_size'];
            $thumbnail_custom_dimension = $content['twae_thumbnail_custom_dimension'];
                    
            if($content['twae_image']['id']!=""){
                if($thumbnail_size =='custom'){
                    $custom_size = array ( $thumbnail_custom_dimension['width'],$thumbnail_custom_dimension['height']);
                    $image= wp_get_attachment_image($content['twae_image']['id'], $custom_size , true);	
                    
                }
                else{
                    $image= wp_get_attachment_image($content['twae_image']['id'],$thumbnail_size, true);                
                }
                $image =  ' <div class="twae-timeline-img">'.$image.'</div>';
            }else if($content['twae_image']['url']!=""){
                $image = '<div class="twae-timeline-img"><img src="'.$content['twae_image']['url'].'"></img></div>';
            }
            else{
                $image ='';
            }

            echo '<div class="swiper-slide '.esc_attr($sidesHeight).'">';
                if($show_year_label == 'yes'){
                    echo '<div class="twae-year-container">
                        <span class="twae-year-label twae-year">'.$timeline_year.'</span>
                    </div>';
                }
                echo '<div class="twae-label-extra-label"><div>
                    <span class="twae-label">'.$story_date_label.'</span> 
                    <span class="twae-extra-label">'.$story_extra_label.'</span>
                </div></div>
                <div class="twae-bg-orange twae-icon">';
                \Elementor\Icons_Manager::render_icon( $content['twae_story_icon'], [ 'aria-hidden' => 'true' ] );
                echo'</div>'; 
                echo '<div class="twae-story-info">
                    '.$image.'                    
                    <span class="twae-title">'.$timeline_story_title.'</span>
                    <div class="twae-description">'.$timeline_description.'</div>                        
                </div>
            </div>';
        }
    }    
       echo ' </div>
    <!-- Add Pagination -->        
    <div class="twae-pagination"></div>
    <!-- Add Arrows -->
    <div class="twae-button-prev twae-icon-left-open-big"></div>
    <div class="twae-button-next twae-icon-right-open-big"></div>
    </div>';




