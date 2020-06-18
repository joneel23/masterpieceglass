<?php

namespace Elementor;

 class Mp_Button_Elementor_Widgets extends Widget_Base {
 
				public function get_name() {
					return 'content-toggle-button';
				}
			
				public function get_title() {
					return __( 'Content Toggle Button', 'elementor' );
				}
			
				public function get_icon() {
					return 'eicon-dual-button';
				}
			
				public function get_keywords() {
					return [ 'button', 'content', 'toggle' ];
				}
 
		protected function _register_controls() {

				/*
				* BUTTON TEXT
				*/
				$this->start_controls_section(
					'button_settings',
					[
						'label' => __( 'Button Settings', 'elementor' ),
					]
				);

				$this->add_control(
					'link',
					[
						'label' => __( 'Link', 'elementor' ),
						'type' => Controls_Manager::URL,
						'placeholder' => __( 'https://your-link.com', 'elementor' ),
						'default'=>[
							'url'=>'',
						]
					]
				);
			
				$this->add_control(
					'button_text',
					[
						'label' => __( 'Button Text', 'elementor' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => __( 'Button Text', 'elementor' ),
					]
				);

				$this->add_control(
					'font_size',
					[
						'label' => __( 'Size', 'elementor' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px', 'em', 'rem' ],
						'range' => [
							'px' => [
								'min' => 1,
								'max' => 200,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 20,
						],
					]
				);

				$this->add_responsive_control(
					'space_between',
					[
						'label' => __( 'Spacing', 'plugin-name' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'devices' => [ 'desktop', 'tablet', 'mobile' ],
						'desktop_default' => [
							'size' => 30,
							'unit' => 'px',
						],
						'tablet_default' => [
							'size' => 20,
							'unit' => 'px',
						],
						'mobile_default' => [
							'size' => 10,
							'unit' => 'px',
						],
						'selectors' => [
							'{{WRAPPER}} .widget-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'text_color',
					[
						'label' => __( 'Text Color', 'elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '#fefefe',
					]
				);

				$this->add_control(
					'alignment',
					[
						'label' => __( 'Alignment', 'elementor' ),
						'type' => \Elementor\Controls_Manager::CHOOSE,
						'options' => [
							'left' => [
								'title' => __( 'Left', 'elementor' ),
								'icon' => 'fa fa-align-left',
							],
							'center' => [
								'title' => __( 'Center', 'elementor' ),
								'icon' => 'fa fa-align-center',
							],
							'right' => [
								'title' => __( 'Right', 'elementor' ),
								'icon' => 'fa fa-align-right',
							],
						],
						'default' => 'center',
					]
				);

				$this->end_controls_section();

	   }
 
	protected function render() {
		$settings = $this->get_settings_for_display();
	  ?>

	<div class="elementor-custom-button-wrapper">
		<button class="elementor-content-custom-button-btn hero_img_btn" id="" >
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <?php echo $settings['button_text']; ?>
        </button>
	</div>
	<?php

	}

	protected function _content_template(){

		
	}

 }