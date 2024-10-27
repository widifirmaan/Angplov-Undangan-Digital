<#
	var countItem = 1;
    var timeline_layout = '';
    var timeline_layout_wrapper = 'twae-centered';
    if(settings.twae_layout == 'one-sided'){
        var timeline_layout = "twae-one-sided-timeline";
        var timeline_layout_wrapper = 'twae-one-sided-wrapper';
    }
    #>
    <div class="twae-vertical twae-wrapper {{{ timeline_layout_wrapper }}}">
        <div class="twae-timeline-centered twae-timeline-sm twae-line {{{ timeline_layout }}}">
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
            
            if(item.twae_show_year_label == 'yes'){
                #>
                <span class="twae-year-container">
                    <span class="twae-year-label twae-year">{{{ item.twae_year }}}</span>
                </span>
                <#
            }
            var story_alignment = "twae-right-aligned";
            if(settings.twae_layout == 'centered'){
                
                if ( countItem % 2 == 0) {
                    var story_alignment = "twae-left-aligned";						
                }
            }
            twaeiconHTML = elementor.helpers.renderIcon( view, item.twae_story_icon, { 'aria-hidden': true }, 'i' , 'object' ),
            
            #>
            <article class="twae-timeline-entry {{{ story_alignment }}}">									
                <div class="twae-timeline-entry-inner">
                    <time class="twae-label-extra-label">
                        <span class="twae-label">{{{ item.twae_date_label }}}</span>
                        <span class="twae-extra-label">{{{ item.twae_extra_label }}}</span>
                    </time>
                    <div class="twae-bg-orange twae-icon">
                    <# if ( twaeiconHTML && twaeiconHTML.rendered ) { #>
                        {{{ twaeiconHTML.value }}}
                    <# } else { #>
                        <i class="{{ item.twae_story_icon.value }}" aria-hidden="true"></i>
                    <# } #>
                    
                    </div>
                    <div class="twae-bg-orange twae-data-container">
                        <span class="twae-title">{{{ item.twae_story_title}}}</span>
                        <div class="twae-timeline-img"><img src="{{{ image_url }}}" /></div>
                        <div class="twae-description">{{{ item.twae_description }}}</div>
                    </div>
                </div>
            </article>
            <#
            countItem = countItem+1;
        });
        #>
        </div>
    </div>