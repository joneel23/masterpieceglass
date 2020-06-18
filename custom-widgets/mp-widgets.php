<?php

class Mp_Widgets{
    protected static $instance = null;   

    public static function get_instance(){
      if( !isset( static::$instance )){
        static::$instance = new static;
      }
      return static::$instance;
    }

    protected function __construct(){
      //  require_once('mp-button-widget.php');
      // require_once('btn.php');

        require_once ('hero-button-widget.php');
        require_once ('mp-gallery-widget.php');
        require_once ('mp-gallery-pro-widget.php');

        add_action('elementor/widgets/widgets_registered',[$this, 'register_widgets']);
    }

    function register_widgets(){
        // \Elementor\plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Mp_Button_Elementor_Widgets_test());
//         \Elementor\plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Mp_Button_Elementor_Widgets());

            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Elementor_Hero_Button_Widget() );

            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Elementor_MP_Gallery() );

//            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\MP_Pro_Gallery() );
       }
    }

add_action('init','Mp_Widgets_init');
function Mp_Widgets_init(){
    Mp_Widgets::get_instance();
}