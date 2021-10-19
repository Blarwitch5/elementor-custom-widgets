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
class RB_Step_Box extends Widget_Base {

    /**
     * Retrieve button widget name.
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'step-box';
    }

    /**
     * Retrieve button widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Step Box', 'elementor' );
    }

    /**
     * Retrieve button widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-box';
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
        return [ 'step-box-js' ];
    }

    protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Étape', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'step_icon',
			[
				'label' => __( 'Icône', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $repeater->add_control(
			'step_number', [
				'label' => __( 'Numéro', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Numéro' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_title', [
				'label' => __( 'Titre', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Titre' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'step_content', [
				'label' => __( 'Contenu', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Contenu' , 'plugin-domain' ),
				'show_label' => false,
			]
		);

		$this->add_control(
			'step',
			[
				'label' => __( 'Toutes les étapes', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'step_title' => __( 'Titre #1', 'plugin-domain' ),
                        'step_number' => __( 'Étape #1', 'plugin-domain' ),
                        'step_icon' => __( 'Icône. .', 'plugin-domain' ),
						'step_content' => __( 'Contenu.', 'plugin-domain' ),
					],
					[
						'step_title' => __( 'Titre #2', 'plugin-domain' ),
                        'step_number' => __( 'Étape #2', 'plugin-domain' ),
                        'step_icon' => __( 'Icône.', 'plugin-domain' ),
						'step_content' => __( 'Contenu.', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ step_title }}}',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['step'] ) {
			echo '<div class="steps">';
			foreach (  $settings['step'] as $item ) {
				echo '<div class="elementor-repeater-item-' . $item['_id'] . ' steps__item">
                        <div class="steps__top">
                            <div class="steps__number">'
                                . $item['step_number'] .
                            '</div>
                            <div class="steps__shape">
                            </div>
                            <div class="steps__icon">
                                <img src="' . $item['step_icon']['url'] . '">
                            </div>
                        </div>
                        <div class="steps__middle">
                            <div class="steps__title">'. $item['step_title'] .'</div>
                            <div class="steps__separation"></div>
                        </div>
                        <div class="steps__bottom">
                            <p>' . $item['step_content'] . '</p>
                        </div>
                    </div>';
			}
			echo '  
                </div>';
		}
	}

	protected function _content_template() {
		?>
		<# if ( settings.step.length ) { #>
        <div class="steps">
			<# _.each( settings.step, function( item ) { #>
                <div class="elementor-repeater-item-{{ item._id }} steps____container">
                        <div class="steps__top">
                            <div class="steps__number">{{{ item.step_number }}}</div>
                            <div class="steps__shape"></div>
                            <div class="steps__icon">
                                <img src="{{ item.step_icon.url }}">
                            </div>
                        </div>
                     </div>
                     <div class=""steps__separation></div>
                <div class="steps__title">{{{ item.step_title }}}</div>
				<p>{{{ item.step_content }}}</p>
			<# }); #>
        </div>
		<# } #>
		<?php
	}
}
