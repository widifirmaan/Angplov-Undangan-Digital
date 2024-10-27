<?php
//Weddingpress Templates Library VIEWS
if (!defined('ABSPATH')) exit; 
?>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-header-actions">
	<div id="weddingpressElementorLibrary-header-sync" class="elementor-templates-modal__header__item">
		<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e('Sync Library', 'weddingpress'); ?>"></i>
		<span class="elementor-screen-only"><?php echo __('Sync Library', 'weddingpress'); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-header-menu">
	<# jQuery.each( tabs, ( tab, args ) => { #>
		<div class="elementor-component-tab elementor-template-library-menu-item" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
	<# } ); #>
</script>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-header-insert">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		{{{ wdp.library.getModal().printTemplateButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-header-back">
	<i class="eicon-" aria-hidden="true"></i>
	<span><?php echo __('Back to Library', 'weddingpress'); ?></span>
</script>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-loading">
	<div class="elementor-loader-wrapper">
		<div class="elementor-loader">
			<div class="elementor-loader-boxes">
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
			</div>
		</div>
		<div class="elementor-loading-title"><?php echo __('Loading', 'weddingpress'); ?></div>
	</div>
</script>


<script type="text/template" id="tmpl-weddingpressElementorLibrary-insert-button">
	<a class="elementor-template-library-template-action weddingpressElementorLibrary-insert-button elementor-button">
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php echo __('Insert', 'weddingpress'); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-get-pro-button">
	<a class="elementor-template-library-template-action elementor-button weddingpressElementorLibrary-elementor-go-pro" href="https://weddingpress.com/purchase/" target="_blank">
		<i class="eicon-bag-medium" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php echo __('Go Pro', 'weddingpress'); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-weddingpressElementorLibrary-preview">
	<iframe></iframe>
</script>

<!--
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								NEEDS SOME CHANGES HERE
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-->
<script type="text/template" id="tmpl-weddingpressElementorLibrary-empty">
	<div class="elementor-template-library-blank-icon">
		<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/no-search-results.svg'; ?>" class="elementor-template-library-no-results" />
	</div>
	<div class="elementor-template-library-blank-title"></div>
	<div class="elementor-template-library-blank-message"></div>
	<div class="elementor-template-library-blank-footer">
		<?php echo __( 'Want to learn more about the Elementor library?', 'weddingpress' ); ?>
		<a class="elementor-template-library-blank-footer-link" href="https://go.elementor.com/docs-library/" target="_blank"><?php echo __( 'Click here', 'elementor' ); ?></a>
	</div>
</script>


<script type="text/template" id="tmpl-weddingpressElementorLibrary-logo">
    <span class="weddingpressElementorLibrary-logo-wrap">
		<img src="<?php echo WEDDINGPRESS_ELEMENTOR_URL ?>admin/assets/img/wdp.png" style="height: 30px;">
	</span>
    <span class="haTemplateLibrary__logo-title">{{{ title }}}</span>
</script>



<script type="text/template" id="tmpl-weddingpressElementorLibrary-templates">
	<div id="weddingpressElementorLibrary-toolbar">
		<div id="weddingpressElementorLibrary-toolbar-filter" class="weddingpressElementorLibrary-toolbar-filter">
			<# if ( wdp.library.getTags() ) { var selectedTag = wdp.library.getTag( 'tags' ); #>				
				<ul id="weddingpressElementorLibrary-filter-tags" class="weddingpressElementorLibrary-filter-tags">
					<li data-tag="">All</li>
					<# _.each( wdp.library.getTags(), function( name, slug ) {
						var selected = selectedTag === slug ? 'active' : '';
						#>
						<li data-tag="{{ slug }}" class="{{ selected }}">{{{ name }}}</li>
					<# } ); #>
				</ul>
			<# } #>
		</div>

		<div id="weddingpressElementorLibrary-toolbar-search">
			<label for="weddingpressElementorLibrary-search" class="elementor-screen-only"><?php esc_html_e( 'Search Templates:', 'weddingpress'); ?></label>
			<input id="weddingpressElementorLibrary-search" placeholder="<?php esc_attr_e( 'Search', 'weddingpress'); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>

	<div class="weddingpressElementorLibrary-window">
		<div id="weddingpressElementorLibrary-list"></div>
	</div>
</script>


<script type="text/template" id="tmpl-weddingpressElementorLibrary-template">
	<div class="weddingpressElementorLibrary-body" id="weddingpressTemplate-{{ template_id }}">
		<div class="weddingpressElementorLibrary-template-preview elementor-template-library-template-preview">
			<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		</div>
		<img class="weddingpressElementorLibrary-thumbnail" src="{{ thumbnail }}">
		<# if ( obj.isPro ) { #>
		<span class="weddingpressElementorLibrary-badge"><?php esc_html_e( 'Pro', 'weddingpress' ); ?></span>
		<# } #>
		<div class="weddingpressElementorlibrary-template-name">{{{ title }}}</div>
	</div>
	
	<div class="weddingpressElementorLibrary-footer">
		{{{ wdp.library.getModal().printTemplateButton( obj ) }}}		
	</div>
</script>
