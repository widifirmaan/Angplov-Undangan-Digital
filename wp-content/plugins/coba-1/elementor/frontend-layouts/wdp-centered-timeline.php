<?php
echo '
<div class="twae-vertical twae-wrapper '.esc_attr($timeline_layout_wrapper).'">    
    <div class="twae-timeline-centered twae-timeline-sm twae-line '.esc_attr($timeline_layout).'">';	
  if(is_array($data)){
    foreach($data as $index=>$content){
        $left_aligned = "twae-right-aligned";
        if($layout == 'centered'){
            if($countItem % 2 == 0){ 
                $left_aligned = "twae-left-aligned";  
            }
        }
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
            $image =  '<div class="twae-timeline-img">'.$image.'</div>';
        }else if($content['twae_image']['url']!=""){
            $image = '<div class="twae-timeline-img"><img src="'.$content['twae_image']['url'].'"></img></div>';
        }
        else{
            $image ='';
        }

        if($show_year_label == 'yes'){
            echo '<span class="twae-year-container">
                <span class="twae-year-label twae-year">'.$timeline_year.'</span>
            </span>';
        }
        
        echo '<article class="twae-timeline-entry '.esc_attr($left_aligned).'">
            <div class="twae-timeline-entry-inner">
                <time class="twae-label-extra-label">
                    <span class="twae-label">'.$story_date_label.'</span>
                    <span class="twae-extra-label">'.$story_extra_label.'</span>
                </time>
                <div class="twae-bg-orange twae-icon">';
                \Elementor\Icons_Manager::render_icon( $content['twae_story_icon'], [ 'aria-hidden' => 'true' ] );
                echo'</div>
                <div class="twae-bg-orange twae-data-container">
                    <span class="twae-title">'.$timeline_story_title.'</span>
                    '.$image.'
                    <div class="twae-description">'.$timeline_description.'</div>
                </div>
            </div>
        </article>';				
        $countItem = $countItem +1;
    }
}
    echo'</div></div>';