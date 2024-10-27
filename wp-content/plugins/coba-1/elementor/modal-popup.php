<?php

namespace WeddingPress\elementor;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Popup Box Widget
 */
class Weddingpress_Widget_Modal_Popup extends Widget_Base {

	/**
	 * Retrieve popup box widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'weddingpress-modal-popup';
	}

	/**
	 * Retrieve popup box widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Popup', 'weddingpress' );
	}

	/**
	 * Retrieve popup box widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'elkit_icon eicon-drag-n-drop';
	}

	public function get_categories() {
        return [ 'weddingpress' ];
    }


	/**
	 * Retrieve the list of scripts the image carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	// public function get_script_depends() {
	// 	return [ 'exad-main-script' ];
	// }


	protected function register_controls() {
		$exad_primary_color = get_option( 'exad_primary_color_option', '#196CFF' );

		/**
		 * Modal Popup Content section
		 */
		$this->start_controls_section(
			'exad_modal_content_section',
			[
				'label' => __( 'Contents', 'weddingpress' )
			]
		);

		$this->add_control(
			'exad_modal_content',
			[
				'label'   => __( 'Type of Modal', 'weddingpress' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
					'image'          => __( 'Image', 'weddingpress' ),
					'image-gallery'  => __( 'Image Gallery', 'weddingpress' ),
					'html_content'   => __( 'HTML Content', 'weddingpress' ),
					'youtube'        => __( 'Youtube Video', 'weddingpress' ),
					// 'vimeo'          => __( 'Vimeo Video', 'weddingpress' ),
					'external-video' => __( 'Self Hosted Video', 'weddingpress' ),
					'external_page'  => __( 'Iframe Page', 'weddingpress' ),
					'shortcode'      => __( 'ShortCode', 'weddingpress' )
				]
			]
		);

		/**
		 * Modal Popup image section
		 */
		$this->add_control(
			'exad_modal_image',
			[
				'label'      => __( 'Image', 'weddingpress' ),
				'type'       => Controls_Manager::MEDIA,
				'default'    => [
					'url' 	 => Utils::get_placeholder_image_src()
				],
				'dynamic'    => [
					'active' => true
                ],
                'condition'  => [
                    'exad_modal_content' => 'image'
                ]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'condition' => [
                    'exad_modal_content' => 'image'
                ]
			]
		);

		/**
		 * Modal Popup image gallery
		 */

		$this->add_control(
			'exad_modal_image_gallery_column',
			[
				'label'   => __( 'Column', 'weddingpress' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'column-three',
                'options' => [
					'column-one'   => __( 'Column 1', 'weddingpress' ),
					'column-two'   => __( 'Column 2', 'weddingpress' ),
					'column-three' => __( 'Column 3', 'weddingpress' ),
					'column-four'  => __( 'Column 4', 'weddingpress' ),
					'column-five'  => __( 'Column 5', 'weddingpress' ),
					'column-six'   => __( 'Column 6', 'weddingpress' )
				],
				'condition' => [
					'exad_modal_content' => 'image-gallery'
				]
			]
		);

		$image_repeater = new Repeater();

		$image_repeater->add_control(
			'exad_modal_image_gallery',
			[
				'label'   => __( 'Image', 'weddingpress' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				]
			]
		);

		$image_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
			]
		);

		$image_repeater->add_control(
			'exad_modal_image_gallery_text',
			[
				'label' => __( 'Description', 'weddingpress' ),
				'type'  => Controls_Manager::TEXTAREA
			]
		);

		$this->add_control(
			'exad_modal_image_gallery_repeater',
			[
				'label'   => esc_html__( 'Image Gallery', 'weddingpress' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $image_repeater->get_controls(),
				'default' => [
					[ 'exad_modal_image_gallery' => Utils::get_placeholder_image_src() ],
					[ 'exad_modal_image_gallery' => Utils::get_placeholder_image_src() ],
					[ 'exad_modal_image_gallery' => Utils::get_placeholder_image_src() ]
				],
				'condition' => [
					'exad_modal_content' => 'image-gallery'
				]
			]
		);
		/**
		 * Modal Popup html content section
		 */
		$this->add_control(
			'exad_modal_html_content',
			[
				'label'     => __( 'Add your content here (HTML/Shortcode)', 'weddingpress' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => __( 'Add your popup content here', 'weddingpress' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [
				  	'exad_modal_content' => 'html_content'
			  	]
			]
		);

		/**
		 * Modal Popup video section
		 */

		$this->add_control(
            'exad_modal_youtube_video_url',
            [
				'label'       => __( 'Provide Youtube Video URL', 'weddingpress' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'https://www.youtube.com/watch?v=q9fL_nJJoZE',
				'placeholder' => __( 'Place Youtube Video URL', 'weddingpress' ),
				'title'       => __( 'Place Youtube Video URL', 'weddingpress' ),
				'condition'   => [
                    'exad_modal_content' => 'youtube'
                ]
            ]
        );

		
        $this->add_control(
            'exad_modal_vimeo_video_url',
            [
				'label'       => __( 'Provide Vimeo Video URL', 'weddingpress' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'https://vimeo.com/347565673',
				'placeholder' => __( 'Place Vimeo Video URL', 'weddingpress' ),
				'title'       => __( 'Place Vimeo Video URL', 'weddingpress' ),
				'condition'   => [
                    'exad_modal_content' => 'vimeo'
                ]
            ]
		);

		/**
		 * Modal Popup external video section
		 */
		$this->add_control(
			'exad_modal_external_video',
			[
				'label'      => __( 'External Video', 'weddingpress' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => [
                    'exad_modal_content' => 'external-video'
                ]
			]
		);
		
		$this->add_control(
            'exad_modal_external_page_url',
            [
				'label'       => __( 'Provide External URL', 'weddingpress' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'https://desainpromosi.id',
				'placeholder' => __( 'Place External Page URL', 'weddingpress' ),
				'condition'   => [
                    'exad_modal_content' => 'external_page'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'exad_modal_video_width',
            [
				'label'        => __( 'Content Width', 'weddingpress' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px', '%' ],
				'range'        => [
                    'px'       => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5
                    ],
                    '%'        => [
                        'min'  => 0,
                        'max'  => 100
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 720
                ],
                'selectors'    => [
					'{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element iframe,
					{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-video-hosted' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .exad-modal-item' => 'width: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_modal_content' => [ 'youtube', 'vimeo', 'external_page', 'external-video' ]
                ]
            ]
        );

        $this->add_responsive_control(
            'exad_modal_video_height',
            [
				'label'        => __( 'Content Height', 'weddingpress' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px', '%' ],
				'range'        => [
                    'px'       => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5
                    ],
                    '%'        => [
						'min'  => 0,
						'max'  => 100
                    ]
                ],
                'default'      => [
					'unit'     => 'px',
					'size'     => 400
                ],
                'selectors'    => [
                    '{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element iframe' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .exad-modal-item' => 'height: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'exad_modal_content' => [ 'youtube', 'vimeo', 'external_page' ]
                ]
            ]
        );

        $this->add_control(
            'exad_modal_shortcode',
            [
				'label'       => __( 'Enter your shortcode', 'weddingpress' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( '[gallery]', 'weddingpress' ),
				'condition'   => [
                    'exad_modal_content' => 'shortcode'
                ]
            ]
		);

		$this->add_responsive_control(
			'exad_modal_content_width',
			[
				'label' => __( 'Content Width', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'      => [
					'unit'     => 'px',
					'size'     => 480
                ],
				'selectors' => [
					'{{WRAPPER}} .exad-modal-item' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [
                    'exad_modal_content' => [ 'image', 'image-gallery', 'html_content', 'shortcode' ]
                ]
			]
		);

		$this->add_responsive_control(
			'exad_modal_content_height',
			[
				'label' => __( 'Contant Height for Tablet & Mobile', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'        => [
					'px'       => [
						'min'  => 0,
						'max'  => 630,
						'step' => 1
					],
					'%'        => [
						'min'  => 0,
						'max'  => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 300
				],
				'selectors' => [
					'{{WRAPPER}} .exad-modal-item.modal-vimeo' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'exad_modal_btn_text',
			[
				'label'       => __( 'Button Text', 'weddingpress' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Click Me', 'weddingpress' ),
				'dynamic'     => [
					'active'  => true
				]
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'exad_modal_btn_icon',
			[
				'label'       => __( 'Button Icon', 'weddingpress' ),
				'label_block' => true,
				'type'        => Controls_Manager::ICONS,
                // 'default'     => [
                //     'value'   => 'fab fa-wordpress-simple',
                //     'library' => 'fa-brands'
                // ]
			]
		);

		$this->end_controls_section();

		/**
		 * Modal Popup settings section
		 */
		$this->start_controls_section(
			'exad_modal_setting_section',
			[
				'label' => __( 'Settings', 'weddingpress' )
			]
		);
		
		$this->add_control(
			'exad_modal_overlay',
			[
				'label'        => __( 'Overlay', 'weddingpress' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'weddingpress' ),
				'label_off'    => __( 'Hide', 'weddingpress' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);
		
		$this->add_control(
			'exad_modal_overlay_click_close',
			[
				'label'     => __( 'Close While Clicked Outside', 'weddingpress' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'ON', 'weddingpress' ),
				'label_off' => __( 'OFF', 'weddingpress' ),
				'default'   => 'yes',
				'condition' => [
					'exad_modal_overlay' => 'yes'
				]
			]
		);
        
		$this->end_controls_section();

		/**
		 * Modal Popup button style
		 */

		$this->start_controls_section(
			'exad_modal_display_settings',
			[
				'label' => __( 'Button', 'weddingpress' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		// 	$this->end_controls_tab();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				// 'global' => [
				// 	'default' => Group_Control,
				// ],
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				// 'global' => [
				// 	'default' => Global_Colors::COLOR_ACCENT,
				// ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);


		$this->end_controls_tabs();


        $this->end_controls_section();
        
		/**
		 * Modal Popup Container section
		 */
		$this->start_controls_section(
			'exad_modal_container_section',
			[
				'label' => __( 'Container', 'weddingpress' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'exad_modal_content_align',
			[
				'label'     => __( 'Alignment', 'weddingpress' ),
				'type'      => Controls_Manager::CHOOSE,
				'toggle'    => false,
				'default'   => 'center',
				'options'   => [
					'left'  => [
						'title' => __( 'Left', 'weddingpress' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center'    => [
						'title' => __( 'Center', 'weddingpress' ),
						'icon'  => 'eicon-text-align-center'
					],
					'right'     => [
						'title' => __( 'Right', 'weddingpress' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'selectors' => [
					'{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element' => 'text-align: {{VALUE}};'
				],
				'condition' => [
					'exad_modal_content' => ['image-gallery', 'html_content']
				]
			]
		);

		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'exad_modal_image_gallery_description_typography',
				'selector'  => '{{WRAPPER}} .exad-modal-content .exad-modal-element .exad-modal-element-card .exad-modal-element-card-body p',
				'condition' => [
					'exad_modal_content' => [ 'image-gallery' ]
				]
			]
		);

		$this->add_control(
			'exad_modal_image_gallery_description_color',
			[
				'label'     => __( 'Description Color', 'weddingpress' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .exad-modal-content .exad-modal-element .exad-modal-element-card .exad-modal-element-card-body p'  => 'color: {{VALUE}};'
				],
				'condition' => [
					'exad_modal_content' => [ 'image-gallery' ]
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'exad_modal_content_border',
				'selector' => '{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element'
			]
		);
		
		$this->add_control(
			'exad_modal_image_gallery_bg',
			[
				'label'     => __( 'Background Color', 'weddingpress' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element'  => 'background: {{VALUE}};'
				],
				'condition' => [
					'exad_modal_content' => ['image-gallery', 'html_content']
				]
			]
		);

		$this->add_control(
			'exad_modal_image_gallery_padding',
			[
				'label'      => __( 'Padding', 'weddingpress' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element .exad-modal-element-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'  => [
					'exad_modal_content' => [ 'image-gallery', 'html_content' ]
				]
			]
		);
        
        $this->add_responsive_control(
            'exad_modal_image_gallery_description_margin',
            [
                'label'      => __('Margin(Description)', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .exad-modal-item .exad-modal-content .exad-modal-element .exad-modal-element-card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
				'condition'  => [
					'exad_modal_content' => [ 'image-gallery' ]
				]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'exad_modal_animation_tab',
			[
				'label' => __( 'Animation', 'weddingpress' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_modal_transition',
			[
				'label'   => __( 'Style', 'weddingpress' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top-to-middle',
				'options' => [
					'top-to-middle'    => __( 'Top To Middle', 'weddingpress' ),
					'bottom-to-middle' => __( 'Bottom To Middle', 'weddingpress' ),
					'right-to-middle'  => __( 'Right To Middle', 'weddingpress' ),
					'left-to-middle'   => __( 'Left To Middle', 'weddingpress' ),
					'zoom-in'          => __( 'Zoom In', 'weddingpress' ),
					'zoom-out'         => __( 'Zoom Out', 'weddingpress' ),
					'left-rotate'      => __( 'Rotation', 'weddingpress' )
				]
			]
		);

		$this->end_controls_section();
		
		/**
		 * Modal Popup overlay style
		 */
        
		$this->start_controls_section(
			'exad_modal_overlay_tab',
			[
				'label'     => __( 'Overlay', 'weddingpress' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'exad_modal_overlay' => 'yes'
				]
			]
		);

		$this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'            => 'exad_modal_overlay_color',
                'types'           => [ 'classic' ],
                'selector'        => '{{WRAPPER}} .exad-modal-overlay',
                'fields_options'  => [
                    'background'  => [
                        'default' => 'classic'
                    ],
                    'color'       => [
                        'default' => 'rgba(0,0,0,.5)'
                    ]
                ]
            ]
        );
		
		$this->end_controls_section();

		/**
		 * Modal Popup Close button style
		 */

		$this->start_controls_section(
			'exad_modal_close_btn_style',
			[
				'label' => __( 'Close Button', 'weddingpress' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'exad_modal_close_btn_position',
			[
				'label' => __( 'Close Button Position', 'weddingpress' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'weddingpress' ),
				'label_on' => __( 'Custom', 'weddingpress' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );
        
        $this->start_popover();

            $this->add_responsive_control(
                'exad_modal_close_btn_position_x_offset',
                [
                    'label' => __( 'X Offset', 'weddingpress' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -4000,
                            'max' => 4000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn' => 'left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'exad_modal_close_btn_position_y_offset',
                [
                    'label' => __( 'Y Offset', 'weddingpress' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -4000,
                            'max' => 4000,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_popover();

		$this->add_control(
            'exad_modal_close_btn_icon_size',
            [
				'label'      => __( 'Icon Size', 'weddingpress' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
                    'px'       => [
						'min'  => 0,
						'max'  => 30,
                    ],
                ],
                'default'   => [
                    'unit'  => 'px',
                    'size'  => 20
                ],
                'selectors' => [
					'{{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn span::before' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn span::after' => 'height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );

        $this->add_control(
			'exad_modal_close_btn_color',
			[
				'label'     => __( 'Color', 'weddingpress' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn span::before, {{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn span::after'  => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'exad_modal_close_btn_bg_color',
			[
				'label'    => __( 'Background Color', 'weddingpress' ),
				'type'     => Controls_Manager::COLOR,
				'default'  => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .exad-modal-item.modal-vimeo .exad-modal-content .exad-close-btn'  => 'background: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
		
	}

	protected function render() { 
		$settings            = $this->get_settings_for_display();		
		$modal_image         = $settings['exad_modal_image'];
		$modal_image_url_src = Group_Control_Image_Size::get_attachment_image_src( !empty( $modal_image['id'] ), 'thumbnail', $settings );
		if( empty( $modal_image_url_src ) ) {
			$modal_image_url = $modal_image['url']; 
		} else { 
			$modal_image_url = $modal_image_url_src;
		}

		if( 'youtube' === $settings['exad_modal_content'] ){
			$url = $settings['exad_modal_youtube_video_url'];
	
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
	
			$youtube_id = $matches[1];
		}

		if( 'vimeo' === $settings['exad_modal_content'] ){
			$vimeo_url       = $settings['exad_modal_vimeo_video_url'];
			$vimeo_id_select = explode('/', $vimeo_url);
			$vidid           = explode( '&', str_replace('https://vimeo.com', '', end($vimeo_id_select) ) );
			$vimeo_id        = $vidid[0];
		}

		$this->add_render_attribute( 'exad_modal_action', [
			'class'             => 'exad-modal-image-action image-modal',
			'data-exad-modal'   => '#exad-modal-' . $this->get_id(),
			'data-exad-overlay' => esc_attr( $settings['exad_modal_overlay'] )
		] );

		$this->add_render_attribute( 'exad_modal_overlay', [
			'class'                         => 'exad-modal-overlay',
			'data-exad_overlay_click_close' => $settings['exad_modal_overlay_click_close']
		] );

		$this->add_render_attribute( 'exad_modal_item', 'class', 'exad-modal-item' );
		$this->add_render_attribute( 'exad_modal_item', 'class', 'modal-vimeo' );
		$this->add_render_attribute( 'exad_modal_item', 'class', $settings['exad_modal_transition'] );
		$this->add_render_attribute( 'exad_modal_item', 'class', $settings['exad_modal_content'] );

		
		echo '<div class="exad-modal">';
          	echo '<div class="exad-modal-wrapper">';

            	echo '<div class="elementor-button-wrapper">';
              		echo '<a href="#" '.$this->get_render_attribute_string('exad_modal_action').'>';
						echo '<span class="elementor-button" role="button">';
						echo '<span class="elementor-button-content-wrapper">';
							// if( 'left' === $settings['exad_modal_btn_icon_align'] && !empty( $settings['exad_modal_btn_icon']['value'] ) ) {
							// 	Icons_Manager::render_icon( $settings['exad_modal_btn_icon'], [ 'aria-hidden' => 'true' ] );
							// }
							
							Icons_Manager::render_icon( $settings['exad_modal_btn_icon'], [ 'aria-hidden' => 'true' ] );
							echo '<span style="padding-left:5px" >';
							echo esc_html( $settings['exad_modal_btn_text'] );
							echo '</span>';
						echo '</span>';
						echo '</span>';
              		echo '</a>';
				echo '</div>';
			
				echo '<div id="exad-modal-'.esc_attr( $this->get_id() ).'" '.$this->get_render_attribute_string('exad_modal_item').'">';
             		echo '<div class="exad-modal-content">';
                		echo '<div class="exad-modal-element '.esc_attr( $settings['exad_modal_image_gallery_column'] ).'">';
							if ( 'image' === $settings['exad_modal_content'] ) {
								echo '<img src="'.esc_url( $modal_image_url ).'" />';
							}

							if ( 'image-gallery' === $settings['exad_modal_content'] ) {
								foreach ( $settings['exad_modal_image_gallery_repeater'] as $gallery ) :
									$image_gallery     = $gallery[ 'exad_modal_image_gallery' ];
									$image_gallery_url = Group_Control_Image_Size::get_attachment_image_src( $image_gallery['id'], 'thumbnail', $gallery );
							
									if ( empty( $image_gallery_url ) ) {
										$image_gallery_url = $image_gallery['url'];
									} else {
										$image_gallery_url = $image_gallery_url;
									}
									echo '<div class="exad-modal-element-card">';
										echo '<div class="exad-modal-element-card-thumb">';
											echo '<img src="'.esc_url( $image_gallery_url ).'" >';
										echo '</div>';
										if ( !empty( $gallery['exad_modal_image_gallery_text'] ) ) {
											echo '<div class="exad-modal-element-card-body">';
												echo '<p>'.wp_kses_post( $gallery['exad_modal_image_gallery_text'] ).'</p>';
											echo '</div>';
										}
									echo '</div>';
								endforeach;
							}

							if ( 'html_content' === $settings['exad_modal_content'] ) {
								echo '<div class="exad-modal-element-body">';
									echo '<p>'.wp_kses_post( $settings['exad_modal_html_content'] ).'</p>';
								echo '</div>';
							}

							if ( 'youtube' === $settings['exad_modal_content'] ) {
								echo '<iframe src="https://www.youtube.com/embed/'.esc_attr( $youtube_id ).'" frameborder="0" allowfullscreen></iframe>';
							}

							if ( 'vimeo' === $settings['exad_modal_content'] ) {
								echo '<iframe id="vimeo-video" src="https://player.vimeo.com/video/'.esc_attr( $vimeo_id ).'" frameborder="0" allowfullscreen ></iframe>';
							}

							if ( 'external-video' === $settings['exad_modal_content'] ) {
								echo '<video class="exad-video-hosted" src="'.esc_url( $settings['exad_modal_external_video']['url'] ).'" controls="" controlslist="nodownload">';
								echo '</video>';
							}

							if ( 'external_page' === $settings['exad_modal_content'] ) {
								echo '<iframe src="'.esc_url( $settings['exad_modal_external_page_url'] ).'" frameborder="0" allowfullscreen ></iframe>';
							}

							if ( 'shortcode' === $settings['exad_modal_content'] ) {
								echo do_shortcode( $settings['exad_modal_shortcode'] );
							}

							echo '<div class="exad-close-btn">';
								echo '<span></span>';
							echo '</div>';

                		echo '</div>';
              		echo '</div>';
            	echo '</div>';
			echo '</div>';
			echo '<div '.$this->get_render_attribute_string('exad_modal_overlay').'></div>';
		echo '</div>';
	
	}


}