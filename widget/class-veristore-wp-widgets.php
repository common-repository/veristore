<?php

/**
 * The Widgets of the plugin.
 * 
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/widget
 */

/**
 * Veristore-Widget-Badge
 *
 * @see WP_Widget
 * 
 * @package    Veristore
 * @subpackage veristore/widget
 * @author     Lukas Kleinschmidt <lukas.kleinschmidt@aixhibit.de>
 */
class Veristore_Widget_Badge extends WP_Widget {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $veristore    The ID of this plugin.
     */
    private $veristore;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The options of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $options
     */
    private $options;

    /**
     * Register widget with WordPress.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->veristore = 'veristore_badge';
        $this->version = '1.0.0';
        $this->options = get_option( 'veristore_options' );

        parent::__construct(
            $this->veristore,
            __( 'Veristore-Badge', 'veristore' ),
            array(
                'classname'  => 'widget_' . $this->veristore,
                'description' => __( 'Short description of the widget goes here.', 'veristore' )
            )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        if ( ! isset ( $args[ 'widget_id' ] ) ) {
            $args[ 'widget_id' ] = $this->id;
        }

        if ( isset ( $cache[ $args[ 'widget_id' ] ] ) ) {
            return print $cache[ $args[ 'widget_id' ] ];
        }

        extract( $args, EXTR_SKIP );

        $widget_string = $before_widget;

        ob_start();

        include( plugin_dir_path( __FILE__ ) . 'partials/veristore-widget-badge-public.php' );

        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;

        print $widget_string;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     * 
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $instance = wp_parse_args(
            $instance,
            array(
                'title' => '',
                'type' => 'vbadgebig'
            )
        );

        // Display the admin form
        include( plugin_dir_path( __FILE__ ) . 'partials/veristore-widget-badge-admin.php' );
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
        $instance[ 'type' ] = ( ! empty( $new_instance[ 'type' ] ) ) ? strip_tags( $new_instance[ 'type' ] ) : '';

        return $instance;
    }

    /**
     * Retrieve specific option of the plugin.
     *
     * @since     1.0.0
     * @return    string    The option of the plugin.
     */
    public function get_option( $option ) {
        return $this->options[ $option ];
    }
}

/**
 * Veristore-Widget-Structured-Data
 *
 * @see WP_Widget
 * 
 * @package    Veristore
 * @subpackage veristore/widget
 * @author     Lukas Kleinschmidt <lukas.kleinschmidt@aixhibit.de>
 */
class Veristore_Widget_Structured_Data extends WP_Widget {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $veristore    The ID of this plugin.
     */
    private $veristore;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Register widget with WordPress.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->veristore = 'veristore_structured_data';
        $this->version = '1.0.0';

        parent::__construct(
            $this->veristore,
            __( 'Veristore Bewertungen', 'veristore' ),
            array(
                'classname'  => 'widget_' . $this->veristore,
                'description' => __( 'Zeigt eine Bewertungsübersicht als Text an.', 'veristore' )
            )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        if ( ! isset ( $args[ 'widget_id' ] ) ) {
            $args[ 'widget_id' ] = $this->id;
        }

        if ( isset ( $cache[ $args[ 'widget_id' ] ] ) ) {
            return print $cache[ $args[ 'widget_id' ] ];
        }

        extract( $args, EXTR_SKIP );

        $widget_string = $before_widget;

//      25.08.2017        
        $options = get_option( 'veristore_options' );
        if ( array_key_exists('vs_structdata', $options) && !empty($options['vs_structdata']) ) {
            ob_start();

            include( plugin_dir_path( __FILE__ ) . 'partials/veristore-widget-structured-data-public.php' );

            $widget_string .= ob_get_clean();
        }
        
        $widget_string .= $after_widget;

        print $widget_string;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     * 
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $instance = wp_parse_args(
            $instance,
            array(
                'title' => '',
                'font-size' => 'normal'
            )
        );

        // Display the admin form
        include( plugin_dir_path( __FILE__ ) . 'partials/veristore-widget-structured-data-admin.php' );
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
        $instance[ 'font-size' ] = ( ! empty( $new_instance[ 'font-size' ] ) ) ? strip_tags( $new_instance[ 'font-size' ] ) : '';

        return $instance;
    }
}