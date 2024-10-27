<div id="twae-horizontal-wrapper" class="twae-wrapper twae-horizontal swiper-container" data-slidestoshow = "{{{sidesToShow}}}"  data-autoplay="{{{autoplay}}}">
    <div class="twae-horizontal-timeline swiper-wrapper">
        <#
        _.each( settings.twae_list, function( item, index ) {
            var timeline_image = {
                id: item.twae_image.id,
                url: item.twae_image.url,
                size: item.twae_thumbnail_size,
                dimension: item.twae_thumbnail_custom_dimension,
                model: view.getEditModel()
            };
            var image_url = elementor.imagesManager.getImageUrl( timeline_image );
            twaeiconHTML = elementor.helpers.renderIcon( view, item.twae_story_icon, { 'aria-hidden': true }, 'i' , 'object' ),
            
            #>
            <div class="swiper-slide {{{sidesHeight}}}">	
                
                <#
                    if(item.twae_show_year_label == 'yes'){
                        #>
                        <div class="twae-year-container">
                            <span class="twae-year-label twae-year">{{{ item.twae_year }}}</span>
                        </div>
                        <#
                    }
                    #>
                    <div class="twae-label-extra-label"><div>
                        <span class="twae-label">{{{ item.twae_date_label }}}</span>
                        <span class="twae-extra-label">{{{ item.twae_extra_label }}}</span>
                    </div></div>		
                    <div class="twae-bg-orange twae-icon">
                        <# if ( twaeiconHTML && twaeiconHTML.rendered ) { #>
                            {{{ twaeiconHTML.value }}}
                        <# } else { #>
                            <i class="{{ item.twae_story_icon.value }}" aria-hidden="true"></i>
                        <# } #>
                            
                    </div>
                    <div class="twae-story-info">              
                    <div class="twae-timeline-img"><img src="{{{ image_url }}}" /></div>             
                    <span class="twae-title">{{{ item.twae_story_title}}}</span>
                    <div class="twae-description">{{{ item.twae_description }}}</div>
                    </div>
            </div>
            <#
        });
        #>
    </div>
    <!-- Add Pagination -->        
    <div class="twae-pagination"></div>
    <!-- Add Arrows -->
    
    <div class="twae-button-prev twae-icon-left-open-big"></div>
    <div class="twae-button-next twae-icon-right-open-big"></div>
</div>

