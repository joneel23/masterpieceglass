<?php
/**
 * Created by PhpStorm.
 * User: WEB
 * Date: 5/26/2020
 * Time: 4:52 PM
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

class Elementor_Hero_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'hero-button';
    }

    public function get_title() {
        return 'Hero Button';
    }

    public function get_icon() {
        return 'eicon-dual-button';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Content', 'elementor' ),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __( 'Button Title', 'elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter your title', 'elementor' ),
            ]
        );

        $this->add_control(
            'button_effects',
            array(
                'label'   => esc_html__( 'Button Effects', 'elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'hero_img_btn'   => esc_html__( 'Animation 1', 'elementor' ),
                    'hero_img_btn2'    => esc_html__( 'Animation 2', 'elementor' ),
                    'hero_img_btn3'  => esc_html__( 'Animation 3', 'elementor' ),
                    'hero_img_btn4' => esc_html__( 'Animation 4', 'elementor' ),
                ),
                'default'     => 'hero_img_btn',
            )
        );


        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'elementor' ),
                'default' => [
                    'url' => '',
                ]
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
            'hover_color',
            [
                'label' => __( 'Text Hover Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Hover Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'button_border',
            [
                'label' => __( 'Button Border', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'condition' => [
                    'button_effects' => 'hero_img_btn2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border: {{TOP}}{{UNIT}} solid;',
                ],
            ]
        );
        $this->add_control(
            'button_border_color',
            [
                'label' => __( 'Border Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'button_effects' => 'hero_img_btn2',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{VALUE}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Button', 'elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'hero_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $btn_effects = $settings['button_effects'];
        $url = $settings['link']['url'];
        echo  "<a href='$url' class='elementor-button ".$btn_effects."' role='button'><span></span><span></span><span></span><span></span>
        $settings[text]</a>";


    }

    protected function _content_template() {

    }
}

