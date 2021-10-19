<?php
namespace RBCustomWidget\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Button fixed
 *
 * Elementor widget for fixed button.
 *
 * @since 1.0.0
 */
class RB_Custom_tabs extends Widget_Base {

    /**
     * Retrieve button widget name.
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'custom-tabs';
    }

    /**
     * Retrieve button widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Custom Tabs', 'elementor' );
    }

    /**
     * Retrieve button widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'general' ];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'custom-tabs-js' ];
    }

    protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Tab', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'tab_name', [
				'label' => __( 'Tab Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Title' , 'plugin-domain' ),
				'label_block' => true,
			]
		);
        $repeater->add_control(
			'tab_id', [
				'label' => __( 'Tab ID (mandatory - no accents)', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'id' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' => __( 'Content', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Content' , 'plugin-domain' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'tab',
			[
				'label' => __( 'All tabs', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_name' => __( 'Tab 1', 'plugin-domain' ),
                        'tab_id' => __( 'tab 1 id', 'plugin-domain' ),
						'tab_content' => __( 'Content', 'plugin-domain' ),
					],
					[
						'tab_name' => __( 'Tab #2', 'plugin-domain' ),
                        'tab_id' => __( 'tab 2 id', 'plugin-domain' ),
						'tab_content' => __( 'Content', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ tab_name }}}',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['tab'] ) {
			echo '<div class="tab">';
			foreach (  $settings['tab'] as $item ) {
				echo '<button class="elementor-repeater-item-' . $item['_id'] . ' tab__link" onclick="openTab(event, \''. strtolower(str_replace(' ', '-', $item['tab_id'])) .'\')">
                        '. $item['tab_name'] .'
                      </button>';
			}
			echo '  
                    </div>
                    <div class="tab__content-wrapper">';
            foreach (  $settings['tab'] as $item ) {
                echo '<div id="'. strtolower(str_replace(' ', '-', $item['tab_id'])) .'" class="elementor-repeater-item-' . $item['_id'] . ' tab__content">
                        '. $item['tab_content'] .'
                        </div>';
            }
            echo '</div>';
		}
	}

	protected function _content_template() {
		?>
		<# if ( settings.tab.length ) { #>
        <div class="tab">
			<# _.each( settings.tab, function( item ) { #>
                <button class="elementor-repeater-item-{{ item._id }} tablinks" onclick="openTab(event, '{{{ item.tab_id }}}')">
                    {{{ item.tab_name }}}
                </button>
			<# }); #>
        </div>
        <# _.each( settings.tab, function( item ) { #>
                <div id="{{{ item.tab_id }}}" class="elementor-repeater-item-{{ item._id }} tabcontent">
                {{{ item.tab_content }}}
                      </div>
			<# }); #>
		<# } #>
		<?php
	}
}
