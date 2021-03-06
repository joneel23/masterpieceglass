<?php
/**
 * Created by PhpStorm.
 * User: WEB
 * Date: 5/26/2020
 * Time: 4:52 PM
 */

namespace Elementor;
//namespace ElementorPro\Plugin;
//namespace Elementor\Core\Settings;

//namespace ElementorPro\Modules\Gallery\Widgets;

//namespace ElementorPro;
//namespace ElementorPro\Base;
//
//use ElementorPro\Base\Base_Widget;


//use Elementor\Core\Settings\Manager;
use Elementor\Controls_Manager;

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;

use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use ElementorPro\Plugin;


class Elementor_MP_Gallery extends Widget_Base {

    public function get_name() {
        return 'mp-gallery';
    }

    public function get_title() {
        return __( 'Masterpiece Gallery', 'elementor-pro' );
    }

    public function get_script_depends() {
        return [ 'elementor-gallery' ];
    }

    public function get_style_depends() {
        return [ 'elementor-gallery' ];
    }

    public function get_icon() {
        return 'eicon-gallery-justified';
    }

    public function get_keywords() {
        return [ 'image', 'photo', 'visual', 'gallery' ];
    }

    protected function _register_controls() {

        $this->start_controls_section( 
            'settings', [ 'label' => __( 'Masterpiece Gallery', 'elementor' ) ] 
        );

        $this->add_control(
            'gallery_type',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Type', 'elementor-pro' ),
                'default' => 'single',
                'options' => [
                    'single' => __( 'Single', 'elementor-pro' ),
                    'multiple' => __( 'Multiple', 'elementor-pro' ),
                ],
            ]
        );

        $this->add_control(
            'mp-gallery',
            [
                'type' => Controls_Manager::GALLERY,
                'condition' => [
                    'gallery_type' => 'single',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'gallery_title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __( 'Title', 'elementor-pro' ),
                'default' => __( 'New Gallery', 'elementor-pro' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'multiple_gallery',
            [
                'type' => Controls_Manager::GALLERY,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'galleries',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => __( 'Galleries', 'elementor-pro' ),
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ gallery_title }}}',
                'default' => [
                    [
                        'gallery_title' => __( 'New Gallery', 'elementor-pro' ),
                    ],
                ],
                'condition' => [
                    'gallery_type' => 'multiple',
                ],
            ]
        );

        $this->add_control(
            'order_by',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Order By', 'elementor-pro' ),
                'options' => [
                    '' => __( 'Default', 'elementor-pro' ),
                    'random' => __( 'Random', 'elementor-pro' ),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'lazyload',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => __( 'Lazy Load', 'elementor-pro' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'gallery_layout',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Layout', 'elementor-pro' ),
                'default' => 'grid',
                'options' => [
                    'grid' => __( 'Grid', 'elementor-pro' ),
                    'justified' => __( 'Justified', 'elementor-pro' ),
                    'masonry' => __( 'Masonry', 'elementor-pro' ),
                ],
                'separator' => 'before',
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __( 'Columns', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'min' => 1,
                'max' => 24,
                'condition' => [
                    'gallery_layout!' => 'justified',
                ],
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'ideal_row_height',
            [
                'label' => __( 'Row Height', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 200,
                ],
                'tablet_default' => [
                    'size' => 150,
                ],
                'mobile_default' => [
                    'size' => 150,
                ],
                'condition' => [
                    'gallery_layout' => 'justified',
                ],
                'required' => true,
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => __( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'tablet_default' => [
                    'size' => 10,
                ],
                'mobile_default' => [
                    'size' => 10,
                ],
                'required' => true,
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => __( 'Link', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'file',
                'options' => [
                    '' => __( 'None', 'elementor-pro' ),
                    'file' => __( 'Media File', 'elementor-pro' ),
                    'custom' => __( 'Custom URL', 'elementor-pro' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => __( 'URL', 'elementor-pro' ),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'link_to' => 'custom',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'aspect_ratio',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Aspect Ratio', 'elementor-pro' ),
                'default' => '3:2',
                'options' => [
                    '1:1' => '1:1',
                    '3:2' => '3:2',
                    '4:3' => '4:3',
                    '9:16' => '9:16',
                    '16:9' => '16:9',
                    '21:9' => '21:9',
                ],
                'condition' => [
                    'gallery_layout' => 'grid',
                ],
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail_image',
                'default' => 'medium',
            ]
        );

        $this->end_controls_section(); // settings

        $this->start_controls_section(
            'section_filter_bar_content',
            [
                'label' => __( 'Filter Bar', 'elementor-pro' ),
                'condition' => [
                    'gallery_type' => 'multiple',
                ],
            ]
        );

        $this->add_control(
            'show_all_galleries',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => __( '"All" Filter', 'elementor-pro' ),
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'show_all_galleries_label',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __( '"All" Filter Label', 'elementor-pro' ),
                'default' => __( 'All', 'elementor-pro' ),
                'condition' => [
                    'show_all_galleries' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pointer',
            [
                'label' => __( 'Pointer', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'underline',
                'options' => [
                    'none' => __( 'None', 'elementor-pro' ),
                    'underline' => __( 'Underline', 'elementor-pro' ),
                    'overline' => __( 'Overline', 'elementor-pro' ),
                    'double-line' => __( 'Double Line', 'elementor-pro' ),
                    'framed' => __( 'Framed', 'elementor-pro' ),
                    'background' => __( 'Background', 'elementor-pro' ),
                    'text' => __( 'Text', 'elementor-pro' ),
                ],
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'animation_line',
            [
                'label' => __( 'Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => 'Fade',
                    'slide' => 'Slide',
                    'grow' => 'Grow',
                    'drop-in' => 'Drop In',
                    'drop-out' => 'Drop Out',
                    'none' => 'None',
                ],
                'condition' => [
                    'pointer' => [ 'underline', 'overline', 'double-line' ],
                ],
            ]
        );

        $this->add_control(
            'animation_framed',
            [
                'label' => __( 'Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => 'Fade',
                    'grow' => 'Grow',
                    'shrink' => 'Shrink',
                    'draw' => 'Draw',
                    'corners' => 'Corners',
                    'none' => 'None',
                ],
                'condition' => [
                    'pointer' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'animation_background',
            [
                'label' => __( 'Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => 'Fade',
                    'grow' => 'Grow',
                    'shrink' => 'Shrink',
                    'sweep-left' => 'Sweep Left',
                    'sweep-right' => 'Sweep Right',
                    'sweep-up' => 'Sweep Up',
                    'sweep-down' => 'Sweep Down',
                    'shutter-in-vertical' => 'Shutter In Vertical',
                    'shutter-out-vertical' => 'Shutter Out Vertical',
                    'shutter-in-horizontal' => 'Shutter In Horizontal',
                    'shutter-out-horizontal' => 'Shutter Out Horizontal',
                    'none' => 'None',
                ],
                'condition' => [
                    'pointer' => 'background',
                ],
            ]
        );

        $this->add_control(
            'animation_text',
            [
                'label' => __( 'Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'grow',
                'options' => [
                    'grow' => 'Grow',
                    'shrink' => 'Shrink',
                    'sink' => 'Sink',
                    'float' => 'Float',
                    'skew' => 'Skew',
                    'rotate' => 'Rotate',
                    'none' => 'None',
                ],
                'condition' => [
                    'pointer' => 'text',
                ],
            ]
        );

        $this->end_controls_section(); // settings

        $this->start_controls_section( 'overlay', [ 'label' => __( 'Overlay', 'elementor-pro' ) ] );

        $this->add_control(
            'overlay_background',
            [
                'label' => __( 'Background', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'overlay_title',
            [
                'label' => __( 'Title', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'None', 'elementor-pro' ),
                    'title' => __( 'Title', 'elementor-pro' ),
                    'caption' => __( 'Caption', 'elementor-pro' ),
                    'alt' => __( 'Alt', 'elementor-pro' ),
                    'description' => __( 'Description', 'elementor-pro' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'overlay_description',
            [
                'label' => __( 'Description', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'None', 'elementor-pro' ),
                    'title' => __( 'Title', 'elementor-pro' ),
                    'caption' => __( 'Caption', 'elementor-pro' ),
                    'alt' => __( 'Alt', 'elementor-pro' ),
                    'description' => __( 'Description', 'elementor-pro' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section(); // overlay

        $this->start_controls_section(
            'image_style',
            [
                'label' => __( 'Image', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'image_tabs' );

        $this->start_controls_tab(
            'image_normal',
            [
                'label' => __( 'Normal', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'image_border_color',
            [
                'label' => __( 'Border Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--image-border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'image_border_width',
            [
                'label' => __( 'Border Width', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}}' => '--image-border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => __( 'Border Radius', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}}' => '--image-border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} .e-gallery-image',
            ]
        );

        $this->end_controls_tab(); // overlay_background normal

        $this->start_controls_tab(
            'image_hover',
            [
                'label' => __( 'Hover', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'image_border_color_hover',
            [
                'label' => __( 'Border Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-gallery-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius_hover',
            [
                'label' => __( 'Border Radius', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-gallery-item:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters_hover',
                'selector' => '{{WRAPPER}} .e-gallery-item:hover .e-gallery-image',
            ]
        );

        $this->end_controls_tab(); // overlay_background normal

        $this->end_controls_tabs();// overlay_background tabs

        $this->add_control(
            'image_hover_animation',
            [
                'label' => __( 'Hover Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => 'None',
                    'grow' => 'Zoom In',
                    'shrink-contained' => 'Zoom Out',
                    'move-contained-left' => 'Move Left',
                    'move-contained-right' => 'Move Right',
                    'move-contained-top' => 'Move Up',
                    'move-contained-bottom' => 'Move Down',
                ],
                'separator' => 'before',
                'default' => '',
                'frontend_available' => true,
                'render_type' => 'ui',
            ]
        );

        $this->add_control(
            'image_animation_duration',
            [
                'label' => __( 'Animation Duration', 'elementor-pro' ) . ' (ms)',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 800,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--image-transition-duration: {{SIZE}}ms',
                ],
            ]
        );

        $this->end_controls_section(); // overlay_background

        $this->start_controls_section(
            'overlay_style',
            [
                'label' => __( 'Overlay', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'overlay_background' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'overlay_background_tabs' );

        $this->start_controls_tab(
            'overlay_normal',
            [
                'label' => __( 'Normal', 'elementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ],
                'selector' => '{{WRAPPER}} .elementor-gallery-item__overlay',
                'fields_options' => [
                    'background' => [
                        'label' => __( 'Overlay', 'elementor-pro' ),
                    ],
                ],
            ]
        );

        $this->end_controls_tab(); // overlay_background normal

        $this->start_controls_tab(
            'overlay_hover',
            [
                'label' => __( 'Hover', 'elementor-pro' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_background_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .e-gallery-item:hover .elementor-gallery-item__overlay',
                'exclude' => [ 'image' ],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => 'rgba(0,0,0,0.5)',
                    ],
                ],
            ]
        );

        $this->end_controls_tab(); // overlay_background normal

        $this->end_controls_tabs();// overlay_background tabs

        $this->add_control(
            'image_blend_mode',
            [
                'label' => __( 'Blend Mode', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'Normal', 'elementor-pro' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'color-burn' => 'Color Burn',
                    'hue' => 'Hue',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'exclusion' => 'Exclusion',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--overlay-mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'before',
                'render_type' => 'ui',
            ]
        );

        $this->add_control(
            'background_overlay_hover_animation',
            [
                'label' => __( 'Hover Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'groups' => [
                    [
                        'label' => __( 'None', 'elementor-pro' ),
                        'options' => [
                            '' => __( 'None', 'elementor-pro' ),
                        ],
                    ],
                    [
                        'label' => __( 'Entrance', 'elementor-pro' ),
                        'options' => [
                            'enter-from-right' => 'Slide In Right',
                            'enter-from-left' => 'Slide In Left',
                            'enter-from-top' => 'Slide In Up',
                            'enter-from-bottom' => 'Slide In Down',
                            'enter-zoom-in' => 'Zoom In',
                            'enter-zoom-out' => 'Zoom Out',
                            'fade-in' => 'Fade In',
                        ],
                    ],
                    [
                        'label' => __( 'Exit', 'elementor-pro' ),
                        'options' => [
                            'exit-to-right' => 'Slide Out Right',
                            'exit-to-left' => 'Slide Out Left',
                            'exit-to-top' => 'Slide Out Up',
                            'exit-to-bottom' => 'Slide Out Down',
                            'exit-zoom-in' => 'Zoom In',
                            'exit-zoom-out' => 'Zoom Out',
                            'fade-out' => 'Fade Out',
                        ],
                    ],
                ],
                'separator' => 'before',
                'default' => '',
                'frontend_available' => true,
                'render_type' => 'ui',
            ]
        );

        $this->add_control(
            'background_overlay_animation_duration',
            [
                'label' => __( 'Animation Duration', 'elementor-pro' ) . ' (ms)',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 800,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--overlay-transition-duration: {{SIZE}}ms',
                ],
            ]
        );

        $this->end_controls_section(); // overlay_background

        $this->start_controls_section(
            'overlay_content_style',
            [
                'label' => __( 'Content', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                //TODO: add conditions for this section
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label' => __( 'Alignment', 'elementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}' => '--content-text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'content_vertical_position',
            [
                'label' => __( 'Vertical Position', 'elementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => __( 'Top', 'elementor-pro' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => __( 'Middle', 'elementor-pro' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => __( 'Bottom', 'elementor-pro' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--content-justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Padding', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--content-padding: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => __( 'Title', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'overlay_title!' => '',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--title-text-color: {{VALUE}}',
                ],
                'condition' => [
                    'overlay_title!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-gallery-item__title',
                'condition' => [
                    'overlay_title!' => '',
                ],
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label' => __( 'Spacing', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}}' => '--description-margin-top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'overlay_title!' => '',
                ],
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label' => __( 'Description', 'elementor-pro' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'overlay_description!' => '',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--description-text-color: {{VALUE}}',
                ],
                'condition' => [
                    'overlay_description!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-gallery-item__description',
                'condition' => [
                    'overlay_description!' => '',
                ],
            ]
        );

        $this->add_control(
            'content_hover_animation',
            [
                'label' => __( 'Hover Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'groups' => [
                    [
                        'label' => __( 'None', 'elementor-pro' ),
                        'options' => [
                            '' => __( 'None', 'elementor-pro' ),
                        ],
                    ],
                    [
                        'label' => __( 'Entrance', 'elementor-pro' ),
                        'options' => [
                            'enter-from-right' => 'Slide In Right',
                            'enter-from-left' => 'Slide In Left',
                            'enter-from-top' => 'Slide In Up',
                            'enter-from-bottom' => 'Slide In Down',
                            'enter-zoom-in' => 'Zoom In',
                            'enter-zoom-out' => 'Zoom Out',
                            'fade-in' => 'Fade In',
                        ],
                    ],
                    [
                        'label' => __( 'Reaction', 'elementor-pro' ),
                        'options' => [
                            'grow' => 'Grow',
                            'shrink' => 'Shrink',
                            'move-right' => 'Move Right',
                            'move-left' => 'Move Left',
                            'move-up' => 'Move Up',
                            'move-down' => 'Move Down',
                        ],
                    ],
                    [
                        'label' => __( 'Exit', 'elementor-pro' ),
                        'options' => [
                            'exit-to-right' => 'Slide Out Right',
                            'exit-to-left' => 'Slide Out Left',
                            'exit-to-top' => 'Slide Out Up',
                            'exit-to-bottom' => 'Slide Out Down',
                            'exit-zoom-in' => 'Zoom In',
                            'exit-zoom-out' => 'Zoom Out',
                            'fade-out' => 'Fade Out',
                        ],
                    ],
                ],
                'default' => 'fade-in',
                'separator' => 'before',
                'render_type' => 'ui',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'content_animation_duration',
            [
                'label' => __( 'Animation Duration', 'elementor-pro' ) . ' (ms)',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 800,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--content-transition-duration: {{SIZE}}ms; --content-transition-delay: {{SIZE}}ms;',
                ],
                'condition' => [
                    'content_hover_animation!' => '',
                ],
            ]
        );

        $this->add_control(
            'content_sequenced_animation',
            [
                'label' => __( 'Sequenced Animation', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'content_hover_animation!' => '',
                ],
                'frontend_available' => true,
                'render_type' => 'ui',
            ]
        );

        $this->end_controls_section(); // overlay_content

        $this->start_controls_section(
            'filter_bar_style',
            [
                'label' => __( 'Filter Bar', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'gallery_type' => 'multiple',
                ],
            ]
        );

        $this->add_control(
            'align_filter_bar_items',
            [
                'label' => __( 'Align', 'elementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elementor-pro' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-gallery--filter-align-',
                'selectors_dictionary' => [
                    'left' => 'flex-start',
                    'right' => 'flex-end',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--titles-container-justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->start_controls_tabs( 'filter_bar_colors' );

        $this->start_controls_tab( 'filter_bar_colors_normal',
            [
                'label' => __( 'Normal', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'galleries_title_color_normal',
            [
                'label' => __( 'Text Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--galleries-title-color-normal: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'galleries_titles_typography',
                'selector' => '{{WRAPPER}} .elementor-gallery-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->end_controls_tab();// filter_bar_colors_normal

        $this->start_controls_tab( 'filter_bar_colors_hover',
            [
                'label' => __( 'Hover', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'galleries_title_color_hover',
            [
                'label' => __( 'Text Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--galleries-title-color-hover: {{VALUE}}',
                ],
                'condition' => [
                    'pointer!' => 'background',
                ],
            ]
        );

        /*
        When the pointer style = background, users could need a different text color.
        The control handles the title color in hover state, only when the pointer style is background.
        */
        $this->add_control(
            'galleries_title_color_hover_pointer_bg',
            [
                'label' => __( 'Text Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}}' => '--galleries-title-color-hover: {{VALUE}}',
                ],
                'condition' => [
                    'pointer' => 'background',
                ],
            ]
        );

        $this->add_control(
            'galleries_pointer_color_hover',
            [
                'label' => __( 'Pointer Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--galleries-pointer-bg-color-hover: {{VALUE}}',
                ],
                'condition' => [
                    'pointer!' => [ 'none', 'text' ],
                ],
            ]
        );

        $this->end_controls_tab();// filter_bar_colors_hover

        $this->start_controls_tab( 'filter_bar_colors_active',
            [
                'label' => __( 'Active', 'elementor-pro' ),
            ]
        );

        $this->add_control(
            'galleries_title_color_active',
            [
                'label' => __( 'Text Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--gallery-title-color-active: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'galleries_pointer_color_active',
            [
                'label' => __( 'Pointer Color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--galleries-pointer-bg-color-active: {{VALUE}}',
                ],
                'condition' => [
                    'pointer!' => [ 'none', 'text' ],
                ],

            ]
        );

        $this->end_controls_tab();// filter_bar_colors_active

        $this->end_controls_tabs(); // filter_bar_colors

        $this->add_control(
            'pointer_width',
            [
                'label' => __( 'Pointer Width', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'devices' => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET ],
                'range' => [
                    'px' => [
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--galleries-pointer-border-width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
                'condition' => [
                    'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
                ],
            ]
        );

        $this->add_control(
            'galleries_titles_space_between',
            [
                'label' => __( 'Space Between', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-gallery-title' => '--space-between: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'galleries_titles_gap',
            [
                'label' => __( 'Gap', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-gallery__titles-container' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section(); // filter_bar_style

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $is_multiple = 'multiple' === $settings['gallery_type'] && ! empty( $settings['galleries'] );

        $is_single = 'single' === $settings['gallery_type'] && ! empty( $settings['mp-gallery'] );

        $has_description = ! empty( $settings['overlay_description'] );

        $has_title = ! empty( $settings['overlay_title'] );

        $has_animation = ! empty( $settings['image_hover_animation'] ) || ! empty( $settings['content_hover_animation'] ) || ! empty( $settings['background_overlay_hover_animation'] );

        $gallery_item_tag = ! empty( $settings['link_to'] ) ? 'a' : 'div';

        //get columns
        $columns = $settings['columns'];

        $galleries = [];

        if ( $is_multiple ) {
            $this->add_render_attribute( 'titles-container', 'class', 'elementor-gallery__titles-container' );

            if ( $settings['pointer'] ) {
                $this->add_render_attribute( 'titles-container', 'class', 'e--pointer-' . $settings['pointer'] );

                foreach ( $settings as $key => $value ) {
                    if ( 0 === strpos( $key, 'animation' ) && $value ) {
                        $this->add_render_attribute( 'titles-container', 'class', 'e--animation-' . $value );
                        break;
                    }
                }
            } ?>
            <div class="filters">
                <div <?php echo $this->get_render_attribute_string( 'titles-container' ); ?>>
                    <div class="button-group js-radio-button-group" id="main-filter-group" data-filter-group="title">
                    <?php if ( $settings['show_all_galleries'] ) { ?>
                        <button data-filter="" class="button is-checked elementor-item elementor-gallery-title"><?php echo $settings['show_all_galleries_label']; ?></button>
                    <?php } ?>

                    <?php foreach ( $settings['galleries'] as $index => $gallery ) :
                        if ( ! $gallery['multiple_gallery'] ) {
                            continue;
                        }

                        $galleries[ $index ] = $gallery['multiple_gallery'];
                        ?>
                        <button data-filter=".gal-item<?php echo $index; ?>" class="button elementor-item elementor-gallery-title"><?php echo $gallery['gallery_title']; ?></button>
                        <?php
                    endforeach; ?>
                    </div>
                </div>
                <div class="button-group js-radio-button-group" id="sub-filter-group" data-filter-group="sub-title">
                    <li data-filter=".broken-window-panes" class="button elementor-sub-title">Broken Window Panes <span>x</span></li>
                    <li data-filter=".window-failure" class="button elementor-sub-title">Window Failure <span>x</span></li>
                    <li data-filter=".stained-glass-repair" class="button elementor-sub-title">Stained Glass Repair <span>x</span></li>
                </div>
            </div>
            <?php
        } elseif ( $is_single ) {
            $galleries[0] = $settings['mp-gallery'];
        } 
        
        elseif ( Plugin::elementor()->editor->is_edit_mode() ) { ?>
          <i class="elementor-widget-empty-icon eicon-gallery-justified"></i>
        <?php }

        //$this->add_render_attribute( 'gallery_container', 'class', 'elementor-gallery__container e-gallery-container e-gallery-masonry e-gallery--ltr' );
        $this->add_render_attribute( 'gallery_container', 'class', 'grid' );

        if ( $has_title || $has_description ) {
            $this->add_render_attribute( 'gallery_item_content', 'class', 'istope-gallery-item__content' );

            if ( $has_title ) {
                $this->add_render_attribute( 'gallery_item_title', 'class', 'elementor-gallery-item__title' );
            }

            if ( $has_description ) {
                $this->add_render_attribute( 'gallery_item_description', 'class', 'elementor-gallery-item__description' );
            }
        }

        $this->add_render_attribute( 'gallery_item_background_overlay', [ 'class' => 'elementor-gallery-item__overlay' ] );

        $gallery_items = [];
        $thumbnail_size = $settings['thumbnail_image_size'];
        foreach ( $galleries as $gallery_index => $gallery ) {
            foreach ( $gallery as $index => $item ) {
                if ( in_array( $item['id'], array_keys( $gallery_items ), true ) ) {
                    $gallery_items[ $item['id'] ][] = $gallery_index;
                } else {
                    $gallery_items[ $item['id'] ] = [ $gallery_index ];
                }
            }
        }

//        if ( 'random' === $settings['order_by'] ) {
//            $shuffled_items = [];
//            $keys = array_keys( $gallery_items );
//            shuffle( $keys );
//            foreach ( $keys as $key ) {
//                $shuffled_items[ $key ] = $gallery_items[ $key ];
//            }
//            $gallery_items = $shuffled_items;
//        }
        //var_dump($galleries);

        if ( ! empty( $galleries ) ) { ?>
        <div <?php echo $this->get_render_attribute_string( 'gallery_container' ); ?>>
            <div class="grid-sizer"></div>
            <?php
            foreach ( $gallery_items as $id => $tags ) :
                $unique_index = $id; //$gallery_index . '_' . $index;


                $image_src = wp_get_attachment_image_src( $id, $thumbnail_size );
                if ( ! $image_src ) {
                    continue;
                }
                $attachment = get_post( $id );
                $image_data = [
                    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                    'media' => wp_get_attachment_image_src( $id, 'full' )['0'],
                    'src' => $image_src['0'],
                    'width' => $image_src['1'],
                    'height' => $image_src['2'],
                    'caption' => $attachment->post_excerpt,
                    'description' => $attachment->post_content,
                    'title' => $attachment->post_title,
                ];


                foreach ($tags as &$index) {
                    $index = 'gal-item'.$index;
                }
                $filter_title_index = implode( ' ', $tags );

                $this->add_render_attribute( 'gallery_item_' . $unique_index, [
                    'class' => [
                        'grid-item',
                        $filter_title_index,
                    ],
                ] );

                if ( $has_animation ) {
                    //$this->add_render_attribute( 'gallery_item_' . $unique_index, [ 'class' => 'elementor-animated-content' ] );
                }

                if ( $is_multiple ) {
                    //$this->add_render_attribute( 'gallery_item_' . $unique_index );
                }

                if ( 'a' === $gallery_item_tag ) {
                    if ( 'file' === $settings['link_to'] ) {
                        $href = $image_data['media'];

                        $this->add_render_attribute( 'gallery_item_' . $unique_index, [
                            'href' => $href,
                        ] );

                        $this->add_lightbox_data_attributes( 'gallery_item_' . $unique_index, $id, 'yes', 'all-' . $this->get_id() );
                    } elseif ( 'custom' === $settings['link_to'] ) {
                        $this->add_link_attributes( 'gallery_item_' . $unique_index, $settings['url'] );
                    }
                }

                $this->add_render_attribute( 'gallery_item_image_' . $unique_index,
                    [
                        'class' => [
                            'iso-gallery-image',
                        ],
                        'src' => $image_data['src'],
                        'data-width' => $image_data['width'],
                        'data-height' => $image_data['height'],
                        'alt' => $image_data['alt'],
                    ]
                );?>
                <<?php echo $gallery_item_tag; ?> <?php echo $this->get_render_attribute_string( 'gallery_item_' . $unique_index ); ?>>
                <div class="isotope-content-container">
                    <img <?php echo $this->get_render_attribute_string( 'gallery_item_image_' . $unique_index ); ?> />
                    <?php if ( ! empty( $settings['overlay_background'] ) ) : ?>
                    <div <?php echo $this->get_render_attribute_string( 'gallery_item_background_overlay' ); ?>></div>
                <?php endif; ?>
                    <?php if ( $has_title || $has_description ) : ?>
                    <div <?php echo $this->get_render_attribute_string( 'gallery_item_content' ); ?>>
                        <div class="isotope-content-wrap">
                        <?php if ( $has_title ) :
                            $title = $image_data[ $settings['overlay_title'] ];
                            if ( ! empty( $title ) ) : ?>
                                <div <?php echo $this->get_render_attribute_string( 'gallery_item_title' ); ?>><?php echo $title; ?></div>
                            <?php endif;
                        endif;
                        if ( $has_description ) :
                            $description = $image_data[ $settings['overlay_description'] ];
                            if ( ! empty( $description ) ) :?>
                                <div <?php echo $this->get_render_attribute_string( 'gallery_item_description' ); ?>><?php echo $description; ?></div>
                            <?php endif;
                        endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                </<?php echo $gallery_item_tag; ?>>
            <?php endforeach;
            //endforeach; ?>
            </div>
        <?php }

    }

//    protected function _content_template() {
//
//    }
}

