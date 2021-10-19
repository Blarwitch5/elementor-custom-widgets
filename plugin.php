<?php
namespace RBCustomWidget;

use RBCustomWidget\Widgets\RB_Step_Box;
use RBCustomWidget\Widgets\RB_Custom_Tabs;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {
    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;
    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.2.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
    public function widget_scripts() {
        //wp_register_script( 'step-box-js', plugins_url( '/assets/js/step-box.js', __FILE__ ), [ 'jquery' ], false, true );
        wp_register_script( 'custom-tabs-js', plugins_url( '/assets/js/custom-tabs.js', __FILE__ ), [ 'jquery' ], false, true );
    }

    /**
     *  widgets styles
     *
     * Load widgets styles
     *
    */
    public function widget_styles() { 
        wp_enqueue_style( 'step-box', plugins_url( 'assets/css/step-box.css', __FILE__ ) );
        wp_enqueue_style( 'custom-tabs', plugins_url( 'assets/css/custom-tabs.css', __FILE__ ) );

    }

    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files() {
        require_once( __DIR__ . '/widgets/step-box.php' );
        require_once( __DIR__ . '/widgets/custom-tabs.php' );

        //require_once( __DIR__ . '/widgets/inline-editing.php' );
    }
    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();
        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\RB_Step_Box() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\RB_Custom_Tabs() );
        //\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Inline_Editing() );
    }
    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct() {
        // Register widget scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
    }
}
// Instantiate Plugin Class
Plugin::instance();
