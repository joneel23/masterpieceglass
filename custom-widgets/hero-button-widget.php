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
        $url = $settings['link']['url'];
        echo  "<a href='$url' class='elementor-button' role='button'><span></span><span></span><span></span><span></span>
        $settings[text]</a>";


    }

    protected function _content_template() {

    }
}

