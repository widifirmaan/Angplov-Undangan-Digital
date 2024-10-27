<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Woo_Add_To_Cart.
 */
class Weddingpress_Widget_WC_Order extends Widget_Base {

	/**
	 * Retrieve Widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wdp-woo-add-to-cart';
	}

	/**
	 * Retrieve Widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Woocommerce Order', 'weddingpress' );
	}

	/**
	 * Retrieve Widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'elkit_icon eicon-checkout';
	}


	public function get_categories() {
        return [ 'weddingpress' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.4.13.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	// public function get_keywords() {
	// 	return parent::get_widget_keywords( 'Woo_Add_To_Cart' );
	// }

	/**
	 * Get Script Depends.
	 *
	 * @access public
	 *
	 * @return array scripts.
	 */
	public function get_script_depends() {
		return array( 'wdp-woocommerce' );
	}

	/**
	 * Retrieve the list of styles the Add to Cart widget depended on.
	 *
	 * Used to set style dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() {
		return array(
			'wdp-woocommerce',
		);
	}

	// /**
	//  * Register controls.
	//  *
	//  * @access protected
	//  */
	// protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	// 	$this->register_controls();
	// }

	/**
	 * Register FAQ widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.3
	 * @access protected
	 */
	protected function register_controls() {
		/* Product Control */
		$this->register_content_product_controls();
		/* Button Control */
		$this->register_content_button_controls();
		/* Button Style */
		$this->register_style_button_controls();

		
	}

	public function unescape_html( $safe_text, $text ) {
		return $text;
	}

	public static function get_products() {
		$products = array();
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => '-1',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'simple',
				),
			),
		);
		$posts = get_posts( $args );
		if ( !empty($posts) ) {
			foreach ( $posts as $post ) {
				$products[$post->ID] = $post->post_title;
			}
		}
		return $products;
	}

	/**
	 * Register Content Product Controls.
	 *
	 * @access protected
	 */
	protected function register_content_product_controls() {

		$this->start_controls_section(
			'section_product_field',
			array(
				'label' => __( 'Product', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);


		$this->add_control(
			'product_id',
			array(
				'label'     => __( 'Select Product', 'powerpack' ),
				'type' => Controls_Manager::SELECT2,
				'default' => '',
				'options' => self::get_products(),
				'label_block' => true,

			)
		);


		$this->add_control(
			'enable_redirect',
			array(
				'label'        => __( 'Auto Redirect', 'powerpack' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'description'  => __( 'Enable this option to redirect cart page after the product gets added to cart', 'powerpack' ),

			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Button Controls.
	 *
	 * @access protected
	 */
	protected function register_content_button_controls() {
		$this->start_controls_section(
			'section_button_field',
			array(
				'label' => __( 'Button', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
			$this->add_control(
				'btn_text',
				array(
					'label'   => __( 'Text', 'powerpack' ),
					'type'    => Controls_Manager::TEXT,
					'default' => __( 'Add to cart', 'powerpack' ),
					'dynamic' => array(
						'active' => true,
					),

				)
			);
			$this->add_responsive_control(
				'align',
				array(
					'label'        => __( 'Alignment', 'powerpack' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => array(
						'left'    => array(
							'title' => __( 'Left', 'powerpack' ),
							'icon'  => 'fa fa-align-left',
						),
						'center'  => array(
							'title' => __( 'Center', 'powerpack' ),
							'icon'  => 'fa fa-align-center',
						),
						'right'   => array(
							'title' => __( 'Right', 'powerpack' ),
							'icon'  => 'fa fa-align-right',
						),
						'justify' => array(
							'title' => __( 'Justified', 'powerpack' ),
							'icon'  => 'fa fa-align-justify',
						),
					),
					'prefix_class' => 'pp-add-to-cart%s-align-',
					'default'      => 'left',
				)
			);
			$this->add_control(
				'btn_size',
				array(
					'label'   => __( 'Size', 'powerpack' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => array(
						'xs' => __( 'Extra Small', 'powerpack' ),
						'sm' => __( 'Small', 'powerpack' ),
						'md' => __( 'Medium', 'powerpack' ),
						'lg' => __( 'Large', 'powerpack' ),
						'xl' => __( 'Extra Large', 'powerpack' ),
					),
				)
			);
			$this->add_responsive_control(
				'btn_padding',
				array(
					'label'      => __( 'Padding', 'powerpack' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),

				)
			);
			$this->add_control(
				'select_btn_icon',
				array(
					'label'            => __( 'Icon', 'powerpack' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'btn_icon',
					'default'          => array(
						'value'   => 'fas fa-shopping-cart',
						'library' => 'fa-solid',
					),

				)
			);
			$this->add_control(
				'btn_icon_align',
				array(
					'label'   => __( 'Icon Position', 'powerpack' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'left',
					'options' => array(
						'left'  => __( 'Before', 'powerpack' ),
						'right' => __( 'After', 'powerpack' ),
					),

				)
			);
			$this->add_control(
				'btn_icon_indent',
				array(
					'label'     => __( 'Icon Spacing', 'powerpack' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'max' => 50,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					),

				)
			);
		$this->end_controls_section();
	}

	/**
	 * Register Style Button Controls.
	 *
	 * @access protected
	 */
	protected function register_style_button_controls() {

		$this->start_controls_section(
			'section_design_button',
			array(
				'label' => __( 'Button', 'powerpack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .pp-button',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			)
		);

		$this->start_controls_tabs( 'button_tabs_style' );

			$this->start_controls_tab(
				'button_normal',
				array(
					'label' => __( 'Normal', 'powerpack' ),
				)
			);

				$this->add_control(
					'button_color',
					array(
						'label'     => __( 'Text Color', 'powerpack' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} .pp-button'     => 'color: {{VALUE}};',
							'{{WRAPPER}} .pp-button svg' => 'fill: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'           => 'button_background_color',
						'label'          => __( 'Background Color', 'powerpack' ),
						'types'          => array( 'classic', 'gradient' ),
						'selector'       => '{{WRAPPER}} .pp-button',
						'fields_options' => array(
							'color' => array(
								'scheme' => array(
									'type'  => Scheme_Color::get_type(),
									'value' => Scheme_Color::COLOR_4,
								),
							),
						),
					)
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					array(
						'name'        => 'button_border',
						'placeholder' => '',
						'default'     => '',
						'selector'    => '{{WRAPPER}} .pp-button',
					)
				);

				$this->add_control(
					'border_radius',
					array(
						'label'      => __( 'Border Radius', 'powerpack' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => array( 'px', '%' ),
						'selectors'  => array(
							'{{WRAPPER}} .pp-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					array(
						'name'     => 'button_box_shadow',
						'selector' => '{{WRAPPER}} .pp-button',
					)
				);

				$this->add_control(
					'view_cart_color',
					array(
						'label'     => __( 'View Cart Text Color', 'powerpack' ),
						'type'      => Controls_Manager::COLOR,
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
						'selectors' => array(
							'{{WRAPPER}} .added_to_cart' => 'color: {{VALUE}};',
						),
						'condition' => array(
							'show_quantity' => '',
						),
					)
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'button_hover',
				array(
					'label' => __( 'Hover', 'powerpack' ),
				)
			);

				$this->add_control(
					'button_hover_color',
					array(
						'label'     => __( 'Text Color', 'powerpack' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} .pp-button:focus, {{WRAPPER}} .pp-button:hover' => 'color: {{VALUE}};',
							'{{WRAPPER}} .pp-button:focus svg, {{WRAPPER}} .pp-button:hover svg' => 'fill: {{VALUE}};',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					array(
						'name'           => 'button_background_hover_color',
						'label'          => __( 'Background Color', 'powerpack' ),
						'types'          => array( 'classic', 'gradient' ),
						'selector'       => '{{WRAPPER}} .pp-button:focus, {{WRAPPER}} .pp-button:hover',
						'fields_options' => array(
							'color' => array(
								'scheme' => array(
									'type'  => Scheme_Color::get_type(),
									'value' => Scheme_Color::COLOR_4,
								),
							),
						),
					)
				);

				$this->add_control(
					'button_border_hover_color',
					array(
						'label'     => __( 'Border Hover Color', 'powerpack' ),
						'type'      => Controls_Manager::COLOR,
						'scheme'    => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
						'condition' => array(
							'button_border_border!' => '',
						),
						'selectors' => array(
							'{{WRAPPER}} .pp-button:focus, {{WRAPPER}} .pp-button:hover' => 'border-color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'hover_animation',
					array(
						'label' => __( 'Hover Animation', 'powerpack' ),
						'type'  => Controls_Manager::HOVER_ANIMATION,
					)
				);

				$this->add_control(
					'view_cart_hover_color',
					array(
						'label'     => __( 'View Cart Text Color', 'powerpack' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'{{WRAPPER}} .added_to_cart:hover' => 'color: {{VALUE}};',
						),
						'condition' => array(
							'show_quantity' => '',
						),
					)
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Style Quantity Controls.
	 *
	 * @access protected
	 */
	protected function register_style_quantity_controls() {

		$this->start_controls_section(
			'section_atc_quantity_style',
			[
				'label' => __( 'Quantity', 'powerpack' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label' => __( 'Spacing', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .quantity + .button' => 'margin-left: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .quantity + .button' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'quantity_typography',
				'selector' => '{{WRAPPER}} .quantity .qty',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'quantity_border',
				'selector' => '{{WRAPPER}} .quantity .qty',
				'exclude' => [ 'color' ],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'quantity_border_radius',
			[
				'label' => __( 'Border Radius', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'quantity_padding',
			[
				'label' => __( 'Padding', 'powerpack' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .quantity .qty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'quantity_style_tabs' );

		$this->start_controls_tab( 'quantity_style_normal',
			[
				'label' => __( 'Normal', 'powerpack' ),
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'quantity_text_color',
			[
				'label' => __( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'quantity_bg_color',
			[
				'label' => __( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'dynamic_product',
							'operator' => '==',
							'value' => 'yes',
						],
						[
							'name' => 'show_quantity',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'quantity_border_color',
			[
				'label' => __( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty' => 'border-color: {{VALUE}}',
				],

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'quantity_style_focus',
			[
				'label' => __( 'Focus', 'powerpack' ),

			]
		);

		$this->add_control(
			'quantity_text_color_focus',
			[
				'label' => __( 'Text Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty:focus' => 'color: {{VALUE}}',
				],

			]
		);

		$this->add_control(
			'quantity_bg_color_focus',
			[
				'label' => __( 'Background Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty:focus' => 'background-color: {{VALUE}}',
				],

			]
		);

		$this->add_control(
			'quantity_border_color_focus',
			[
				'label' => __( 'Border Color', 'powerpack' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .qty:focus' => 'border-color: {{VALUE}}',
				],

			]
		);

		$this->add_control(
			'quantity_transition',
			[
				'label' => __( 'Transition Duration', 'powerpack' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.2,
				],
				'range' => [
					'px' => [
						'max' => 2,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .quantity .qty' => 'transition: all {{SIZE}}s',
				],

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	/**
	 * Render Woo Product Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();

			$product  = false;

			if ( ! empty( $settings['product_id'] ) ) {
				$product_data = get_post( $settings['product_id'] );
			}

			$product = ! empty( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ) ) ? wc_setup_product_data( $product_data ) : false;

			if ( $product ) {
				// if ( 'yes' === $settings['show_quantity'] ) {
				// 	// $this->render_form_button( $product );
				// 	$this->render_ajax_button( $product, true );
				// } else {
					$this->render_ajax_button( $product );
				// }
			} elseif ( current_user_can( 'manage_options' ) ) {
				$class = implode(
					' ',
					array_filter(
						array(
							'button',
							'pp-button',
							'elementor-button',
							'elementor-size-' . $settings['btn_size'],
							'elementor-animation-' . $settings['hover_animation'],
						)
					)
				);
				$this->add_render_attribute(
					'button',
					array( 'class' => $class )
				);

				echo '<div class="pp-woo-add-to-cart">';
				echo '<a ' . wp_kses_post( $this->get_render_attribute_string( 'button' ) ) . '>';
				echo esc_attr__( 'Please select the product', 'powerpack' );
				echo '</a>';
				echo '</div>';
			}
		// }
	}

	/**
	 * @param \WC_Product $product
	 */
	private function render_ajax_button( $product ) {
		$settings = $this->get_settings_for_display();
		$atc_html = '';

		if ( $product ) {

			$product_id   = $product->get_id();
			$product_type = $product->get_type();

			$class = array(
				'pp-button',
				'elementor-button',
				'elementor-animation-' . $settings['hover_animation'],
				'elementor-size-' . $settings['btn_size'],
				'product_type_' . $product_type,
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			);

			if ( 'yes' === $settings['enable_redirect'] ) {
				$class[] = 'pp-redirect';
			}

			$this->add_render_attribute(
				'button',
				array(
					'rel'             => 'nofollow',
					'href'            => $product->add_to_cart_url(),
					'data-quantity'   => ( isset( $settings['quantity'] ) ? $settings['quantity'] : 1 ),
					'data-product_id' => $product_id,
					'class'           => $class,
				)
			);

			$this->add_render_attribute(
				'icon-align',
				'class',
				array(
					'pp-icon',
					'pp-atc-icon-align',
					'elementor-align-icon-' . $settings['btn_icon_align'],
				)
			);

			if ( ! isset( $settings['btn_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				// add old default
				$settings['btn_icon'] = 'fa fa-shopping-cart';
			}

			$has_icon = ! empty( $settings['btn_icon'] );

			if ( $has_icon ) {
				$this->add_render_attribute( 'i', 'class', $settings['btn_icon'] );
				$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
			}

			if ( ! $has_icon && ! empty( $settings['select_btn_icon']['value'] ) ) {
				$has_icon = true;
			}
			$migrated = isset( $settings['__fa4_migrated']['select_btn_icon'] );
			$is_new   = ! isset( $settings['btn_icon'] ) && Icons_Manager::is_migration_allowed();
			?>
			<div class="pp-woo-add-to-cart">
				
				<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'button' ) ); ?>>
					<span class="pp-atc-content-wrapper">
						<?php if ( 'right' === $settings['btn_icon_align'] ) { ?>
							<span class="pp-atc-btn-text"><?php echo wp_kses_post( $settings['btn_text'] ); ?></span>
						<?php } ?>
						<?php
						if ( $has_icon ) {
							echo '<span ' . wp_kses_post( $this->get_render_attribute_string( 'icon-align' ) ) . '>';
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['select_btn_icon'], array( 'aria-hidden' => 'true' ) );
							} elseif ( ! empty( $settings['btn_icon'] ) ) {
								?>
								<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i>
								<?php
							}
							echo '</span>';
						}
						?>
						<?php if ( 'left' === $settings['btn_icon_align'] ) { ?>
							<span class="pp-atc-btn-text"><?php echo wp_kses_post( $settings['btn_text'] ); ?></span>
						<?php } ?>
					</span>
				</a>
			</div>
			<?php
		}
	}

	private function render_form_button( $product ) {
		$settings = $this->get_settings_for_display();

		echo '<div class="pp-woo-add-to-cart">';
		if ( ! $product && current_user_can( 'manage_options' ) ) {

			return;
		}

		$text_callback = function() {
			ob_start();
			$this->render_text();

			return ob_get_clean();
		};

		add_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
		add_filter( 'woocommerce_product_single_add_to_cart_text', $text_callback );
		add_filter( 'esc_html', array( $this, 'unescape_html' ), 10, 2 );

		ob_start();
		woocommerce_template_single_add_to_cart();
		$form = ob_get_clean();
		$form = str_replace( 'single_add_to_cart_button', 'single_add_to_cart_button elementor-button elementor-size-' . $settings['btn_size'] . ' pp-button', $form );
		echo $form;

		remove_filter( 'woocommerce_product_single_add_to_cart_text', $text_callback );
		remove_filter( 'woocommerce_get_stock_html', '__return_empty_string' );
		remove_filter( 'esc_html', array( $this, 'unescape_html' ) );

		echo '</div>';
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			array(
				'content-wrapper' => array(
					'class' => 'elementor-button-content-wrapper',
				),
				'icon-align'      => array(
					'class' => array(
						'pp-icon',
						'elementor-button-icon',
						'elementor-align-icon-' . $settings['btn_icon_align'],
					),
				),
				'btn_text'        => array(
					'class' => 'elementor-button-text',
				),
			)
		);

		if ( ! isset( $settings['btn_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['btn_icon'] = 'fa fa-shopping-cart';
		}

		$has_icon = ! empty( $settings['btn_icon'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['btn_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		if ( ! $has_icon && ! empty( $settings['select_btn_icon']['value'] ) ) {
			$has_icon = true;
		}
		$migrated = isset( $settings['__fa4_migrated']['select_btn_icon'] );
		$is_new   = ! isset( $settings['btn_icon'] ) && Icons_Manager::is_migration_allowed();

		$this->add_inline_editing_attributes( 'btn_text', 'none' );
		?>
		<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
			<?php
			if ( $has_icon ) {
				echo '<span ' . wp_kses_post( $this->get_render_attribute_string( 'icon-align' ) ) . '>';
				if ( $is_new || $migrated ) {
					Icons_Manager::render_icon( $settings['select_btn_icon'], array( 'aria-hidden' => 'true' ) );
				} elseif ( ! empty( $settings['btn_icon'] ) ) {
					?>
					<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i>
					<?php
				}
				echo '</span>';
			}
			?>
			<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'btn_text' ) ); ?>>
				<?php echo wp_kses_post( $settings['btn_text'] ); ?>
			</span>
		</span>
		<?php
	}
}
