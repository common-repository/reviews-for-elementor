<?php
namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Testimonial_Grid_Mode_Widget extends Widget_Base {

	public function get_name() {
		return 'testimonial-grid-mode';
	}

	public function get_title() {
		return __( 'Google Review Grid', 'testimonials-plugin' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'nahiro-elements' ];
	}

	public function get_keywords() {
		return [ 'review', 'grid' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'tilt', 'bdt-uikit-icons' ];
	}

	public function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'testimonials-plugin' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Default', 'testimonials-plugin' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Columns', 'testimonials-plugin' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'2' => '2',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Reviews Per Page', 'testimonials-plugin' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

		// $this->add_control(
		// 	'show_pagination',
		// 	[
		// 		'label' => esc_html__( 'Pagination', 'testimonials-plugin' ),
		// 		'type'  => Controls_Manager::SWITCHER,
		// 	]
		// );

		$this->add_responsive_control(
			'item_gap',
			[
				'label'   => esc_html__( 'Column Gap', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode > .bdt-grid'     => 'margin-left: -{{SIZE}}px',
					'{{WRAPPER}} .testimonial-grid-mode > .bdt-grid > *' => 'padding-left: {{SIZE}}px',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'   => esc_html__( 'Row Gap', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode > .bdt-grid'     => 'margin-top: -{{SIZE}}px',
					'{{WRAPPER}} .testimonial-grid-mode > .bdt-grid > *' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		
		$this->add_control(
			'show_image',
			[
				'label'   => esc_html__( 'Review Image', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => esc_html__( 'Title', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_address',
			[
				'label'   => esc_html__( 'Date', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		

		$this->add_control(
			'show_text',
			[
				'label'   => esc_html__( 'Text', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'text_limit',
			[
				'label'     => esc_html__( 'Text Limit', 'testimonials-plugin' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => esc_html__( 'Rating', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_filter_bar',
			[
				'label' => esc_html__( 'Filter Bar', 'testimonials-plugin' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'item_match_height',
			[
				'label' => esc_html__( 'Item Match Height', 'testimonials-plugin' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'item_masonry',
			[
				'label' => esc_html__( 'Masonry', 'testimonials-plugin' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label'     => __( 'Navigation', 'testimonials-plugin' ),
				/*'condition' => [
					'_skin!' => 'bdt-thumb',
				],*/
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'testimonials-plugin' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'testimonials-plugin' ),
					'arrows' => __( 'Arrows', 'testimonials-plugin' ),
					'dots'   => __( 'Dots', 'testimonials-plugin' ),
					'none'   => __( 'None', 'testimonials-plugin' ),
				],
				'prefix_class' => 'bdt-navigation-type-',
				'render_type'  => 'template',				
			]
		);

		$this->end_controls_section();
		
				
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__( 'Item', 'testimonials-plugin' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[
				'label' => esc_html__( 'Normal', 'testimonials-plugin' ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border Color', 'testimonials-plugin' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[
				'label' => esc_html__( 'Hover', 'testimonials-plugin' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[
				'label'     => esc_html__( 'Background', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-item-inner:hover',
			]
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => esc_html__( 'Image', 'testimonials-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border Color', 'testimonials-plugin' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-img-wrapper',
				'separator'   => 'before',
			]
		);
		
		$this->add_control(
			'image_hover_border_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'image_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-img-wrapper:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-img-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => esc_html__( 'Margin', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-img-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'testimonials-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'testimonials-plugin' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_address',
			[
				'label'     => esc_html__( 'Date', 'testimonials-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_address' => 'yes',
				],
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Text Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-address' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'address_margin',
			[
				'label'      => esc_html__( 'Margin', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Typography', 'testimonials-plugin' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-address',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Text', 'testimonials-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label'      => esc_html__( 'Margin', 'testimonials-plugin' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'testimonials-plugin' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .testimonial-grid-mode .testimonial-grid-mode-text',
			]
		);

		$this->end_controls_section();

		

		$this->start_controls_section(
			'section_design_filter',
			[
				'label'     => esc_html__( 'Filter Bar', 'testimonials-plugin' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_bar' => 'yes',
				],
			]
		);

		$this->add_control(
			'filter_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'testimonials-plugin' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'testimonials-plugin' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'testimonials-plugin' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'testimonials-plugin' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters-wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography_filter',
				'label'    => esc_html__( 'Typography', 'testimonials-plugin' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filters li',
			]
		);

		$this->add_control(
			'filter_spacing',
			[
				'label'     => esc_html__( 'Bottom Space', 'testimonials-plugin' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_style_desktop' );

		$this->start_controls_tab(
			'filter_tab_desktop',
			[
				'label' => __( 'Desktop', 'testimonials-plugin' )
			]
		);

		$this->add_control(
			'desktop_filter_normal',
			[
				'label' => esc_html__( 'Normal', 'testimonials-plugin' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter',
			[
				'label'     => esc_html__( 'Text Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_filter_background',
			[
				'label'     => esc_html__( 'Background', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'desktop_filter_padding',
			[
				'label'      => __('Padding', 'testimonials-plugin'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'desktop_filter_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-ep-grid-filters li'
			]
		);

		$this->add_control(
			'desktop_filter_radius',
			[
				'label'      => __('Radius', 'testimonials-plugin'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-ep-grid-filters li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_filter_shadow',
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filters li'
			]
		);

		$this->add_control(
			'filter_item_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'testimonials-plugin' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters > li.bdt-ep-grid-filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .bdt-ep-grid-filters > li.bdt-ep-grid-filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_control(
			'desktop_filter_active',
			[
				'label' => esc_html__( 'Active', 'testimonials-plugin' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'color_filter_active',
			[
				'label'     => esc_html__( 'Text Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_background',
			[
				'label'     => esc_html__( 'Background', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'desktop_active_filter_radius',
			[
				'label'      => __('Radius', 'testimonials-plugin'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'desktop_active_filter_shadow',
				'selector' => '{{WRAPPER}} .bdt-ep-grid-filters li.bdt-active'
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'filter_tab_mobile',
			[
				'label' => __( 'Mobile', 'testimonials-plugin' )
			]
		);

		$this->add_control(
			'filter_mbtn_width',
			[
				'label' => __('Button Width(%)', 'testimonials-plugin'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 100
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-button' => 'width: {{SIZE}}%;'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_color',
			[
				'label'     => __( 'Button Text Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_background',
			[
				'label'     => __( 'Button Background', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-button' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_color',
			[
				'label'     => __( 'Text Color', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dropdown-nav li' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'filter_mbtn_dropdown_background',
			[
				'label'     => __( 'Dropdown Background', 'testimonials-plugin' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-dropdown' => 'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_mbtn_dropdown_typography',
				'label'    => esc_html__( 'Typography', 'testimonials-plugin' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .bdt-dropdown-nav li',
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	
	public function render_button_link( $post_id ) {
		$settings = $this->get_settings();
		
		if( ! $settings['show_button_link'] ) {
			return;
		}
		?>
		<a target="_blank" href="<?php echo get_post_meta( $post_id, 'testimonial_link', true ); ?>" type="button" class="square_btn btn_button_link"><?php echo $settings['button_link_text']; ?></a>
		<?php
	}

	public function render_image( $image_id ) {
		$settings = $this->get_settings();
		
		if( ! $settings['show_image'] ) {
			return;
		}

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $image_id ), 'medium' );		

		if ( ! $testimonial_thumb ) {
			$testimonial_thumb = get_post_meta( get_the_ID(), 'testimonial_image', true );
		} else {
			$testimonial_thumb = $testimonial_thumb[0];
		}


		?>
		<div>
			<div class="testimonial-grid-mode-img-wrapper bdt-overflow-hidden bdt-border-circle bdt-background-cover">
				<img src="<?php echo esc_url($testimonial_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			</div>
		</div>
		<?php
	}

	public function render_title( $post_id ) {
		$settings = $this->get_settings();

		if( ! $settings['show_title'] ) {
			return;
		}

		?>
		<h4 class="testimonial-grid-mode-title bdt-margin-remove-bottom"><?php echo esc_attr(get_the_title( $post_id )); ?></h4>
		<?php
	}

	public function render_address( $post_id ) {
		$settings = $this->get_settings();

		if( ! $settings['show_address'] ) {
			return;
		}

		?>
        <p class="testimonial-grid-mode-address bdt-text-meta bdt-margin-remove">
        	<?php echo /*date('d/m/Y',get_post_meta( get_the_ID(), 'testimonial_time', true ));*/ get_post_meta( get_the_ID(), 'testimonial_time', true )->format('d/m/Y'); ?>
    	</p>
		<?php
	}

	public function filter_excerpt_length() {
		return $this->get_settings( 'text_limit' );
	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function render_excerpt($post_id) {

		if ( ! $this->get_settings( 'show_text' ) ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );

		if ( $this->get_settings( 'show_link' ) ) { ?>
			<a target="_blank" style="color:inherit;" href="<?php echo get_post_meta( $post_id, 'testimonial_link', true );   ?>">
		<?php } ?>
		<div class="testimonial-grid-mode-text">
			<?php do_shortcode(the_excerpt()); ?>
		</div>
		<?php
		if ( $this->get_settings( 'show_link' ) ) { ?>
			</a>
		<?php }
		remove_filter( 'excerpt_length', [ $this, 'filter_excerpt_length' ], 20 );
		remove_filter( 'excerpt_more', [ $this, 'filter_excerpt_more' ], 20 );
	}

	public function render_rating( $post_id , $position = "top_right") {
		$settings = $this->get_settings();

		if( ! $settings['show_rating'] ) {
			return;
		}

		?>
		<div class="testimonial-grid-mode-rating" style="<?php echo ($position == "under_button") ?  "margin-top:2%;" : "" ?>">
			<ul style="<?php echo ($position == "under_button") ?  "display:inline-flex;" : "display:flex;" ?>" class="bdt-rating bdt-rating-<?php echo get_post_meta( $post_id, 'testimonial_rating', true ); ?> bdt-grid bdt-grid-collapse" bdt-grid>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
				<li class="bdt-rating-item"><i class="fa fa-star" aria-hidden="true"></i></li>
			</ul>
		</div>
		<?php
	}

	public function render_filter_menu() {
		$settings         = $this->get_settings();
		$testi_categories = [];
		$wp_query         = $this->render_query();

		if ( 'by_name' === $settings['source'] and ! empty($settings['post_categories'] ) ) {
			$testi_categories = $settings['post_categories'];
		} else {

			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$terms = get_the_terms( get_the_ID(), 'testimonial_categories' );
				foreach ($terms as $term) {
					$testi_categories[] = esc_attr($term->slug);
				};
			endwhile;

			$testi_categories = array_unique($testi_categories);

			wp_reset_postdata();

		}
		
		?>

		<div class="bdt-ep-grid-filters-wrapper">
			
			<button class="bdt-button bdt-button-default bdt-hidden@m" type="button"><?php esc_html_e( 'Filter', 'testimonials-plugin' ); ?></button>
			<div bdt-dropdown="mode: click;" class="bdt-dropdown bdt-margin-remove-top bdt-margin-remove-bottom">
			    <ul class="bdt-nav bdt-dropdown-nav">

					<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All', 'testimonials-plugin' ); ?></li>
					
					<?php foreach($testi_categories as $testi_category => $value) : ?>
						<?php $filter_name = get_term_by('slug', $value, 'testimonial_categories'); ?>
						<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
							<?php echo $filter_name->name; ?>
						</li>				
					<?php endforeach; ?>
			    
			    </ul>
			</div>


			<ul class="bdt-ep-grid-filters bdt-visible@m" bdt-margin>
				<li class="bdt-ep-grid-filter bdt-active" bdt-filter-control><?php esc_html_e( 'All', 'testimonials-plugin' ); ?></li>
		
				<?php foreach($testi_categories as $product_category => $value) : ?>
					<?php $filter_name = get_term_by('slug', $value, 'testimonial_categories'); ?>
					<li class="bdt-ep-grid-filter" bdt-filter-control="[data-filter*='bdtf-<?php echo esc_attr(trim($value)); ?>']">
						<?php echo $filter_name->name; ?>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php		
	}

	public function render_header() {
		$settings = $this->get_settings();

		$this->add_render_attribute('testimonial-grid-wrapper', 'class', ['testimonial-grid-mode-layout-'.$settings['layout'], 'testimonial-grid-mode', 'bdt-ep-grid-filter-container', 'swiper-slide', 'testimonial-grid-mode-item', 'swiper-slide-duplicate']);

		$this->add_render_attribute('testimonial-grid', 'bdt-grid', '');
		$this->add_render_attribute('testimonial-grid', 'class', 'bdt-grid');

		if ( $settings['show_filter_bar'] ) {
			$this->add_render_attribute('testimonial-grid-wrapper', 'bdt-filter', 'target: #testimonial-grid-mode-' . $this->get_id());
		}

		if ( $settings['item_match_height'] ) {
			$this->add_render_attribute('testimonial-grid', 'bdt-height-match', 'div > .testimonial-grid-mode-item-inner');
		}

		if ( $settings['item_masonry'] ) {
			$this->add_render_attribute('testimonial-grid', 'bdt-grid', 'masonry: true;');
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'testimonial-grid-wrapper' ); ?>>
	
		<?php if ( $settings['show_filter_bar'] ) {
			$this->render_filter_menu();
		}

		?>
		<div id="testimonial-grid-mode-<?php echo $this->get_id(); ?>" <?php echo $this->get_render_attribute_string( 'testimonial-grid' ); ?>>
		<?php
	}

	public function render_footer() { ?>
			</div>
		</div>
		<?php
	}

	public function render_query($offset = 0) {
		$settings = $this->get_settings();

		
		$args = array(
			'post_type'      => 'testimonial',
			'posts_per_page' => $settings['posts_per_page'],
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'post_status'    => 'publish',
			'offset' => $offset
		);

		if ( 'by_name' === $settings['source'] and !empty($settings['post_categories']) ) {			  
			$args['tax_query'][] = array(
				'taxonomy' => 'testimonial_categories',
				'field'    => 'slug',
				'terms'    => $settings['post_categories'],
			);
		}

		$wp_query = new \WP_Query($args);

		return $wp_query;
	}

	public function render_loop_item($loop_number) {
		$settings = $this->get_settings();
		$wp_query = $this->render_query(($settings['posts_per_page'] * $loop_number));
		//$wp_query = $this->render_query(4);

		if($wp_query->have_posts()) {			

			$this->add_render_attribute('testimonial-grid-item', 'class', 'testimonial-grid-mode-item');
			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-width-1-'. $settings['columns_mobile']);
			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-width-1-'. $settings['columns_tablet'] .'@s');
			$this->add_render_attribute('testimonial-grid-item', 'class', 'bdt-width-1-'. $settings['columns'] .'@m');

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

				<?php 

				if( $settings['show_filter_bar'] ) {
					$item_filters = get_the_terms( get_the_ID(), 'testimonial_categories' ); 
	    			foreach ($item_filters as $item_filter) {
	    				$this->add_render_attribute('testimonial-grid-item', 'data-filter', 'bdtf-' . $item_filter->slug, true);
	    			}
	    		}
	    		?>

		  		<div <?php echo $this->get_render_attribute_string( 'testimonial-grid-item' ); ?>>
	  				<?php if ('1' == $settings['layout']) : ?>
			  			<div class="testimonial-grid-mode-item-inner">
				  			<div class="bdt-grid bdt-position-relative bdt-grid-small bdt-flex-middle" bdt-grid>
				               <?php $this->render_image( get_the_ID() ); ?>
			               		<?php if ( $settings['show_title'] || $settings['show_address'] ) : ?>
				           			<div class="testimonial-grid-mode-title-address">
						               <?php
						               $this->render_title( get_the_ID() );
										if ($settings['ratings_position'] == 'under_name' && $settings['show_rating'])
										{
											$this->render_rating( get_the_ID() ); 
										}
						               $this->render_address( get_the_ID() );
						              
						              if ($settings['show_rating']) : ?>
					               			<?php if ('3' <= $settings['columns']) : ?>
						           				<?php
													if ($settings['ratings_position'] == 'top_right')
													{
														$this->render_rating( get_the_ID() ); 
													}
												?>
						                	<?php endif; ?>
					                	
					               			<?php if ('2' >= $settings['columns']) : ?>
									           	<div class="bdt-position-center-right">
								           			<?php 
														if ($settings['ratings_position'] == 'top_right')
														{
															$this->render_rating( get_the_ID() ); 
														}
													?>
									           	</div>
						                	<?php endif; ?>
				                		<?php endif; ?>

						           	</div>
			                	<?php endif; ?>
			            	</div>
			          		<?php $this->render_excerpt(get_the_ID()); 
							if ($settings['show_button_link']) : ?>
								<div class="testimonial-button-link">
									<?php $this->render_button_link( get_the_ID() ); 
										if ($settings['ratings_position'] == 'under_button' && $settings['show_rating'])
										{
											$this->render_rating( get_the_ID(), $settings['ratings_position'] ); 
										}
									?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ('2' == $settings['layout']) : ?>
			  			<div class="testimonial-grid-mode-item-inner bdt-position-relative bdt-text-center">
			               <div class=""><?php $this->render_image( get_the_ID() ); ?></div>
		               		<?php if ( $settings['show_title'] || $settings['show_address'] ) : ?>
			           			<div class="testimonial-grid-mode-title-address">
					               <?php
					               $this->render_title( get_the_ID() );
									if ($settings['ratings_position'] == 'under_name' && $settings['show_rating'])
									{
										$this->render_rating( get_the_ID() ); 
									}
					               $this->render_address( get_the_ID() );
					               ?>
					           	</div>
		                	<?php endif; ?>			          
		          			<?php $this->render_excerpt(get_the_ID()); ?>
		           			<?php 
								if ($settings['ratings_position'] == 'top_right')
								{
									$this->render_rating( get_the_ID() ); 
								}
							if ($settings['show_button_link']) : ?>
								<div class="testimonial-button-link">
									<?php $this->render_button_link( get_the_ID() ); 
										if ($settings['ratings_position'] == 'under_button' && $settings['show_rating'])
										{
											$this->render_rating( get_the_ID(), $settings['ratings_position'] ); 
										}
									?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ('3' == $settings['layout']) : ?>
			  			<div class="testimonial-grid-mode-item-inner">
			          		<?php $this->render_excerpt(get_the_ID()); ?>
				  			<div class="bdt-grid bdt-position-relative bdt-grid-small bdt-flex-middle" bdt-grid>
				               <?php $this->render_image( get_the_ID() ); ?>
			               		<?php if ( $settings['show_title'] || $settings['show_address'] ) : ?>
				           			<div class="testimonial-grid-mode-title-address">
						               <?php
						               $this->render_title( get_the_ID() );
										if ($settings['ratings_position'] == 'under_name' && $settings['show_rating'])
										{
											$this->render_rating( get_the_ID() ); 
										}
						               $this->render_address( get_the_ID() );
						               
						               if ($settings['show_rating']) : ?>
					               			<?php if ('3' <= $settings['columns']) : ?>
						           				<?php 
													if ($settings['ratings_position'] == 'top_right')
													{
														$this->render_rating( get_the_ID() ); 
													}
												?>
						                	<?php endif; ?>

					               			<?php if ('2' >= $settings['columns']) : ?>
									           	<div class="bdt-position-center-right">
								           			<?php 
														if ($settings['ratings_position'] == 'top_right')
														{
															$this->render_rating( get_the_ID() ); 
														}
													?>
									           	</div>
						                	<?php endif; ?>
					                	<?php endif; ?>

						           	</div>
			                	<?php endif; ?>
			            	</div>
							<?php if ($settings['show_button_link']) : ?>
								<div class="testimonial-button-link">
									<?php $this->render_button_link( get_the_ID() ); 
										if ($settings['ratings_position'] == 'under_button' && $settings['show_rating'])
										{
											$this->render_rating( get_the_ID(), $settings['ratings_position'] ); 
										}
									?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endwhile;

			// if ($settings['show_pagination']) {
			// 	element_pack_post_pagination($wp_query);
			// }

			wp_reset_postdata();

		} else {
			echo '<div class="bdt-alert-warning" bdt-alert>Oppps!! There is no post, please select actual post or categories.<div>';
		}
	}

	public function get_reviews_data($place_id, $g_api){
                                                   
        $result = @wp_remote_get('https://maps.googleapis.com/maps/api/place/details/json?placeid='.trim($place_id).'&key='.trim($g_api));
        
        if(isset($result['body'])){
            
           $result = json_decode($result['body'],true);   
           
           if($result['result']){
               return $result['result'];
               
           }else{
               if($result['error_message']){
                   return array('status' => false, 'message' => $result['error_message']);
               }else{
                   return array('status' => false, 'message' => esc_html__( 'Something went wrong', 'schema-and-structured-data-for-wp' ));
               }                             
           }
                                                       
        }else{
           return null;
        }        
                                            
    }
	
	public function render() {
		$settings = $this->get_settings();
		if ($settings['enable_schema'])
		{
			$testimonials_review_settings_options = get_option( 'testimonials_review_settings_options' );
			$result = $this->get_reviews_data($testimonials_review_settings_options['locations_names'][0], $testimonials_review_settings_options['google_api']); 
	$result_photo = @wp_remote_get('https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' . $result["photos"][0]["photo_reference"] . '&key='.trim($testimonials_review_settings_options['google_api']));
	//echo $testimonials_review_settings_options['google_api'];
			//print_r ($result_photo["url"]);
			//add_action('wp_head', array($this, 'inject_required_scripts'));
			echo '<script>jQuery( document ).ready(function() {
		  var s = document.createElement("script");
		s.type = "application/ld+json";
		 var code = "{\"@context\": \"https://schema.org/\",\"@type\": \"LocalBusiness\",\"image\" :\"https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' . $result["photos"][0]["photo_reference"] . '&key=' . trim($testimonials_review_settings_options["google_api"]) . '\",\"name\": \"'. $result["name"] . '\",\"description\":\"' . get_bloginfo("description") . '\",\"address\": {\"@type\": \"PostalAddress\",\"streetAddress\": \"' . $result["address_components"][0]["short_name"] . ' ' . $result["address_components"][1]["short_name"] . '\",\"addressLocality\": \"'. $result["address_components"][3]["short_name"] .'\",\"addressRegion\": \"'. $result["address_components"][4]["short_name"] .'\",\"postalCode\": \"'. $result["address_components"][6]["short_name"] .'\",\"addressCountry\": \"'. $result["address_components"][5]["short_name"] .'\"},\"telephone\":\"' . $result["international_phone_number"] . '\",\"aggregateRating\": {\"@type\": \"AggregateRating\",\"bestRating\": \"5\",\"ratingCount\": \"' . $result["user_ratings_total"] . '\",\"ratingValue\": \"' . $result["rating"] . '\"},\"review\":[';
			$text = "";
			$reviews = $result['reviews'];
				foreach ($reviews as $review) {
				$text = $text . '{\"@type\": \"Review\",\"author\": {\"@type\":\"Person\",\"name\":\"' . $review["author_name"]  . '\"},\"datePublished\": \"' . date("Y-m-d", $review["time"]) . '\",\"description\": \"' . $review["text"] . '\",\"name\": \"\",\"reviewRating\": {\"@type\": \"Rating\",\"bestRating\": \"5\",\"ratingValue\": \"' . $review["rating"] . '\",\"worstRating\": \"1\"}},';
					}
				   echo substr ( $text , 0, strlen($text) - 1 );     
				   echo ']}";
				   console.log(code);
		  s.appendChild(document.createTextNode(code));

		jQuery("head").append(s);
	});</script>';

			/*echo '<script type="application/ld+json">{"@context": "https://schema.org/","@type": "LocalBusiness","image" :"https://d3puay5pkxu9s4.cloudfront.net/curso/3823/800_imagen.jpg","name": "'. $result["name"] . '","description":"' . get_bloginfo("description") . '","address": {"@type": "PostalAddress","streetAddress": "' . $result["address_components"][1]["short_name"] . ' ' . $result["address_components"][0]["long_name"] . '","addressLocality": "'. $result["address_components"][3]["short_name"] .'","addressRegion": "'. $result["address_components"][4]["short_name"] .'","postalCode": "'. $result["address_components"][6]["short_name"] .'","addressCountry": "'. $result["address_components"][5]["short_name"] .'"},"aggregateRating": {"@type": "AggregateRating","bestRating": "5","ratingCount": "' . $result["user_ratings_total"] . '","ratingValue": "' . $result["rating"] . '"},"review":[';
			$text = "";
			$reviews = $result['reviews'];
				foreach ($reviews as $review) {
				$text = $text . '{"@type": "Review","author": {"@type":"Person","name":"' . $review["author_name"]  . '"},"datePublished": "' . date("Y-m-d", $review["time"]) . '","description": "' . $review["text"] . '","name": "","reviewRating": {"@type": "Rating","bestRating": "5","ratingValue": "' . $review["rating"] . '","worstRating": "1"}},';
					}
				   echo substr ( $text , 0, strlen($text) - 1 );     
				   echo ']}</script>';*/
		}
		
		$settings = $this->get_settings();
		
        $postCountTotal = 5;
		
		$howmany = $postCountTotal / $settings['posts_per_page'];
		$hasta = 0;
		
		if (is_numeric( $howmany ) && floor( $howmany ) != $howmany)
		{
			$hasta = floor($howmany) + 1;
		}
		else
		{
			$hasta = $howmany;
		}
		echo '<div id="testimonial-grid-mode-cbd8da3" class="testimonial-grid-mode testimonial-grid-mode-skin-default bdt-arrows-dots-align-center" bdt-height-match="target: > div > div > div > div > .testimonial-grid-mode-text" data-settings="{&quot;loop&quot;:true,&quot;slidesPerView&quot;:3,&quot;spaceBetween&quot;:48,&quot;breakpoints&quot;:{&quot;1025&quot;:{&quot;slidesPerView&quot;:2,&quot;spaceBetween&quot;:48},&quot;768&quot;:{&quot;slidesPerView&quot;:1,&quot;spaceBetween&quot;:48}},&quot;navigation&quot;:{&quot;nextEl&quot;:&quot;#testimonial-grid-mode-cbd8da3 .bdt-navigation-next-grid&quot;,&quot;prevEl&quot;:&quot;#testimonial-grid-mode-cbd8da3 .bdt-navigation-prev-grid&quot;},&quot;pagination&quot;:{&quot;el&quot;:&quot;#testimonial-carousel-mode-cbd8da3 .swiper-pagination&quot;,&quot;type&quot;:&quot;bullets&quot;,&quot;clickable&quot;:true}}">';
		echo '<div class="swiper-container-grid swiper-container-horizontal"><div class="swiper-wrapper">';
		for($i=0; $i<$hasta; $i++){
			//        echo '<div class="swiper-slide">Slide '. $i .'</div>';
			echo '<div class="swiper-slide">';
			$this->render_header();
			$this->render_loop_item($i);
			$this->render_footer();
			echo '</div>'; 
		}
		echo '</div></div>'; 
		if ('both' == $settings['navigation'] || 'arrows' == $settings['navigation'])
		{
		echo '<div class="bdt-position-z-index bdt-position-center">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div class="bdt-visible@m">
						<a href="" class="bdt-navigation-prev-grid bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" tabindex="0" role="button" aria-label="Previous slide"><svg width="38" height="38" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-left"><polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4"></polyline></svg></a>
					</div>						
					<div class="bdt-visible@m">
						<a href="" class="bdt-navigation-next-grid bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9" tabindex="0" role="button" aria-label="Next slide"><svg width="38" height="38" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-right"><polyline fill="none" stroke="#000" stroke-width="1.03" points="7 4 13 10 7 16"></polyline></svg></a>
					</div>
					
				</div>
			</div>
		</div>';
		}
		if ('both' == $settings['navigation'] || 'dots' == $settings['navigation'])
		{
		echo '<div style="text-align:center;" class="bdt-dots-container" style="display:contents;">
						<div class="swiper-pagination-grid swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span></div>
					</div>';
		echo '</div>'; 
		}
//echo '<div id="testimonial-carousel-mode-cbd8da3" class="testimonial-carousel-mode testimonial-carousel-mode-skin-default bdt-arrows-dots-align-center" bdt-height-match="target: > div > div > div > div > .testimonial-carousel-mode-text" data-settings="{&quot;loop&quot;:true,&quot;slidesPerView&quot;:3,&quot;spaceBetween&quot;:48,&quot;breakpoints&quot;:{&quot;1025&quot;:{&quot;slidesPerView&quot;:2,&quot;spaceBetween&quot;:48},&quot;768&quot;:{&quot;slidesPerView&quot;:1,&quot;spaceBetween&quot;:48}},&quot;navigation&quot;:{&quot;nextEl&quot;:&quot;#testimonial-carousel-mode-cbd8da3 .bdt-navigation-next&quot;,&quot;prevEl&quot;:&quot;#testimonial-carousel-mode-cbd8da3 .bdt-navigation-prev&quot;},&quot;pagination&quot;:{&quot;el&quot;:&quot;#testimonial-carousel-mode-cbd8da3 .swiper-pagination&quot;,&quot;type&quot;:&quot;bullets&quot;,&quot;clickable&quot;:true}}"><div class="swiper-container-grid"><div class="swiper-wrapper"><div class="swiper-slide testimonial-carousel-mode-item">Slide 1</div><div class="swiper-slide testimonial-carousel-mode-item">Slide 2</div><div class="swiper-slide testimonial-carousel-mode-item">Slide 3</div></div></div><a href="" class="bdt-navigation-prev-grid bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9" tabindex="0" role="button" aria-label="Previous slide"><svg width="38" height="38" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-left"><polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4"></polyline></svg></a><div class="bdt-navigation-next-grid"></div></div>';
			//<div class="bdt-navigation-prev-grid"></div>
    //<div class="bdt-navigation-next-grid"></div>

		//echo '</div>';
		
	}
	public function render_both_navigation() {
	
		$hide_arrow_on_mobile = 'bdt-visible@m';

		?>
		<div class="bdt-position-z-index bdt-position-center">
			<div class="bdt-arrows-dots-container bdt-slidenav-container ">
				
				<div class="bdt-flex bdt-flex-middle">
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav" bdt-icon="icon: chevron-left; ratio: 1.9"></a>
					</div>

						<div class="swiper-pagination"></div>
					
					<div class="<?php echo esc_attr( $hide_arrow_on_mobile ); ?>">
						<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav" bdt-icon="icon: chevron-right; ratio: 1.9"></a>
					</div>
					
				</div>
			</div>
		</div>
		<?php
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Testimonial_Grid_Mode_Widget() );